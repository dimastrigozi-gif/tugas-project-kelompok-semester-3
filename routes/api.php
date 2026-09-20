<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TurnamenController;

Route::get('/turnamen', [TurnamenController::class, 'index']);
Route::get('/turnamen/{id}', [TurnamenController::class, 'show']);
Route::post('/turnamen', [TurnamenController::class, 'store']);