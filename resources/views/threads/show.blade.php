<?php
/** @var \App\Thread $thread */
?>

@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="card mb-2">
					<div class="card-header">
						<a href="{{route('profile', $thread->creator)}}">
							{{$thread->creator->name}}
						</a>
						posted:
						{{$thread->title}}
					</div>
					<div class="card-body">
						{{$thread->body}}
					</div>
				</div>

				@foreach($replies as $reply)
					@include('threads.reply')
				@endforeach

				{{$replies->links()}}

				@auth()
					<form method="POST" action="{{$thread->path() . '/replies'}}">
						@csrf
						<div class="form-group">
							<textarea name="body" id="body" class="form-control" placeholder="Say something"
									  rows="5"></textarea>
						</div>
						<button type="submit" class="btn btn-outline-dark">Post</button>
					</form>
				@endauth
				@guest()
					<a class="text-center" href="{{route('login')}}">Please sign-in to participate</a>
				@endguest
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<p>
							This thread was published
							{{$thread->created_at->diffForHumans()}} by
							<a href="#">
								{{$thread->creator->name}}
							</a>
							and currently has
							{{$thread->replies_count}}
							{{Str::plural('comment', $thread->replies_count)}}.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
