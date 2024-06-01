<?php

namespace App\Http\Middleware;

use App\Enum\UserTypeEnum;
use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserActivation
{
    use ApiResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('api')->check() && auth('api')->user()->type == UserTypeEnum::EMPLOYEE) {
            if (!auth('api')->user()->is_active) {
                return $this->respondWithError(__('messages.responses.user_is_deactivated'));
            }
        }
        return $next($request);
    }
}
