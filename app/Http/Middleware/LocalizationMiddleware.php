<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $lang = 'en';
        if ($request->hasHeader('lang'))
            $lang = $request->header('lang');
        app()->setLocale($lang);
        return $next($request);
    }
}
