<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanHistory extends Model 
{
    public $timestamps = false; // Menggunakan 'scanned_at'

    protected $fillable = [
        'user_plant_id',
        'detected_issue_id',
        'confidence_score',
        'image_path',
        'user_notes',
        'ai_raw_response',
        'scanned_at'
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
        'confidence_score' => 'float',
        'ai_raw_response' => 'array', // Otomatis convert JSON ke Array
    ];

    public function userPlant() { 
        return $this->belongsTo(UserPlant::class); 
    }

    public function detectedIssue() {
        return $this->belongsTo(PlantIssue::class, 'detected_issue_id');
    }
}