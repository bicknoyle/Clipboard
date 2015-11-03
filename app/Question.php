<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
        'rules'   => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['label', 'field', 'type', 'rules', 'options'];

    /**
     * Check if question is required
     *
     * @return bool
     */
    public function isRequired()
    {
        return in_array('required', is_null($this->rules) ? [] : $this->rules);
    }

    /**
     * Check if question is type
     *
     * @param string $type
     * @return bool
     */
    public function isType($type)
    {
        return $type === $this->type;
    }

    /**
     * Return options attribute as a string
     *
     * @param string $delimeter
     * @return string
     */
    public function optionsToString($delimeter=', ')
    {
        if (is_null($this->options)) {
            return '';
        }

        return implode($delimeter, array_values($this->options));
    }

    public function survey()
    {
    	return $this->belongsTo('App\Survey');
    }
}
