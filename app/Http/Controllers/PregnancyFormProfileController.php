<?php

namespace App\Http\Controllers;

use App\Models\PregnancyFormProfile;
use Illuminate\Http\Request;
use App\Models\AuditTrail;

class PregnancyFormProfileController extends Controller
{
    private $response;
    public function __construct()
    {
        $this->response = [];
    }
    public function archivePregnancy(Request $request)
    {
        try {
            PregnancyFormProfile::where('id', $request->id)->update([
                'archive' => 1,
            ]);
            $this->response = ['message' => 'Successful', 'status' => 'success', 'statusCode' => 201];
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'pregnancy_form_profiles', 'archivePregnancy', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function getPregnancies(Request $request)
    {
        try {
            $pregnancies = PregnancyFormProfile::leftJoin('personal_profiles as profile', 'pregnancy_form_profiles.personal_profile_id',  '=', 'profile.id')
                ->where('pregnancy_form_profiles.archive', 0)
                ->where('profile.archive', 0)
                ->where(function ($query) use ($request) {
                    $query->where('profile.firstname', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('profile.lastname', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('profile.middlename', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('pregnancy_form_profiles.family_planning', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('pregnancy_form_profiles.type_of_delivery', 'LIKE', '%' . $request->search . '%');
                });
            $totalPregnancies = $pregnancies->count();
            $pregnanciesPage = $pregnancies->orderBy('pregnancy_form_profiles.id', 'desc')
                ->skip((intval($request->page) - 1) * ($totalPregnancies > intval($request->recordPerPage) ? intval($request->recordPerPage) : 0))
                ->take(intval($request->recordPerPage))
                ->get(
                    ['profile.*', 'pregnancy_form_profiles.id as pregnancy_id', 'pregnancy_form_profiles.post_partum', 'pregnancy_form_profiles.family_planning',
                    'pregnancy_form_profiles.type_of_delivery','pregnancy_form_profiles.lmp','pregnancy_form_profiles.edc','pregnancy_form_profiles.gp',
                    'pregnancy_form_profiles.status as pregnancy_status', 'pregnancy_form_profiles.personal_profile_id',
                    ]);
            return response()->json(['message' => 'Successful', 'status' => 'success', 'pregnancies' => $pregnanciesPage, 'count' => $totalPregnancies], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function insertPregnancy(Request $request)
    {   
        $id = 0;
        $request->validate([
            'personal_profile_id' => ['required'],
            'post_partum' => ['required'],
            'family_planning' => ['required'],
            'type_of_delivery' => ['required'],
            'lmp' => ['required'],
            'edc' => ['required'],
            'gp' => ['required'],
            'status' => ['required'],
        ]);
        try {
            $pregnancy = PregnancyFormProfile::create([
                'personal_profile_id' => $request->personal_profile_id,
                'post_partum' => $request->post_partum,
                'family_planning' => $request->family_planning,
                'type_of_delivery' => $request->type_of_delivery,
                'lmp' => $request->lmp,
                'edc' => $request->edc,
                'gp' => $request->gp,
                'status' => $request->status,
            ]);
            $id = $pregnancy->id;

            $this->response = ['message' => 'Successful', 'status' => 'success', 'statusCode' => 201];
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $id, 'pregnancy_form_profiles', 'insertPregnancy', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function updatePregnancy(Request $request)
    {
        $request->validate([
            'personal_profile_id' => ['required'],
            'post_partum' => ['required'],
            'family_planning' => ['required'],
            'type_of_delivery' => ['required'],
            'lmp' => ['required'],
            'edc' => ['required'],
            'gp' => ['required'],
        ]);
        try {
            $pregnancy = PregnancyFormProfile::where('id', $request->pregnancy_id)->update([
                // 'personal_profile_id' => $request->personal_profile_id,
                'post_partum' => $request->post_partum,
                'family_planning' => $request->family_planning,
                'type_of_delivery' => $request->type_of_delivery,
                'lmp' => $request->lmp,
                'edc' => $request->edc,
                'gp' => $request->gp,
                'status' => $request->status,
            ]);
            if ($pregnancy) {
                $this->response = ['message' => 'Updated successfully', 'status' => 'success', 'pregnancy' => $pregnancy, 'statusCode' => 201];
            } else {
                $this->response = ['message' => 'Update failed', 'status' => 'error', 'statusCode' => 403];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'pregnancy_form_profiles', 'updatePregnancy', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
   
}
