<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PregnancyFormProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'personal_profile_id',
        'post_partum',
        'family_planning',
        'type_of_delivery',
        'lmp',
        'edc',
        'gp'
    ];
}
