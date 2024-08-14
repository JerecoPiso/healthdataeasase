<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
Route::get('household', [ReportController::class, 'generateHouseholdReport']);
// Route::get('/household', function () {
//     return view('reports/household');
// });
Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');