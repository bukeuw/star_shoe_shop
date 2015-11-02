<?php

namespace App\Http\Middleware;

use Closure;

class MustBeAdmin
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
        // check if user has logged in
        if(auth()->check()) {
            // check if user is admin
            if(auth()->user()->is_admin){ 
                return $next($request);
            } else {
                return redirect('/');
            }
        }

        return redirect('/admin/login');
    }
}
