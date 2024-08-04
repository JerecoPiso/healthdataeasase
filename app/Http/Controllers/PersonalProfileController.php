<?php

namespace App\Http\Controllers;

use App\Models\PersonalProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PersonalProfileController extends Controller
{
    //
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
                'family_head_id' => $request->family_head_id,
                'relation_ship_to_head' => $request->relation_ship_to_head,
                'phone_number' => $request->phone_number,
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
    public function getPersonalProfile(Request $request)
    {
        try {
            $profile = PersonalProfile::where('archive', 0)->get();
            return response()->json(['data' => $profile, 'user' => $request->user()]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occure', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
}
