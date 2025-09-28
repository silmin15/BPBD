<?php
// routes/api.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController; // <-- Kita akan buat controller ini
use App\Http\Controllers\Api\KejadianBencanaApiController;
use App\Http\Controllers\Api\KecamatanApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Endpoint publik untuk login via AJAX/modal
// Route::post('/login', [AuthController::class, 'login']);

// API Kejadian Bencana (Peta)
Route::prefix('kejadian-bencana')->group(function () {
    Route::get('/', [KejadianBencanaApiController::class, 'index']);
    Route::get('/jenis-bencana', [KejadianBencanaApiController::class, 'jenisBencana']);
    Route::get('/kecamatan', [KejadianBencanaApiController::class, 'kecamatan']);
    Route::get('/statistics', [KejadianBencanaApiController::class, 'statistics']);
    Route::get('/statistics/yearly', [KejadianBencanaApiController::class, 'statisticsYearly']);
    Route::get('/statistics/by-type', [KejadianBencanaApiController::class, 'statisticsByType']);
    Route::get('/statistics/by-kecamatan', [KejadianBencanaApiController::class, 'statisticsByKecamatan']);
});

// API Kecamatan (Peta)
Route::prefix('kecamatan')->group(function () {
    Route::get('/boundaries', [KecamatanApiController::class, 'boundaries']);
    Route::get('/statistics', [KecamatanApiController::class, 'statistics']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
