<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserPlantController;
use App\Http\Controllers\MonitoringLogController;
use App\Http\Controllers\PlantSpeciesController;

/*
|--------------------------------------------------------------------------
| Public Routes (Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Bisa ditambahkan route publik untuk melihat katalog tanaman jika diinginkan
// Route::get('/species', [PlantSpeciesController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Wajib Login dengan Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // --- Modul Tanaman Saya ---
    // GET /api/my-plants -> List semua tanaman user
    Route::get('/my-plants', [UserPlantController::class, 'index']);
    
    // POST /api/my-plants -> Tambah tanaman baru
    Route::post('/my-plants', [UserPlantController::class, 'store']);
    
    // GET /api/my-plants/{id} -> Detail tanaman & history log
    Route::get('/my-plants/{id}', [UserPlantController::class, 'show']);

    // --- Modul Monitoring ---
    // POST /api/logs -> Input data harian (tinggi, kondisi, foto)
    Route::post('/logs', [MonitoringLogController::class, 'store']);

    // --- Modul Master Data (Species) ---
    // Jika Controller belum dibuat, Anda bisa buat sederhana dulu
    // Route::get('/species', [PlantSpeciesController::class, 'index']);
});