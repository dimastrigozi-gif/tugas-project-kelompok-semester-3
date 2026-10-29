<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Support\Tenancy\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resolver tenant aktif untuk route internal (Penyelenggara).
 * Dijalankan SETELAH auth.
 * Menolak bila user bukan pemilik halaman ini, atau statusnya gak aktif.
 */
final class SetTenantContext
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Ambil data penyelenggara dari URL (Route Model Binding)
        /** @var User|null $penyelenggara */
        $penyelenggara = $request->route('penyelenggara');

        // 2. Cek apakah user ini beneran penyelenggara yang aktif
        if (! $penyelenggara instanceof User || $penyelenggara->role !== 'penyelenggara') {
            abort(404);
        }

        if ($penyelenggara->status !== 'active') {
            abort(403, 'Akun penyelenggara tidak aktif.');
        }

        // 3. Cek apakah yang login adalah pemilik halaman ini
        $user = $request->user();
        if ($user === null || $user->id !== $penyelenggara->id) {
            abort(403, 'Akses ditolak. Ini bukan halaman Anda.');
        }

        // 4. Pasang gelang pengenal (TenantContext)
        $context = app(TenantContext::class);
        $context->set($penyelenggara);

        try {
            return $next($request);
        } finally {
            // 5. WAJIB: Copot gelangnya setelah selesai biar gak bocor
            $context->clear();
        }
    }
}