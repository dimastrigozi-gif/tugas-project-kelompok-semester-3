<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Portal SUPER ADMIN (internal, butuh login)
|--------------------------------------------------------------------------
| File ini di-load oleh PortalRoutes::admin() dari bootstrap/app.php.
| Prefix & name sudah di-set di sana, jadi di sini LANGSUNG route-nya.
*/

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');
