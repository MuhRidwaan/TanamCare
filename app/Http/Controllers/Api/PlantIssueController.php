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
     * Menampilkan daftar penyakit/hama.
     * Bisa difilter berdasarkan species_id.
     * Contoh: /api/issues?species_id=1
     */
    public function index(Request $request)
    {
        $query = PlantIssue::with('species:id,name'); // Eager load nama spesies

        // Jika ada parameter ?species_id=1
        if ($request->has('species_id')) {
            // Ambil issue yang KHUSUS untuk tanaman ini ATAU issue UMUM (null)
            $query->where(function($q) use ($request) {
                $q->where('species_id', $request->species_id)
                  ->orWhereNull('species_id');
            });
        }

        $issues = $query->orderBy('problem_name', 'asc')->get();

        return response()->json([
            'success' => true,
            'count' => $issues->count(),
            'data' => $issues
        ]);
    }

    /**
     * GET /api/issues/{id}
     * Detail solusi lengkap.
     */
    public function show($id)
    {
        $issue = PlantIssue::with('species')->find($id);

        if (!$issue) {
            return response()->json([
                'success' => false,
                'message' => 'Data penyakit/solusi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $issue
        ]);
    }

    /**
     * POST /api/issues
     * Menambah knowledge base penyakit baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'species_id' => 'nullable|exists:plant_species,id', // Boleh null (masalah umum)
            'problem_name' => 'required|string|max:255',
            'symptoms' => 'required|string',
            'solution' => 'required|string',
            'prevention' => 'nullable|string'
        ]);

        $issue = PlantIssue::create([
            'species_id' => $request->species_id,
            'problem_name' => $request->problem_name,
            'symptoms' => $request->symptoms,
            'solution' => $request->solution,
            'prevention' => $request->prevention,
            'created_by' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data solusi berhasil ditambahkan',
            'data' => $issue
        ], 201);
    }
}