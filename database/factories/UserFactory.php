<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'role' => $faker->boolean(30) ? 'admin' : 'user',
        'name' => $faker->unique()->userName,
        'password' => \Hash::make('123'),
        'city' => $faker->city,
        'created_at' => $faker->dateTimeBetween('-10 years', 'now', 'Europe/Moscow'),
    ];
});
