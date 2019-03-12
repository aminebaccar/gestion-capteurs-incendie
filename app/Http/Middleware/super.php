<?php

namespace App\Http\Middleware;

use Closure;

class super
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
      if (Auth::check() && (Auth::user()->role == 'super')) {
          return $next($request);
      }
      else {
        return redirect()->route('login');
      }
    }


}
