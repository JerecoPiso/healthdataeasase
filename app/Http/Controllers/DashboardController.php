<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HouseholdProfile;
use App\Models\PersonalProfile;
use App\Models\HealthProfile;
use App\Models\PregnancyFormProfile;
class DashboardController extends Controller
{
    //
    public function getCounts(){
        $users = User::get('id')->count();
        $household = HouseholdProfile::where('archive', 0)->get('id')->count();
        $personal = PersonalProfile::where('archive', 0)->get('id')->count();
        $health = HealthProfile::where('archive', 0)->get('id')->count();
        $pregnancy = PregnancyFormProfile::where('archive', 0)->get('id')->count();
        return response()->json(
            ['counts' => 
                [
                    'users' => $users, 
                    'household' => $household,
                    'personal' => $personal,
                    'health' => $health,
                    'pregnancy' => $pregnancy
                ]
        ]);
    }
}
