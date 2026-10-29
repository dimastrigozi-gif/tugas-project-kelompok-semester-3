<?php

namespace App\Modules\Tournament\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

final class TenantTournamentController extends Controller
{
    use AuthorizesRequests;

    public function show(User $penyelenggara, Tournament $tournament): JsonResponse
    {
        // Ini Satpam Policy! Kalau bukan pemilik, langsung 403 Forbidden.
        $this->authorize('view', $tournament);

        return response()->json([
            'pesan' => 'Berhasil masuk!',
            'turnamen' => $tournament->nama,
            'pemilik' => $tournament->id_penyelenggara,
        ]);
    }
}