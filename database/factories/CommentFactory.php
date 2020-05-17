<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 20),
        'product_id' => $faker->numberBetween(2, 1400),
        'type' => $faker->boolean(50) ? 'otzuv' : 'comment',
        'comment' => $faker->text(50),
        'good_comment' => function ($comment) use ($faker) {
            if ($comment['type'] == 'otzuv') {
                return $faker->text(20);
            } else {
                return null;
            }
        },
        'bad_comment' => function ($comment) use ($faker) {
            if ($comment['type'] == 'otzuv') {
                return $faker->text(20);
            } else {
                return null;
            }
        },
        'is_notifiable' => 0,
        'rating' => function ($comment) use ($faker) {
            if ($comment['type'] == 'otzuv') {
                return $faker->numberBetween(1, 5);
            } else {
                return 0;
            }
        },
        'created_at' => $faker->dateTimeBetween('-5 years', 'now', 'Europe/Moscow')
    ];
});
