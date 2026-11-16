<?php

use App\Models\User;
use App\Modules\Admin\Http\Controllers\AdminTournamentController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', fn (User $penyelenggara) => view('penyelenggara.dashboard', ['penyelenggara' => $penyelenggara]))
    ->name('dashboard');

// Route Turnamen
Route::get('/tournaments', [AdminTournamentController::class, 'index'])->name('tournaments.index');
Route::get('/tournaments/create', [AdminTournamentController::class, 'create'])->name('tournaments.create');
Route::post('/tournaments', [AdminTournamentController::class, 'store'])->name('tournaments.store');