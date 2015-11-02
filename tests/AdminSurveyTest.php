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
            ->seeInDatabase('questions', ['survey_id' => $this->survey->id, 'label' => $label, 'field' => $field, 'type' => 'select', 'options' => json_encode($options)])
        ;
    }
}
