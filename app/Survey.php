<?php

namespace App;

use App\Question;
use App\Response;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    public function addResponse(Response $response)
    {
    	$this->responses()->save($response);
    }

    public function addQuestion(Question $question)
    {
        $this->questions()->save($question);
    }

    public function questions()
    {
    	return $this->hasMany('App\Question');
    }

    public function responses()
    {
    	return $this->hasMany('App\Response');
    }

    public function rules()
    {
    	$rules = [];
    	foreach ($this->questions as $question) {
            if (isset($question->rules)) {
                $rules[$question->field] = $question->rules;
            }
        }

        return $rules;
    }
}
