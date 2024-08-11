<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use App\Models\HealthProfile;
use Illuminate\Http\Request;
class HealthProfileController extends Controller
{
    private $response;
    public function __construct()
    {
        $this->response = [];
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
}
