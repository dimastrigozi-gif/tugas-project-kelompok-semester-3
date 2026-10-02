<?php

namespace App\Modules\Tournament;

use App\Modules\ModuleServiceProvider;

/**
 * Modul: Tournament (alias 'tournament').
 * Tanggung jawab: Bikin dan kelola turnamen.
 */
final class TournamentServiceProvider extends ModuleServiceProvider
{
    public function register(): void
    {
        // Binding kontrak -> implementasi ditambahkan saat modul diimplementasikan.
    }

    protected function moduleAlias(): string
    {
        return 'tournament';
    }
}
