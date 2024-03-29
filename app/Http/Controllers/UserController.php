<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Http\Requests;
use App\User;

class UserController extends Controller
{


    public function postSignUp(Request $request){
      $this->validate($request,  [
        'email'=>'required|email|unique:users',
        'first_name'=>'required|min:4|max:60',
        'password'=>'required|min:4'
      ]);

      $user= new User();
      $user->first_name=$request->first_name;
      $user->email=$request->email;
      $user->password= bcrypt($request->password);
      $user->save();

      Auth::login($user);

      return redirect()->route('dashboard');

    }
    public function postSignIn(Request $request){
      $this->validate($request,  [
        'email'=>'required|email',
        'password'=>'required'
      ]);
      if(Auth::attempt(['email'=>$request['email'], 'password'=>$request['password']])){
        return redirect()->route('dashboard');
      }
      return redirect()->back();
    }

    public function getLogout(){
      Auth::logout();
      return redirect()->route('home');
    }

    public function getAccount()
    {

        return view('account', ['user'=>Auth::user()]);
    }

    public function postSaveAccount(Request $request)
    {
        $this->validate($request,  [
            'first_name'=>'required|max:128'
        ]);

        $user=Auth::user();
        $user->first_name=$request->first_name;
        $user->update();

        $file=$request->file('image');
        //$filename=$request->first_name.'-'.$user->id.'.jpg';
        $filename=$user->id.'.jpg';

        if($file){
           Storage::disk('local')->put("/user".$user->id."/".$filename, File::get($file));
        }
        return redirect()->route('account');
    }

    public function getUserImage($filename)
    {
        //$file=Storage::disk('local')->get("user".Auth::user()->id.'/'.$filename);
        $file=Storage::get("user".Auth::user()->id.'/'.$filename);
        return new Response($file,200);
    }
}
