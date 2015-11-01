<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SurveyTest extends TestCase
{
    use DatabaseTransactions;

    public function loadFixtures($surveyOpts = [], $questionOpts = [])
    {
        $this->survey = factory(App\Survey::class)->create($surveyOpts);
        $this->question = factory(App\Question::class)->make($questionOpts);
        $this->survey->questions()->save($this->question);
    }

    public function setUp()
    {
        parent::setUp();

        $this->faker = Faker\Factory::create();
    }

    /**
     * Test regular text question
     *
     * @return void
     */
    public function testTextQueston()
    {
        $this->loadFixtures();

        $this
            ->visit(action('SurveyController@getSurvey', ['id' => $this->survey->id]))
            ->see($this->question->label)
            ->type($this->faker->word, $this->question->field)
        ;
    }

    /**
     * Test survey question with checkbox field
     *
     * @return void
     */
    public function testCheckboxQuestion()
    {
        $this->loadFixtures([], [
            'type' => 'checkbox'
        ]);

        $this
            ->visit(action('SurveyController@getSurvey', ['id' => $this->survey->id]))
            ->see('checkbox')
            ->check($this->question->field)
        ;
    }

    /**
     * Test survey questions with select field
     *
     * @return void
     */
    public function testSelectQuestion()
    {
        $options = ["" => ""];
        foreach ($this->faker->words() as $word) {
            $options[$word] = $word;
        }
        $this->loadFixtures([], [
            'type'    => 'select',
            'options' => $options,
        ]);

        $this
            ->visit(action('SurveyController@getSurvey', ['id' => $this->survey->id]))
            ->see('<select')
            ->see(key($options))
            ->select("", $this->question->field)
        ;
    }

    /**
     * Test survey questions with radio field
     *
     * @return void
     */
    public function testRadioQuestion()
    {
        $options = [];
        foreach ($this->faker->words() as $word) {
            $options[$word] = $word;
        }
        $this->loadFixtures([], [
            'type'    => 'radio',
            'options' => $options,
        ]);

        $this
            ->visit(action('SurveyController@getSurvey', ['id' => $this->survey->id]))
            ->see('radio')
            ->see(key($options))
            ->select("", $this->question->field)
        ;
    }


    /**
     * Test submitting survey questions
     *
     * @return void
     */
    public function testSubmitSurveyQuestions()
    {
        $this->loadFixtures();
        $input = $this->faker->word;

        $this
            ->visit(action('SurveyController@getSurvey', ['id' => $this->survey->id]))
            ->type($input, $this->question->field)
            ->press('Submit')
            ->see("Thank you")
            ->seeInDatabase('answers', ['question_id' => $this->question->id, 'value' => $input])
        ;
    }

    /**
     * Test submit fails validation
     *
     * @return void
     */
    public function testSubmitFailsValidation()
    {
        $this->loadFixtures([], ['rules' => ['required']]);

        $this
            ->visit(action('SurveyController@getSurvey', ['id' => $this->survey->id]))
            ->press('Submit')
            ->seePageIs(action('SurveyController@getSurvey', ['id' => $this->survey->id]))
            ->see('The '.$this->question->field.' field is required')
        ;
    }
}
