<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Laratube\Model;
use Faker\Generator as Faker;
use Laratube\Channel;
use Laratube\User;

$factory->define(Channel::class, function (Faker $faker) {
    return [
        'name' => rtrim($faker->sentence(3), '.'),
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'description' => $faker->sentence(rand(25, 35)),
    ];
});
