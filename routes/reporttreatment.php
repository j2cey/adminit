<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\ReportTreatments\ReportTreatmentController;
//use App\Http\Controllers\ReportTreatments\TreatmentOperationController;
//use App\Http\Controllers\ReportTreatments\ReportTreatmentStepController;
use App\Http\Controllers\ReportTreatments\TreatmentWorkflowController;
use App\Http\Controllers\ReportTreatments\TreatmentWorkflowStepController;


//Route::resource('reporttreatments',ReportTreatmentController::class)->middleware('auth');
//Route::resource('reporttreatmentsteps',ReportTreatmentStepController::class)->middleware('auth');
//Route::resource('treatmentoperations',TreatmentOperationController::class)->middleware('auth');

Route::resource('treatmentworkflows',TreatmentWorkflowController::class)->middleware('auth');
Route::resource('treatmentworkflowsteps',TreatmentWorkflowStepController::class)->middleware('auth');
