<?php

namespace App\Support\Tenancy;

use App\Models\User;
use RuntimeException;

/**
 * Menyimpan satu User aktif (sebagai Tenant/Penyelenggara) selama SATU request/job.
 * Didaftarkan sebagai scoped() binding agar tidak bocor antar request.
 */
final class TenantContext
{
    private ?User $user = null;

    public function set(User $user): void
    {
        $this->user = $user;
    }

    public function clear(): void
    {
        $this->user = null;
    }

    public function has(): bool
    {
        return $this->user !== null;
    }

    /** Gagal cepat bila context belum diisi (mencegah query lintas tenant tak sengaja). */
    public function user(): User
    {
        return $this->user ?? throw new RuntimeException('TenantContext belum diisi.');
    }

    public function id(): int
    {
        return $this->user()->id;
    }

    public function idOrNull(): ?int
    {
        return $this->user?->id;
    }
}