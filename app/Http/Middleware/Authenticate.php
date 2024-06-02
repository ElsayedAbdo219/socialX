<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
<<<<<<< HEAD
        return $request->expectsJson() ? null : route('login');
=======
        return $request->expectsJson() ? null : route('admin.login');
>>>>>>> 8e8dff787b35a54fd7a7ff9e3accd62cda6d8720
    }
}
