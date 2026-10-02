<?php

namespace App\Modules\Match;

use App\Modules\ModuleServiceProvider;

/**
 * Modul: Match (alias 'match').
 * Tanggung jawab: Jadwal dan hasil pertandingan.
 */
final class MatchServiceProvider extends ModuleServiceProvider
{
    public function register(): void
    {
        // Binding kontrak -> implementasi ditambahkan saat modul diimplementasikan.
    }

    protected function moduleAlias(): string
    {
        return 'match';
    }
}
