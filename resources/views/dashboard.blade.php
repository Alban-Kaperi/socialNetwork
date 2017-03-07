@extends('layouts.master')

@section('content')
@include('includes.message-block')
<section  class="row new-post">
  <div class="col-md-6 col-md-offset-3">
    <header><h3>What do you have to say?</h3></header>
    <form class="" action="{{route('post.create')}}" method="post">
      <div class="form-group">
        <textarea name="body" class="form-control" name="new-post" id="new-post"></textarea>
        <br>
        <button type="submit" class="btn btn-primary">Create Post</button>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
      </div>
    </form>
  </div>
</section>



<section class="row posts">
<div class="col-md-6 col-md-offset-3">
  <header>
    <h3>What other people say...</h3>
  </header>
  @foreach($posts as $post)
  <article class="post" data-postid="{{$post->id}}">
    <p class="post-body">{{$post->body}}</p>
    <div class="info">
      Posted by {{$post->user->first_name}} on {{$post->created_at}}
    </div>
    <div class="interaction">
      <a href="#" class="like">{{Auth::user()->likes()->where('post_id', $post->id)->first()?Auth::user()->likes()->where('post_id', $post->id)->first()->like==1?"You like this post":"Like":"Like"}}</a>|
      <a href="#" class="like">{{Auth::user()->likes()->where('post_id', $post->id)->first()?Auth::user()->likes()->where('post_id', $post->id)->first()->like==0?'You don\'t like this post':"Dislike":"Dislike"}}</a>
      @if(Auth::user()==$post->user)
      |
      <a href="#" class="edit">Edit</a>|
      <a href="{{ route('post.delete', ['post_id'=>$post->id]) }}">Delete</a>
      @endif

    </div>
  </article>
  <br><br>
  @endforeach
</div>
</section>

<div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Post</h4>
      </div>
      <div class="modal-body">
        <form  action="index.html" method="post">
          <div class="form-group">
            <label for="post-body">Edit the Post</label>
            <textarea name="name" rows="6" class="form-control" id="post-body"></textarea>


          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
  var token='{{ csrf_token() }}';
  var urlEdit='{{ route('edit') }}';
  var urlLike='{{ route('like') }}';
</script>
@endsection
