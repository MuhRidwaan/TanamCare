<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringLog extends Model 
{
    public $timestamps = false; // Karena di migrasi tidak ada $table->timestamps() hanya 'log_date'

    protected $fillable = [
        'user_plant_id',
        'height_cm',
        'leaf_count',
        'condition',
        'log_date'
    ];

    protected $casts = [
        'log_date' => 'date',
        'height_cm' => 'float',
    ];

    public function userPlant() { 
        return $this->belongsTo(UserPlant::class); 
    }
}