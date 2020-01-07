<?php

/** @var Factory $factory */

use App\Reply;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Reply::class, function (Faker $faker) {
    return [
		'user_id' => function () {
			return factory('App\User')->create()->id;
		},
		'thread_id' => function () {
			return factory('App\User')->create()->id;
		},
		'body'    => $faker->paragraph,
    ];
});
