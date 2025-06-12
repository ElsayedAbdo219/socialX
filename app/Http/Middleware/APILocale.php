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
    // حدد اللغات المدعومة في مشروعك
    $supportedLocales = ['en', 'ar'];

    // Laravel هتختار أنسب لغة منهم بناءً على Accept-Language
    $locale = $request->getPreferredLanguage($supportedLocales);

    App::setLocale($locale ?? config('app.locale'));

    return $next($request);
}
}
