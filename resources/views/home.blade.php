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
                    <i class="icon-{{$user->user->id}} icon-no fas fa-circle"></i>
                    <div class="dropdown">
                        <button class="more btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a id ="myModal" name="{{$user->user->id}}" class="addgroup dropdown-item" data-toggle="modal" data-target="#exampleModal">Add to group</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="title">
                <h5>Group</h5>
            </div>
            <hr>
            <div>
                @foreach ($listgroups as $group)
                <div name="infogroup" id="{{$group->group_id}}" class="info">
                    <input type="hidden" id="channelgroup" value="{{$group->name}}">
                    <h5 class="namegroup-{{$group->group_id}}" id="{{$group->group_id}}">{{$group->name}}</h5>
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
                <button class="addmem btn btn-primary" style="display: none;">Add</button>

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
                    <a name="infouser" class="add dropdown-item" id="{{$user->id}}">Send Message</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</div>
<!-- modal create group -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Group</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Name:
                        </label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button name="addgroup" type="button" class="btn btn-primary" data-dismiss="modal">Create Group
                </button>
            </div>
        </div>
    </div>
</div>
<!-- modal addmem -->
<div class="modal fade" id="addMemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <input type="hidden" id="group-id" value="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Member</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Name:
                        </label>
                        <input type="text" class="form-control" id="recipient-name-add">
                        <button name="addmem" type="button" class="btn btn-primary" data-dismiss="modal">Add
                        </button>
                    </div>
                </form>
            </div>
            <div class="load-friend" id ="load-friend">
                <!-- Load friend to here -->
            </div>
        </div>
    </div>
</div>
<div class="dropdown">
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    Dropdown button
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="#">Link 1</a>
    <a class="dropdown-item" href="#">Link 2</a>
    <a class="dropdown-item" href="#">Link 3</a>
  </div>
</div>
@stop
@section('script')
<script src="{{ asset('js/homepage.js') }}"></script>
<script src="{{ asset('js/listen.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stop