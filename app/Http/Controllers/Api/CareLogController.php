<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CareLog;
use App\Models\UserPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CareLogController extends Controller
{
    // Lihat riwayat perawatan tanaman tertentu
    public function index(Request $request)
    {
        $request->validate(['user_plant_id' => 'required|exists:user_plants,id']);

        $logs = CareLog::where('user_plant_id', $request->user_plant_id)
            ->orderBy('performed_at', 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $logs]);
    }

    // Catat aktivitas baru (siram, pupuk, potong dahan)
    public function store(Request $request)
    {
        $request->validate([
            'user_plant_id' => 'required|exists:user_plants,id',
            'action_type'   => 'required|string|in:watering,fertilizing,pruning,pest_control',
            'notes'         => 'nullable|string',
            'performed_at'  => 'required|date' // Bisa diisi now() dari frontend
        ]);

        // Cek Punya Siapa
        $plant = UserPlant::where('id', $request->user_plant_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$plant) return response()->json(['message' => 'Akses ditolak'], 403);

        $log = CareLog::create([
            'user_plant_id' => $request->user_plant_id,
            'action_type'   => $request->action_type,
            'notes'         => $request->notes,
            'performed_at'  => $request->performed_at
        ]);

        return response()->json(['success' => true, 'message' => 'Aktivitas dicatat', 'data' => $log], 201);
    }
}