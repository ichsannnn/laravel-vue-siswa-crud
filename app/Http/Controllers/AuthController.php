<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class AuthController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest', ['except' => 'get_logout']);
    }

    public function get_login()
    {
      return view('auth.login');
    }

    public function post_login(Request $r)
    {
      $this->validate($r, [
        'username'  => 'required',
        'password'  => 'required'
      ]);

      $username = $r->input('username');
      $password = $r->input('password');
      if (Auth::attempt(['username' => $username, 'password' => $password], true)) {
        if (Auth::viaRemember()) {
          return redirect()->intended(route('home'));
        }
        return redirect()->intended(route('home'));
      }
      return redirect()->route('login')->with('message','Username atau password salah.');
    }

    public function get_register()
    {
      return view('auth.register');
    }

    public function post_register(Request $r)
    {
      $this->validate($r, [
        'name'  => 'required',
        'username'  => 'required|unique:users',
        'email' =>  'required|unique:users',
        'password'  => 'required|confirmed'
      ]);

      $username = $r->input('username');
      $password = $r->input('password');

      $user = new User;
      $user->name = $r->input('name');
      $user->username = $username;
      $user->email = $r->input('email');
      $user->password = bcrypt($password);
      $user->save();

      if (Auth::attempt(['username' => $username, 'password' => $password], true)) {
        if (Auth::viaRemember()) {
          return redirect()->intended(route('home'));
        }
        return redirect()->intended(route('home'));
      }
    }

    public function get_logout()
    {
      Auth::logout();
      return redirect()->route('login');
    }
}
