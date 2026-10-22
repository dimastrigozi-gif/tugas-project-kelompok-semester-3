<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $fillable = ['nama', 'id_game', 'id_kapten', 'logo'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'id_game');
    }

    public function kapten(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_kapten');
    }

    public function members(): HasMany
    {
        return $this->hasMany(TeamMember::class, 'id_tim');
    }
}