<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class),
        'title' => $faker->sentence,
    ];
});

$factory->state(\App\Post::class, 'draft', ['status' => 'draft']);

$factory->state(\App\Post::class, 'published', ['status' => 'published']);
