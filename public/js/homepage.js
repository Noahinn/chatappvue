var recipient_id = "";
var group_id = "";
var kind = "";
var group_mem_id ="";


var base_url = window.location.origin + '/chat/public';

function clickButton(str, id){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

  $.ajax({
    url: base_url+str,
    data: {
      id : id,
  },
  type: 'post',
  dataType: 'json',
  success: function (response){
     location.reload();
 },
 error : function(xhr, textStatus, errorThrown) {
    alert('Ajax request failed.');
}
});
}

$(document).on( "click","[name='add']" , function(event) {
  var str ='/add';
  var id = event.target.id;
  clickButton(str, id);
});

$(document).on( "click","[name='confirm']" , function(event) {
  var str ='/accept';
  var id = event.target.id;
  clickButton(str, id);
});

$(document).on( "click","[name='del']" , function(event) {
  var str ='/delete';
  var id = event.target.id;
  clickButton(str, id);
});


// load messages history via click
$("[name='info']").click(function(event) {
  $('.addmem').hide();
  kind = 'p';
  recipient_id ="";
  recipient_id = this.id;
  namefriend = $('.namefriend-'+recipient_id).html();
  $('.icon-'+this.id).hide();
  $('#namefriend').html(namefriend);
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

  $.ajax({
    url: base_url+'/loadmessage',
    data: {
      recipient_id : recipient_id,
  },
  type: 'post',
  dataType: 'json',
  success: function (response){
      $('#chats').empty();
      if(jQuery.isEmptyObject(response.messages)){
      }
      else{
        response.messages.forEach(function(item) {
          var str = '<li class="left clearfix">'
          +'<div class="chat-body clearfix">'
          +'<div class="header">'
          +'<strong class="primary-font">'
          +item.name
          +'</strong>'
          +'</div>'
          +'<p>'
          +item.message
          +'</p>'
          +'</div>'
          +'</li>';
          $("#chats").append(str);
      });
        $('#myPanel').animate({
          scrollTop: $('#myPanel').get(0).scrollHeight}, 100);
    }

},
error : function(xhr, textStatus, errorThrown) { 
  alert('error'); 
}
});
});

// send message function
function sendMessage(){

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: base_url+'/sendmessage',
    data: {
      textmess : $("#textmess").val(),
      recipient_id: recipient_id,
  },
  type: 'post',
  dataType: 'json',
  success: function (response){
      $("#textmess").val('');
      var str = '<li class="left clearfix">'
      +'<div class="chat-body clearfix">'
      +'<div class="header">'
      +'<strong class="primary-font">'
      +response.user.name
      +'</strong>'
      +'</div>'
      +'<p>'
      +response.message.message
      +'</p>'
      +'</div>'
      +'</li>'
      $("#chats").append(str);
      $('#myPanel').animate({
        scrollTop: $('#myPanel').get(0).scrollHeight}, 1000);
  },
  error : function(xhr, textStatus, errorThrown) { 
      alert('Ajax request failed.'); 
  }
});
}

$("#btn-chat").click(function(){
  if (kind == 'p'){
    sendMessage();
}else{
    sendMessageGroup();
}

});

$('#textmess').keypress(function(event){
  var keycode = (event.keyCode ? event.keyCode : event.which);
  if(keycode == '13'){
    if (kind == 'p'){
      sendMessage();
  }else{
      sendMessageGroup();
  }
}
});

// click addgroup
$('.addgroup').click(function(){
  $('#exampleModal').modal('show');
  group_id = this.name;
})

//create group
$("[name='addgroup']").click(function(event) {
  namegroup = $('#recipient-name').val();

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

  $.ajax({
    url: base_url+'/creategroup',
    data: {
      user_id_2 : group_id,
      name : namegroup,
  },
  type: 'post',
  dataType: 'json',
  success: function (response){
      alert(response.notification);
      location.reload();
  },
  error : function(xhr, textStatus, errorThrown) { 
      alert('error'); 
  }
});
});

// LOAD MESSAGES GROUP
$("[name='infogroup']").click(function(event) {
  $('.addmem').show();

  kind = 'g';
  group_id = this.id;
  $('#group-id').val(group_id);
  namegroup = $('.namegroup-'+group_id).html();
  $('#namefriend').html(namegroup);
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

  $.ajax({
    url: base_url+'/loadmessagegroup',
    data: {
      group_id : group_id,
  },
  type: 'post',
  dataType: 'json',
  success: function (response){
      $('#chats').empty();
      if(jQuery.isEmptyObject(response.messages)){
      }
      else{
        response.messages.forEach(function(item) {
          var str = '<li class="left clearfix">'
          +'<div class="chat-body clearfix">'
          +'<div class="header">'
          +'<strong class="primary-font">'
          +item.name
          +'</strong>'
          +'</div>'
          +'<p>'
          +item.message
          +'</p>'
          +'</div>'
          +'</li>';
          $("#chats").append(str);
      });
        $('#myPanel').animate({
          scrollTop: $('#myPanel').get(0).scrollHeight}, 100);
    }

},
error : function(xhr, textStatus, errorThrown) { 
  alert('error'); 
}
});
});
// send message group function
function sendMessageGroup(){

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
  $.ajax({
    url: base_url+'/sendmessagegroup',
    data: {
      textmess : $("#textmess").val(),
      group_id: group_id,
  },
  type: 'post',
  dataType: 'json',
  success: function (response){
      $("#textmess").val('');
      var str = '<li class="left clearfix">'
      +'<div class="chat-body clearfix">'
      +'<div class="header">'
      +'<strong class="primary-font">'
      +response.user.name
      +'</strong>'
      +'</div>'
      +'<p>'
      +response.message.message
      +'</p>'
      +'</div>'
      +'</li>'
      $("#chats").append(str);
      $('#myPanel').animate({
        scrollTop: $('#myPanel').get(0).scrollHeight}, 1000);
  },
  error : function(xhr, textStatus, errorThrown) { 
      alert('Ajax request failed.'); 
  }
});
}

// function loadFriendToAddGroup
function loadFriend(){
    $("#load-friend").empty();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

    $.ajax({
      url: base_url+'/loadfriend',
      data: {
        group_id: group_id,
    },
    type: 'post',
    dataType: 'json',
    success: function (response){
        response.friends.forEach(function(item) {
          var str = '<div class="info">'
          +'<img class="rounded-circle" src="'
          +item.user.avatar
          +'">'
          +'<h5 class="namefriend-'
          +item.user.id
          +'">'
          +item.user.name
          +'</h5>'
          +'<div class="dropdown">'
          +'<button name="add-with-id" id="'
          +item.user.id
          +'" class="addmem btn btn-primary">Add'
          +'</button>'
          +'</div>'
          +'</div>';
          $("#load-friend").append(str);
      });
    },
    error : function(xhr, textStatus, errorThrown) { 
        alert('Ajax request failed.'); 
    }
});
}


// function AddMember
function addMember($id_member){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

  $.ajax({
    url: base_url+'/addmem',
    data: {
      id_member: $id_member,
      user_add : $("#recipient-name-add").val(),
      group_id: group_mem_id,
  },
  type: 'post',
  dataType: 'json',
  success: function (response){
     alert(response.notification);
 },
 error : function(xhr, textStatus, errorThrown) { 
    alert('Ajax request failed.'); 
}
});  
}

// click add with name
$("[name='addmem']").click(function(event) {
  addMember(0);
});

//click add with list friends
$(document).on( "click","[name='add-with-id']" , function(event) {
  addMember(this.id);
  loadFriend();
});

// Click Add Button
$('.addmem').click(function(){
  $('#addMemModal').modal('show');
  loadFriend();
});
