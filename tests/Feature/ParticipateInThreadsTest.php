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

	public function test_unath_user_cannot_delete_reply () {
		$this->withExceptionHandling();
		$reply = create(Reply::class);

		$this->delete("/replies/{$reply->id}")
			->assertRedirect('/login');

		$this->signIn()
			->delete("/replies/{$reply->id}")
			->assertStatus(403);
	}

	public function test_auth_user_can_delete_reply () {
		$this->signIn();
		$reply = create(Reply::class, ['user_id' => auth()->id()]);
		$this->delete("/replies/{$reply->id}")->assertStatus(302);
		$this->assertDatabaseMissing('replies', ['id' => $reply->id]);

	}

	public function test_auth_user_can_update_reply () {
		$this->signIn();
		$reply = create(Reply::class, ['user_id' => auth()->id()]);
		$attributes = [
			'id'   => $reply->id,
			'body' => 'this is a new body',
		];
		$this->patch("/replies/{$reply->id}", $attributes);
		$this->assertDatabaseHas('replies', $attributes);
	}

	public function test_unath_user_cant_update_reply () {
		$reply = create(Reply::class);
		$attributes = [
			'id'   => $reply->id,
			'body' => 'this is a new body',
		];
		$this->patch("/replies/{$reply->id}", $attributes)
			->assertRedirect('/login');
		$this->assertDatabaseMissing('replies', $attributes);
	}
}
