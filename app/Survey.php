<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    //

    public function questions()
    {
    	return $this->belongsToMany('App\Question', 'survey_questions')->withTimestamps();
    }
}
