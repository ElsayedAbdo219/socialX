<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    Paginator::useBootstrap();
    Schema::defaultStringLength(191);
    //date_default_timezone_set(Config::get('app.timezone', 'Africa/Cairo'));
    // App::setLocale(session('locale', config('app.locale')));

    # Enforce Morph Model
    $modelFiles = Storage::disk('app')->files('Models');
    foreach ($modelFiles as $modelFile) {
      $model = str_replace('.php', '', $modelFile);
      $model = str_replace('Models/', '', $model);
      $modelClass = 'App\\Models\\' . str_replace('/', '\\', $model);
      Relation::enforceMorphMap([
        "$model" => "$modelClass"
      ]);
    }


    Response::macro('apiResponse', function ($data, $error, $pagination, $extras, $message, $success, $code) {
      $response = array(
        "success" => $success,
        "data" => $data,
        "error" => $error,
        "pagination" => $pagination,
        "extras" => $extras,
        "message" => $message,
      );
      return response()->json($response, $code, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    });

    /**
     * Paginate a standard Laravel Collection.
     *
     * @param int $perPage
     * @param int $total
     * @param int $page
     * @param string $pageName
     * @return array
     */
    Collection::macro('customPaginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
      $page = $page ?:  LengthAwarePaginator::resolveCurrentPage($pageName);
      return new LengthAwarePaginator(
        $this->forPage((int)$page, (int)$perPage)->values(), // 👈 دي الإضافة المهمة
        $total ?: $this->count(),
        $perPage,
        $page,
        [
          'path' => LengthAwarePaginator::resolveCurrentPath(),
          'pageName' => $pageName,
        ]
      );
    });
  }
}
