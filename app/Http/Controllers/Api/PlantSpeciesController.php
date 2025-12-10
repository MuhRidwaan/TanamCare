<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlantSpecies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlantSpeciesController extends Controller
{
    /**
     * GET /api/species
     */
    public function index()
    {
        $species = PlantSpecies::select('id', 'name', 'scientific_name', 'description', 'image_url')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $species
        ]);
    }

    /**
     * GET /api/species/{id}
     */
    public function show($id)
    {
        // Eager load 'issues' (hama/penyakit)
        $species = PlantSpecies::with('issues')->find($id);

        if (!$species) {
            return response()->json([
                'success' => false,
                'message' => 'Spesies tanaman tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $species
        ]);
    }

    /**
     * POST /api/species
     * Menambah master data tanaman baru.
     */
    public function store(Request $request)
    {
        // Validasi sesuai tabel plant_species terbaru
        $request->validate([
            'name' => 'required|string|max:255',
            'scientific_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            
            // Kolom teknis pertanian
            'soil_recommendation' => 'nullable|string',
            'planting_distance' => 'nullable|string',
            'sunlight_needs' => 'nullable|string', // Rename dari sunlight_requirement
            'optimal_temp_min' => 'nullable|integer',
            'optimal_temp_max' => 'nullable|integer',
            'harvest_duration_days' => 'nullable|integer',
        ]);

        $species = PlantSpecies::create([
            'name' => $request->name,
            'scientific_name' => $request->scientific_name,
            'description' => $request->description,
            'image_url' => $request->image_url,
            'soil_recommendation' => $request->soil_recommendation,
            'planting_distance' => $request->planting_distance,
            'sunlight_needs' => $request->sunlight_needs,
            'optimal_temp_min' => $request->optimal_temp_min,
            'optimal_temp_max' => $request->optimal_temp_max,
            'harvest_duration_days' => $request->harvest_duration_days,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Master data tanaman berhasil dibuat',
            'data' => $species
        ], 201);
    }
}