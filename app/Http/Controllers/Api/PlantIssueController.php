<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlantIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlantIssueController extends Controller
{
    /**
     * GET /api/issues
     */
    public function index(Request $request)
    {
        $query = PlantIssue::with('species:id,name');

        if ($request->has('species_id')) {
            $query->where(function($q) use ($request) {
                $q->where('species_id', $request->species_id)
                  ->orWhereNull('species_id');
            });
        }

        $issues = $query->orderBy('name', 'asc')->get(); 

        return response()->json([
            'success' => true,
            'count' => $issues->count(),
            'data' => $issues
        ]);
    }

    /**
     * GET /api/issues/{id}
     */
    public function show($id)
    {
        $issue = PlantIssue::with('species')->find($id);

        if (!$issue) {
            return response()->json([
                'success' => false,
                'message' => 'Data penyakit tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $issue
        ]);
    }

    /**
     * POST /api/issues
     */
    public function store(Request $request)
    {
        $request->validate([
            'species_id' => 'nullable|exists:plant_species,id',
            'name' => 'required|string|max:255', 
            'scientific_name' => 'nullable|string|max:255',
            'symptoms' => 'nullable|string',
            'cause' => 'nullable|string',
            'solution' => 'nullable|string',
            'prevention' => 'nullable|string'
        ]);

        $issue = PlantIssue::create([
            'species_id' => $request->species_id,
            'name' => $request->name,
            'scientific_name' => $request->scientific_name,
            'symptoms' => $request->symptoms,
            'cause' => $request->cause,
            'solution' => $request->solution,
            'prevention' => $request->prevention,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data solusi berhasil ditambahkan',
            'data' => $issue
        ], 201);
    }
}