<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
Route::get('reports/household', [ReportController::class, 'generateHouseholdReport']);
Route::get('reports/seniorcitizen', [ReportController::class, 'generateSeniorCitizenReport']);
Route::get('reports/pregnants', [ReportController::class, 'generatePregnantsReport']);

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');