<?php

use App\Modules\Tournament\Services\PublicTournamentQuery;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Portal PESERTA (publik, anonim)
|--------------------------------------------------------------------------
| File ini otomatis dibungkus oleh PortalRoutes::customer() dari bootstrap/app.php.
| Jadi di sini kita TINGGAL TULIS ROUTE-NYA SAJA.
*/

Route::get('/', function () {
    return view('peserta.home');
})->name('home');

Route::get('/katalog', function (PublicTournamentQuery $query) {
    return response()->json([
        'pesan' => 'Katalog Turnamen Publik',
        'data' => $query->forPublic(),
    ]);
})->name('katalog');