require('./bootstrap');

var base_url = window.location.origin + '/chat/public';

// function search(){
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//     $.ajax({
//         url: base_url+'/search',
//         data: {
//             name: $("#search").val(),
//         },
//         type: 'post',
//         dataType: 'json',
//         success: function (response){
//             if(response.user == ''){
//               $("#sea").html("");
//               $('#app').hide();
//               var str = '<div class="card">'
//               +'<div class="card-header">'
//               +'<h1>'
//               + 'No Result'
//               +'</h1>'
//               +'</div>'
//               +'</div>';
//               $("#sea").append(str);
//           }
//           else{
//              $("#sea").html("");
//              $('#app').hide();
//              response.user.forEach(function(item){
//                 var str = '<div class="card">'
//                 +'<div class="card-header">'
//                 +'<a href="#">'
//                 +item.name
//                 +'</a>'
//                 +'</div>'
//                 +'<h1>'
//                 +item.email
//                 +'</h1>'
//                 +'<button name="add" style="width: 90px" id="'
//                 +item.id
//                 +'" class="add">Add'
//                 +'</button>'
//                 +'</div>';
//                 $("#sea").append(str);
//             })
//          }

//      },
//      error : function(xhr, textStatus, errorThrown) { 
//         alert('Ajax request failed.'); 
//     }
// });
// }

$('#search').keypress(function(event){

    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        window.location.href=base_url+'/search/'+ $("#search").val();
        // search();
    }
});
