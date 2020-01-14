<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class FavoritesController extends Controller {

	/**
	 * FavoritesController constructor.
	 */
	public function __construct () {
		$this->middleware('auth');
	}

	/**
	 * @param Reply $reply
	 *
	 * @return RedirectResponse
	 */
	public function store (Reply $reply) {
		$reply->favorite();

		return back();
	}

	/**
	 * @param Reply $reply
	 *
	 * @return ResponseFactory|RedirectResponse|Response
	 */
	public function destroy (Reply $reply) {
		$reply->unfavorite();

		if (request()->wantsJson()) {
			return response([], 204);
		}

		return back();
	}
}
