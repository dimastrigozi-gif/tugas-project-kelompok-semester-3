<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    // Tabel ini cuma punya kolom joined_at, bukan timestamps default
    public $timestamps = false;

    protected $fillable = ['id_tim', 'id_user', 'nama_dalam_game', 'peran', 'joined_at'];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'id_tim');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}