var postId=0;//variabli qe do ruaje id e postimit tek modali
var postBodyElement=null;// variabel per te ruajtur selektorin
//mbushja e popupit me tekstin e postimit te userit
$('.post').find('.interaction').find('.edit').on('click', function(event){
  event.preventDefault();
  postBodyElement=$(this).parent().parent().children('.post-body');
  var postBody=postBodyElement.text();
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
        //console.log(msg['message']);
        //console.log(JSON.stringify(msg));
        $(postBodyElement).text(msg['new_body']);
        /*d per ta mbyllur modalin duhet me ate id ose klase me te cilen
        eshte hapur
        */
        $('#edit-modal').modal('hide');

        });
});
