<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase {

	use DatabaseMigrations;

	private $thread;

	protected function setUp (): void {
		parent::setUp();

		$this->thread = create(Thread::class);
	}

	public function test_user_can_view_all_threads () {
		$this->get('/threads')
			->assertSee($this->thread->title);
	}

	public function test_user_can_view_one_thread () {
		$this->get($this->thread->path())
			->assertSee($this->thread->title);
	}

	public function test_user_can_read_replies_to_thread () {
		$reply = create(Reply::class, [
			'thread_id' => $this->thread->id
		]);

		$this->get($this->thread->path())
			->assertSee($reply->body);
	}

	public function test_user_filter_threads_by_channel () {
		$channel = create(Channel::class);
		$channelThread = create(Thread::class, ['channel_id' => $channel->id]);
		$thread = create(Thread::class);

		$this->get('/threads/' . $channel->slug)
			->assertSee($channelThread->title)
			->assertDontSee($thread);
	}

	public function test_user_can_filter_threads_by_username () {
		$this->signIn(create(User::class, ['name' => 'Jake']));

		$jakeThread = create(Thread::class, ['user_id' => auth()->id()]);
		$notJakeThread = create(Thread::class);

		$this->get('/threads?by=Jake')
			->assertSee($jakeThread->title)
			->assertDontSee($notJakeThread);
	}

}
