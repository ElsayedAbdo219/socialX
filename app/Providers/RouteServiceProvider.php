<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';
    protected $namespace    = 'App\\Http\\Controllers';
    protected string $apiClientNamespace = 'App\\Http\\Controllers\\Api\\V1\\Client';
    protected array $apiMiddlewares = ['api','apilocale'];

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        if(config('global.should_use_api_key_middleware')) {
            array_push($this->apiMiddlewares, 'apikey');
        }

        $this->routes(function () { 

            Route::middleware(['api','apilocale'])
                ->namespace($this->apiClientNamespace)
                ->prefix('client-api/v1')
                ->group(base_path('routes/api-v1.php'));


            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }
}
