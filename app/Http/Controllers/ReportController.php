<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

use App\Models\PregnancyFormProfile;
use App\Models\PersonalProfile;
use App\Models\Purok;

class ReportController extends Controller
{
    //
    public function generateHouseholdReport(Request $request)
    {
        $purok = '';
        if ($request->purok_id == 0) {
            $profiles = PersonalProfile::leftJoin('household_profiles as house', 'personal_profiles.household_profile_id', '=', 'house.id')
                ->leftJoin('puroks', 'house.purok_id', '=', 'puroks.id')
                ->where('personal_profiles.archive', 0)
                ->orderBy('personal_profiles.household_profile_id', 'ASC')
                ->get(
                    [
                        DB::raw("TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) AS age"),
                        'personal_profiles.*',
                        'house.household_number',
                        'house.personal_profile_id',
                        'puroks.name as purok_name'
                    ]
                );
            $purok = 'All Purok/s';
        } else {
            $profiles = PersonalProfile::leftJoin('household_profiles as house', 'personal_profiles.household_profile_id', '=', 'house.id')
            ->leftJoin('puroks', 'house.purok_id', '=', 'puroks.id')
                ->where('personal_profiles.archive', 0)
                ->where('house.purok_id', $request->purok_id)
                ->orderBy('personal_profiles.household_profile_id', 'ASC')
                ->get(
                    [
                        DB::raw("TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) AS age"),
                        'personal_profiles.*',
                        'house.household_number',
                        'house.personal_profile_id',
                        'puroks.name as purok_name'
                    ]
                );
            $p = Purok::where('id', $request->purok_id)->value('name');
            $purok = $p ? $p : '';
        }
        $data = [
            'profiles' => $profiles,
            'purok' => $purok,
            'img_path' => public_path('images/stafe.png'),
            'css_path' => public_path('css/report.css'),
        ];
        $pdf = Pdf::loadView('/reports/household', $data);
        $pdf->set_option('isRemoteEnabled', false);
        return $pdf->stream('household.pdf');
        // return view('/reports/household', $data);
    }
    public function generateSeniorCitizenReport(Request $request)
    {
        $purok = '';
        if ($request->purok_id == 0) {
            $seniors = PersonalProfile::whereRaw('TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) >= ?', [60])
                ->where('personal_profiles.archive', 0)->orderBy('personal_profiles.lastname', 'ASC')
                ->select('personal_profiles.*',  DB::raw("TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) AS age"))
                ->get();
            $purok = 'All Purok/s';
        } else {
            $seniors = PersonalProfile::leftJoin('household_profiles as house', 'personal_profiles.household_profile_id', '=', 'house.id')
                ->whereRaw('TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) >= ?', [60])
                ->where('house.purok_id', $request->purok_id)
                ->where('personal_profiles.archive', 0)->orderBy('personal_profiles.lastname', 'ASC')
                ->select('personal_profiles.*',  DB::raw("TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) AS age"))
                ->get();
            $p = Purok::where('id', $request->purok_id)->value('name');
            $purok = $p ? $p : '';
        }
        $data = [
            'seniors' => $seniors,
            'purok' => $purok,
            'img_path' => public_path('images/stafe.png'),
            'css_path' => public_path('css/report.css'),
        ];
        $pdf = Pdf::loadView('/reports/seniorcitizen', $data);
        return $pdf->stream('seniorcitizens.pdf');
        // return view('/reports/seniorcitizen', $data);
    }
    public function generateUnderweightReport(Request $request)
    {
        $purok = '';
        if ($request->purok_id == 0) {
            $underweight = PersonalProfile::leftJoin('health_profiles', 'personal_profiles.id', '=', 'health_profiles.personal_profile_id')
                ->whereRaw('TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) <= ?', [$request->age])
                ->where('health_profiles.bmi', '<=', 18.5)  // BMI <= 18.5
                ->where('personal_profiles.archive', 0)
                ->orderBy('personal_profiles.lastname', 'ASC')
                ->select('personal_profiles.*', DB::raw("TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) AS age"),  'health_profiles.bmi')
                ->get();
            $purok = 'All Purok/s';
        } else {
            $underweight = PersonalProfile::leftJoin('household_profiles as house', 'personal_profiles.household_profile_id', '=', 'house.id')
                ->leftJoin('health_profiles', 'personal_profiles.id', '=', 'health_profiles.personal_profile_id')
                ->where('house.purok_id', $request->purok_id)

                ->whereRaw('TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) <= ?', [$request->age])
                ->where('health_profiles.bmi', '<=', 18.5)  // BMI <= 18.5
                ->where('personal_profiles.archive', 0)
                ->orderBy('personal_profiles.lastname', 'ASC')
                ->select('personal_profiles.*', DB::raw("TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) AS age"),  'health_profiles.bmi')
                ->get();
            $p = Purok::where('id', $request->purok_id)->value('name');
            $purok = $p ? $p : '';
        }

        $data = [
            'underweight' => $underweight,
            'purok' => $purok,

            'img_path' => public_path('images/stafe.png'),
            'css_path' => public_path('css/report.css'),
        ];
        $pdf = Pdf::loadView('/reports/underweight', $data);
        return $pdf->stream('underweight_below_' . $request->age . '.pdf');

        // return view('/reports/seniorcitizen', $data);
    }
    public function generatePregnantsReport(Request $request)
    {
        $purok = '';
        if ($request->purok_id == 0) {

            $latestPregnancies = PregnancyFormProfile::leftJoin('personal_profiles as profile', 'pregnancy_form_profiles.personal_profile_id', '=', 'profile.id')
                ->leftJoin('pregnancy_form_profiles as latest', function ($join) {
                    $join->on('pregnancy_form_profiles.personal_profile_id', '=', 'latest.personal_profile_id')
                        ->whereRaw('pregnancy_form_profiles.created_at < latest.created_at')
                        ->where('latest.status', 'Active')
                        ->where('latest.archive', 0);
                })
                ->whereRaw('TIMESTAMPDIFF(YEAR, profile.birthdate, CURDATE()) <= ?', [$request->age])
                ->whereNull('latest.id')
                ->where('pregnancy_form_profiles.archive', 0)
                ->where('pregnancy_form_profiles.status', 'Active')
                ->orderBy('profile.lastname', 'ASC')
                ->select(DB::raw("TIMESTAMPDIFF(YEAR, profile.birthdate, CURDATE()) AS age"), 'pregnancy_form_profiles.*', 'profile.lastname', 'profile.work', 'profile.educational_attainment', 'profile.firstname', 'profile.middlename', 'profile.suffix',   DB::raw("TIMESTAMPDIFF(YEAR, profile.birthdate, CURDATE()) AS age"))
                ->get();
        } else {
            $latestPregnancies = PregnancyFormProfile::leftJoin('personal_profiles as profile', 'pregnancy_form_profiles.personal_profile_id', '=', 'profile.id')
                ->leftJoin('household_profiles as house', 'profile.household_profile_id', '=', 'house.id')
                ->where('house.purok_id', $request->purok_id)

                ->leftJoin('pregnancy_form_profiles as latest', function ($join) {
                    $join->on('pregnancy_form_profiles.personal_profile_id', '=', 'latest.personal_profile_id')
                        ->whereRaw('pregnancy_form_profiles.created_at < latest.created_at')
                        ->where('latest.status', 'Active')
                        ->where('latest.archive', 0);
                })
                ->whereRaw('TIMESTAMPDIFF(YEAR, profile.birthdate, CURDATE()) <= ?', [$request->age])
                ->whereNull('latest.id')
                ->where('pregnancy_form_profiles.archive', 0)
                ->where('pregnancy_form_profiles.status', 'Active')
                ->orderBy('profile.lastname', 'ASC')
                ->select(DB::raw("TIMESTAMPDIFF(YEAR, profile.birthdate, CURDATE()) AS age"), 'pregnancy_form_profiles.*', 'profile.lastname', 'profile.work', 'profile.educational_attainment', 'profile.firstname', 'profile.middlename', 'profile.suffix',   DB::raw("TIMESTAMPDIFF(YEAR, profile.birthdate, CURDATE()) AS age"))
                ->get();
            $p = Purok::where('id', $request->purok_id)->value('name');
            $purok = $p ? $p : '';
        }

        $data = [
            'purok' => $purok,
            'pregnants' => $latestPregnancies,
            'img_path' => public_path('images/stafe.png'),
            'css_path' => public_path('css/report.css'),

        ];
        $pdf = Pdf::loadView('/reports/pregnants', $data);
        return $pdf->stream('pregnants.pdf');
        // return view('/reports/pregnants', $data);
    }
    public function generateReportAgeRange(Request $request)
    {
        $members = PersonalProfile::select(
            'personal_profiles.*',
            DB::raw("TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age"),
        )
            ->having('age', '>=', $request->minAge)
            ->having('age', '<=', $request->maxAge)
            ->whereNotNull('birthdate')
            ->get();
        $data = [
            'members' => $members,
            'img_path' => public_path('images/stafe.png'),
            'css_path' => public_path('css/report.css'),
            'minAge' => $request->minAge,
            'maxAge' => $request->maxAge
        ];
        $pdf = Pdf::loadView('/reports/reportByAgeRange', $data);
        return $pdf->stream('age_between_' . $request->minAge . '_and_' . $request->maxAge . '.pdf');

        // return view('/reports/seniorcitizen', $data);
    }
    public function generateReportByCategory(Request $request)
    {
        $category = $request->category;
        $value = $request->value;
        $members = null;

        switch ($category) {
            case 'Civil Status':
                $members = PersonalProfile::where('archive', 0)->where('civil_status', $value)->get();
                break;
            case 'Educational Attainment':
                $members = PersonalProfile::where('archive', 0)->where('educational_attainment', $value)->get();
                break;
            case 'Electricity':
                $members = PersonalProfile::leftJoin('household_profiles as hp', 'personal_profiles.household_profile_id', '=',  'hp.id')->where('personal_profiles.archive', 0)->where('hp.electricity', $value)->get(['personal_profiles.*']);
                break;
            case 'Health Status':
                $members = PersonalProfile::leftJoin('health_profiles as hp', 'personal_profiles.id', '=',  'hp.id')->where('personal_profiles.archive', 0)->where('hp.health_status', 'like', '%' . $value . '%')->get(['personal_profiles.*']);
                break;
            case 'Maintenance':
                $members = PersonalProfile::leftJoin('health_profiles as hp', 'personal_profiles.id', '=',  'hp.id')->where('personal_profiles.archive', 0)->where('hp.maintenance', 'like', '%' . $value . '%')->get(['personal_profiles.*']);
                break;
            case 'Sex':
                $members = PersonalProfile::where('archive', 0)->where('sex', $value)->get();
                break;
            case 'Work':
                $members = PersonalProfile::where('archive', 0)->where('work', $value)->get();
                // Code to execute if expression equals value3
                break;
        }
        $data = [
            'members' => $members,
            'img_path' => public_path('images/stafe.png'),
            'css_path' => public_path('css/report.css'),
            'category' => $category,
            'value' => $value,
        ];
        $pdf = Pdf::loadView('/reports/reportbycategory', $data);
        return $pdf->stream(str_replace(' ', '_', $category . '_' . $value) . '.pdf');
    }
}
