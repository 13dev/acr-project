<?php

namespace App\Http\Core\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class CheckIsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        return redirect('home')->with('error','You have not admin access.');
    }
}
