<?php

namespace App\Modules\Payment;

use App\Modules\ModuleServiceProvider;

/**
 * Modul: Payment (alias 'payment').
 * Tanggung jawab: Pembayaran pendaftaran turnamen.
 */
final class PaymentServiceProvider extends ModuleServiceProvider
{
    public function register(): void
    {
        // Binding kontrak -> implementasi ditambahkan saat modul diimplementasikan.
    }

    protected function moduleAlias(): string
    {
        return 'payment';
    }
}
