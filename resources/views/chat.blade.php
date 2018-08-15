@extends('layouts.app')

@section('content')

<div id="chat" class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Chats</div>
                <div class="panel-body" id ="myPanel">
                    <ul class="chat" id="chats">
                        @foreach ($messages as $message)
                        <li class="left clearfix">
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">
                                        {{ $message->user->name }}
                                    </strong>
                                </div>
                                <p>
                                    {{ $message->message }}
                                </p>
                            </div>
                        </li>
                        @endforeach
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
    </div>
</div>
<input type="hidden" value = "{{$room}}" id="room">
@stop
@section('script')
<script src="{{ asset('js/chat.js') }}" defer></script>
@stop