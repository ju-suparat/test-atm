<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Note::class, function (Faker $faker) {
    return [
        'value'  => $faker->randomElement($array = array(20, 50, 100, 500, 1000)),
        'amount' => $faker->numberBetween(1, 100),
    ];
});
