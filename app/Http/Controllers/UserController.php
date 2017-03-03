<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
