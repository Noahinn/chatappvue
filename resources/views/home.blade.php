@extends('layouts.app')

@section('style')
<link href="{{ asset('css/homepage.css') }}" rel="stylesheet">
@stop

@section('content')

<div class="container-fluid" style="">
    <input type="hidden" id="room" value="{{Auth::user()->id}}">
    <!-- row friends -->
    <div class="row">
        <div class="col-md-3">
            <div class="title">
                <h5>Messenger</h5>
            </div>
            <hr>
            <div>
                @foreach ($friends as $user)
                <div name="info" id="{{$user->user->id}}" class="info">
                    <img class="rounded-circle" src="{{$user->user->avatar}}">
                    <h5 class="namefriend-{{$user->user->id}}" id="{{$user->user->id}}">{{$user->user->name}}</h5>
                    <i class="icon-{{$user->user->id}} icon-no fas fa-circle" style="color:red; display: none"></i>
                </div>
                @endforeach
            </div>
        </div>

        <!-- form chat -->
        <div class="col-md-6" >
            <div class="panel panel-default">
                <div id= "namefriend" class="title">
                    <!-- add friend name -->
                </div>
                <hr>
                <div class="panel-body" id ="myPanel">
                    <ul class="chat" id="chats">
                        <!-- load messages -->
                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="textmess" type="text" name="message" class="form-control input-sm" placeholder="Type your message here...">
                        <span class="input-group-btn">
                            <button class="btn btn-primary btn-sm" id="btn-chat">
                                Send
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- row user -->
        <div class="col-md-3">
         <div class="title">
            <h5>Others</h5>
        </div>
        <hr>
        @foreach ($users as $user)
        <div class="info">
            <img class="rounded-circle" src="{{$user->avatar}}">
            <h5 class="namefriend-{{$user->id}}"> {{$user->name}} </h5>
            <div class="dropdown">
                <button name="add" id="{{$user->id}}" class="add btn btn-primary">Add
                </button>
                <button class="more btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
                <div class="dropdown-menu">
                    <a name="info" class="add dropdown-item" id="{{$user->id}}">Send Message</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</div>

@stop
@section('script')
<script src="{{ asset('js/homepage.js') }}"></script>
@stop