require('./bootstrap');

var room = $('#room').val();

Echo.channel(room)
.listen('MessageSent', (e) => {
  // if(e.user.name == namefriend){
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
   +'</li>';
   $("#chats").append(str);
   $('#myPanel').animate({
    scrollTop: $('#myPanel').get(0).scrollHeight}, 1000);
 // }
//  else{
//   $('.icon-'+e.user.id).show();
// }

});