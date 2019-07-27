<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Laratube\Model;
use Faker\Generator as Faker;

$factory->define(\Laratube\Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence(8),
        'user_id' => function () {
            return factory(\Laratube\User::class)->create()->id;
        },
        'video_id' => function () {
            return factory(\Laratube\Video::class)->create()->id;
        },
        'comment_id' => null,
    ];
});
