<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RetrieveAction\RetrieveActionController;
use App\Http\Controllers\RetrieveAction\RetrieveActionTypeController;
use App\Http\Controllers\RetrieveAction\RetrieveActionValueController;
use App\Http\Controllers\RetrieveAction\SelectedRetrieveActionController;

Route::resource('retrieveactiontypes',RetrieveActionTypeController::class)->middleware('auth');
Route::get('retrieveactiontypes.fetch',[RetrieveActionTypeController::class,'fetch'])
    ->name('retrieveactiontypes.fetch')
    ->middleware('auth');

Route::resource('retrieveactions',RetrieveActionController::class)->middleware('auth');
Route::get('retrieveactions.fetch',[RetrieveActionController::class,'fetch'])
    ->name('retrieveactions.fetch')
    ->middleware('auth');

Route::resource('selectedretrieveactions',SelectedRetrieveActionController::class)->middleware('auth');
Route::get('selectedretrieveactions.test',[SelectedRetrieveActionController::class,'test'])
    ->name('selectedretrieveactions.test')
    ->middleware('auth');
Route::get('selectedretrieveactions.fetch',[SelectedRetrieveActionController::class,'fetch'])
    ->name('selectedretrieveactions.fetch')
    ->middleware('auth');
/*Route::put('selectedretrieveactions.addtomodel',[SelectedRetrieveActionController::class,'addtomodel'])
    ->name('selectedretrieveactions.addtomodel')
    ->middleware('auth');
Route::put('selectedretrieveactions.removefrommodel',[SelectedRetrieveActionController::class,'removefrommodel'])
    ->name('selectedretrieveactions.removefrommodel')
    ->middleware('auth');*/

Route::resource('retrieveactionvalues',RetrieveActionValueController::class)->middleware('auth');
Route::get('retrieveactionvalues.fetch',[RetrieveActionValueController::class,'fetch'])
    ->name('retrieveactionvalues.fetch')
    ->middleware('auth');
