<?php

//-----------------------------------------------------------------------------

//Qe te perdorim autentifikimin e laravelit duhet qe tek klasa user te perdorim:
use Illuminate\Contracts\Auth\Authenticatable;
class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
}

//pastaj kemi te drejte te perdoim :
Auth::login($user);
if(Auth::attempt(['email'=>$request['email'], 'password'=>$request['password']]))
//-----------------------------------------------------------------------------

 ?>
