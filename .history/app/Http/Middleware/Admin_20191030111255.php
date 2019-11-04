<?php

namespace App\Http\Middleware;

use Closure;
use \app\AgentToken;

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
        }else{
            if (request()->header('Authorization')){
                $user = AgentToken::where('token', request()->header('Authorization'))->first();
                if ($user) {
                    return $next($request);
                }
            }else{
                return 'Your Token invalid';
            } 
        }
        //  elseif(auth()->user()->type == 'employee')
        // {
        //     return redirect(adminPath().'/employees/');
    }
}
