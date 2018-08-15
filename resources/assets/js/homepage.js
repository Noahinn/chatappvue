require('./bootstrap');

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

$(document).on( "click","[name='add']" , function() {
  var str ='/add';
  var id = $("[name='add']").attr('id');
  clickButton(str, id);
});

$(document).on( "click","[name='confirm']" , function() {
  var str ='/accept';
    var id = $("[name='confirm']").attr('id');
    clickButton(str, id);
});

$(document).on( "click","[name='del']" , function() {
  var str ='/delete';
    var id = $("[name='del']").attr('id');
    clickButton(str, id);
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