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
        $input = $this->faker->sentence(3);

        $this
            ->visit('/admin/surveys/create')
            ->type($input, 'name')
            ->press('Create')
            ->see('Survey created')
            ->see('Edit Survey')
            ->see($input)
            ->seeInDatabase('surveys', ['name' => $input])
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

        $input = $this->faker->sentence(3);
        $url = route('admin.surveys.edit', ['id' => $this->survey->id]);

        $this
            ->visit($url)
            ->type($input, 'name')
            ->press('Update')
            ->seePageIs($url)
            ->see('Survey updated')
            ->seeInDatabase('surveys', ['id' => $this->survey->id, 'name' => $input])
        ;
    }

    /**
     * Test showing survey
     *
     * @return void
     */
    public function testShow()
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
            ->seeInDatabase('questions', ['survey_id' => $this->survey->id, 'label' => $label, 'field' => $field, 'type' => 'text', 'rules' => '["required"]', 'options' => null])
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
        $optionsJson = json_encode(array_combine($options, $options));

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
        $optionsJson = json_encode(array_combine($options, $options));

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
        ;
    }
}
