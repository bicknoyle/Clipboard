<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTest extends TestCase
{
    /**
     * Test admin index
     *
     * @return void
     */
    public function testIndex()
    {
        $this
            ->visit('/admin')
            ->see('Admin')
        ;
    }

    /**
     * Create survey
     */
    public function testCreateSurvey()
    {
        $this
            ->visit('/admin')
            ->click('Create Survey')
            ->seePageIs('/admin/surveys/create')
        ;
    }
}
