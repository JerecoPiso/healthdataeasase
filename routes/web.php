<?php

use Illuminate\Support\Facades\Route;

Route::get('/household', function () {
    return view('household');
});
Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');