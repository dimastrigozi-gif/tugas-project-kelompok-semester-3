<?php

namespace App\Jobs;

use App\Models\Tournament;
use App\Models\User;
use App\Support\Tenancy\TenantContext;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CountTenantTournaments implements ShouldQueue
{
    use Queueable;

    public ?int $result = null;

    public function __construct(public int $userId) {}

    public function handle(TenantContext $context): void
    {
        $user = User::query()->findOrFail($this->userId);
        $context->set($user);

        try {
            // Query memakai global scope tenant aktif (nanti di Tahap 4)
            // Untuk sekarang hitung aja semua turnamen milik user ini
            $this->result = Tournament::query()->where('id_penyelenggara', $user->id)->count();
        } finally {
            $context->clear(); // WAJIB! Biar gak bocor ke job berikutnya
        }
    }
}