<?php

use App\Http\Controllers\DiagnosisController;
use Illuminate\Support\Facades\Route;

Route::get('/symptoms', [DiagnosisController::class, 'symptoms']);
Route::post('/diagnose', [DiagnosisController::class, 'diagnose']);
