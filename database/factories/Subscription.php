<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Laratube\Model;
use Faker\Generator as Faker;
use Laratube\Subscription;
use Laratube\User;
use Laratube\Channel;

$factory->define(Subscription::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'channel_id' => function () {
            return factory(Channel::class)->create()->id;
        },
    ];
});
