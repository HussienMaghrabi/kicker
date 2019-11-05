<?php
namespace App\Http\Middleware;
use App\AgentToken;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
class api
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
//    public function handle($request, Closure $next, $guard = null)
//    {
//        if (Auth::guard($guard)->check()) {
//            return $next($request);
//        }
//        return response()->json(['status'=>'login']);
//    }
    public function handle($request, Closure $next, $guard = null)
    {
        if (request()->header('Authorization'))
        {
            if (AgentToken::where('token', request()->header('Authorization'))->first())return $next($request);
        }
        $data = [
            'status' => false,
            'message' => __('api.Authorization'),
            'date' => null
        ];
        return response()->json($data);
    }
}
