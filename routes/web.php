<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
Route::get('reports/bycategory/{category}/{value}', [ReportController::class, 'generateReportByCategory']);
Route::get('reports/household/{purok_id}', [ReportController::class, 'generateHouseholdReport']);
Route::get('reports/seniorcitizen/{purok_id}', [ReportController::class, 'generateSeniorCitizenReport']);
Route::get('reports/underweight/{age}/{purok_id}', [ReportController::class, 'generateUnderweightReport']);
Route::get('reports/pregnants/{age}/{purok_id}', [ReportController::class, 'generatePregnantsReport']);
Route::get('reports/generateReportAgeRange/{minAge}/{maxAge}', [ReportController::class, 'generateReportAgeRange']);

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');