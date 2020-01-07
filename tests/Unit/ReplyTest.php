<?php

namespace Tests\Unit;

use App\Reply;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase {

	use DatabaseMigrations;

	public function test_reply_has_owner () {
		$reply = create(Reply::class);
		self::assertInstanceOf(User::class, $reply->owner);
	}
}
