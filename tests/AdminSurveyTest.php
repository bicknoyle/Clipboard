<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminSurveyTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test create survey
     *
     * @return void
     */
    public function testCreate()
    {
        $input = $this->faker->sentence(3);

        $this
            ->visit('/admin/surveys/create')
            ->type($input, 'name')
            ->press('Create')
            ->see('Survey created')
            ->see('Edit Survey')
            ->see($input)
            ->seeInDatabase('surveys', ['name' => $input])
        ;
    }
}
