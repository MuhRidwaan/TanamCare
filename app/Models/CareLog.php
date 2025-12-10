<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareLog extends Model 
{
    public $timestamps = false; // Menggunakan 'performed_at'

    protected $fillable = [
        'user_plant_id',
        'action_type', // watering, fertilizing, dll
        'notes',
        'performed_at'
    ];

    protected $casts = [
        'performed_at' => 'datetime',
    ];

    public function userPlant() { 
        return $this->belongsTo(UserPlant::class); 
    }
}