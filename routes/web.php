<?php

use App\Presentation\Http\Controllers\DonkiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/instruments', [DonkiController::class, 'getInstrumentsFromMeasurements']);
Route::get('/activity-ids', [DonkiController::class, 'getActivityIdsFromMeasurements']);
Route::get('/instruments/percentage-usage', [DonkiController::class, 'getInstrumentsUsage']);
