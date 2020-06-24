<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminAuthenticated
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

//        if(auth()->check()) {
//            if(auth()->user()->isActive())
//            {
//                if(auth()->user()->isAdmin())
//                {
//                    // return redirect('/admin/panel');
//                    return $next($request);
//                }
//                else
//                {
//                    return redirect('/user/panel');
//                }
//
//            }
//
//        }
        if(auth()->check()) {
            if(auth()->user()->isAdmin())
            {
                return $next($request);
            }
            else
            {
                return redirect('/user/panel');
            }

        }

        return redirect('/');
    }
}
