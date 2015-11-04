<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Input;
use InvalidArgumentException;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('empty_if', function($attribute, $value, $parameters, $validator) {
            if (count($parameters) !== 2) {
                throw new InvalidArgumentException("Validation rule empty_if requires 2 parameters.");
            }

            if (Input::get($parameters[0]) == $parameters[1] and !empty($value)) {
                return false;
            }

            return true;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
