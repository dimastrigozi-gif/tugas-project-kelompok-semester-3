<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turnamen extends Model
{
    protected $table = 'turnamen';

    protected $fillable = [
        'nama',
        'game',
        'jadwal',
        'biaya',
    ];
}