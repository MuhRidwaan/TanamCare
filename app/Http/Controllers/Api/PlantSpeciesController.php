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
     * Menampilkan semua katalog tanaman.
     * Digunakan saat user ingin memilih tanaman untuk ditambahkan.
     */
    public function index()
    {
        $species = PlantSpecies::select('id', 'name', 'scientific_name', 'description', 'watering_frequency_days')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $species
        ]);
    }

    /**
     * GET /api/species/{id}
     * Menampilkan detail lengkap perawatan tanaman + penyakit umumnya.
     */
    public function show($id)
    {
        // Eager load 'issues' (hama/penyakit) yang terkait dengan tanaman ini
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
     * Menambah master data tanaman baru (Biasanya untuk Admin).
     */
    public function store(Request $request)
    {
        // Opsional: Cek apakah user adalah admin
        // if ($request->user()->role !== 'admin') {
        //     return response()->json(['message' => 'Unauthorized'], 403);
        // }

        $request->validate([
            'name' => 'required|string|max:255',
            'scientific_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'watering_frequency_days' => 'required|integer|min:1',
            'optimal_temp_min' => 'nullable|integer',
            'optimal_temp_max' => 'nullable|integer',
            'sunlight_requirement' => 'nullable|string' // full_sun, shade, etc
        ]);

        $species = PlantSpecies::create([
            'name' => $request->name,
            'scientific_name' => $request->scientific_name,
            'description' => $request->description,
            'watering_frequency_days' => $request->watering_frequency_days,
            'optimal_temp_min' => $request->optimal_temp_min,
            'optimal_temp_max' => $request->optimal_temp_max,
            'sunlight_requirement' => $request->sunlight_requirement,
            'created_by' => Auth::id(), // Audit user
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Master data tanaman berhasil dibuat',
            'data' => $species
        ], 201);
    }
}