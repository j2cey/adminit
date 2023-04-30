<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportTreatments\OperationResultController;
use App\Http\Controllers\ReportTreatments\ReportTreatmentResultController;
use App\Http\Controllers\ReportTreatments\ReportTreatmentStepResultController;


Route::resource('reporttreatmentresults',ReportTreatmentResultController::class)->middleware('auth');
Route::resource('reporttreatmentstepresults',ReportTreatmentStepResultController::class)->middleware('auth');
Route::resource('operationresults',OperationResultController::class)->middleware('auth');
