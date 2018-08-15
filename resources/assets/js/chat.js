require('./bootstrap');
var room = $('#room').val();
Echo.channel(room)
.listen('MessageSent', (e) => {
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
});

$('#myPanel').animate({
    scrollTop: $('#myPanel').get(0).scrollHeight}, 1000);

var base_url = window.location.origin + '/chat/public';

function sendMessage(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: base_url+'/messages',
        data: {
            textmess : $("#textmess").val()
        },
        type: 'post',
        dataType: 'json',
        success: function (response){
            $('#textmess').val('');
            $('#myPanel').animate({
                scrollTop: $('#myPanel').get(0).scrollHeight}, 1000);
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
        },
        error : function(xhr, textStatus, errorThrown) { 
            alert('Ajax request failed.'); 
        }
    });
}

$("#btn-chat").click(function(){
    sendMessage();
})

$('#textmess').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        sendMessage();
    }
});