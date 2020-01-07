<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase {

	use DatabaseMigrations;

	public function test_guest_cannot_create_threads () {
		$this->expectException(AuthenticationException::class);

		/** @var Thread $thread */
		$thread = factory(Thread::class)->make();

		$this->post('/threads', $thread->toArray());
	}

	public function test_auth_user_can_create_threads () {
		$this->actingAs(factory(User::class)->create());

		/** @var Thread $thread */
		$thread = factory(Thread::class)->make();

		$this->post('/threads', $thread->toArray());

		$this->get($thread->path())
			->assertSee($thread->title)
			->assertSee($thread->body);
	}
}
