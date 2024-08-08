<?php

namespace App\Http\Controllers;

use App\Models\HealthProfile;
use Illuminate\Http\Request;

class HealthProfileController extends Controller
{
    //
   
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
                    'bmi' => $request->bmi,
                    'health_status' => $request->health_status
                ]);
            if ($health) {
                return response()->json(['message' => 'Update successful', 'status' => 'success', 'health' => $health], 201);
            } else {
                return response()->json(['message' => 'Update failed', 'status' => 'error',], 500);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
}
