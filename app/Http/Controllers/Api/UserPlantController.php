<?php

namespace App\Http\Controllers;

use App\Models\UserPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPlantController extends Controller
{
    // List tanaman milik user login
    public function index()
    {
        $plants = UserPlant::with('species') // Ambil info spesiesnya juga
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $plants]);
    }

    // Tambah tanaman baru
    public function store(Request $request)
    {
        $request->validate([
            'species_id' => 'required|exists:plant_species,id',
            'planting_date' => 'required|date',
            'location' => 'required|in:indoor,outdoor,greenhouse',
            'nickname' => 'nullable|string'
        ]);

        $plant = UserPlant::create([
            'user_id' => Auth::id(), // ID dari token
            'species_id' => $request->species_id,
            'planting_date' => $request->planting_date,
            'location' => $request->location,
            'nickname' => $request->nickname,
            'status' => 'growing'
        ]);

        return response()->json(['success' => true, 'message' => 'Tanaman ditambahkan', 'data' => $plant], 201);
    }

    // Detail tanaman + History Log
    public function show($id)
    {
        $plant = UserPlant::with(['species', 'logs' => function($q) {
            $q->orderBy('log_date', 'desc');
        }])->where('user_id', Auth::id())->find($id);

        if (!$plant) {
            return response()->json(['message' => 'Tanaman tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $plant]);
    }
}