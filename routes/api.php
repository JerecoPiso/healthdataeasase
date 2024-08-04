<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalProfileController;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});
Route::prefix('personalprofile')->middleware('auth:sanctum')->controller(PersonalProfileController::class)->group(function () {
    Route::post('insertPersonalProfile', 'insertPersonalProfile');
    Route::post('getPersonalProfile', 'getPersonalProfile');
});


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
