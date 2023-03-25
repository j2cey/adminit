<?php

namespace App\Http\Controllers\ReportTreatments;

use App\Http\Controllers\Controller;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Http\Requests\ReportTreatmentResult\StoreReportTreatmentResultRequest;
use App\Http\Requests\ReportTreatmentResult\UpdateReportTreatmentResultRequest;

class ReportTreatmentResultController extends Controller
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
     * @param  \App\Http\Requests\ReportTreatmentResult\StoreReportTreatmentResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportTreatmentResultRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportTreatments\ReportTreatmentResult  $reportTreatmentResult
     * @return \Illuminate\Http\Response
     */
    public function show(ReportTreatmentResult $reportTreatmentResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportTreatments\ReportTreatmentResult  $reportTreatmentResult
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportTreatmentResult $reportTreatmentResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ReportTreatmentResult\UpdateReportTreatmentResultRequest  $request
     * @param  \App\Models\ReportTreatments\ReportTreatmentResult  $reportTreatmentResult
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportTreatmentResultRequest $request, ReportTreatmentResult $reportTreatmentResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportTreatments\ReportTreatmentResult  $reportTreatmentResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportTreatmentResult $reportTreatmentResult)
    {
        //
    }
}
