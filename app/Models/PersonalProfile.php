<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonalProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'lastname',
        'firstname',
        'middlename',
        'suffix',
        'birthdate',
        'sex',
        'civil_status',
        'educational_attainment',
        'work',
        'household_profile_id',
        'relation_ship_to_head',
        'phone_number',
    ];

    public function householdProfiles(): BelongsTo
    {
        return $this->belongsTo(HouseholdProfile::class);
    }
    public function scopePersonalProfileWithHealthProfile($query)
    {
        return $query->leftJoin('health_profiles AS hp', 'personal_profiles.id', '=', 'hp.personal_profile_id')->where('personal_profiles.archive', 0)
            ->orderBy('personal_profiles.id', 'desc')
            ->get([
                'personal_profiles.*', 'hp.id as health_id', 'hp.philhealth_number', 'hp.blood_type',
                'hp.maintenance', 'hp.height', 'hp.weight', 'hp.bmi', 'hp.health_status'
            ]);
    }
}
