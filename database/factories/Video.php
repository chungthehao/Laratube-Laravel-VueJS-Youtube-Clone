<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Laratube\Model;
use Faker\Generator as Faker;

$factory->define(\Laratube\Video::class, function (Faker $faker) {
    return [
        'channel_id' => function () {
            return factory(\Laratube\Channel::class)->create()->id;
        },
        'views' => $faker->numberBetween(1, 1000),
        'title' => rtrim($faker->sentence(4), '.'),
        'description' => $faker->sentence(10),
        'path' => $faker->word(), // ko quan trọng, vì chỉ xài khi convert video
        'percentage' => 100,
        'thumbnail' => $faker->imageUrl(),
    ];
});
