<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aktivitas extends Model
{
    public $timestamps = false;

    protected $table = 'aktivitas';
    protected $fillable = ['user_id', 'aktivitas', 'detail', 'waktu'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}