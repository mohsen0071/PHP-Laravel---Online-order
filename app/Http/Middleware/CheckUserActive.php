<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserActive
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
        if(auth()->check()) {
            if(auth()->user()->isActive())
                return $next($request);
        }

        return abort(404);
    }
}
