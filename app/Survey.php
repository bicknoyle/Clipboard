<?php

namespace App;

use App\Response;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    //

    public function addResponse(Response $response)
    {
    	$this->responses()->save($response);
    }

    public function questions()
    {
    	return $this->belongsToMany('App\Question', 'survey_questions')->withTimestamps();
    }

    public function responses()
    {
    	return $this->hasMany('App\Response');
    }

    public function rules()
    {
    	$rules = [];
    	foreach ($this->questions as $question) {
            $rules[$question->field] = empty($question->rules) ? '' : $question->rules;
        }

        return $rules;
    }
}
