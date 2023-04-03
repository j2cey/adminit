<?php

use App\Http\Controllers\FormattedValue\FormatTypeController;


Route::resource('formattypes',FormatTypeController::class)->middleware('auth');
Route::get('formattypes.fetch',[FormatTypeController::class,'fetch'])
    ->name('formattypes.fetch')
    ->middleware('auth');
Route::get('formattypes.fetchall',[FormatTypeController::class,'fetchall'])
    ->name('formattypes.fetchall')
    ->middleware('auth');
