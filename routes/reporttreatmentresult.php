<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportTreatments\OperationResultController;
use App\Http\Controllers\ReportTreatments\ReportTreatmentResultController;
use App\Http\Controllers\ReportTreatments\ReportTreatmentWorkflowController;
use App\Http\Controllers\ReportTreatments\ReportTreatmentStepResultController;
use App\Http\Controllers\ReportTreatments\ReportTreatmentWorkflowStepController;


Route::resource('reporttreatmentresults',ReportTreatmentResultController::class)->middleware('auth');
Route::resource('reporttreatmentstepresults',ReportTreatmentStepResultController::class)->middleware('auth');
Route::resource('operationresults',OperationResultController::class)->middleware('auth');

Route::resource('reporttreatmentworkflows',ReportTreatmentWorkflowController::class)->middleware('auth');
Route::resource('reporttreatmentworkflowsteps',ReportTreatmentWorkflowStepController::class)->middleware('auth');
