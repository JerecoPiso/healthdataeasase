<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{   
    private $response;
    public function __construct()
    {
        $this->response = [];
    }
    public function archiveUser(Request $request)
    {
        try {
            User::where('id', $request->id)->update([
                'archive' => 1,
            ]);
            return response()->json(['message' => 'Successful', 'status' => 'success'], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function changePassword(Request $request)
    {
        try {
            $userInfo = User::where('id', $request->id)->get()->first();
            if (Hash::check($request->old_password, $userInfo->password)) {
                if($request->password === $request->retype_password){
                    User::where('id', $request->id)->update([
                        'password' => Hash::make($request->password,[
                            'rounds' => 12
                        ])
                    ]);
                    $this->response = ['message' => 'Password changed successfully', 'status' => 'success', 'statusCode' => 201];
                }else{
                    $this->response = ['message' => 'Password did not matched!', 'status' => 'error', 'statusCode' => 403];
                }
            } else {
                $this->response = ['message' => 'Old password is incorrect!', 'status' => 'error', 'statusCode' => 403];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => $e->getMessage(), 'status' => 'error', 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'users', 'changePassword', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
    public function getUsers(Request $request)
    {
        try {
            $users = User::where('archive', 0)
                ->where(function ($query) use ($request) {
                    $query->where('username', 'LIKE', '%' . $request->search . '%')
                        ->where('firstname', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('middlename', 'LIKE', '%' . $request->search . '%');
                });
            $totalUsers = $users->count();
            $usersPage = $users->orderBy('id', 'desc')
                ->skip((intval($request->page) - 1) * ($totalUsers > intval($request->recordPerPage) ? intval($request->recordPerPage) : 0))
                ->take(intval($request->recordPerPage))
                ->get();

            return response()->json(['message' => 'Success', 'status' => 'success', 'users' => $usersPage, 'count' => $totalUsers]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error has occure', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'max:45'],
            'password' => ['required'],
        ]);
        $user = User::where('username', $request->username)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken($request->username)->plainTextToken;
                AuditTrail::createAuditTrail($user->id, $user->id, 'users', 'login', 'success', 'Success', '');
                return response()->json(['token' => $token, '_role' => $user->role,'message' => 'Logged in successfully', 'status' => 'success']);
            } else {
                return response()->json(['message' => 'Password was incorrect', 'status' => 'error']);
            }
        } else {
            return response()->json(['message' => 'Username does not exist', 'status' => 'error']);
        }
    }
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logged out successfully', 'status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error has occure', 'status' => 'error', 'data' => $e->getMessage()], 500);
        }
    }
    public function register(Request $request)
    {
        try {
            if (User::where('username', $request->username)->get(['id'])->count() == 0) {
                $user = User::create([
                    'username' => $request->username,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'middlename' => $request->middlename,
                    'suffix' => $request->suffix,
                    'role' => $request->role,
                    'password' => Hash::make($request->password,[
                        'rounds' => 12,
                    ])
                ]);
                if ($user) {
                    // AuditTrail::createAuditTrail($user->id, $user->id, 'users', 'login', 'success', 'Success', '');
                    return response()->json(['message' => 'Registration successful', 'status' => 'success', 'user' => $user], 201);
                } else {
                    return response()->json(['message' => 'Registration failed', 'status' => 'error',], 500);
                }
            } else {
                return response()->json(['message' => 'Username already exists', 'status' => 'error',], 201);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'Registration failed',   'status' => 'error', 'error' => $e->getMessage()], 500);
        }
    }
    public function updateUser(Request $request)
    {
        try {
            if (User::where('username', $request->username)->whereNot('id', $request->id)->get(['id'])->count() == 0) {
                User::where('id', $request->id)->update([
                    'username' => $request->username,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'middlename' => $request->middlename,
                    'suffix' => $request->suffix,
                    'role' => $request->role,
                ]);
                $this->response = ['message' => 'Updated successfully', 'status' => 'success', 'statusCode' => 201];
            } else {
                $this->response = ['message' => 'Update failed', 'status' => 'error', 'statusCode' => 403];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->response = ['message' => 'An error has occured', 'status' => 'error', 'data' => $e->getMessage(), 'statusCode' => 500];
        }
        AuditTrail::createAuditTrail($request->user()->id, $request->id, 'users', 'updateUser', $this->response['status'], $this->response['message'], json_encode($request->all()));
        return response()->json($this->response, $this->response['statusCode']);
    }
}
