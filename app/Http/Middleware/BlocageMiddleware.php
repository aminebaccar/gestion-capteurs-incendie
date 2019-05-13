<?php

namespace App\Http\Middleware;

use Closure;

class BlocageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    if (Auth::check() && Auth::user()->bloque==0) {
        return $next($request);
    }
    else {
      return redirect('/blocage');
    }
}
