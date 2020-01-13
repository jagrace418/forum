<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ManageThreadsTest extends TestCase {

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

	public function test_auth_user_can_delete_thread () {
		$this->signIn();
		/** @var Thread $thread */
		$thread = create(Thread::class, ['user_id' => auth()->id()]);
		/** @var Reply $reply */
		$reply = create(Reply::class, ['thread_id' => $thread->id, 'user_id' => auth()->id()]);
		$this->deleteJson($thread->path())
			->assertStatus(204);
		$this->assertDatabaseMissing('threads', ['id' => $thread->id]);
		//make sure the replies are also deleted
		$this->assertDatabaseMissing('replies', ['id' => $reply->id]);
		//make sure the activity is also deleted
		$this->assertDatabaseMissing('activities', [
			'subject_id'   => $thread->id,
			'subject_type' => Thread::class
		]);
		$this->assertDatabaseMissing('activities', [
			'subject_id'   => $reply->id,
			'subject_type' => Reply::class
		]);
	}

	public function test_unauth_user_cannot_delete_thread () {
		/** @var Thread $thread */
		$thread = create(Thread::class);
		/** @var Reply $reply */
		$reply = create(Reply::class, ['thread_id' => $thread->id]);
		$this->delete($thread->path())
			->assertRedirect('/login');
		$this->assertDatabaseHas('threads', ['id' => $thread->id]);
		$this->assertDatabaseHas('replies', ['id' => $reply->id]);

		//try it when the thread doesn't belong to signed in user
		$this->signIn();
		$this->delete($thread->path())
			->assertStatus(403);
		$this->assertDatabaseHas('threads', ['id' => $thread->id]);
		$this->assertDatabaseHas('replies', ['id' => $reply->id]);
	}
}
