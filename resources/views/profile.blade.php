@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <input type="hidden" id="room" value="{{Auth::user()->id}}">
            <!-- Friends -->
            <h1 style="color: red">Friends</h1>
            @foreach ($friends as $user)
            <div class="card">
                @if (Auth::user()->id<=$user->user->id)
                <div class="card-header">
                    <a href="http://localhost/chat/public/chat/room-{{Auth::user()->id}}-{{$user->user->id}}">{{$user->user->name}}
                    </a>
                </div>
                @else
                <div class="card-header">
                    <a href="http://localhost/chat/public/chat/room-{{$user->user->id}}-{{Auth::user()->id}}">
                       {{$user->user->name}}
                   </a>
               </div>
               @endif
               <h1> {{$user->user->email}} </h1>
               <button style="width: 90px" id="{{$user->user->id}}" name="del">Unfriend
                </button>
            </div>
            @endforeach
            <!-- friend request -->
            <h1 style="color: red">Request</h1>
            @foreach ($friends_wait as $user)
            <div class="card">
                @if (Auth::user()->id<=$user->user->id)
                <div class="card-header">
                    <a href="http://localhost/chat/public/chat/room-{{Auth::user()->id}}-{{$user->user->id}}">
                    {{$user->user->name}}
                    </a>
                </div>
                @else
                <div class="card-header">
                    <a href="http://localhost/chat/public/chat/room-{{$user->user->id}}-{{Auth::user()->id}}">
                        {{$user->user->name}}
                    </a>
                </div>
                @endif
                <h1> {{$user->user->email}} </h1>
                <button style="width: 90px" id="{{$user->user->id}}" name="confirm">Confirm
                </button>
                <button style="width: 90px" id="{{$user->user->id}}" name="del">Delete
                </button>
            </div>
            @endforeach
            <!-- friend send -->
            <h1 style="color: red">Sent</h1>
            @foreach ($friends_send as $user)
            <div class="card">
                @if (Auth::user()->id<=$user->user->id)
                <div class="card-header">
                    <a href="http://localhost/chat/public/chat/room-{{Auth::user()->id}}-{{$user->user->id}}">
                    {{$user->user->name}}
                    </a>
                </div>
                @else
                <div class="card-header">
                    <a href="http://localhost/chat/public/chat/room-{{$user->user->id}}-{{Auth::user()->id}}">
                        {{$user->user->name}}
                    </a>
                </div>
                @endif
                <h1> {{$user->user->email}} </h1>
                <button style="width: 90px" id="{{$user->user->id}}" name="del">Delete
                </button>
            </div>
            @endforeach
        </div>
    </div>
</div>
@stop
@section('script')
<script src="{{ asset('js/homepage.js') }}"></script>
@stop