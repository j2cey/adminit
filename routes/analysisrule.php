<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalysisRules\AnalysisRuleController;
use App\Http\Controllers\AnalysisRules\ThresholdMinController;
use App\Http\Controllers\AnalysisRules\ThresholdMaxController;
use App\Http\Controllers\AnalysisRules\AnalysisRuleTypeController;
use App\Http\Controllers\AnalysisRules\AnalysisRuleThresholdController;
use App\Http\Controllers\AnalysisRuleComparison\ComparisonTypeController;
use App\Http\Controllers\AnalysisRuleComparison\ComparisonEqualController;
use App\Http\Controllers\AnalysisRuleComparison\ComparisonLessThanController;
use App\Http\Controllers\AnalysisRuleComparison\ComparisonNotEqualController;
use App\Http\Controllers\AnalysisRuleComparison\ComparisonGreaterThanController;
use App\Http\Controllers\AnalysisRuleComparison\AnalysisRuleComparisonController;


Route::resource('analysisruletypes',AnalysisRuleTypeController::class)->middleware('auth');
Route::get('analysisruletypes.fetch',[AnalysisRuleTypeController::class,'fetch'])
    ->name('analysisruletypes.fetch')
    ->middleware('auth');
Route::get('analysisruletypes.fetchall',[AnalysisRuleTypeController::class,'fetchall'])
    ->name('analysisruletypes.fetchall')
    ->middleware('auth');


Route::resource('analysisrules',AnalysisRuleController::class)->middleware('auth');
Route::get('analysisrules.fetch',[AnalysisRuleController::class,'fetch'])
    ->name('analysisrules.fetch')
    ->middleware('auth');
Route::get('analysisrules.fetchall',[AnalysisRuleController::class,'fetchall'])
    ->name('analysisrules.fetchall')
    ->middleware('auth');
Route::get('analysisrules.fetchone/{id}',[AnalysisRuleController::class,'fetchone'])
    ->name('analysisrules.fetchone')
    ->middleware('auth');

#region Threshold

Route::resource('analysisrulethresholds',AnalysisRuleThresholdController::class)->middleware('auth');
Route::get('analysisrulethresholds.fetch',[AnalysisRuleThresholdController::class,'fetch'])
    ->name('analysisrulethresholds.fetch')
    ->middleware('auth');
Route::get('analysisrulethresholds.fetchall',[AnalysisRuleThresholdController::class,'fetchall'])
    ->name('analysisrulethresholds.fetchall')
    ->middleware('auth');

Route::resource('thresholdmins',ThresholdMinController::class)->middleware('auth');
Route::get('thresholdmins.fetch',[ThresholdMinController::class,'fetch'])
    ->name('thresholdmins.fetch')
    ->middleware('auth');

Route::resource('thresholdmaxes',ThresholdMaxController::class)->middleware('auth');
Route::get('thresholdmaxes.fetch',[ThresholdMaxController::class,'fetch'])
    ->name('thresholdmaxes.fetch')
    ->middleware('auth');

#endregion

#region Comparison

Route::resource('comparisontypes',ComparisonTypeController::class)->middleware('auth');
Route::get('comparisontypes.fetchall',[ComparisonTypeController::class,'fetchall'])
    ->name('comparisontypes.fetchall')
    ->middleware('auth');

Route::resource('analysisrulecomparisons',AnalysisRuleComparisonController::class)->middleware('auth');
Route::get('analysisrulecomparisons.fetchall',[AnalysisRuleComparisonController::class,'fetchall'])
    ->name('analysisrulecomparisons.fetchall')
    ->middleware('auth');

Route::resource('comparisonlessthans',ComparisonLessThanController::class)->middleware('auth');

Route::resource('comparisongreaterthans',ComparisonGreaterThanController::class)->middleware('auth');

Route::resource('comparisonequals',ComparisonEqualController::class)->middleware('auth');

Route::resource('comparisonnotequals',ComparisonNotEqualController::class)->middleware('auth');

#endregion
