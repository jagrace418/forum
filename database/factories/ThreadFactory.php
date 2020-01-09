<?php

/** @var Factory $factory */

use App\Channel;
use App\Thread;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Thread::class, function (Faker $faker) {
	return [
		'user_id'    => function () {
			return create(User::class)->id;
		},
		'channel_id' => function () {
			return create(Channel::class)->id;
		},
		'title'      => $faker->sentence,
		'body'       => $faker->paragraph,
	];
});
