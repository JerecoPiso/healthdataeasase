<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\HouseholdProfile;
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
}
