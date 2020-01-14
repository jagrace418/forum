@component('profiles.activities.activity')
	@slot('heading')
		{{$profileUser->name}} favorited
		<a href="{{$activity->subject->favorited->path()}}">
			a reply
		</a>
	@endslot

	@slot('body')
		{{$activity->subject->favorited->body}}
	@endslot
@endcomponent