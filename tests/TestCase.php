<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery as m;
use Faker\Factory as Faker;
use App\Note;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;

    protected $faker;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        $this->faker = Faker::create();

        factory(Note::class)->create([
            'value' => 20,
            'color' => 'green'
        ]);

        factory(Note::class)->create([
            'name' => 'pending',
            'color' => 'yellow'
        ]);
    }

    protected function mockInstance(string $class)
    {
        $this->app->instance($class, m::mock($class));

        return $this->app->make($class);
    }

    public function tearDown()
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }
}
