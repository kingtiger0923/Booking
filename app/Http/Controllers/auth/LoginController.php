<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
  function checkUser(Request $request) {
    $data = $request->all();
    $user = Users::where('email', $data['email'])->first();

    if( $user && $user->password == $data['password'] ) {
      session(['email' => $data['email'], 'logged_in' => true, 'username' => $user->name]);

      if( isset($data['remember']) ) {
          DB::table('sessions')->insert([
              'user_id' => $user->id, 'payload' => 'Nothing', 'ip_address' => $request->ip()
          ]);
      }

      return redirect('/home');
    }

    return back()->withErrors(['Login Failed!']);
  }

  function Logout() {
    session()->forget('username');
    session()->forget('email');
    session()->forget('logged_in');
    session()->forget('access_token');
    DB::table('sessions')->where('ip_address', '=', request()->ip())->delete();
    return redirect('/');
  }
}
