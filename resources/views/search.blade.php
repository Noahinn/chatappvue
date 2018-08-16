@extends('layouts.app')

@section('content')
<div id ="app" class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			@if (count($users) == 0)
			<h1>No Result</h1>
			@else
			<input type="hidden" id="room" value="{{Auth::user()->id}}">
			<h1 style="color: red">Result</h1>
			@foreach ($users as $user)
			<div class="card">
				@if (Auth::user()->id<=$user->id)
				<div class="card-header">
					<a href="http://localhost/chat/public/chat/room-{{Auth::user()->id}}-{{$user->id}}">
						{{$user->name}}
					</a>
				</div>
				@else
				<div class="card-header">
					<a href="http://localhost/chat/public/chat/room-{{$user->id}}-{{Auth::user()->id}}">
						{{$user->name}}
					</a>
				</div>
				@endif
				<h1> {{$user->email}} </h1>
				@if (in_array($user->name, $friends))
				<button style="width: 90px">Friend
				</button>
				@else
				@if (in_array($user->name, $friend_wait))
				<button style="width: 90px">Watting
				</button>
				@else
				@if (in_array($user->name, $friend_req))
				<button style="width: 90px">Delete
				</button>
				@else
				<button name="add" style="width: 90px" id="{{$user->id}}" class="add">Add
				</button>
				@endif
				@endif
				@endif
			</div>
			@endforeach
			@endif
		</div>
	</div>
</div>
@stop

@section('script')
<script src="{{ asset('js/homepage.js') }}"></script>
@stop