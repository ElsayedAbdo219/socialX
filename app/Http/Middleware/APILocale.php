<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class APILocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Request()->server('HTTP_ACCEPT_LANGUAGE')) {
            App::setLocale(Request()->server('HTTP_ACCEPT_LANGUAGE'));
        } else {
            App::setLocale(config('app.locale'));
        }
        return $next($request);
    }
}
