<?php

namespace App\Http\Controllers;

use App\Models\PregnancyFormProfile;
use Illuminate\Http\Request;

class PregnancyFormProfileController extends Controller
{
  
    public function getPregnancies(Request $request)
    {
        try {
            $pregnancies = PregnancyFormProfile::leftJoin('personal_profiles as profile', 'pregnancy_form_profiles.personal_profile_id',  '=', 'profile.id')
                ->where('pregnancy_form_profiles.archive', 0)
                ->where(function ($query) use ($request) {
                    $query->where('profile.firstname', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('profile.lastname', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('profile.middlename', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('pregnancy_form_profiles.family_planning', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('pregnancy_form_profiles.type_of_delivery', 'LIKE', '%' . $request->search . '%');
                })
                ->orderBy('profile.lastname', 'asc')
                ->get(['pregnancy_form_profiles.*', 'profile.lastname', 'profile.firstname', 'profile.middlename']);
            return response()->json(['message' => 'Successful', 'status' => 'success', 'pregnancies' => $pregnancies, 'count' => $pregnancies->count()], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function insertPregnancy(Request $request)
    {
        try {
            PregnancyFormProfile::create([
                'personal_profile_id' => $request->personal_profile_id,
                'post_partum' => $request->post_partum,
                'family_planning' => $request->family_planning,
                'type_of_delivery' => $request->type_of_delivery,
                'lmp' => $request->lmp,
                'edc' => $request->edc,
                'gp' => $request->gp,
            ]);
            return response()->json(['message' => 'Successful', 'status' => 'success'], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function updatePregnancy(Request $request)
    {
        try {
            PregnancyFormProfile::where('id', $request->id)->update([
                'personal_profile_id' => $request->personal_profile_id,
                'post_partum' => $request->post_partum,
                'family_planning' => $request->family_planning,
                'type_of_delivery' => $request->type_of_delivery,
                'lmp' => $request->lmp,
                'edc' => $request->edc,
                'gp' => $request->gp,
            ]);
            return response()->json(['message' => 'Successful', 'status' => 'success'], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function archivePregnancy(Request $request)
    {
        try {
            PregnancyFormProfile::where('id', $request->id)->update([
                'archive' => 1,
            ]);
            return response()->json(['message' => 'Successful', 'status' => 'success'], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
}
