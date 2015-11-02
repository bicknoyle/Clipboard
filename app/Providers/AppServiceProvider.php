<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
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
        Validator::extend('rules_exist', function ($attribute, $value, $parameters, $validator) {
            $rules = (is_string($value)) ? explode('|', $value) : $value;

            foreach ($rules as $rule) {
                if (strpos($rule, ':') !== false) {
                    list($rule, $parameters) = explode(':', $rule);
                }
                if (!method_exists($validator, 'validate'.Str::studly($rule))) {

                    return false;
                }
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
