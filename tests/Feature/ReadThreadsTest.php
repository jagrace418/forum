<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase {

	use DatabaseMigrations;

	private $thread;

	public function test_user_can_view_all_threads () {
		$this->get('/threads')
			->assertStatus(200)
			->assertSee($this->thread->title);
	}

	public function test_user_can_view_one_thread () {
		$this->get($this->thread->path())
			->assertSee($this->thread->title);
	}

	public function test_user_can_read_replies_to_thread () {
		$reply = factory(Reply::class)
			->create(['thread_id' => $this->thread->id]);

		$this->get($this->thread->path())
			->assertSee($reply->body);

	}

	protected function setUp (): void {
		parent::setUp();

		$this->thread = factory(Thread::class)->create();
	}
}
