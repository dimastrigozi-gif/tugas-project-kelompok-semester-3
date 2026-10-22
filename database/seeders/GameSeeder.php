<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        Game::create([
            'nama_game' => 'Mobile Legends',
            'jenis' => 'tim',
            'maks_anggota' => 5,
            'ikon' => 'mlbb.png',
        ]);

        Game::create([
            'nama_game' => 'Free Fire',
            'jenis' => 'tim',
            'maks_anggota' => 4,
            'ikon' => 'ff.png',
        ]);
    }
}