<?php

namespace App\Support\Routing;

use Closure;
use Illuminate\Support\Facades\Route;

final class PortalRoutes
{
    public static function customer(Closure|string $routes): void
    {
        Route::middleware('web')
            ->prefix('turnamen')
            ->name('peserta.')
            ->group($routes);
    }

    public static function tenant(Closure|string $routes): void
    {
        Route::middleware(['web', 'auth', 'verified', 'tenant']) // <-- 'role:penyelenggara' diganti 'tenant'
             ->prefix('penyelenggara/{penyelenggara:id}')   // <-- Nambah {penyelenggara:username}
            ->name('penyelenggara.')
            ->scopeBindings()                                      // <-- Nambah scopeBindings
            ->group($routes);
    }

    public static function admin(Closure|string $routes): void
    {
        Route::middleware(['web', 'auth', 'verified', 'role:super_admin'])
            ->prefix('admin')
            ->name('admin.')
            ->group($routes);
    }
}