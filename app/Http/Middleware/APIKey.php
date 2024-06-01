<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;

class APIKey
{
    use ApiResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('Api-Key') === readAPIKey()) {
            return $next($request);
        } else {
            $errors = [
                ['api_key' => ['Api Key Not Valid']],
            ];
            $message = 'Api Key Not Valid';

            return $this->respondWithErrors(
                __('Failed Operation'),
                400,
                $errors,
                __($message)
            );
        }
    }
}
