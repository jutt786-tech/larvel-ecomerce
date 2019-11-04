<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckoutUser
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
        // auth guest create session where request coming after login redirect same page
        if (Auth::guest()) {
            return redirect()->guest('login');
        }
        return $next($request);
    }
}
