<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormatRule\FormatTextSizeController;
use App\Http\Controllers\FormatRule\FormatRuleController;
use App\Http\Controllers\FormatRule\FormatTextColorController;
use App\Http\Controllers\FormatRule\FormatTextWeightController;
use App\Http\Controllers\FormatRule\FormatRuleTypeController;


Route::resource('formatruletypes',FormatRuleTypeController::class)->middleware('auth');
Route::get('formatruletypes.fetch',[FormatRuleTypeController::class,'fetch'])
    ->name('formatruletypes.fetch')
    ->middleware('auth');
Route::get('formatruletypes.fetchall',[FormatRuleTypeController::class,'fetchall'])
    ->name('formatruletypes.fetchall')
    ->middleware('auth');

Route::resource('formatrules',FormatRuleController::class)->middleware('auth');
Route::get('formatrules.fetch',[FormatRuleController::class,'fetch'])
    ->name('formatrules.fetch')
    ->middleware('auth');
Route::get('formatrules.fetchall',[FormatRuleController::class,'fetchall'])
    ->name('formatrules.fetchall')
    ->middleware('auth');

Route::resource('formattextcolors',FormatTextColorController::class)->middleware('auth');
Route::get('formattextcolors.fetch',[FormatTextColorController::class,'fetch'])
    ->name('formattextcolors.fetch')
    ->middleware('auth');
Route::get('formattextcolors.fetchall',[FormatTextColorController::class,'fetchall'])
    ->name('formattextcolors.fetchall')
    ->middleware('auth');

Route::resource('formattextsizes',FormatTextSizeController::class)->middleware('auth');
Route::get('formattextsizes.fetch',[FormatTextSizeController::class,'fetch'])
    ->name('formattextsizes.fetch')
    ->middleware('auth');
Route::get('formattextsizes.fetchall',[FormatTextSizeController::class,'fetchall'])
    ->name('formattextsizes.fetchall')
    ->middleware('auth');

Route::resource('formattextweights',FormatTextWeightController::class)->middleware('auth');

Route::get('formattextweights.fetch',[FormatTextWeightController::class,'fetch'])
    ->name('formattextweights.fetch')
    ->middleware('auth');
Route::get('formattextweights.fetchall',[FormatTextWeightController::class,'fetchall'])
    ->name('formattextweights.fetchall')
    ->middleware('auth');
