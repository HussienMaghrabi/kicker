<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if (!auth()->user()) {
            return redirect(adminPath().'/login');
        }
        //  elseif(auth()->user()->type == 'employee')
        // {
        //     return redirect(adminPath().'/employees/');

        return $next($request);
    }
}
