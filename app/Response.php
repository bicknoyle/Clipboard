<?php

namespace App;

use App\Answer;
use App\Question;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Response extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['survey_id', 'ip'];

    public function addAnswer(Answer $answer)
    {
        $this->answers()->save($answer);
    }

    public function answerQuestion(Question $question, $value)
    {
        $this->addAnswer(new Answer(['question_id' => $question->id, 'value' => $value]));
    }

    public function answerQuestions(EloquentCollection $questions, Collection $values)
    {
        foreach($questions as $question) {
            $this->answerQuestion($question, $values->get($question->field, ''));
        }
    }

    public function answers()
    {
    	return $this->hasMany('App\Answer');
    }
}
