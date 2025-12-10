<?php

namespace App\Http\Controllers\Api; 

use App\Http\Controllers\Controller;
use App\Models\MonitoringLog;
use App\Models\UserPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringLogController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_plant_id' => 'required|exists:user_plants,id',
            'log_date' => 'required|date',
            'condition' => 'required|string',
            'photo' => 'nullable|image|max:2048'
        ]);

        $plant = UserPlant::where('id', $request->user_plant_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$plant) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('monitoring_photos', 'public');
        }

        $log = MonitoringLog::create([
            'user_plant_id' => $request->user_plant_id,
            'log_date' => $request->log_date,
            'height_cm' => $request->height_cm,
            'leaf_count' => $request->leaf_count,
            'condition' => $request->condition,
            'notes' => $request->notes,
            'photo_path' => $photoPath
        ]);

        return response()->json(['success' => true, 'data' => $log], 201);
    }
}