<?php

namespace App\Modules\Registration;

use App\Modules\ModuleServiceProvider;

/**
 * Modul: Registration (alias 'registration').
 * Tanggung jawab: Pendaftaran peserta atau tim ke turnamen.
 */
final class RegistrationServiceProvider extends ModuleServiceProvider
{
    public function register(): void
    {
        // Binding kontrak -> implementasi ditambahkan saat modul diimplementasikan.
    }

    protected function moduleAlias(): string
    {
        return 'registration';
    }
}
