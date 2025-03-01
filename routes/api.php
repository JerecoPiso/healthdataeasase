<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HealthProfileController;
use App\Http\Controllers\PersonalProfileController;
use App\Http\Controllers\HouseholdProfileController;
use App\Http\Controllers\PregnancyFormProfileController;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('continueForgotPassword', 'continueForgotPassword');
    Route::post('forgotPassword', 'forgotPassword');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
    Route::post('register', 'register');

    Route::delete('archiveUser/{id}', 'archiveUser');
    Route::post('changePassword', 'changePassword')->middleware('auth:sanctum');
    Route::post('getUsers', 'getUsers')->middleware('auth:sanctum');
    Route::get('getUsersByRole/{role}', 'getUsersByRole')->middleware('auth:sanctum');
    
    Route::post('getLogs', 'getLogs')->middleware('auth:sanctum');
    Route::post('updateUser', 'updateUser')->middleware('auth:sanctum');
});

Route::prefix('dashboard')->middleware('auth:sanctum')->controller(DashboardController::class)->group(function () {
    Route::get('getCounts', 'getCounts');
    Route::get('getCountsByAgeGroup', 'getCountsByAgeGroup');
});
Route::prefix('personalprofile')->middleware('auth:sanctum')->controller(PersonalProfileController::class)->group(function () {
    Route::delete('archivePersonalProfile/{id}', 'archivePersonalProfile');
    Route::delete('unarchivePersonalProfile/{id}', 'unarchivePersonalProfile');
    Route::post('getPersonalProfile', 'getPersonalProfile');
    Route::post('getFemales', 'getFemales');
    Route::get('getBabies', 'getBabies');
    Route::post('insertPersonalProfile', 'insertPersonalProfile');
    Route::post('updatePersonalProfile', 'updatePersonalProfile');
    Route::post('viewProfile', 'viewProfile');
});
Route::prefix('household')->middleware('auth:sanctum')->controller(HouseholdProfileController::class)->group(function () {
    Route::post('addPurok', 'addPurok');
    Route::get('getPuroks', 'getPuroks');
    Route::delete('archivePurok/{id}', 'archivePurok');

    Route::delete('archiveHouseholdProfile/{id}', 'archiveHouseholdProfile');
    Route::delete('unarchiveHouseholdProfile/{id}', 'unarchiveHouseholdProfile');
    Route::post('changeHouseholdHead', 'changeHouseholdHead');
    Route::post('getHousehold', 'getHousehold');
    Route::post('getHouseHoldNumber', 'getHouseHoldNumber');
    Route::post('insertHousehold', 'insertHousehold');
    Route::post('separateHousehold', 'separateHousehold');
    Route::post('updateHousehold', 'updateHousehold');
    Route::post('updatePurok', 'updatePurok');

});
Route::prefix('healthprofile')->middleware('auth:sanctum')->controller(HealthProfileController::class)->group(function () {
    Route::post('addVaccine', 'addVaccine');
    Route::get('getVaccines', 'getVaccines');
    Route::delete('archiveHealthProfile/{id}', 'archiveHealthProfile');
    Route::delete('archiveVaccination/{id}', 'archiveVaccination');
    Route::delete('archiveVaccine/{id}', 'archiveVaccine');

    Route::post('getVaccinations', 'getVaccinations');
    Route::post('saveVaccination', 'saveVaccination');
    Route::post('updateHealthProfile', 'updateHealthProfile');
    Route::post('updateVaccination', 'updateVaccination');
    Route::post('updateVaccine', 'updateVaccine');

});
Route::prefix('pregnancy')->middleware('auth:sanctum')->controller(PregnancyFormProfileController::class)->group(function () {
    Route::delete('archivePregnancy/{id}', 'archivePregnancy');
    Route::post('getPregnancies', 'getPregnancies');
    Route::post('insertPregnancy', 'insertPregnancy');
    Route::post('updatePregnancy', 'updatePregnancy');
});
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
