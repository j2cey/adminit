<?php

use App\Http\Controllers\FormattedValue\FormatTypeController;
use App\Http\Controllers\FormattedValue\FormattedValueSmsController;
use App\Http\Controllers\FormattedValue\FormattedValueHtmlController;


Route::resource('formattypes',FormatTypeController::class)->middleware('auth');
Route::get('formattypes.fetch',[FormatTypeController::class,'fetch'])
    ->name('formattypes.fetch')
    ->middleware('auth');
Route::get('formattypes.fetchall',[FormatTypeController::class,'fetchall'])
    ->name('formattypes.fetchall')
    ->middleware('auth');

Route::resource('formattedvaluehtmls',FormattedValueHtmlController::class)->middleware('auth');
Route::get('formattedvaluehtmls.fetch',[FormattedValueHtmlController::class,'fetch'])
    ->name('formattedvaluehtmls.fetch')
    ->middleware('auth');

Route::resource('formattedvaluesms',FormattedValueSmsController::class)->middleware('auth');
Route::get('formattedvaluesms.fetch',[FormattedValueSmsController::class,'fetch'])
    ->name('formattedvaluesms.fetch')
    ->middleware('auth');

