<?php

namespace App\Http\Controllers;

use App\Models\PersonalProfile;
use Illuminate\Http\Request;
use App\Models\HealthProfile;

class PersonalProfileController extends Controller
{
    //
    public function getFemales(Request $request)
    {
        try {
            $females = PersonalProfile::where("sex", 'Female')->where('archive', 0)->get();
            return response()->json(['message' => 'Successful', 'status' => 'success', 'females' => $females], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function insertPersonalProfile(Request $request)
    {
        try {
            $profile = PersonalProfile::create([
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'birthdate' => $request->birthdate,
                'sex' => $request->sex,
                'civil_status' => $request->civil_status,
                'educational_attainment' => $request->educational_attainment,
                'work' => $request->work,
                'household_profile_id' => $request->household_profile_id,
                'relation_ship_to_head' => $request->relation_ship_to_head,
                'phone_number' => $request->phone_number,
            ]);
            HealthProfile::create([
                "personal_profile_id" => $profile->id,
                "philhealth_number" => $request->philhealth_number,
                "blood_type" => $request->blood_type,
                "maintenance" => $request->maintenance,
                "height" => $request->height,
                "weight" => $request->weight,
                "bmi" => 26.5,
                "health_status" => $request->health_status,
            ]);
            if ($profile) {
                return response()->json(['message' => 'Registration successful', 'status' => 'success', 'user' => $profile], 201);
            } else {
                return response()->json(['message' => 'Registration failed', 'status' => 'error',], 500);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occure', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function updatePersonalProfile(Request $request)
    {
        try {
            $profile = PersonalProfile::where('id', $request->id)
                ->update([
                    'lastname' => $request->lastname,
                    'firstname' => $request->firstname,
                    'middlename' => $request->middlename,
                    'birthdate' => $request->birthdate,
                    'sex' => $request->sex,
                    'civil_status' => $request->civil_status,
                    'educational_attainment' => $request->educational_attainment,
                    'work' => $request->work,
                    'relation_ship_to_head' => $request->relation_ship_to_head,
                    'phone_number' => $request->phone_number,
                ]);

            if ($profile) {
                return response()->json(['message' => 'Update successful', 'status' => 'success', 'user' => $profile], 201);
            } else {
                return response()->json(['message' => 'Update failed', 'status' => 'error',], 500);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occure', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function getPersonalProfile(Request $request)
    {
        try {
            // leftJoin('health_profiles', 'personal_profiles.id')->where('archive', 0)->orderBy('id', 'desc')->get()
            $profile = PersonalProfile::PersonalProfileWithHealthProfile();
            return response()->json(['data' => $profile]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occure', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
}
