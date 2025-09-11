<?php
// routes/api.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController; // <-- Kita akan buat controller ini
use App\Http\Controllers\Api\KejadianBencanaApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Endpoint publik untuk login via AJAX/modal
// Route::post('/login', [AuthController::class, 'login']);

// API Kejadian Bencana untuk Peta
Route::prefix('kejadian-bencana')->group(function () {
    Route::get('/', [KejadianBencanaApiController::class, 'index']);
    Route::get('/jenis-bencana', [KejadianBencanaApiController::class, 'jenisBencana']);
    Route::get('/kecamatan', [KejadianBencanaApiController::class, 'kecamatan']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
