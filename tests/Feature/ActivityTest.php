<?php


namespace Tests\Feature;


use App\Activity;
use App\Reply;
use App\Thread;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ActivityTest extends TestCase {

	use DatabaseMigrations;

	public function test_record_activity_on_thread_create () {

		$this->signIn();
		/** @var Thread $thread */
		$thread = create(Thread::class);

		$this->assertDatabaseHas('activities', [
			'type'         => 'created_thread',
			'user_id'      => auth()->id(),
			'subject_id'   => $thread->id,
			'subject_type' => Thread::class,
		]);

		/** @var Activity $activity */
		$activity = Activity::firstOrFail();

		self::assertEquals($activity->subject->id, $thread->id);
	}

	public function test_record_activity_when_reply_is_created () {
		$this->signIn();

		$reply = create(Reply::class);

		self::assertEquals(2, Activity::count());

		$this->assertDatabaseHas('activities', [
			'type'         => 'created_reply',
			'user_id'      => auth()->id(),
			'subject_id'   => $reply->id,
			'subject_type' => Reply::class,
		]);
	}

	public function test_fetches_activity_feed_for_user () {
		$this->signIn();

		$thread = create(Thread::class, [
			'user_id' => auth()->id()
		]);

		$oldThread = create(Thread::class, [
			'user_id'    => auth()->id(),
			'created_at' => Carbon::now()->subWeek()
		]);

		auth()->user()->activity()->first()->update([
			'created_at' => Carbon::now()->subWeek()
		]);

		$feed = Activity::feed(auth()->user());

		self::assertTrue($feed->keys()->contains(
			Carbon::now()->format('Y-m-d')
		));

		self::assertTrue($feed->keys()->contains(
			Carbon::now()->subWeek()->format('Y-m-d')
		));
	}
}