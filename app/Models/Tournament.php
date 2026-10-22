<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    protected $fillable = [
        'id_penyelenggara', 'id_game', 'nama', 'deskripsi', 'jenis_game',
        'maks_peserta', 'biaya_daftar', 'hadiah', 'waktu_buka', 'waktu_tutup',
        'status', 'banner', 'nama_lokasi', 'tipe', 'alamat', 'kota',
        'link_maps', 'platform_stream', 'link_stream', 'tempat_live',
    ];

    public function penyelenggara(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_penyelenggara');
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'id_game');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'id_turnamen');
    }

    public function matches(): HasMany
    {
        return $this->hasMany(Pertandingan::class, 'id_turnamen');
    }
}