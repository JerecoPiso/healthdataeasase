<?php

namespace App\Http\Controllers;

use App\Models\PersonalProfile;
use Illuminate\Http\Request;
use App\Models\HealthProfile;
use Illuminate\Support\Facades\DB;

class PersonalProfileController extends Controller
{
    //
    public function getFemales(Request $request)
    {
        try {
            $females = PersonalProfile::where('archive', 0)
                ->where("sex", 'Female')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('pregnancy_form_profiles')
                        ->whereColumn('pregnancy_form_profiles.personal_profile_id', 'personal_profiles.id');
                })
                ->orderBy('lastname', 'asc')
                ->get();
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
                'suffix' => $request->suffix,
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
            $profile = PersonalProfile::PersonalProfileWithHealthProfile($request);
            return response()->json(['data' => $profile['profilesPage'], 'count' => $profile['count']]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occure', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function archivePersonalProfile(Request $request)
    {
        try {
            PersonalProfile::where('id', $request->id)->update([
                'archive' => 1,
            ]);
            return response()->json(['message' => 'Successful', 'status' => 'success'], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
}
