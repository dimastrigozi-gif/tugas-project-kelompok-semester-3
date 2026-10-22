<?php

use App\Http\Middleware\EnsureUserHasRole;
use App\Support\Routing\PortalRoutes;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Portal routes — didaftarkan lewat PortalRoutes (Modul 2).
            PortalRoutes::customer(base_path('routes/customer.php'));
            PortalRoutes::tenant(base_path('routes/tenant.php'));
            PortalRoutes::admin(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => EnsureUserHasRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
