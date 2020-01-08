<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ChannelTest extends TestCase {

	use DatabaseMigrations;

	public function test_channel_has_threads () {
		$channel = create(Channel::class);
		$thread = create(Thread::class, ['channel_id' => $channel->id]);
		self::assertTrue($channel->threads->contains($thread));
	}
}