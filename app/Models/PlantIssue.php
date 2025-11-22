<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlantSpecies extends Model {
    use SoftDeletes;
    protected $guarded = ['id']; // Shortcut agar semua kolom bisa diisi kecuali ID

    public function issues() {
        return $this->hasMany(PlantIssue::class, 'species_id');
    }
}