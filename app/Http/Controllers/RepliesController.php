<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Reply;
use App\Thread;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class RepliesController extends Controller {

	public function __construct () {
		$this->middleware('auth');
	}

	/**
	 * @param Channel $channel
	 * @param Thread  $thread
	 *
	 * @return RedirectResponse
	 * @throws ValidationException
	 */
	public function store (Channel $channel, Thread $thread) {
		$this->validate(request(), [
			'body' => 'required',
		]);

		$thread->addReply([
			'body'    => request('body'),
			'user_id' => auth()->id(),
		]);

		return back()
			->with('flash', 'Your reply has been left.');
	}

	/**
	 * @param Reply $reply
	 *
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 * @throws Exception
	 */
	public function destroy (Reply $reply) {
		$this->authorize('update', $reply);

		$reply->delete();

		return back();
	}

	/**
	 * @param Reply $reply
	 *
	 * @throws AuthorizationException
	 */
	public function update (Reply $reply) {
		$this->authorize('update', $reply);

		$reply->update(request(['body']));
	}
}
