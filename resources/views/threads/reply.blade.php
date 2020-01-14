<?php
/** @var \App\Reply $reply */
?>
<reply :attributes="{{$reply}}" inline-template v-cloak>
	<div id="reply-{{$reply->id}}" class="card mb-2">
		<div class="card-header">
			<div class="level">
				<h5 class="flex">
					<a href="/profiles/{{$reply->owner->name}}">
						{{$reply->owner->name}}
					</a>
					said {{$reply->created_at->diffForHumans()}} ...
				</h5>
				@can('update', $reply)
					<button class="btn btn-outline-dark" @click="editing = true">Edit</button>
					<button class="btn btn-outline-dark" @click="destroy">Delete</button>
				@endcan
				<favorite :reply="{{$reply}}"></favorite>
			</div>
		</div>
		<div class="card-body">
			<div v-if="editing">
				<div class="form-group">
					<textarea class="form-control" v-model="body"></textarea>
				</div>
				<button class="btn btn-outline-dark" @click="editing = false">Cancel</button>
				<button class="btn btn-outline-dark" @click="update">Update</button>
			</div>
			<div v-else v-text="body"></div>
		</div>
	</div>
</reply>