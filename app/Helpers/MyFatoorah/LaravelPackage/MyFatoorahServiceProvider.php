<?php

namespace  App\Helpers\MyFatoorah\LaravelPackage;

use Illuminate\Support\ServiceProvider;

class MyFatoorahServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__.'/config/myfatoorah.php' => config_path('myfatoorah.php'),
        ], 'myfatoorah');

        $this->publishes([
            __DIR__.'/controller/MyFatoorahController.php' => app_path().'/Http/Controllers/MyFatoorahController.php',
        ], 'myfatoorah');


        defined('MYFATOORAH_LARAVEL_PACKAGE_VERSION') or define('MYFATOORAH_LARAVEL_PACKAGE_VERSION', '2.0.2');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/myfatoorah.php',
            'myfatoorah'
        );
    }
}
