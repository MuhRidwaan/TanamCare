<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'role',
        'latitude',
        'longitude',
        'city'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function userPlants()
    {
        return $this->hasMany(UserPlant::class);
    }
}