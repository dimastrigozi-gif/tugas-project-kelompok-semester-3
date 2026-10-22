<?php

use App\Http\Controllers\Api\TurnamenController;
use Illuminate\Support\Facades\Route;

Route::get('/turnamen', [TurnamenController::class, 'index']);
Route::get('/turnamen/{id}', [TurnamenController::class, 'show']);
Route::post('/turnamen', [TurnamenController::class, 'store']);
