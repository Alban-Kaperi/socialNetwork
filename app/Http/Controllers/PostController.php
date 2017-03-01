<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use App\Post;
class PostController extends Controller
{
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
}
