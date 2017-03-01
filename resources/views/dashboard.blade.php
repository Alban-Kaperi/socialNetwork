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
  <article class="post">
    <p>
      Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
    </p>
    <div class="info">
      Posted by Ildi on 12 Feb 2016
    </div>
    <div class="interaction">
      <a href="#">Like</a>|
      <a href="#">Dislike</a>|
      <a href="#">Edit</a>|
      <a href="#">Delete</a>
    </div>
  </article>
<br><br>

  <article class="post">
    <p>
      Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
    </p>
    <div class="info">
      Posted by Albani on 12 Feb 2016
    </div>
    <div class="interaction">
      <a href="#">Like</a>|
      <a href="#">Dislike</a>|
      <a href="#">Edit</a>|
      <a href="#">Delete</a>
    </div>
  </article>

</div>
</section>
@endsection
