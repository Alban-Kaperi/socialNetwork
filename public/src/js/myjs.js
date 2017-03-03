var postId=0;//variabli qe do ruaje id e postimit tek modali

//mbushja e popupit me tekstin e postimit te userit
$('.post').find('.interaction').find('.edit').on('click', function(event){
  event.preventDefault();
  var postBody=$(this).parent().parent().children('.post-body').text();
  //metoda e atij
  //var postBody=event.target.parentNode.parentNode.childNodes[1].textContent;
  postId=$(this).parent().parent().data('postid');
  //metoda e atij
  //  postId = event.target.parentNode.parentNode.dataset['postid'];//marrim id nga data-postid tek article
  $('#post-body').val(postBody);
  $('#edit-modal').modal();
});

//dergimi i informacionit te modalit me ajax
$('#modal-save').on('click', function () {
  var post_body=$('#post-body').val();//marrim kontetin e postimit  tek modali
    $.ajax({
            method: 'POST',
            url: urlEdit,
            data: {body: post_body, postId: postId, _token: token}
    }).done(function (msg) {
            console.log(msg['message']);
        });
});
