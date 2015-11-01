<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Setup some things to use for testing
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->faker = Faker\Factory::create();
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Load up some data for testing
     *
     * @return void
     */
    public function loadFixtures($surveyOpts = [], $questionOpts = [])
    {
        $this->survey = factory(App\Survey::class)->create($surveyOpts);
        $this->question = factory(App\Question::class)->make($questionOpts);
        $this->survey->questions()->save($this->question);
    }
}
