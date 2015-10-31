<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['response_id', 'question_id', 'value'];

    public function response()
    {
    	return $this->belongsTo('App\Response');
    }
}
