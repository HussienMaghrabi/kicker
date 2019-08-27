<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;
use Closure;

class webSitelang
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
        $segment = $request->segment(1);
        if ($request->method() === 'GET') {
            if (!in_array($segment, config('app.locales'))){
                $segments = $request->segments();
                $fallback = session('locale') ?: config('app.fallback_locale');
                $segments = array_prepend($segments, $fallback);
                return redirect()->to(implode('/', $segments));
            }
            session(['locale' => $segment]);
            app()->setLocale($segment);
            session::put("Newlang",$segment);
        }
        return $next($request);
    }
}
