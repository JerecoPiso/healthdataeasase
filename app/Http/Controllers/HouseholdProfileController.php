<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalProfile;
use App\Models\HouseholdProfile;
use App\Generators\RandomNumber;
use App\Models\HealthProfile;

class HouseholdProfileController extends Controller
{
    //
    protected $random;
    public function __construct(RandomNumber $randomNumber)
    {
        $this->random = $randomNumber;
    }
    // 
    public function insertHousehold(Request $request)
    {
        try {
            $household = HouseholdProfile::create([
                'household_number' =>  $request->household_number,
                'nhts' => $request->nhts,
                'electricity' => $request->electricity,
                'water_supply' => $request->water_supply,
                'toilet' => $request->toilet,
            ]);
            $profile = PersonalProfile::create([
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'suffix' => $request->suffix,
                'birthdate' => $request->birthdate,
                'sex' => $request->sex,
                'civil_status' => $request->civil_status,
                'educational_attainment' => $request->educational_attainment,
                'work' => $request->work,
                'household_profile_id' => $household->id,
                'relation_ship_to_head' => $request->relation_ship_to_head,
                'phone_number' => $request->phone_number,
            ]);
            HealthProfile::create([
                "personal_profile_id" =>  $profile->id,
                "philhealth_number" => $request->philhealth_number,
                "blood_type" => $request->blood_type,
                "maintenance" => $request->maintenance,
                "height" => $request->height,
                "weight" => $request->weight,
                "bmi" => 26.5,
                "health_status" => $request->health_status,
            ]);
            HouseholdProfile::where('id', $household->id)->update([
                'household_head' => $request->firstname . ' ' . ($request->middlename ? $request->middlename : '') . ' ' . $request->lastname
            ]);
            if ($profile) {
                return response()->json(['message' => 'Registration successful', 'status' => 'success', 'household' => $household], 201);
            } else {
                return response()->json(['message' => 'Registration failed', 'status' => 'error',], 500);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occure', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function getHouseHoldNumber(Request $request)
    {
        $householdNumber = "";
        $householdNumberExists = true;
        while ($householdNumberExists) {
            $householdNumber = $this->random->HouseholdNumber();
            $householdNumberExists = HouseholdProfile::where('household_number', $householdNumber)->exists();
        }
        return response()->json(['householdNumber' => $householdNumber]);
    }
    public function getHousehold(Request $request)
    {
        try {
            $households = HouseholdProfile::with(['personalProfiles' => function ($query) {
                        $query->where('archive', 0);
                }])
                ->orderBy('household_profiles.id', 'desc')
                ->get();
            return response()->json(['data' => $households]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occure', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function archiveHouseholdProfile(Request $request)
    {
        try {
            HouseholdProfile::where('id', $request->id)->update([
                'archive' => 1,
            ]);
            return response()->json(['message' => 'Successful', 'status' => 'success'], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
}
