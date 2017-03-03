<?php

/****************************** Dita 1 ****************************************/

//Qe te perdorim autentifikimin e laravelit duhet qe tek klasa user te perdorim:
use Illuminate\Contracts\Auth\Authenticatable;
class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
}

//emipastaj kemi te drejte te perdoim :
Auth::login($user);
if(Auth::attempt(['email'=>$request['email'], 'password'=>$request['password']]))
//-----------------------------------------------------------------------------
/****************************** Dita 2 ****************************************/
// tek controlleri validojme nqs forma i permbush standartet tona nqs jo i bejme redirect
// back me te problemet kjo behet me funcionin e meposhtem
$this->validate($request,  [
  'email'=>'required|email|unique:users',
  'first_name'=>'required|min:4|max:60',
  'password'=>'required|min:4'
]);

//tek file i blade shfaqim erroret nqs ka ndonje
@if(count($errors) > 0)
    <div class="row">
        <div class="col-md-4 col-md-offset-4 error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
//Nqs duam te ndryshojme dhe pamjen gjate nje errori dhe te mbajme ne memorje
//se cfare u dergu perdorim kodin me poshte
<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email">Your E-Mail</label>
    <input class="form-control" type="text" name="email" id="email" value="{{ Request::old('email') }}">
</div>
//-----------------------------------------------------------------------------

//tek file me poshte percaktojne se ku do i bejme redirect nqs nuk eshte loguar
//app\Http\Middleware\Authenticate.php
public function handle($request, Closure $next, $guard = null)
{
    if (Auth::guard($guard)->guest()) {
        if ($request->ajax() || $request->wantsJson()) {
            return response('Unauthorized.', 401);
        } else {
            return redirect()->route('home');//pra i themi ta dergoje tek home
        }
    }

    return $next($request);
}
//-----------------------------------------------------------------------------
/****************************** Dita 3 ****************************************/
//controlleri PostController
public function postCreatePost(Request $request){
  $this->validate($request,  [
    'body'=>'required|min:4'
  ]);

  $post= new Post();
  $post->body=$request->body;
  $message="Failed to create post";
  if($request->user()->posts()->save($post))// e regjistron postimin tek useri i loguar
  {
    $message="Post created succesfuly!";
  }
  return redirect()->route('dashboard')->with(['message'=>$message]);

}


//output i erroreve

@if(count($errors) > 0)
    <div class="row">
        <div class="col-md-4 col-md-offset-4 alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
@if(Session::has('message'))
    <div class="row">
        <div class="col-md-4 col-md-offset-4 alert alert-success">
            {{Session::get('message')}}
        </div>
    </div>
@endif


//-----------------------------------------------------------------------------
/****************************** Dita 4 ****************************************/
// tek PostController shtojme
public function getDeletePost($post_id){
  $post=Post::where('id', $post_id)->first();
  // ose $post=Post::find($post_id)->first();
  $post->delete();
  return redirect()->route('dashboard')->with(['message'=>"succesfuly deleted"]);

//kurse tek dashboard.blade.php e rishkruajme ne kete menyre
@foreach($posts as $post)
<article class="post">
  <p>{{$post->body}}</p>
  <div class="info">
    Posted by {{$post->user->first_name}} on {{$post->created_at}}
  </div>
  <div class="interaction">
    <a href="#">Like</a>|
    <a href="#">Dislike</a>|
    <a href="#">Edit</a>|
    <a href="{{ route('post.delete', ['post_id'=>$post->id]) }}">Delete</a>
  </div>
</article>
<br><br>
@endforeach
//-----------------------------------------------------------------------------
/****************************** Dita 5 ****************************************/
/*shtojme edhe  keto dy variabla tek dashboardi ne fund sepse do na duhen per
 kerkesat e ajax qe te dergojme te dhenat*/
<script>
  var token='{{ csrf_token() }}';
  var urlEdit='{{ route('edit') }}';
</script>

// tek myjs.js shtojme
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

//-------------------tek routes.php shtojme--------------
Route::post('/edit', function(\Illuminate\Http\Request $request)
{
  return response()->json(['message'=>$request['body']]);
})->name('edit');
 ?>
