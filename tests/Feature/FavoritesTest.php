<?php


namespace Tests\Feature;


use App\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoritesTest extends TestCase {

	use DatabaseMigrations;

	public function test_non_auth_user_cannot_favorite_a_reply () {
		$this->withExceptionHandling();
		$reply = create(Reply::class);
		$this->post('/replies/' . $reply->id . '/favorites')
			->assertRedirect('/login');
	}

	public function test_auth_user_can_favorite_any_reply () {
		$this->signIn();
		$reply = create(Reply::class);
		$this->post('/replies/' . $reply->id . '/favorites');
		self::assertCount(1, $reply->favorites);
	}

	public function test_auth_user_can_unfavorite_a_reply () {
		$this->signIn();
		$reply = create(Reply::class);
		$this->post('/replies/' . $reply->id . '/favorites');
		self::assertCount(1, $reply->favorites);
		$this->delete('/replies/' . $reply->id . '/favorites');
		self::assertCount(0, $reply->fresh()->favorites);
	}

	public function test_auth_user_can_only_favorite_once () {
		$this->signIn();
		$reply = create(Reply::class);
		try {
			$this->post('/replies/' . $reply->id . '/favorites');
			$this->post('/replies/' . $reply->id . '/favorites');
			$this->post('/replies/' . $reply->id . '/favorites');
		} catch (\Exception $e) {
			$this->fail('tried to insert duplicate favorites');
		}

		self::assertCount(1, $reply->favorites);
	}
}