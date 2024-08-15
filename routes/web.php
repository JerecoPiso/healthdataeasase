<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
Route::get('reports/household', [ReportController::class, 'generateHouseholdReport']);

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');