<?php


namespace Tests\Feature;


use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProfilesTest extends TestCase {

	use DatabaseMigrations;

	public function test_user_has_profile () {
		/** @var User $user */
		$user = create(User::class);
		$this->get("/profiles/{$user->name}")
			->assertSee($user->name);
	}

	public function test_profiles_show_all_threads_by_user () {
		$this->signIn();
		/** @var Thread $thread */
		$thread = create(Thread::class, ['user_id' => auth()->id()]);
		$this->get("/profiles/" . auth()->user()->name)
			->assertSee($thread->title);
	}
}