<?php
/** @var \App\Thread $thread */
?>

@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<a href="#">
							{{$thread->creator->name}}
						</a>
						posted:
						{{$thread->title}}
					</div>
					<div class="card-body">
						{{$thread->body}}
					</div>
				</div>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-md-8">
				@foreach($thread->replies as $reply)
					@include('threads.reply')
				@endforeach
			</div>
		</div>

		@auth()
			<div class="row justify-content-center">
				<div class="col-md-8">
					<form method="POST" action="{{$thread->path() . '/replies'}}">
						@csrf
						<div class="form-group">
							<textarea name="body" id="body" class="form-control" placeholder="Say something"
									  rows="5"></textarea>
						</div>
						<button type="submit" class="btn btn-default">Post</button>
					</form>
				</div>
			</div>
		@endauth
		@guest()
			<a class="text-center" href="{{route('login')}}">Please sign-in to participate</a>
		@endguest
	</div>
@endsection
