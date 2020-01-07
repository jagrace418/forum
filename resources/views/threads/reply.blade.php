<div class="card">
	<div class="card-header">
		<a href="#">
			{{$reply->owner->name}}
			said
			{{$reply->created_at->diffForHumans()}} ...
		</a>
	</div>
	<div class="card-body">
		{{$reply->body}}
	</div>
</div>