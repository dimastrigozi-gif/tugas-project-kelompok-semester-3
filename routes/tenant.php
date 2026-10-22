<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Portal PENYELENGGARA (internal, butuh login)
|--------------------------------------------------------------------------
| File ini di-load oleh PortalRoutes::tenant() dari bootstrap/app.php.
| Prefix & name sudah di-set di sana, jadi di sini LANGSUNG route-nya.
*/

Route::get('/dashboard', function () {
    return view('penyelenggara.dashboard');
})->name('dashboard');
