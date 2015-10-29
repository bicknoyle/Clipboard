<?php

namespace App\Providers;

use App\Repositories\SurveyRepository;
use App\Survey;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\SurveyRepository', function ($app) {
            return new SurveyRepository(new Survey);
        });
    }
}
