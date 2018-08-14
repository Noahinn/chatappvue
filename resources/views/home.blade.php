@extends('layouts.app')

@section('content')
<div id ="app" class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <input type="hidden" id="room" value="{{Auth::user()->id}}">
            <h1 style="color: red">All</h1>
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
                <button style="width: 90px" id="{{$user->id}}" class="add" v-on:click="onClick($event)">Add
                </button>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div id="sea" class="col-md-8">
        </div>
    </div>
</div>

@stop
@section('script')
<script src="{{ asset('js/homepage.js') }}"></script>
@stop