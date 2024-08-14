<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use App\Models\HealthProfile;
use App\Models\PersonalProfile;
use App\Models\Vaccination;

use Illuminate\Http\Request;
class HealthProfileController extends Controller
{
    private $response;
    public function __construct()
    {
        $this->response = [];
    }
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
    public function getVaccinations(Request $request){
        try {
            $vaccinations = PersonalProfile::has('vaccinations')->with(['vaccinations' => function($query) use ($request)  {
                $query->where('vaccinations.archive',  0);
            }])
            ->where(function ($query) use ($request) {
                $query->where('lastname', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('firstname', 'LIKE', '%' . $request->search . '%');
            })
            ->where('archive', 0);
            $totalBabies = $vaccinations->count();
            $babiesPage = $vaccinations->orderBy('id', 'desc')
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
            'vaccine' => ['required'],
            'vaccinator' => ['required'],
            'vaccination_datetime' => ['required'],
        ]);
        try {
            $vaccination = Vaccination::create([
                "personal_profile_id" => $request->personal_profile_id,
                "vaccine" => $request->vaccine,
                "vaccinator" => $request->vaccinator,
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
            'vaccine' => ['required'],
            'vaccinator' => ['required'],
            'vaccination_datetime' => ['required'],
        ]);
        try {
            $health = Vaccination::where('id', $request->id)
                ->update([
                    'vaccine' => $request->vaccine,
                    'vaccinator' => $request->vaccinator,
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
}
