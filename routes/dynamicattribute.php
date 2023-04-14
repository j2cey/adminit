<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DynamicAttributes\DynamicAttributeController;
use App\Http\Controllers\DynamicAttributes\DynamicAttributeTypeController;

Route::get('/tests', function () {
    $report = App\Models\Reports\Report::where("title","Report 01")->first();
    if ( is_null($report) ) {
        $report = App\Models\Reports\Report::createNew("Report 01", App\Models\Reports\ReportType::first(), "");
        $report->addDynamicAttribute("Att Dyn. 01", App\Models\DynamicAttributes\DynamicAttributeType::find(1)->first(), "");
        $report->latestDynamicattribute->addValue("Test for Add value xxx 1", true);
        $report->addDynamicAttribute("Att Dyn. 02", App\Models\DynamicAttributes\DynamicAttributeType::find(2)->first(), "");
        $report->latestDynamicattribute->addValue("241");
        $report->addDynamicAttribute("Att Dyn. 02", App\Models\DynamicAttributes\DynamicAttributeType::find(4)->first(), "");
        $report->latestDynamicattribute->addValue("0");

        $report->dynamicattributes[0]->addValue("Test for the new row", true);
    }
    //$report->dynamicattributes[0]->addValue("Test for the latest row", true);
    //dd($report->latestDynamicattribute());
    //$report->latestDynamicattribute()->addValue("Test for Add value xxx 1", true);
    //dd($report->oldestDynamicattribute->hasdynamicattribute->latestDynamicvaluerow);
    dd($report);
    $first_report = App\Models\Reports\Report::first();
    dd("first_report: ", $first_report, $first_report->dynamicattributes, $first_report->dynamicattributes[0]->values());
});



Route::resource('dynamicattributetypes',DynamicAttributeTypeController::class)->middleware('auth');
Route::get('dynamicattributetypes.fetch',[DynamicAttributeTypeController::class,'fetch'])
    ->name('dynamicattributetypes.fetch')
    ->middleware('auth');
Route::get('dynamicattributetypes.fetchall',[DynamicAttributeTypeController::class,'fetchall'])
    ->name('dynamicattributetypes.fetchall')
    ->middleware('auth');

Route::resource('dynamicattributes',DynamicAttributeController::class)->middleware('auth');
Route::get('dynamicattributes.fetch',[DynamicAttributeController::class,'fetch'])
    ->name('dynamicattributes.fetch')
    ->middleware('auth');
