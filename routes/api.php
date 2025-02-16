<?php

use App\Presentation\Http\Controllers\DonkiController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/instruments', [DonkiController::class, 'getInstrumentsFromMeasurements']);
Route::get('/activity-ids', [DonkiController::class, 'getActivityIdsFromMeasurements']);
Route::get('/instruments/percentage-usage', [DonkiController::class, 'getInstrumentsUsage']);
Route::post('/instruments/percentage-usage', [DonkiController::class, 'getInstrumentUsage'])->withoutMiddleware([VerifyCsrfToken::class]);
