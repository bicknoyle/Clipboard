<?php

namespace App;

use App\Response;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function addResponse(Response $response)
    {
    	$this->responses()->save($response);
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
            $rules[$question->field] = empty($question->rules) ? '' : $question->rules;
        }

        return $rules;
    }
}
