<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalProfile;
use App\Models\HouseholdProfile;
use App\Generators\RandomNumber;
use App\Models\HealthProfile;
use App\Models\AuditTrail;
use App\Models\Purok;

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
    public function addPurok(Request $request)
    {
        $id = 0;
        try {
            if (Purok::where('name', $request->name)->get(['id'])->count() == 0) {
                $purok = Purok::create([
                    'name' => $request->name,
                    'archive' => 0
                ]);
                if ($purok) {
                    $id = $purok->id;
                    $this->response = ['message' => 'Purok has been added successfully', 'status' => 'success', 'purok' => $purok, 'statusCode' => 201];
                } else {
                    $this->response = ['message' => 'Adding failed', 'status' => 'error', 'statusCode' => 403];
                }
            } else {
                $this->response = ['message' => 'Purok name already exists', 'status' => 'error', 'statusCode' => 201];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id,  $id, 'purok', 'addPurok', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function archivePurok(Request $request)
    {
        try {
            Purok::where('id', $request->id)->update([
                'archive' => 1,
            ]);
            $this->response = ['message' => 'Successful', 'status' => 'success', 'statusCode' => 201];
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'household_profiles', 'archiveHouseholdProfile', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function archiveHouseholdProfile(Request $request)
    {
        try {
            HouseholdProfile::where('id', $request->id)->update([
                'archive' => 1,
            ]);
            PersonalProfile::where('household_profile_id', $request->id)->update(['archive' => 1]);
            $this->response = ['message' => 'Successful', 'status' => 'success', 'statusCode' => 201];
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'household_profiles', 'archiveHouseholdProfile', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function unarchiveHouseholdProfile(Request $request)
    {
        try {
            HouseholdProfile::where('id', $request->id)->update([
                'archive' => 0,
            ]);
            PersonalProfile::where('household_profile_id', $request->id)->update(['archive' => 0]);
            $this->response = ['message' => 'Successful', 'status' => 'success', 'statusCode' => 201];
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'household_profiles', 'unarchiveHouseholdProfile', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function changeHouseholdHead(Request $request)
    {
        $request->validate([
            'id' => ['required'],
            'personal_profile_id' => ['required'],
            'household_personal_profile_id' => ['required'],
        ]);
        try {
            if ($request->personal_profile_id != $request->household_personal_profile_id) {
                $household = HouseholdProfile::where('id', $request->id)->update([
                    'personal_profile_id' => $request->personal_profile_id
                ]);
                if ($household) {
                    PersonalProfile::where('id', $request->personal_profile_id)->update(['relation_ship_to_head' => "Household Head"]);
                    $this->response = ['message' => 'Updated successfully', 'status' => 'success', 'statusCode' => 201];
                } else {
                    $this->response = ['message' => 'Update failed', 'status' => 'error', 'statusCode' => 403];
                }
            } else {
                $this->response = ['message' => 'The profile is already the household head.', 'status' => 'error', 'statusCode' => 403];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'household_profiles', 'changeHouseholdHead', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    // householdnumber unique generator
    public function getPuroks()
    {
        try {
            $puroks = Purok::where('archive', 0)->get();
            return response()->json(['message' => 'Success', 'status' => 'success', 'puroks' => $puroks]);
        } catch (\Exception $e) {
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
            $households = HouseholdProfile::with(['personalProfiles' => function ($query) use ($request) {
                $query->where('personal_profiles.archive', 0);
            }])
                ->leftJoin('puroks', 'household_profiles.purok_id', '=', 'puroks.id')
                ->leftJoin('users', 'household_profiles.bhw_user_id', '=', 'users.id')
                ->where(function ($query) use ($request) {
                    $query->where('household_profiles.household_number', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('household_profiles.nhts', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('household_profiles.electricity', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('household_profiles.water_supply', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('household_profiles.toilet', 'LIKE', '%' . $request->search . '%');
                })
                ->where('household_profiles.archive', $request->status);
            $totalHousehold = $households->count();
            $householdPage = $households->orderBy('household_profiles.id', 'desc')
                ->skip((intval($request->page) - 1) * ($totalHousehold > intval($request->recordPerPage) ? intval($request->recordPerPage) : 0))
                ->take(intval($request->recordPerPage))
                ->select('household_profiles.*', 'puroks.name as purok_name', 'users.firstname as bhw_fname', 'users.lastname as bhw_lname')
                ->get();
            return response()->json(['data' => $householdPage, 'count' => $totalHousehold]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occure', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function insertHousehold(Request $request)
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
            'relation_ship_to_head' => ['required'],
            // 'blood_type' => ['required'],
            'height' => ['required'],
            'weight' => ['required'],
            'nhts' => ['required'],
            'electricity' => ['required'],
            'water_supply' => ['required'],
            'toilet' => ['required'],
            'bhw_user_id' => ['required'],
            'purok_id' => ['required'],
        ]);
        try {
            $household = HouseholdProfile::create([
                'personal_profile_id' =>  0,
                'household_number' =>  $request->household_number,
                'nhts' => $request->nhts,
                'electricity' => $request->electricity,
                'water_supply' => $request->water_supply,
                'toilet' => $request->toilet,
                'bhw_user_id' => $request->bhw_user_id,
                'purok_id' => $request->purok_id,
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
                'personal_profile_id' =>  $profile->id
            ]);
            if ($household && $profile) {
                $id = $household->id;
                $this->response = ['message' => 'Registration successful', 'status' => 'success', 'household' => $household, 'statusCode' => 201];
            } else {
                $this->response = ['message' => 'Registration failed', 'status' => 'error', 'statusCode' => 403];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 403];
        }
        AuditTrail::createAuditTrail($request->user()->id, $id, 'household_profiles', 'insertHousehold', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function separateHousehold(Request $request)
    {
        $request->validate([
            'household_number' => ['required'],
            'personal_profile_id' => ['required'],
            'nhts' => ['required'],
            'electricity' => ['required'],
            'water_supply' => ['required'],
            'toilet' => ['required'],
            'bhw_user_id' => ['required'],
            'purok_id' => ['required'],
        ]);
        try {
            try {
                if (HouseholdProfile::where('personal_profile_id', $request->personal_profile_id)->get()->count() == 0) {
                    $household = HouseholdProfile::create([
                        'household_number' => $request->household_number,
                        'personal_profile_id' => $request->personal_profile_id,
                        'nhts' => $request->nhts,
                        'electricity' => $request->electricity,
                        'water_supply' => $request->water_supply,
                        'toilet' => $request->toilet,
                        'bhw_user_id' => $request->bhw_user_id,
                        'purok_id' => $request->purok_id,
                    ]);
                    PersonalProfile::where('id', $request->personal_profile_id)->update([
                        'household_profile_id' => $household->id,
                        'relation_ship_to_head' => 'Household Head'
                    ]);
                    HealthProfile::create([
                        "personal_profile_id" =>  $request->personal_profile_id,
                        "philhealth_number" => '',
                        "blood_type" => '',
                        "maintenance" => '[]',
                        "height" => 0,
                        "weight" => 0,
                        "bmi" => 0,
                        "health_status" => '[]',
                    ]);
                    if ($household) {
                        $this->response = ['message' => 'Created successfully', 'status' => 'success', 'statusCode' => 201];
                    } else {
                        $this->response = ['message' => 'Creation failed', 'status' => 'error', 'statusCode' => 403];
                    }
                } else {
                    $this->response = ['message' => 'The profile is the head of the household. Please changed the household head first.', 'status' => 'error', 'statusCode' => 403];
                }
            } catch (\Illuminate\Database\QueryException $e) {
                $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
            }
            AuditTrail::createAuditTrail($request->user()->id, $request->id, 'household_profiles', 'separateHousehold', $this->response['status'], $this->response['message'], json_encode($request->all()));
            return response()->json($this->response, $this->response['statusCode']);
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'personal_profiles', 'setAsHouseholdHead', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function updateHousehold(Request $request)
    {
        $request->validate([
            'household_number' => ['required'],
            'nhts' => ['required'],
            'electricity' => ['required'],
            'water_supply' => ['required'],
            'toilet' => ['required'],
            'bhw_user_id' => ['required'],
            'purok_id' => ['required'],
        ]);
        try {
            $household = HouseholdProfile::where('id', $request->id)->update([
                'nhts' => $request->nhts,
                'electricity' => $request->electricity,
                'water_supply' => $request->water_supply,
                'toilet' => $request->toilet,
                'bhw_user_id' => $request->bhw_user_id,
                'purok_id' => $request->purok_id,
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
    public function updatePurok(Request $request)
    {
        try {
            if (Purok::where('name', $request->name)->whereNot('id', $request->id)->get(['id'])->count() == 0) {
                Purok::where('id', $request->id)->update([
                    'name' => $request->name,
                ]);
                $this->response = ['message' => 'Updated successfully', 'status' => 'success', 'statusCode' => 201];
            } else {
                $this->response = ['message' => 'Update failed', 'status' => 'error', 'statusCode' => 403];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'purok', 'update purok', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
}
