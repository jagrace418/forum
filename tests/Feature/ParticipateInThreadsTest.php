<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInThreadsTest extends TestCase {

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

	public function test_reply_requires_body () {
		$this->withExceptionHandling();
		$this->signIn();

		$thread = create(Thread::class);
		/** @var Reply $reply */
		$reply = make(Reply::class, ['body' => null]);

		$this->post($thread->path() . '/replies', $reply->toArray())
			->assertSessionHasErrors('body');
	}
}
