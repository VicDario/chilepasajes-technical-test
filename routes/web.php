<?php

use App\Presentation\Http\Controllers\DonkiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/instruments', [DonkiController::class, 'getInstrumentsFromMeasurements']);
