<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ScanHistory;
use App\Models\UserPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScanHistoryController extends Controller
{
    // Simpan hasil scan (Biasanya dipanggil setelah AI selesai mendeteksi)
    public function store(Request $request)
    {
        $request->validate([
            'user_plant_id' => 'required|exists:user_plants,id',
            'detected_issue_id' => 'nullable|exists:plant_issues,id', // Null jika tanaman sehat
            'confidence_score' => 'required|numeric|min:0|max:100',
            'image_path' => 'required|string', // URL atau path foto
            'user_notes' => 'nullable|string'
        ]);

        // Cek akses
        $plant = UserPlant::where('id', $request->user_plant_id)->where('user_id', Auth::id())->first();
        if (!$plant) return response()->json(['message' => 'Akses ditolak'], 403);

        $scan = ScanHistory::create([
            'user_plant_id' => $request->user_plant_id,
            'detected_issue_id' => $request->detected_issue_id,
            'confidence_score' => $request->confidence_score,
            'image_path' => $request->image_path,
            'user_notes' => $request->user_notes,
            'scanned_at' => now()
        ]);

        // Jika ditemukan penyakit, update status tanaman jadi 'sick'
        if ($request->detected_issue_id) {
            $plant->update(['status' => 'sick']);
        }

        return response()->json(['success' => true, 'data' => $scan], 201);
    }

    // Lihat history scan tanaman
    public function index(Request $request)
    {
        $request->validate(['user_plant_id' => 'required|exists:user_plants,id']);

        $history = ScanHistory::with('detectedIssue') // Ambil nama penyakitnya sekalian
            ->where('user_plant_id', $request->user_plant_id)
            ->orderBy('scanned_at', 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $history]);
    }
}