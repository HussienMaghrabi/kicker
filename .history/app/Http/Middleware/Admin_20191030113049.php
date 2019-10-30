<?php

namespace App\Http\Middleware;

use Closure;
use \App\AgentToken;
use request;

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
            if (request()->header('Authorization')){
                $user = AgentToken::where('token', request()->header('Authorization'))->first();
                dd($user);
                if ($user) {
                    return $next($request);
                }
            }else{
                return 'Your Token invalid';
            } 
            // return redirect(adminPath().'/login');
        }
        //  elseif(auth()->user()->type == 'employee')
        // {
        //     return redirect(adminPath().'/employees/');
    }
}
