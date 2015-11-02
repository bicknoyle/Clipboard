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
     * Set rules from a string
     *
     * @param string $string
     * @return void
     */
    public function setRulesFromString($string)
    {
        $this->rules = $this->splitPipeString($string);
    }

    public function survey()
    {
    	return $this->belongsTo('App\Survey');
    }

    /**
     * Split pipe delimited string into array
     *
     * @param string $string
     * @return array
     */
    private function splitPipeString($string)
    {
        $result = array_filter(explode('|', $string), function ($value) {
            return strlen(trim($value));
        });

        return count($result) ? $result : null;
    }
}
