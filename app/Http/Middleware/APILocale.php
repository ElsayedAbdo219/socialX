<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
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
  public function handle($request, Closure $next)
  {
    $acceptLanguage = $request->header('Accept-Language');

    // Extract the first valid locale (before the comma)
    $locale = Str::before($acceptLanguage, ',');

    // Optional: fallback if empty or not supported
    $supportedLocales = ['en', 'ar', 'en_US', 'ar_EG', 'en_GB', 'en_EG'];
    if (!in_array($locale, $supportedLocales)) {
      $locale = config('app.locale'); // fallback to default locale
    }

    app()->setLocale($locale);
    \Carbon\Carbon::setLocale($locale);

    return $next($request);
  }
}


// $supportedLocales = ['en', 'ar'];
//     $locale = $request->getPreferredLanguage($supportedLocales);
//     App::setLocale($locale ?? config('app.locale'));
//     return $next($request);