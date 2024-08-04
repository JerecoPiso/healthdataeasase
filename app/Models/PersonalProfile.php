<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'lastname',
        'firstname',
        'middlename',
        'birthdate',
        'sex',
        'civil_status',
        'educational_attainment',
        'work',
        'family_head_id',
        'relation_ship_to_head',
        'phone_number',

    ];
}
