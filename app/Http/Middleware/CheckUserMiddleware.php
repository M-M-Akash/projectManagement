<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserMiddleware
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
        if(auth()->user()->role_type == 'user') {

            return $next($request);
        }

        return redirect(route('admin.home'));
    }
}
