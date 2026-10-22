<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected $fillable = ['nama_game', 'jenis', 'maks_anggota', 'ikon'];

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class, 'id_game');
    }

    public function tournaments(): HasMany
    {
        return $this->hasMany(Tournament::class, 'id_game');
    }
}