<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\PregnancyFormProfile;
use App\Models\PersonalProfile;

class ReportController extends Controller
{
    //
    public function generateHouseholdReport()
    {
        $profiles = PersonalProfile::leftJoin('household_profiles as house', 'personal_profiles.household_profile_id', '=', 'house.id')
            ->leftJoin('health_profiles as hp', 'personal_profiles.id', '=', 'hp.personal_profile_id')
            ->where('personal_profiles.archive', 0)
            ->get(
                [
                    'personal_profiles.*',
                    'house.household_number',
                    'house.personal_profile_id',
                    'hp.weight',
                    'hp.height'
                ]
            );
        $data = [
            'profiles' => $profiles,
            'img_path' => public_path('images/stafe.png'),
            'css_path' => public_path('css/report.css'),
        ];
        $pdf = Pdf::loadView('/reports/household', $data);
        return $pdf->download('household.pdf');

        // return view('/reports/household', $data);
    }
    public function generateSeniorCitizenReport()
    {
        $seniors = PersonalProfile::whereRaw('TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) >= ?', [60])->where('archive', 0)->orderBy('lastname', 'ASC')->get();
        $data = [
            'seniors' => $seniors,
            'img_path' => public_path('images/stafe.png'),
            'css_path' => public_path('css/report.css'),
        ];
        $pdf = Pdf::loadView('/reports/seniorcitizen', $data);
        return $pdf->download('seniorcitizens.pdf');

        // return view('/reports/seniorcitizen', $data);
    }
    public function generatePregnantsReport()
    {
        $latestPregnancies = PregnancyFormProfile::leftJoin('personal_profiles as profile', 'pregnancy_form_profiles.personal_profile_id', '=', 'profile.id')
            ->leftJoin('pregnancy_form_profiles as latest', function ($join) {
                $join->on('pregnancy_form_profiles.personal_profile_id', '=', 'latest.personal_profile_id')
                    ->whereRaw('pregnancy_form_profiles.created_at < latest.created_at')
                    ->where('latest.status', 'Active')
                    ->where('latest.archive', 0);
            })
            ->whereNull('latest.id')
            ->where('pregnancy_form_profiles.archive', 0)
            ->where('pregnancy_form_profiles.status', 'Active')
            ->orderBy('profile.lastname', 'ASC')
            ->get(['pregnancy_form_profiles.*', 'profile.lastname', 'profile.firstname', 'profile.middlename', 'profile.suffix']);
        $data = [
            'pregnants' => $latestPregnancies,
            'img_path' => public_path('images/stafe.png'),
            'css_path' => public_path('css/report.css'),
        ];
        $pdf = Pdf::loadView('/reports/pregnants', $data);
        return $pdf->download('pregnants.pdf');

        // return view('/reports/pregnants', $data);
    }
}
