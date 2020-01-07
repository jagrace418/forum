<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase {

	use DatabaseMigrations;

	public function test_unauth_user_may_not_add_replies () {
		$this->withExceptionHandling();

		$thread = create(Thread::class);

		$reply = create(Reply::class);

		$this->post($thread->path() . '/replies', $reply->toArray())
			->assertRedirect('/login');
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
