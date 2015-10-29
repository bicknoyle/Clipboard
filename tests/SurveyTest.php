<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SurveyTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->faker = Faker\Factory::create();

        $this->survey = factory(App\Survey::class)->create();
        $this->question = factory(App\Question::class)->make();
        $this->survey->questions()->save($this->question);
    }

    /**
     * Test survey questions
     *
     * @return void
     */
    public function testSurveysQuestons()
    {
        $this
            ->visit('/surveys/'.$this->survey->id.'/questions')
            ->see($this->survey->name)
            ->see($this->question->label)
        ;
    }

    public function testSubmitSurveyQuestions()
    {
        $this
            ->visit('/surveys/'.$this->survey->id.'/questions')
            ->type($this->faker->word, $this->question->field)
            ->press('Submit')
        ;
    }
}
