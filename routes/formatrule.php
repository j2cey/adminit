<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormatRule\FormatTextSizeController;
use App\Http\Controllers\FormatRule\FormatRuleController;
use App\Http\Controllers\FormatRule\FormatTextColorController;
use App\Http\Controllers\FormatRule\FormatTextWeightController;
use App\Http\Controllers\FormatRule\FormatRuleTypeController;


Route::resource('analysishighlighttypes',FormatRuleTypeController::class)->middleware('auth');
Route::get('analysishighlighttypes.fetch',[FormatRuleTypeController::class,'fetch'])
    ->name('analysishighlighttypes.fetch')
    ->middleware('auth');
Route::get('analysishighlighttypes.fetchall',[FormatRuleTypeController::class,'fetchall'])
    ->name('analysishighlighttypes.fetchall')
    ->middleware('auth');

Route::resource('analysishighlights',FormatRuleController::class)->middleware('auth');
Route::get('analysishighlights.fetch',[FormatRuleController::class,'fetch'])
    ->name('analysishighlights.fetch')
    ->middleware('auth');
Route::get('analysishighlights.fetchall',[FormatRuleController::class,'fetchall'])
    ->name('analysishighlights.fetchall')
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
