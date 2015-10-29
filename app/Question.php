<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //

    public function surveys()
    {
    	return $this->belongsToMany('App\Survey', 'survey_questions')->withTimestamps();
    }
}
