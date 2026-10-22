<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penyelenggara extends Model
{
    protected $table = 'penyelenggara';
    protected $fillable = ['user_id', 'nama_organisasi', 'deskripsi', 'logo', 'kontak', 'alamat'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function turnamen(): HasMany
    {
        return $this->hasMany(Tournament::class, 'id_penyelenggara');
    }
}