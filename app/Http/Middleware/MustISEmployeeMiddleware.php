<?php

namespace App\Http\Middleware;

use Closure;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustISEmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('api')->user()->type != UserTypeEnum::EMPLOYEE) {
            return response()->json(['message' => 'يجب أن تكون مسجل كموظف للقيام بهذا الإجراء'], 403);
        }
        return $next($request);
    }
}
