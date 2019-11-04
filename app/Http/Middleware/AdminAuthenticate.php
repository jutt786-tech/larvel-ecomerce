<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
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
        if (auth()->user()->role->name == 'admin'){
            return redirect(route('admin.dashboard'));

        }elseif (auth()->user()->role->name == 'user'){
//                return redirect()->back();
            return redirect(route('home'));
        }else{
            return redirect(route('login'));
        }

        return $next($request);
    }
}
