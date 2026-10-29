<?php

use App\Models\User;
use App\Modules\Tournament\Http\Controllers\TenantTournamentController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', fn (User $penyelenggara) => view('penyelenggara.dashboard', ['penyelenggara' => $penyelenggara]))
    ->name('dashboard');

// ROUTE BARU UNTUK TAHAP 5 (Test Policy & Binding)
Route::get('/tournaments/{tournament}', [TenantTournamentController::class, 'show'])
    ->name('tournaments.show');