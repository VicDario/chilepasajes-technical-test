<?php

use App\Presentation\Http\Controllers\InstrumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/instruments', [InstrumentController::class, 'getInstrumentsFromDonki']);
