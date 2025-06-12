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
    $supportedLocales = ['en', 'ar'];
    $rawLocale = $request->getPreferredLanguage(['en_EG', 'en', 'ar_EG', 'ar']);

    $map = [
      'en_EG' => 'en',
      'ar_EG' => 'ar',
    ];

    $locale = $map[$rawLocale] ?? $rawLocale ?? config('app.locale');

    App::setLocale($locale);

    return $next($request);
  }
}


// $supportedLocales = ['en', 'ar'];
//     $locale = $request->getPreferredLanguage($supportedLocales);
//     App::setLocale($locale ?? config('app.locale'));
//     return $next($request);