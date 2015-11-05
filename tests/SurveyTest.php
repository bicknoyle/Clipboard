<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SurveyTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test survey index
     *
     * @return void
     */
    public function testIndex()
    {
        $this->loadFixtures();

        $this
            ->visit('/surveys')
            ->see($this->survey->name)
        ;
    }

    /**
     * Test survey index link to survey
     *
     * @return void
     */
    public function testLinksToSurvey()
    {
        $this->loadFixtures();

        $this
            ->visit('/surveys')
            ->click($this->survey->name)
            ->seePageIs(action('SurveyController@getSurvey', ['id' => $this->survey->id]))
        ;
    }

    /**
     * Test show survey
     *
     * @return void
     */
    public function testShowSurvey()
    {
        $this->loadFixtures();

        $this
            ->visit(action('SurveyController@getSurvey', ['id' => $this->survey->id]))
            ->see($this->survey->name)
            ->see($this->survey->description)
        ;
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
        $options = $this->faker->words(3);

        $this->loadFixtures([], [
            'type'    => 'select',
            'options' => $options,
        ]);

        $this
            ->visit(action('SurveyController@getSurvey', ['id' => $this->survey->id]))
            ->see('<select')
            ->see($options[0])
            ->see($options[1])
            ->see($options[2])
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
        $options = $this->faker->words(3);

        $this->loadFixtures([], [
            'type'    => 'radio',
            'options' => $options,
        ]);

        $this
            ->visit(action('SurveyController@getSurvey', ['id' => $this->survey->id]))
            ->see('radio')
            ->see($options[0])
            ->see($options[1])
            ->see($options[2])
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
