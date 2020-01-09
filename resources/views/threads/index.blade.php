<?php
/** @var \App\Thread[]|\Illuminate\Database\Eloquent\Collection $threads */
?>

@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				@forelse($threads as $thread)
					<div class="card mb-2">
						<div class="card-header level">
							<h4 class="flex">
								<a href="{{$thread->path()}}">
									{{$thread->title}}
								</a>
							</h4>
							<strong>{{$thread->replies_count}} {{Str::plural('reply', $thread->replies_count)}}</strong>
						</div>
						<div class="card-body">
							<div class="body">{{$thread->body}}</div>
						</div>
					</div>
				@empty
					<p>There are no threads in this channel right now</p>
				@endforelse
			</div>
		</div>
	</div>
@endsection
