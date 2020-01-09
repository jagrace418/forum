<?php
/** @var \App\Reply $reply */
?>
<div class="card mb-2">
	<div class="card-header">
		<div class="level">
			<h5 class="flex">
				<a href="/profiles/{{$reply->owner->name}}">
					{{$reply->owner->name}}
				</a>
				said {{$reply->created_at->diffForHumans()}} ...
			</h5>
		</div>
		<div>
			<form method="POST" action="/replies/{{$reply->id}}/favorites">
				@csrf
				<button type="submit" class="btn btn-outline-dark" {{$reply->isFavorited() ? 'disabled' : ''}}>
					{{$reply->favorites_count}} {{Str::plural('Favorite', $reply->favorites_count)}}
				</button>
			</form>
		</div>

	</div>
	<div class="card-body">
		{{$reply->body}}
	</div>
</div>