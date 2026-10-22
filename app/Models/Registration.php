<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Registration extends Model
{
    public $timestamps = false;

    protected $fillable = ['id_turnamen', 'id_user', 'id_tim', 'status', 'nomor_seed', 'waktu_daftar'];

    public function turnamen(): BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'id_turnamen');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'id_tim');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'id_pendaftaran');
    }
}