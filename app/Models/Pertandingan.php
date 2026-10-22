<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pertandingan extends Model
{
    protected $table = 'matches';
    protected $fillable = ['id_turnamen', 'babak', 'nomor_match', 'tanggal', 'jam', 'status', 'url_stream'];

    public function turnamen(): BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'id_turnamen');
    }
}