<?php

namespace App\Http\Middleware;

use App\Enum\UserTypeEnum;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustISCompanyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      if(auth('api')->user()->type != UserTypeEnum::COMPANY) {
            return response()->json(['message' => 'يجب أن تكون مسجل كشركة للقيام بهذا الإجراء'], 403);
        }
        return $next($request);
    }
}
