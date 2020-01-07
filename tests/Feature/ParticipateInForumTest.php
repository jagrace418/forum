<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase {

	use DatabaseMigrations;

	public function test_unauth_user_may_not_add_replies () {
		$this->expectException(AuthenticationException::class);

		$thread = create(Thread::class);

		$reply = create(Reply::class);

		$this->post($thread->path() . '/replies', $reply->toArray());
	}

	public function test_auth_user_may_participate_in_thread () {
		$this->be($user = create(User::class));

		$thread = create(Thread::class);

		$reply = make(Reply::class);

		$this->post($thread->path() . '/replies', $reply->toArray());

		$this->get($thread->path())
			->assertSee($reply->body);
	}
}
