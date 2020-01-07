<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase {

	use DatabaseMigrations;

	public function publishThread ($attributes = []) {
		$this->withExceptionHandling();

		$this->signIn();

		$thread = raw(Thread::class, $attributes);

		return $this->post('/threads', $thread);
	}

	public function test_guest_cannot_create_threads () {
		$this->withExceptionHandling();

		$this->get('/threads/create')
			->assertRedirect('/login');

		$this->post('/threads')
			->assertRedirect('/login');
	}

	public function test_auth_user_can_create_threads () {
		$this->signIn();

		/** @var Thread $thread */
		$thread = make(Thread::class);

		$response = $this->post('/threads', $thread->toArray());

		$this->get($response->headers->get('Location'))
			->assertSee($thread->title)
			->assertSee($thread->body);
	}

	public function test_thread_requires_title () {
		$this->publishThread(['title' => null])
			->assertSessionHasErrors('title');
	}

	public function test_thread_requires_body () {
		$this->publishThread(['body' => null])
			->assertSessionHasErrors('body');
	}

	public function test_thread_requires_valid_channel () {
		factory(Channel::class, 2)->make();
		$this->publishThread(['channel_id' => null])
			->assertSessionHasErrors('channel_id');

		$this->publishThread(['channel_id' => 9999])
			->assertSessionHasErrors('channel_id');
	}
}
