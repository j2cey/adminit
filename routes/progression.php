<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Progression\ProgressionController;
use App\Http\Controllers\Progression\ProgressionStepController;

Route::resource('progressionsteps',ProgressionStepController::class)->middleware('auth');
Route::resource('progressions',ProgressionController::class)->middleware('auth');
