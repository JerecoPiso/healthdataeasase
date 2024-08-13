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
        $users = User::where('archive', 0)->get('id')->count();
        $household = HouseholdProfile::where('archive', 0)->get('id')->count();
        $personal = PersonalProfile::where('archive', 0)->get('id')->count();
        $health = HealthProfile::where('archive', 0)->get('id')->count();
        $pregnancy = PregnancyFormProfile::where('archive', 0)->get('id')->count();
        return response()->json(
            [
                'counts' =>
                [
                    'users' => $users,
                    'household' => $household,
                    'personal' => $personal,
                    'health' => $health,
                    'pregnancy' => $pregnancy,
                    // 'user' => $request->user()
                ]
            ]
        );
    }
    public function getCountsByAgeGroup(Request $request)
    {

        $vaccinatedTotal = Vaccination::where('archive', 0)->distinct('personal_profile_id')->count('id');
        $totalBabies = PersonalProfile::where('birthdate', '>=', Carbon::now()->subMonths(12)->format('Y-m-d'))
        ->where("archive", 0)
        ->get()->count();

        $maintenance = HealthProfile::select('maintenance', DB::raw('count(*) as total'))
            ->where('archive', 0)
            ->groupBy('maintenance')
            ->get();
        $health_status = HealthProfile::select('health_status', DB::raw('count(*) as total'))
            ->where('archive', 0)
            ->groupBy('health_status')
            ->get();
        $pregnants = PregnancyFormProfile::select('status', DB::raw('count(*) as total'))
            ->where('archive', 0)
            ->groupBy('status')
            ->get();

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
            'totalBabies' =>$totalBabies
        ]);
    }
}
