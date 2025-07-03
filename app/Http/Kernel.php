<?php

namespace App\Http;

use App\Http\Middleware\CheckTokenExpiration;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        // ...existing middleware...
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // ...existing middleware...
        'check.token.expiration' => CheckTokenExpiration::class,
    ];
}