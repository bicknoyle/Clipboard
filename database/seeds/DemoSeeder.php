<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $survey = factory(App\Survey::class)->create([
            'name'        => 'Demo Survey',
            'description' => 'This is a demo survey, showcasing all of the different types of form fields the survey can create. Try it out!',
        ]);

        $survey->questions()->save(factory(App\Question::class)->make([
            'label' => 'Email',
            'field' => 'email',
            'rules' => ['required', 'email']
        ]));

        $survey->questions()->save(factory(App\Question::class)->make([
            'label' => 'Phone',
            'field' => 'phone',
        ]));

        $survey->questions()->save(factory(App\Question::class)->make([
            'label'   => 'Favorite Color',
            'field'   => 'color',
            'type'    => 'select',
            'options' => ['', 'Red', 'Green', 'Blue'],
            'rules'   => ['required']
        ]));

        $survey->questions()->save(factory(App\Question::class)->make([
            'label'   => 'Planes, trains, or automobiles?',
            'field'   => 'vehicle',
            'type'    => 'radio',
            'options' => ['Planes', 'Trains', 'Automobiles'],
            'rules'   => ['required']
        ]));

        $survey->questions()->save(factory(App\Question::class)->make([
            'label'   => 'Please sign me up for your email list.',
            'field'   => 'opt_in',
            'type'    => 'checkbox',
        ]));
    }
}
