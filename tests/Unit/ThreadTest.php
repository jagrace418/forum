<?php

namespace Tests\Unit;

use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase {

	use DatabaseMigrations;

	private $thread;

	public function test_thread_has_replies () {

		self::assertInstanceOf(Collection::class, $this->thread->replies);
	}

	public function test_thread_has_creator () {
		self::assertInstanceOf(User::class, $this->thread->creator);
	}

	public function test_thread_can_add_replies () {
		$this->thread->addReply([
			'body'    => 'Foo',
			'user_id' => 1
		]);

		self::assertCount(1, $this->thread->replies);
	}

	protected function setUp (): void {
		parent::setUp();
		$this->thread = factory(Thread::class)->create();
	}
}
