<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HealthProfileController;
use App\Http\Controllers\PersonalProfileController;
use App\Http\Controllers\HouseholdProfileController;
use App\Http\Controllers\PregnancyFormProfileController;
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
    Route::post('getFemales', 'getFemales');
    Route::post('updatePersonalProfile', 'updatePersonalProfile');
});
Route::prefix('household')->middleware('auth:sanctum')->controller(HouseholdProfileController::class)->group(function () {
    Route::post('insertHousehold', 'insertHousehold');
    Route::post('getHousehold', 'getHousehold');
    Route::post('getHouseHoldNumber', 'getHouseHoldNumber');
});
Route::prefix('healthprofile')->middleware('auth:sanctum')->controller(HealthProfileController::class)->group(function () {
    Route::post('updateHealthProfile', 'updateHealthProfile');
});
// Route::prefix('pregnancy')->middleware('auth:sanctum')->controller(PregnancyFormProfileController::class)->group(function () {
//     Route::post('updateHealthProfile', 'updateHealthProfile');
// });
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
