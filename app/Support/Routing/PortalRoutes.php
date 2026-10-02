<?php

namespace App\Support\Routing;

use Closure;
use Illuminate\Support\Facades\Route;

/**
 * Definisi TUNGGAL grup route per portal (prefix + name + middleware).
 * Dipakai oleh routes/{customer,tenant,admin}.php DAN
 * file route milik modul di app/Modules/{Modul}/routes/{portal}.php.
 */
final class PortalRoutes
{
    /**
     * Portal PESERTA (publik, anonim).
     * URL: /turnamen/... | Name prefix: peserta.
     */
    public static function customer(Closure|string $routes): void
    {
        Route::middleware('web')
            ->prefix('turnamen')
            ->name('peserta.')
            ->group($routes);
    }

    /**
     * Portal PENYELENGGARA (internal, butuh login).
     * URL: /penyelenggara/... | Name prefix: penyelenggara.
     */
    public static function tenant(Closure|string $routes): void
    {
        Route::middleware(['web', 'auth', 'verified', 'role:penyelenggara'])
            ->prefix('penyelenggara')
            ->name('penyelenggara.')
            ->group($routes);
    }

    /**
     * Portal SUPER ADMIN (internal, butuh login).
     * URL: /admin/... | Name prefix: admin.
     */
    public static function admin(Closure|string $routes): void
    {
        Route::middleware(['web', 'auth', 'verified', 'role:super_admin'])
            ->prefix('admin')
            ->name('admin.')
            ->group($routes);
    }
}
