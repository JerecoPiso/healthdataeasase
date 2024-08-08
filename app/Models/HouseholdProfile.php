<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class HouseholdProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'household_number',
        'nhts',
        'electricity',
        'water_supply',
        'toilet'
    ];
    public function personalProfiles(): HasMany
    {
        return $this->hasMany(PersonalProfile::class);
    }
   
    // public function scopeWithPersonalProfile($query)
    // {
    //     return $query->leftJoin('personal_profiles', 'household_profiles.personal_profile_id', '=', 'personal_profiles.id')
    //         ->where('household_profiles.archive', 0)
    //         ->whereNot('household_profiles.personal_profile_id', NULL)
    //         ->orderBy('household_profiles.id', 'desc')
    //         ->get([
    //             'household_profiles.*', 'personal_profiles.lastname', 'personal_profiles.firstname', 'personal_profiles.middlename'
    //         ]);
    // }
}
