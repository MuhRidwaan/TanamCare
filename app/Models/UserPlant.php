<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPlant extends Model
{
    protected $fillable = [
        'user_id', 
        'species_id', 
        'nickname', 
        'location_type', // Dulu location
        'planting_date', 
        'growth_stage',  // seedling, vegetative, dll
        'status'         // healthy, sick, dead
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Master Species (Detail tanaman)
    public function species()
    {
        return $this->belongsTo(PlantSpecies::class, 'species_id');
    }

    // Relasi ke Log Pertumbuhan (Angka: tinggi, jumlah daun)
    public function monitoringLogs()
    {
        return $this->hasMany(MonitoringLog::class, 'user_plant_id');
    }

    // Relasi ke Log Perawatan (Siram, pupuk)
    public function careLogs()
    {
        return $this->hasMany(CareLog::class, 'user_plant_id');
    }

    // Relasi ke History Scan
    public function scanHistories()
    {
        return $this->hasMany(ScanHistory::class, 'user_plant_id');
    }
}