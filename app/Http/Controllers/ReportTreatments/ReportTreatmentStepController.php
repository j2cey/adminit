<?php

namespace App\Http\Controllers\ReportTreatments;

use App\Http\Controllers\Controller;
use App\Models\ReportTreatments\ReportTreatmentStep;
use App\Http\Requests\ReportTreatmentStep\StoreReportTreatmentStepRequest;
use App\Http\Requests\ReportTreatmentStep\UpdateReportTreatmentStepRequest;

class ReportTreatmentStepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ReportTreatmentStep\StoreReportTreatmentStepRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportTreatmentStepRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportTreatments\ReportTreatmentStep  $reportTreatmentStep
     * @return \Illuminate\Http\Response
     */
    public function show(ReportTreatmentStep $reportTreatmentStep)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportTreatments\ReportTreatmentStep  $reportTreatmentStep
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportTreatmentStep $reportTreatmentStep)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ReportTreatmentStep\UpdateReportTreatmentStepRequest  $request
     * @param  \App\Models\ReportTreatments\ReportTreatmentStep  $reportTreatmentStep
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportTreatmentStepRequest $request, ReportTreatmentStep $reportTreatmentStep)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportTreatments\ReportTreatmentStep  $reportTreatmentStep
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportTreatmentStep $reportTreatmentStep)
    {
        //
    }
}
