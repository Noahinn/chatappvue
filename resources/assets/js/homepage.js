require('./bootstrap');
var namefriend;
var recipient_id ="";

var room = $('#room').val();
Echo.channel(room)
.listen('MessageSent', (e) => {
  if(e.user.name == namefriend){
   var str = '<li class="left clearfix">'
   +'<div class="chat-body clearfix">'
   +'<div class="header">'
   +'<strong class="primary-font">'
   +e.user.name
   +'</strong>'
   +'</div>'
   +'<p>'
   +e.message.message
   +'</p>'
   +'</div>'
   +'</li>'
   $("#chats").append(str);
   $('#myPanel').animate({
    scrollTop: $('#myPanel').get(0).scrollHeight}, 1000);
 }
 else{
  $('.icon-'+e.user.id).show();
}

});


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
          +item.user.name
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
  sendMessage();
});

$('#textmess').keypress(function(event){
  var keycode = (event.keyCode ? event.keyCode : event.which);
  if(keycode == '13'){
    sendMessage();
  }
});

// $("[name='add']").click(function(){
//  var str ='/add';
//  var id = $("[name='add']").attr('id');
//     clickButton(str, id);
// })

// $("[name='confirm']").click(function(){
//  var str ='/accept';
//  var id = $("[name='confirm']").attr('id');
//     clickButton(str, id);
// })

// $("[name='del']").click(function(){
//  var str ='/delete';
//  var id = $("[name='del']").attr('id');
//     clickButton(str, id);
// })