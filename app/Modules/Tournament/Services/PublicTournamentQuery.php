<?php

namespace App\Modules\Tournament\Services;

use App\Models\Tournament;
use Illuminate\Support\Collection;

final class PublicTournamentQuery
{
    /** @return Collection<int, Tournament> */
    public function forPublic(): Collection
    {
        return Tournament::query()
            ->withoutGlobalScope('tenant') // Bypass pagar
            ->whereIn('status', ['buka', 'berjalan'])
            ->orderBy('waktu_buka', 'desc')
            ->get();
    }
}