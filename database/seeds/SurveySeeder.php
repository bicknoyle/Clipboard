<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Survey::class, 3)->create()->each(function ($s) {
            factory(App\Question::class, 5)->make(['rules' => ['required']])->each(function ($q) use ($s) {
                $s->questions()->save($q);
            });
        });
    }
}
