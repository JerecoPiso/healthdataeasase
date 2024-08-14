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
        ->where('personal_profiles.archive', 0)->get(['personal_profiles.*', 'house.household_number', 'house.personal_profile_id']);
        $data = [
            'profiles' => $profiles
        ];
        return view('/reports/household', $data);
        // // Load a view and pass the data
        // $pdf = Pdf::loadView('/reports/household', $data);

        // // Return the generated PDF
        // return $pdf->download('household.pdf');
    }
}
