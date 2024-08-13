<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'personal_profile_id',
        'vaccine',
        'vaccinator',
        'dose',
        'vaccination_datetime',
        'remarks'
    ];

    public function personalProfiles(): BelongsTo
    {
        return $this->belongsTo(PersonalProfile::class, 'personl_profile_id');
    }
}
