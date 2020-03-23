<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class CheckLogin
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if( session()->exists('logged_in') && session('logged_in') ) {
      return $next($request);
    }
    return redirect('/')->withErrors(['You have to login first!!!']);
  }
}
