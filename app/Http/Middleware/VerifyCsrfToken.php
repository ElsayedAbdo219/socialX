<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
<<<<<<< HEAD
        //
=======
        '/pusher-auth',
        'webhook',
>>>>>>> 8e8dff787b35a54fd7a7ff9e3accd62cda6d8720
    ];
}
