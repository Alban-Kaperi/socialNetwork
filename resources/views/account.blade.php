@extends('layouts.master')

@section('title')
    Account
@endsection

@section('content')

    <section class="row new-post">
       <div class="col-md-6 col-md-offset-3">
        <header>
            <h3>Your Account</h3>
        </header>

        <form action="{{route('account.save')}}" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" class="form-control" value="{{$user->first_name}}" id="first_name">
            </div>
            <div class="form-group">
                <label for="image">Image(only .jpg)</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <button type="submit" class="bnt btn-primary">Save Account</button>
            <input type="hidden" value="{{Session::token()}}" name="_token">
        </form>
       </div>
    </section>



    @if(Storage::disk('local')->has('user'.$user->id."/".$user->id.'.jpg'))
        <section class="row new-post">
            <div class="col-md-6 col-md-offset-3">
              <img src="{{route('account.image', ['filename'=>$user->id.'.jpg'])}}" class="img-responsive">
            </div>
        </section>
    @endif


@endsection
