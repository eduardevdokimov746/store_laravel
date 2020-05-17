<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Email;
use Faker\Generator as Faker;

$factory->define(Email::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->email,
        'code_confirm' => md5(rand(1111, 9999))
    ];
});
