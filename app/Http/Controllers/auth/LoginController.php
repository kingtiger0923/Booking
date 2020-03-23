<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users;

class LoginController extends Controller
{
  function checkUser(Request $request) {

    $data = $request->all();
    $user = Users::where('email', $data['email'])->first();

    if( $user && $user->password == $data['password'] ) {
      session(['email' => $data['email'], 'logged_in' => true]);
      return redirect('/home');
    }

    return back()->withErrors(['Login Failed!']);
  }

  function Logout() {
    session()->forget('email');
    session()->forget('logged_in');
    return redirect('/');
  }
}
