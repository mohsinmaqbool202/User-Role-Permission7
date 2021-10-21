<?php

namespace App\Http\Middleware;
use Session;
use Closure;

class FrontLogin
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
        if(empty(Session::has('customerSession')))
        {
            return redirect('/login-register');
        }
        return $next($request);
    }
}
