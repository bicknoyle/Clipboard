<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminSurveyTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test create survey
     *
     * @return void
     */
    public function testCreate()
    {
        $name = $this->faker->sentence(3);
        $description = $this->faker->text(150);

        $this
            ->visit('/admin/surveys/create')
            ->type($name, 'name')
            ->type($description, 'description')
            ->press('Create')
            ->see('Survey created')
            ->see('Edit Survey')
            ->see($name)
            ->seeInDatabase('surveys', ['name' => $name, 'description' => $description])
        ;
    }

    /**
     * Test edit survey
     *
     * @return void
     */
    public function testEdit()
    {
        $this->loadFixtures();

        $url = route('admin.surveys.edit', ['id' => $this->survey->id]);

        $this
            ->visit($url)
            ->see($this->survey->name)
            ->see($this->question->label)
            ->see($this->question->field)
            ->see($this->question->type)
            ->see($this->question->optionsToString())
        ;
    }

    /**
     * Test update survey
     *
     * @return void
     */
    public function testUpdate()
    {
        $this->loadFixtures();

        $name = $this->faker->sentence(3);
        $description = $this->faker->text(150);
        $url = route('admin.surveys.edit', ['id' => $this->survey->id]);

        $this
            ->visit($url)
            ->type($name, 'name')
            ->type($description, 'description')
            ->press('Update')
            ->seePageIs($url)
            ->see('Survey updated')
            ->seeInDatabase('surveys', ['name' => $name, 'description' => $description])
        ;
    }

    /**
     * Test undo survey form
     *
     * @return void
     */
    public function testUndo()
    {
        $this->loadFixtures();

        $name = $this->faker->sentence(3);
        $url = route('admin.surveys.edit', ['id' => $this->survey->id]);

        $this
            ->visit($url)
            ->type($name, 'name')
            ->click('Undo')
            ->seeInDatabase('surveys', ['name' => $this->survey->name])
        ;
    }

    /**
     * Test delete survey
     *
     * @return void
     */
    public function testDelete()
    {
        $this->loadFixtures();

        $url = route('admin.surveys.edit', ['id' => $this->survey->id]);
        $this
            ->visit($url)
            ->press('Delete Survey')
            ->seePageIs('/admin')
            ->see('Survey deleted')
            ->dontSeeInDatabase('surveys', ['id' => $this->survey->id])
            ->dontSeeInDatabase('questions', ['survey_id' => $this->survey->id])
            ->dontSeeInDatabase('responses', ['survey_id' => $this->survey->id])
        ;
    }

    /**
     * Test adding questions
     *
     * @return void
     */
    public function testAddQuestion()
    {
        $this->loadFixtures();

        $label = $this->faker->sentence(3);
        $field = $this->faker->word();
        $url = route('admin.surveys.edit', ['id' => $this->survey->id]);

        $this
            ->visit($url)
            ->type($label, 'label')
            ->type($field, 'field')
            ->press('Add')
            ->seePageIs($url)
            ->see('Question added')
            ->seeInDatabase('questions', ['survey_id' => $this->survey->id, 'label' => $label, 'field' => $field, 'type' => 'text', 'rules' => null, 'options' => null])
        ;
    }

    /**
     * Test adding questions validation
     *
     * @return void
     */
    public function testAddQuestionValidation()
    {
        $this->loadFixtures();

        $url = route('admin.surveys.edit', ['id' => $this->survey->id]);

        $this
            ->visit($url)
            ->press('Add')
            ->seePageIs($url)
            ->see('The label field is required.')
            ->see('The field field is required.')
        ;
    }

    /**
     * Test adding required question
     *
     * @return void
     */
    public function testAddRequiredQuestion()
    {
        $this->loadFixtures();

        $label = $this->faker->sentence(3);
        $field = $this->faker->word();
        $url = route('admin.surveys.edit', ['id' => $this->survey->id]);

        $this
            ->visit($url)
            ->type($label, 'label')
            ->type($field, 'field')
            ->check('rules[required]')
            ->press('Add')
            ->seePageIs($url)
            ->see('Question added')
            ->seeInDatabase('questions', ['survey_id' => $this->survey->id, 'label' => $label, 'field' => $field, 'type' => 'text', 'rules' => '["required"]'])
        ;
    }

    /**
     * Test that adding a duplicate field fails
     *
     * @return void
     */
    public function testDuplicateFieldFails()
    {
        $this->loadFixtures();

        $label = $this->faker->sentence(3);
        $url = route('admin.surveys.edit', ['id' => $this->survey->id]);

        $this
            ->visit($url)
            ->type($label, 'label')
            ->type($this->question->field, 'field')
            ->press('Add')
            ->see('The field has already been taken.')
        ;
    }

    /**
     * Test text field doesnt accept options
     *
     * @return void
     */
    public function testDoesntAcceptOptions()
    {
        $this->loadFixtures();

        $label = $this->faker->sentence(3);
        $field = $this->faker->word();
        $options = $this->faker->words(5);
        $optionsJson = json_encode($options);

        $url = route('admin.surveys.edit', ['id' => $this->survey->id]);

        $this
            ->visit($url)
            ->type($label, 'label')
            ->type($field, 'field')
            ->type('text', 'type')
            ->type(implode(', ',$options), 'options')
            ->press('Add')
            ->see('The options field should be empty for this type.')
            ->dontSeeInDatabase('questions', ['survey_id' => $this->survey->id, 'label' => $label, 'options' => $optionsJson])
        ;
    }

    /**
     * Test adding select question
     */
    public function testAddSelectQuestion()
    {
        $this->loadFixtures();

        $label = $this->faker->sentence(3);
        $field = $this->faker->word();
        $options = $this->faker->words(5);
        $optionsJson = json_encode($options);

        $url = route('admin.surveys.edit', ['id' => $this->survey->id]);

        $this
            ->visit($url)
            ->type($label, 'label')
            ->type($field, 'field')
            ->select('select', 'type')
            ->type(implode(', ', $options), 'options')
            ->press('Add')
            ->seePageIs($url)
            ->see('Question added')
            ->seeInDatabase('questions', ['survey_id' => $this->survey->id, 'label' => $label, 'field' => $field, 'type' => 'select', 'options' => $optionsJson])
        ;
    }

    /**
     * Test select question requires options
     *
     * @return void
     */
    public function testSelectQuestionRequiresOptions()
    {
        $this->loadFixtures();

        $label = $this->faker->sentence(3);
        $field = $this->faker->word();
        $url = route('admin.surveys.edit', ['id' => $this->survey->id]);

        $this
            ->visit($url)
            ->type($label, 'label')
            ->type($field, 'field')
            ->select('select', 'type')
            ->press('Add')
            ->seePageIs($url)
            ->see('The options field is required when type is select.')
            ->dontSeeInDatabase('questions', ['survey_id' => $this->survey->id, 'label' => $label, 'field' => $field])
        ;
    }

    /**
     * Test adding radio question
     *
     * @return void
     */
    public function testAddRadioQuestion()
    {
        $this->loadFixtures();

        $label = $this->faker->sentence(3);
        $field = $this->faker->word();
        $options = $this->faker->words(5);
        $optionsJson = json_encode($options);

        $url = route('admin.surveys.edit', ['id' => $this->survey->id]);

        $this
            ->visit($url)
            ->type($label, 'label')
            ->type($field, 'field')
            ->select('radio', 'type')
            ->type(implode(', ', $options), 'options')
            ->press('Add')
            ->seePageIs($url)
            ->see('Question added')
            ->seeInDatabase('questions', ['survey_id' => $this->survey->id, 'label' => $label, 'field' => $field, 'type' => 'radio', 'options' => $optionsJson])
        ;
    }

    /**
     * Test radio question requires options
     *
     * @return void
     */
    public function testRadioQuestionRequiresOptions()
    {
        $this->loadFixtures();

        $label = $this->faker->sentence(3);
        $field = $this->faker->word();
        $url = route('admin.surveys.edit', ['id' => $this->survey->id]);

        $this
            ->visit($url)
            ->type($label, 'label')
            ->type($field, 'field')
            ->select('radio', 'type')
            ->press('Add')
            ->seePageIs($url)
            ->see('The options field is required when type is radio.')
            ->dontSeeInDatabase('questions', ['survey_id' => $this->survey->id, 'label' => $label, 'field' => $field])
        ;
    }

    /**
     * Test delete question
     *
     * @return void
     */
    public function testDeleteQuestion()
    {
        $this->loadFixtures();

        $url = route('admin.surveys.edit', ['id' => $this->survey->id]);

        $this
            ->visit($url)
            ->press('Delete Question Id:'.$this->question->id)
            ->see('Question deleted')
            ->dontSeeInDatabase('questions', ['id' => $this->question->id])
            ->dontSeeInDatabase('answers', ['question_id' => $this->question->id])
        ;
    }
}
