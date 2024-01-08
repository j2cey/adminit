<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Treatments\TreatmentController;
//use App\Http\Controllers\ReportTreatments\TreatmentOperationController;
//use App\Http\Controllers\ReportTreatments\ReportTreatmentStepController;
use App\Http\Controllers\Treatments\TreatmentResultController;
use App\Http\Controllers\Treatments\TreatmentServiceController;
use App\Http\Controllers\Treatments\TreatmentWorkflowController;
use App\Http\Controllers\Treatments\TreatmentWorkflowStepController;


Route::resource('treatmentservices',TreatmentServiceController::class)->middleware('auth');
Route::resource('treatmentresults',TreatmentResultController::class)->middleware('auth');
Route::resource('treatments',TreatmentController::class)->middleware('auth');
Route::get('treatments.subs/{id}',[TreatmentController::class,'subs'])->middleware('auth');
//Route::resource('reporttreatmentsteps',ReportTreatmentStepController::class)->middleware('auth');
//Route::resource('treatmentoperations',TreatmentOperationController::class)->middleware('auth');

Route::resource('treatmentworkflows',TreatmentWorkflowController::class)->middleware('auth');
Route::resource('treatmentworkflowsteps',TreatmentWorkflowStepController::class)->middleware('auth');
