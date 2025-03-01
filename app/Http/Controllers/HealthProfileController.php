<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use App\Models\HealthProfile;
use App\Models\PersonalProfile;
use App\Models\Vaccination;
use App\Models\Vaccine;
use Illuminate\Http\Request;

class HealthProfileController extends Controller
{
    private $response;
    public function __construct()
    {
        $this->response = [];
    }
    public function addVaccine(Request $request)
    {
        $id = 0;
        try {
            if (Vaccine::where('name', $request->name)->get(['id'])->count() == 0) {
                $vaccine = Vaccine::create([
                    'name' => $request->name,
                    'archive' => 0
                ]);
                if ($vaccine) {
                    $id = $vaccine->id;
                    $this->response = ['message' => 'Vaccine has been added successfully', 'status' => 'success', 'vaccine' => $vaccine, 'statusCode' => 201];
                } else {
                    $this->response = ['message' => 'Adding failed', 'status' => 'error', 'statusCode' => 403];
                }
            } else {
                $this->response = ['message' => 'Vaccine name already exists', 'status' => 'error', 'statusCode' => 201];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id,  $id, 'vaccine', 'add vaccine', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function archiveVaccine(Request $request)
    {
        try {
            Vaccine::where('id', $request->id)->update([
                'archive' => 1,
            ]);
            $this->response = ['message' => 'Successful', 'status' => 'success', 'statusCode' => 201];
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'household_profiles', 'archiveHouseholdProfile', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    // archive vaccination
    public function archiveVaccination(Request $request)
    {
        try {
            Vaccination::where('id', $request->id)->update([
                'archive' => 1,
            ]);
            $this->response = ['message' => 'Successful', 'status' => 'success', 'statusCode' => 201];
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        // audit logs
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'vaccinations', 'archiveVaccination', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function archiveHealthProfile(Request $request)
    {
        try {
            HealthProfile::where('id', $request->id)->update([
                'archive' => 1,
            ]);
            $this->response = ['message' => 'Successful', 'status' => 'success', 'statusCode' => 201];
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'health_profiles', 'archivePersonalProfile', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function getVaccines()
    {
        try {
            $vaccines = Vaccine::where('archive', 0)->get();
            return response()->json(['message' => 'Success', 'status' => 'success', 'vaccines' => $vaccines]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error has occure', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function getVaccinations(Request $request)
    {
        try {
            $vaccinations = PersonalProfile::has('vaccinations')->with(['vaccinations' => function ($query) use ($request) {
                $query->leftJoin('vaccines', 'vaccinations.vaccine_id', '=', 'vaccines.id')
                    ->leftJoin('users', 'vaccinations.vaccinator_id', '=', 'users.id')
                    ->where('vaccinations.archive',  0)->select('vaccinations.*', 'users.lastname', 'users.firstname', 'vaccines.name');
            }])

                ->whereRaw('TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) <= ?', [1])
                ->where(function ($query) use ($request) {
                    $query->where('lastname', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('firstname', 'LIKE', '%' . $request->search . '%');
                })
                ->where('archive', 0);
            $totalBabies = $vaccinations->count();
            $babiesPage = $vaccinations->orderBy('lastname', 'desc')
                ->skip((intval($request->page) - 1) * ($totalBabies > intval($request->recordPerPage) ? intval($request->recordPerPage) : 0))
                ->take(intval($request->recordPerPage))
                ->get();
            return response()->json(['vaccinations' => $babiesPage, 'count' => $totalBabies]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occure', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
        $vaccinations = PersonalProfile::with('vaccinations')->get();
        return response()->json(['vaccinations' => $vaccinations]);
    }
    public function saveVaccination(Request $request)
    {
        $id = 0;
        $request->validate([
            'personal_profile_id' => ['required'],
            'vaccine_id' => ['required'],
            'vaccinator_id' => ['required'],
            'vaccination_datetime' => ['required'],
            'dose' => ['required'],
        ]);
        try {
            $vaccination = Vaccination::create([
                "personal_profile_id" => $request->personal_profile_id,
                "vaccine_id" => $request->vaccine_id,
                "vaccinator_id" => $request->vaccinator_id,
                "dose" => $request->dose,
                "vaccination_datetime" => $request->vaccination_datetime,
                "remarks" => $request->remarks
            ]);
            if ($vaccination) {
                $id = $vaccination->id;
                $this->response = ['message' => 'Registration successful', 'status' => 'success', 'vaccination' => $vaccination, 'statusCode' => 201];
            } else {
                $this->response = ['message' => 'Registration failed', 'status' => 'error', 'statusCode' => 403];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $id, 'vaccinations', 'saveVaccination', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function updateHealthProfile(Request $request)
    {
        try {
            $health = HealthProfile::where('id', $request->health_id)
                ->update([
                    'philhealth_number' => $request->philhealth_number,
                    'blood_type' => $request->blood_type,
                    'maintenance' => $request->maintenance,
                    'height' => $request->height,
                    'weight' => $request->weight,
                    "bmi" => $request->bmi,
                    'health_status' => $request->health_status
                ]);
            if ($health) {
                $this->response = ['message' => 'Updated successfully', 'status' => 'success', 'health' => $health, 'statusCode' => 201];
            } else {
                $this->response = ['message' => 'Update failed', 'status' => 'error', 'statusCode' => 403];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->health_id, 'health_profiles', 'updateHealthProfile', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function updateVaccination(Request $request)
    {
        $request->validate([
            'id' => ['required'],
            'vaccine_id' => ['required'],
            'vaccinator_id' => ['required'],
            'vaccination_datetime' => ['required'],
        ]);
        try {
            $health = Vaccination::where('id', $request->id)
                ->update([
                    "vaccine_id" => $request->vaccine_id,
                    "vaccinator_id" => $request->vaccinator_id,
                    'dose' => $request->dose,
                    'vaccination_datetime' => $request->vaccination_datetime,
                    'remarks' => $request->remarks
                ]);
            if ($health) {
                $this->response = ['message' => 'Updated successfully', 'status' => 'success', 'health' => $health, 'statusCode' => 201];
            } else {
                $this->response = ['message' => 'Update failed', 'status' => 'error', 'statusCode' => 403];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'vaccinations', 'updateVaccination', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function updateVaccine(Request $request)
    {
        try {
            if (Vaccine::where('name', $request->name)->whereNot('id', $request->id)->get(['id'])->count() == 0) {
                Vaccine::where('id', $request->id)->update([
                    'name' => $request->name,
                ]);
                $this->response = ['message' => 'Updated successfully', 'status' => 'success', 'statusCode' => 201];
            } else {
                $this->response = ['message' => 'Update failed', 'status' => 'error', 'statusCode' => 403];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'vaccine', 'update vaccine', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
}
