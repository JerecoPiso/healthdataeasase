<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        try {
            if (User::where('username', $request->username)->get(['id'])->count() == 0) {
                $user = User::create([
                    'username' => $request->username,
                    'password' => Hash::make($request->password)
                ]);
                if ($user) {
                    return response()->json(['message' => 'Registration successful', 'status' => 'success', 'user' => $user], 201);
                } else {
                    return response()->json(['message' => 'Registration failed', 'haha' => $request->all(), 'status' => 'error',], 500);
                }
            } else {
                return response()->json(['message' => 'Username already exists', 'status' => 'error',], 201);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'Registration failed', 'haha' => $request->all(),   'status' => 'error', 'error' => $e->getMessage()], 500);
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
                return response()->json(['token' => $token, 'message' => 'Logged in successfully', 'status' => 'success']);
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
}
