<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPlant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'species_id', 'nickname', 
        'location', 'planting_date', 'status'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Master Species (untuk ambil detail cara rawat)
    public function species()
    {
        return $this->belongsTo(PlantSpecies::class, 'species_id');
    }

    // Relasi ke Log Harian
    public function logs()
    {
        return $this->hasMany(MonitoringLog::class, 'user_plant_id');
    }
}