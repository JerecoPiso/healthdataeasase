<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function vaccinations(): HasMany
    {
        return $this->hasMany(Vaccination::class);
    }
    public function scopePersonalProfileWithHealthProfile($query, $request)
    {
        $profiles = $query->leftJoin('health_profiles AS hp', 'personal_profiles.id', '=', 'hp.personal_profile_id')->where('personal_profiles.archive', $request->status)
            ->where(function ($query) use ($request) {
                $query->where('personal_profiles.firstname', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('personal_profiles.lastname', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('personal_profiles.middlename', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('hp.health_status', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('hp.maintenance', 'LIKE', '%' . $request->search . '%');
            })->where('personal_profiles.status', $request->residentStatus);
        $totalProfiles = $profiles->count();
            $profilesPage = $profiles->orderBy('personal_profiles.id', 'desc')
            ->skip((intval($request->page) - 1) * ($totalProfiles > intval($request->recordPerPage) ? intval($request->recordPerPage) : 0))
            ->take(intval($request->recordPerPage))
             ->get([
                'personal_profiles.*', 'hp.id as health_id', 'hp.philhealth_number', 'hp.blood_type',
                'hp.maintenance', 'hp.height', 'hp.weight', 'hp.bmi', 'hp.health_status'
            ]);
        return [
            'count' => $totalProfiles,
            'profilesPage' => $profilesPage
        ];
    }
}
