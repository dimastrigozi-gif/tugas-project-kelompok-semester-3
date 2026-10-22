<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = ['id_pendaftaran', 'jumlah', 'metode', 'bukti', 'status', 'waktu_bayar', 'catatan'];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'id_pendaftaran');
    }
}