<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase {

	use DatabaseMigrations;

	public function test_guest_cannot_create_threads () {
		$this->withExceptionHandling();

		$this->post('/threads/create')
			->assertStatus(405);

		$this->post('/threads')
			->assertRedirect('/login');
	}

	public function test_auth_user_can_create_threads () {
		$this->signIn();

		/** @var Thread $thread */
		$thread = make(Thread::class);

		$this->post('/threads', $thread->toArray());

		$this->get($thread->path())
			->assertSee($thread->title)
			->assertSee($thread->body);
	}
}
