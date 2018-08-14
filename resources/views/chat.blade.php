@extends('layouts.app')

@section('content')

<div id="chat" class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Chats</div>
                <div class="panel-body" id ="myPanel">
                    <chat-messages :messages="messages"></chat-messages>
                </div>
                <div class="panel-footer">
                    <chat-form
                        v-on:messagesent="addMessage"
                        :user="{{ Auth::user() }}"
                    ></chat-form>
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