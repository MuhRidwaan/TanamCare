<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantIssue extends Model 
{
    // Nama tabel diset manual jika tidak jamak standar (opsional, Laravel pintar menebak)
    protected $table = 'plant_issues'; 

    protected $fillable = [
        'species_id', 
        'name',             // Dulu problem_name
        'scientific_name',
        'symptoms', 
        'cause',            // Kolom baru
        'solution', 
        'prevention'
    ];

    // Relasi ke Species (Penyakit ini milik tanaman apa?)
    public function species() {
        return $this->belongsTo(PlantSpecies::class, 'species_id');
    }
}