<?php

namespace pizzallery\Http\Middleware;

use Closure;

class CheckRole
{
  /**
  * Handle an incoming request.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \Closure  $next
  * @return mixed
  */

  public function handle($request, Closure $next, ...$role)
  {
    if (! $request->user()->hasAnyRole($role)) {
      alert()->error('Oops...', 'No tienes permisos para entrar ahi!');
      return redirect('home');
    }
    return $next($request);
  }
}
