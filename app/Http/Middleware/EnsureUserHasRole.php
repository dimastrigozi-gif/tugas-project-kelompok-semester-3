<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware yang memastikan user punya role tertentu
 * dan statusnya aktif sebelum boleh akses route.
 *
 * Cara pakai di route:
 *   Route::middleware(['web', 'role:admin'])
 *
 * Kalau user bukan role yang diminta → 403 Forbidden.
 */
class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        // Kalau belum login atau role-nya gak cocok → 403.
        if ($user === null || ! $user->hasRole($role)) {
            abort(403, 'Akses ditolak. Role Anda tidak sesuai.');
        }

        return $next($request);
    }
}
