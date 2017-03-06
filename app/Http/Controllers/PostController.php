<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use App\Post;
class PostController extends Controller
{

    public function getDashboard(){
      $posts=Post::orderBy('created_at','desc')->get();
      //$posts=Post::all()->sortByDesc('created_at');
      return view('dashboard', ['posts'=> $posts]);
    }

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

    public function getDeletePost($post_id){
      $post=Post::where('id', $post_id)->first();
      // ose $post=Post::find($post_id)->first();
      if(Auth::user()!=$post->user){
        return redirect()->back();
      }
      $post->delete();
      return redirect()->back()->with(['message'=>"succesfuly deleted"]);

    }

    public function postEditPost(Request $request)
    {
        $this->validate($request, [
            'body'=>'required'
        ]);
        $post=Post::find($request['postId']);
        $post->body=$request->body;
        $post->update();//mund te kishim perdor edhe nje save()
        return response()->json(['new_body'=>$post->body],200);
    }

    public function postLikePost(Request $request){
        $post_id=$request->postId;
        //per ta kthyer ne boolean sepse ne marrim nje string si input
        //$is_like=$request->isLike==='true'?true:false;
        //eshte e njejta gje me
        $is_like=$request->isLike==='true';
        $update=false;
        $post=Post::find($post_id);
        if (!$post) {
          return null;
        }
        $user=Auth::user();
        $like=$user->likes()->where('post_id', $post_id)->first();
        if ($like) {
          # code...
        }


    }

}
