<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ResponseComment;
use Faker\Generator as Faker;

$factory->define(ResponseComment::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 20),
        'comment' => $faker->text(60),
        'created_at' => $faker->dateTimeBetween('-1 years', 'now', 'Europe/Moscow')
    ];
});
