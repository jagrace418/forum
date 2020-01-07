<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use Illuminate\Http\RedirectResponse;

class RepliesController extends Controller {

	public function __construct () {
		$this->middleware('auth');
	}

	/**
	 * @param Channel $channel
	 * @param Thread  $thread
	 *
	 * @return RedirectResponse
	 */
	public function store (Channel $channel, Thread $thread) {
		$thread->addReply([
			'body'    => request('body'),
			'user_id' => auth()->id(),
		]);

		return back();
	}
}
