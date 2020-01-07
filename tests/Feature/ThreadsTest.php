<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadsTest extends TestCase {

	use DatabaseMigrations;

	public function test_user_can_view_all_threads () {
		$thread = factory(Thread::class)->create();
		$response = $this->get('/threads');
		$response->assertStatus(200);
		$response->assertSee($thread->title);
	}

	public function test_user_can_view_one_thread () {
		$thread = factory(Thread::class)->create();
		$response = $this->get($thread->path());
		$response->assertSee($thread->title);
	}
}
