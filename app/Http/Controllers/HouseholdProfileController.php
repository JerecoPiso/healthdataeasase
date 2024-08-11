<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalProfile;
use App\Models\HouseholdProfile;
use App\Generators\RandomNumber;
use App\Models\HealthProfile;
use App\Models\AuditTrail;

class HouseholdProfileController extends Controller
{
    //
    protected $random;
    private $response;
    public function __construct(RandomNumber $randomNumber)
    {
        $this->response = [];
        $this->random = $randomNumber;
    }
    // 
    public function archiveHouseholdProfile(Request $request)
    {
        try {
            HouseholdProfile::where('id', $request->id)->update([
                'archive' => 1,
            ]);
            $this->response = ['message' => 'Successful', 'status' => 'success', 'statusCode' => 201];
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'household_profiles', 'archiveHouseholdProfile', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
      // householdnumber unique generator
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
                  ->where(function ($query) use ($request) {
                      $query->where('household_profiles.household_number', 'LIKE', '%' . $request->search . '%')
                          ->orWhere('household_profiles.household_head', 'LIKE', '%' . $request->search . '%')
                          ->orWhere('household_profiles.nhts', 'LIKE', '%' . $request->search . '%')
                          ->orWhere('household_profiles.electricity', 'LIKE', '%' . $request->search . '%')
                          ->orWhere('household_profiles.water_supply', 'LIKE', '%' . $request->search . '%')
                          ->orWhere('household_profiles.toilet', 'LIKE', '%' . $request->search . '%');
                  })
                  ->where('household_profiles.archive', 0);
  
              $totalHousehold = $households->count();
              $householdPage = $households->orderBy('household_profiles.id', 'desc')
                  ->skip((intval($request->page) - 1) * ($totalHousehold > intval($request->recordPerPage) ? intval($request->recordPerPage) : 0))
                  ->take(intval($request->recordPerPage))
                  ->get();
              return response()->json(['data' => $householdPage, 'count' => $totalHousehold]);
          } catch (\Illuminate\Database\QueryException $e) {
              return response()->json(['message' => 'An error has occure', 'status' => 'error', 'data' => $e->getMessage()], 500);
          }
      }
    public function insertHousehold(Request $request)
    {
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
            'blood_type' => ['required'],
            'height' => ['required'],
            'weight' => ['required'],
            'nhts' => ['required'],
            'electricity' => ['required'],
            'water_supply' => ['required'],
            'toilet' => ['required'],
        ]);
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
                "bmi" => $request->bmi,
                "health_status" => $request->health_status,
            ]);
            HouseholdProfile::where('id', $household->id)->update([
                'household_head' => $request->firstname . ' ' . ($request->middlename ? $request->middlename : '') . ' ' . $request->lastname
            ]);
            if ($household && $profile) {
                $this->response = ['message' => 'Registration successful', 'status' => 'success', 'household' => $household, 'statusCode' => 201];
            } else {
                $this->response = ['message' => 'Registration failed', 'status' => 'error', 'statusCode' => 403];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 403];
        }
        AuditTrail::createAuditTrail($request->user()->id, 0, 'household_profiles', 'insertHousehold', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function updateHousehold(Request $request)
    {   
        $request->validate([
            'nhts' => ['required'],
            'electricity' => ['required'],
            'water_supply' => ['required'],
            'toilet' => ['required'],
        ]);
        try {
            $household = HouseholdProfile::where('id', $request->id)->update([
                'nhts' => $request->nhts,
                'electricity' => $request->electricity,
                'water_supply' => $request->water_supply,
                'toilet' => $request->toilet,
            ]);
            if ($household) {
                $this->response = ['message' => 'Updated successfully', 'status' => 'success', 'statusCode' => 201];
            } else {
                $this->response = ['message' => 'Update failed', 'status' => 'error', 'statusCode' => 403];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'household_profiles', 'updateHousehold', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
 
}
