<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantSpecies extends Model 
{
    // Tidak perlu SoftDeletes jika tidak ada kolom deleted_at di migrasi
    // Tapi jika ingin pakai, pastikan migrasi punya $table->softDeletes();
    
    protected $guarded = ['id']; 
    
    // Atau jika ingin explicit fillable (lebih aman):
    /*
    protected $fillable = [
        'name', 'scientific_name', 'description', 'image_url',
        'soil_recommendation', 'planting_distance', 'sunlight_needs',
        'optimal_temp_min', 'optimal_temp_max', 'harvest_duration_days'
    ];
    */

    // Relasi ke Isu/Penyakit
    public function issues() {
        return $this->hasMany(PlantIssue::class, 'species_id');
    }

    // Relasi ke Tanaman User (Tanaman ini ditanam oleh siapa saja)
    public function userPlants() {
        return $this->hasMany(UserPlant::class, 'species_id');
    }
}