<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'personal_profile_id',
        'philhealth_number',
        'blood_type',
        'maintenance',
        'height',
        'weight',
        'bmi',
        'health_status'
    ];
}
