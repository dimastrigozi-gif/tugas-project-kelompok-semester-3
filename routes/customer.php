<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Portal PESERTA (publik, anonim)
|--------------------------------------------------------------------------
| File ini di-load oleh PortalRoutes::customer() dari bootstrap/app.php.
| Prefix & name sudah di-set di sana, jadi di sini LANGSUNG route-nya.
*/

Route::get('/', function () {
    return view('peserta.home');
})->name('home');
