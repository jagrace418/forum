@extends('layouts.app')
<?php
/** @var \App\User $profileUser */
?>
@section('content')
	<div class="card">
		<div class="card-header">
			<h1>
				{{$profileUser->name}}
				<small>Since {{$profileUser->created_at->diffForHumans()}}</small>
			</h1>
			<div class="card-body">
				@foreach($threads as $thread)
					<div class="card mb-2">
						<div class="card-header">
							<div class="level">
								<span class="flex">
									<a href="{{route('profile', $thread->creator)}}">
									{{$thread->creator->name}}
								</a>
								posted: {{$thread->title}}
								</span>
								<span>{{$thread->created_at->diffForHumans()}}</span>
							</div>
						</div>

					</div>
					<div class="card-body">
						{{$thread->body}}
					</div>
					{{$threads->links()}}
				@endforeach
			</div>
		</div>
	</div>

@endsection