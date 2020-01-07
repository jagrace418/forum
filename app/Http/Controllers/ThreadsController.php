<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ThreadsController extends Controller {

	public function __construct () {
		$this->middleware('auth')
			->except(['show', 'index']);
	}

	/**
	 * Display a listing of the resource.
	 * @return Factory|View
	 */
	public function index () {
		$threads = Thread::latest()->get();

		return view('threads.index', compact('threads'));
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Factory|View
	 */
	public function create () {
		return view('threads.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 *
	 * @return RedirectResponse|Redirector
	 * @throws ValidationException
	 */
	public function store (Request $request) {
		$this->validate($request, [
			'title'      => 'required',
			'body'       => 'required',
			'channel_id' => 'required|exists:channels,id',
		]);

		$thread = Thread::create([
			'user_id'    => auth()->id(),
			'channel_id' => request('channel_id'),
			'title'      => request('title'),
			'body'       => request('body'),
		]);

		return redirect($thread->path());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Channel $channel
	 * @param Thread  $thread
	 *
	 * @return Factory|View
	 */
	public function show (Channel $channel, Thread $thread) {
		return view('threads.show', compact('thread'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Thread $thread
	 *
	 * @return Response
	 */
	public function edit (Thread $thread) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param Thread  $thread
	 *
	 * @return Response
	 */
	public function update (Request $request, Thread $thread) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Thread $thread
	 *
	 * @return Response
	 */
	public function destroy (Thread $thread) {
		//
	}
}
