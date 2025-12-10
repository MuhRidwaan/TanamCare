<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import Controller dengan Namespace yang Benar (Api)
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserPlantController;
use App\Http\Controllers\Api\MonitoringLogController;
use App\Http\Controllers\Api\PlantSpeciesController;
use App\Http\Controllers\Api\PlantIssueController;
use App\Http\Controllers\Api\CareLogController;
use App\Http\Controllers\Api\ScanHistoryController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| Public Routes (Tanpa Token)
|--------------------------------------------------------------------------
*/

// Auth Endpoints
Route::post('/register', [AuthController::class, 'register']);

// PERBAIKAN DI SINI: Tambahkan ->name('login')
// Ini mencegah error "Route [login] not defined" saat user belum terautentikasi
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Knowledge Base (Katalog Tanaman)
Route::get('/species', [PlantSpeciesController::class, 'index']);
Route::get('/species/{id}', [PlantSpeciesController::class, 'show']);

// Knowledge Base (Penyakit & Solusi)
Route::get('/issues', [PlantIssueController::class, 'index']);
Route::get('/issues/{id}', [PlantIssueController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Butuh Token Bearer)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    // Auth Logout & User Profile
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // --- Modul 1: Manajemen Tanaman User ---
    Route::get('/my-plants', [UserPlantController::class, 'index']);
    Route::post('/my-plants', [UserPlantController::class, 'store']);
    Route::get('/my-plants/{id}', [UserPlantController::class, 'show']);

    // --- Modul 2: Monitoring & Logs ---
    Route::post('/logs', [MonitoringLogController::class, 'store']);
    Route::get('/logs', [MonitoringLogController::class, 'index']);

    // --- Modul 3: Admin / Master Data ---
    Route::post('/species', [PlantSpeciesController::class, 'store']);
    Route::post('/issues', [PlantIssueController::class, 'store']);

        // --- Modul 4: Perawatan (Siram/Pupuk) ---
    Route::get('/care-logs', [CareLogController::class, 'index']);
    Route::post('/care-logs', [CareLogController::class, 'store']);

    // --- Modul 5: History Scan AI ---
    Route::get('/scans', [ScanHistoryController::class, 'index']);
    Route::post('/scans', [ScanHistoryController::class, 'store']);

    // --- Modul 6: Update Profil User ---
    Route::put('/user/update', [UserController::class, 'update']);
});