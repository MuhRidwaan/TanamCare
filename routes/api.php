<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import Controller
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserPlantController;
use App\Http\Controllers\Api\MonitoringLogController;
use App\Http\Controllers\Api\PlantSpeciesController;
use App\Http\Controllers\Api\PlantIssueController; // <--- Tambahkan ini

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Katalog Tanaman (Public)
Route::get('/species', [PlantSpeciesController::class, 'index']);
Route::get('/species/{id}', [PlantSpeciesController::class, 'show']);

// Knowledge Base Solusi (Public)
Route::get('/issues', [PlantIssueController::class, 'index']); // Bisa ?species_id=...
Route::get('/issues/{id}', [PlantIssueController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // --- Modul Tanaman Saya ---
    Route::get('/my-plants', [UserPlantController::class, 'index']);
    Route::post('/my-plants', [UserPlantController::class, 'store']);
    Route::get('/my-plants/{id}', [UserPlantController::class, 'show']);

    // --- Modul Monitoring ---
    Route::post('/logs', [MonitoringLogController::class, 'store']);

    // --- Modul Admin / Create Master Data ---
    Route::post('/species', [PlantSpeciesController::class, 'store']);
    Route::post('/issues', [PlantIssueController::class, 'store']); // <--- Route Tambah Solusi
});