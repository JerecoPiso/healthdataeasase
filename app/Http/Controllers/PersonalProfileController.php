<?php

namespace App\Http\Controllers;

use App\Models\PersonalProfile;
use Illuminate\Http\Request;
use App\Models\HealthProfile;
use Illuminate\Support\Facades\DB;
use App\Models\AuditTrail;
use App\Models\HouseholdProfile;
use App\Models\PregnancyFormProfile;
use Carbon\Carbon;

class PersonalProfileController extends Controller
{
    private $response;
    public function __construct()
    {
        $this->response = [];
    }
    public function archivePersonalProfile(Request $request)
    {
        try {
            PersonalProfile::where('id', $request->id)->update([
                'archive' => 1,
            ]);
            if (HouseholdProfile::where('personal_profile_id', $request->id)->exists()) {
                HouseholdProfile::where('personal_profile_id', $request->id)->update(['archive' => 1]);
            }
            HealthProfile::where('personal_profile_id', $request->id)->update([
                'archive' => 1,
            ]);
            PregnancyFormProfile::where('personal_profile_id', $request->id)->update([
                'archive' => 1,
            ]);
            $this->response = ['message' => 'Successful', 'status' => 'success', 'statusCode' => 201];
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'personal_profiles', 'archivePersonalProfile', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function unarchivePersonalProfile(Request $request)
    {
        try {
            PersonalProfile::where('id', $request->id)->update([
                'archive' => 0,
            ]);
            if (HouseholdProfile::where('personal_profile_id', $request->id)->exists()) {
                HouseholdProfile::where('personal_profile_id', $request->id)->update(['archive' => 0]);
            }
            HealthProfile::where('personal_profile_id', $request->id)->update([
                'archive' => 0,
            ]);
            PregnancyFormProfile::where('personal_profile_id', $request->id)->update([
                'archive' => 0,
            ]);
            $this->response = ['message' => 'Successful', 'status' => 'success', 'statusCode' => 201];
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'personal_profiles', 'unarchivePersonalProfile', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function getBabies()
    {
        try {
            $babies = PersonalProfile::whereRaw('TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) <= ?', [1])
                ->where("archive", 0)
                ->orderBy('lastname', 'asc')
                ->get();
            return response()->json(['message' => 'Successful', 'status' => 'success', 'babies' => $babies], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function getFemales(Request $request)
    {
        try {
            $females = PersonalProfile::whereRaw('TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) >= ?', [12])
                ->where('archive', 0)
                ->where("sex", 'Female')
                // ->whereNotExists(function ($query) {
                //     $query->select(DB::raw(1))
                //         ->from('pregnancy_form_profiles')
                //         ->whereColumn('pregnancy_form_profiles.personal_profile_id', 'personal_profiles.id');
                // })
                ->orderBy('lastname', 'asc')
                ->get();
            return response()->json(['message' => 'Successful', 'status' => 'success', 'females' => $females], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function getPersonalProfile(Request $request)
    {
        try {
            $profile = PersonalProfile::PersonalProfileWithHealthProfile($request);
            return response()->json(['data' => $profile['profilesPage'], 'count' => $profile['count']]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function insertPersonalProfile(Request $request)
    {
        $id = 0;
        $request->validate([
            'lastname' => ['required'],
            'firstname' => ['required'],
            'birthdate' => ['required'],
            'sex' => ['required'],
            'civil_status' => ['required'],
            'educational_attainment' => ['required'],
            'work' => ['required'],
            'household_profile_id' => ['required'],
            'relation_ship_to_head' => ['required'],
            'height' => ['required'],
            'weight' => ['required'],
            'bmi' => ['required'],
        ]);
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
                "bmi" => $request->bmi,
                "health_status" => $request->health_status,
            ]);
            if ($profile) {
                $id = $profile->id;
                $this->response = ['message' => 'Registration successful', 'status' => 'success', 'user' => $profile, 'statusCode' => 201];
            } else {
                $this->response = ['message' => 'Registration failed', 'status' => 'error', 'statusCode' => 403];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id,  $id, 'personal_profiles', 'insertPersonalProfile', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function updatePersonalProfile(Request $request)
    {
        $request->validate([
            'lastname' => ['required'],
            'firstname' => ['required'],
            'birthdate' => ['required'],
            'sex' => ['required'],
            'civil_status' => ['required'],
            'educational_attainment' => ['required'],
            'work' => ['required'],
            'relation_ship_to_head' => ['required'],
            'status' => ['required'],
        ]);
        try {
            $profile = PersonalProfile::where('id', $request->id)
                ->update([
                    'lastname' => $request->lastname,
                    'firstname' => $request->firstname,
                    'middlename' => $request->middlename,
                    'suffix' => $request->suffix,
                    'birthdate' => $request->birthdate,
                    'sex' => $request->sex,
                    'civil_status' => $request->civil_status,
                    'educational_attainment' => $request->educational_attainment,
                    'work' => $request->work,
                    'relation_ship_to_head' => $request->relation_ship_to_head,
                    'phone_number' => $request->phone_number,
                    'status' => $request->status,
                ]);

            if ($profile) {
                $this->response = ['message' => 'Updated successfully', 'status' => 'success', 'user' => $profile, 'statusCode' => 201];
            } else {
                $this->response = ['message' => 'Update failed', 'status' => 'error', 'statusCode' => 403];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'personal_profiles', 'updatePersonalProfile', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function viewProfile(Request $request)
    {
        try {

            $profile = PersonalProfile::where('id', $request->id)->get()->first();
            $health = HealthProfile::where('personal_profile_id', $request->id)->get(['*', 'health_profiles.id as health_id'])->first();
            return response()->json(['profile' => $profile, 'health' => $health, 'status' => 'success'], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
}
