<?php

/** @var Factory $factory */

use App\Reply;
use App\Thread;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Reply::class, function (Faker $faker) {
	return [
		'user_id'   => function () {
			return create(User::class)->id;
		},
		'thread_id' => function () {
			return create(Thread::class)->id;
		},
		'body'    => $faker->paragraph,
    ];
});
