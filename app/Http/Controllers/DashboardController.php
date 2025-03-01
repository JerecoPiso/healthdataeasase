<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HouseholdProfile;
use App\Models\PersonalProfile;
use App\Models\HealthProfile;
use App\Models\PregnancyFormProfile;
use App\Models\Vaccination;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function getCounts(Request $request)
    {
        // count of every values in a table that are not archive
        $users = User::where('archive', 0)->get('id')->count();
        $household = HouseholdProfile::where('archive', 0)->get('id')->count();
        $personal = PersonalProfile::where('archive', 0)->get('id')->count();
        $health = HealthProfile::leftJoin('health_profiles as hp', 'health_profiles.personal_profile_id', '=', 'hp.id')->where('health_profiles.archive', 0)->where('hp.archive', 0)->get('health_profiles.id')->count();
        $pregnancy = PregnancyFormProfile::leftJoin('personal_profiles as pp', 'pregnancy_form_profiles.personal_profile_id', '=', 'pp.id')->where('pregnancy_form_profiles.status', 'Active')->where('pregnancy_form_profiles.archive', 0)->where('pp.archive', 0)->get('pregnancy_form_profiles.id')->count();
        return response()->json(
            [
                'counts' =>
                [
                    'users' => $users,
                    'household' => $household,
                    'personal' => $personal,
                    'health' => $health,
                    'pregnancy' => $pregnancy,
                ]
            ]
        );
    }
    public function getCountsByAgeGroup(Request $request)
    {
        $vaccinatedTotal = Vaccination::leftJoin('personal_profiles as profile', 'vaccinations.personal_profile_id', '=', 'profile.id')->where('vaccinations.archive', 0)->distinct('vaccinations.id')->count('vaccinations.id');
        $totalBabies = PersonalProfile::whereRaw('TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) <= ?', [1])
            ->where("archive", 0)
            ->get()->count();
        $maintenaceList = HealthProfile::select('health_profiles.maintenance')->join('personal_profiles as pp', 'health_profiles.personal_profile_id', '=', 'pp.id')
            ->where('pp.archive', 0)
            ->whereNot('health_profiles.maintenance', null)
            ->whereNot('health_profiles.maintenance', '[]')
            ->whereNot('health_profiles.maintenance', '')
            ->where('health_profiles.archive', 0)
            ->get();
        $doneMaintenance = [];
        $maintenance = [];
        foreach ($maintenaceList as $m) {
            $_maintenance = json_decode($m->maintenance, true);
            foreach ($_maintenance as $_m) {
                if (in_array($_m['name'], $doneMaintenance) == false) {
                    $total = HealthProfile::select('maintenance')->leftJoin('personal_profiles as pp', 'health_profiles.personal_profile_id', '=', 'pp.id')
                        ->where('health_profiles.archive', 0)
                        ->where('pp.archive', 0)
                        ->where('health_profiles.maintenance', 'LIKE', '%' . $_m['name'] . '%')
                        ->get()->count();
                    $maintenance[] = [
                        'maintenance' => $_m['name'],
                        'total' => $total
                    ];
                    $doneMaintenance[] = $_m['name'];
                }
            }
        }
        $healthStatusList = HealthProfile::select('health_profiles.health_status')->join('personal_profiles as pp', 'health_profiles.personal_profile_id', '=', 'pp.id')
            ->where('pp.archive', 0)
            ->whereNot('health_profiles.health_status', null)
            ->whereNot('health_profiles.health_status', '[]')
            ->whereNot('health_profiles.health_status', '')
            ->where('health_profiles.archive', 0)
            ->get();
        $doneHealthStatus = [];
        $health_status = [];
        foreach ($healthStatusList as $h) {
            $_hs = json_decode($h->health_status, true);
            foreach ($_hs as $_h) {
                if (in_array($_h['name'], $doneHealthStatus) == false) {
                    $total = HealthProfile::select('health_status')->leftJoin('personal_profiles as pp', 'health_profiles.personal_profile_id', '=', 'pp.id')
                        ->where('health_profiles.archive', 0)
                        ->where('pp.archive', 0)
                        ->where('health_profiles.health_status', 'LIKE', '%' . $_h['name'] . '%')
                        ->get()->count();
                    $health_status[] = [
                        'health_status' => $_h['name'],
                        'total' => $total
                    ];
                    $doneHealthStatus[] = $_h['name'];
                }
            }
        }
        $pregnants = PregnancyFormProfile::select('status', DB::raw('count(*) as total'))
            ->where('archive', 0)
            ->groupBy('status')
            ->get();
        // count age by range
        $ageGroups = PersonalProfile::select(
            DB::raw('CAST(IFNULL(SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 0 AND 6 THEN 1 ELSE 0 END), 0) AS UNSIGNED) as age_0_6'),
            DB::raw('CAST(IFNULL(SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 6 AND 18 THEN 1 ELSE 0 END), 0) AS UNSIGNED) as age_6_18'),
            DB::raw('CAST(IFNULL(SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 19 AND 59 THEN 1 ELSE 0 END), 0) AS UNSIGNED) as age_19_59'),
            DB::raw('CAST(IFNULL(SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) >= 60 THEN 1 ELSE 0 END), 0) AS UNSIGNED) as age_60_above')
        )
            ->where('archive', 0)
            ->first();
        $bmiGroupsTeenager = PersonalProfile::leftJoin('health_profiles as hp', 'personal_profiles.id', '=', 'hp.personal_profile_id')->select(
            DB::raw('CAST(IFNULL(SUM(CASE WHEN TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) BETWEEN 0 AND 18 AND hp.bmi < 18.5 THEN 1 ELSE 0 END), 0) AS UNSIGNED) as Underweight'),
            DB::raw('CAST(IFNULL(SUM(CASE WHEN TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) BETWEEN 0 AND 18 AND hp.bmi BETWEEN 18.5 AND 24.9  THEN 1 ELSE 0 END), 0) AS UNSIGNED) as Normal'),
            DB::raw('CAST(IFNULL(SUM(CASE WHEN TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) BETWEEN 0 AND 18 AND hp.bmi BETWEEN 25 AND 29.9  THEN 1 ELSE 0 END), 0) AS UNSIGNED) as Overweight '),
            DB::raw('CAST(IFNULL(SUM(CASE WHEN TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) BETWEEN 0 AND 18 AND hp.bmi >= 30  THEN 1 ELSE 0 END), 0) AS UNSIGNED) as Obesity'),
        )
            ->where('personal_profiles.archive', 0)
            ->first();
        $bmiGroupsAdults = PersonalProfile::leftJoin('health_profiles as hp', 'personal_profiles.id', '=', 'hp.personal_profile_id')->select(
            DB::raw('CAST(IFNULL(SUM(CASE WHEN TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) > 18 AND hp.bmi < 18.5 THEN 1 ELSE 0 END), 0) AS UNSIGNED) as Underweight'),
            DB::raw('CAST(IFNULL(SUM(CASE WHEN TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) > 18 AND 18 AND hp.bmi BETWEEN 18.5 AND 24.9  THEN 1 ELSE 0 END), 0) AS UNSIGNED) as Normal'),
            DB::raw('CAST(IFNULL(SUM(CASE WHEN TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) > 18 AND 18 AND hp.bmi BETWEEN 25 AND 29.9  THEN 1 ELSE 0 END), 0) AS UNSIGNED) as Overweight '),
            DB::raw('CAST(IFNULL(SUM(CASE WHEN TIMESTAMPDIFF(YEAR, personal_profiles.birthdate, CURDATE()) > 18 AND hp.bmi >= 30  THEN 1 ELSE 0 END), 0) AS UNSIGNED) as Obesity'),
        )->where('personal_profiles.archive', 0)
            ->first();
        $genders = PersonalProfile::select(
            DB::raw('CAST(IFNULL(SUM(CASE WHEN sex = "Male" THEN 1 ELSE 0 END), 0) AS UNSIGNED) as Male'),
            DB::raw('CAST(IFNULL(SUM(CASE WHEN sex = "Female" THEN 1 ELSE 0 END), 0) AS UNSIGNED) as Female'),
        )->where('archive', 0)
            ->first();
        return response()->json([
            'ages' => $ageGroups,
            'genders' => $genders,
            'bmiTeenagers' =>  $bmiGroupsTeenager,
            'bmiAdults' => $bmiGroupsAdults,
            'maintenance' => $maintenance,
            'health_status' => $health_status,
            'pregnants' => $pregnants,
            'vaccinatedTotal' => $vaccinatedTotal,
            'totalBabies' => $totalBabies,
        ]);
    }
}
