<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringLog extends Model {
    protected $guarded = ['id'];
    public function userPlant() { return $this->belongsTo(UserPlant::class); }
}