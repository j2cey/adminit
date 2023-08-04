<?php

namespace App\Http\Controllers\ReportTreatments;

use App\Http\Controllers\Controller;
use App\Models\ReportTreatments\ReportTreatment;
use App\Http\Requests\ReportTreatment\StoreReportTreatmentRequest;
use App\Http\Requests\ReportTreatment\UpdateReportTreatmentRequest;

class ReportTreatmentController extends Controller
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
     * @param  \App\Http\Requests\ReportTreatment\StoreReportTreatmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportTreatmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportTreatments\ReportTreatment  $reportTreatment
     * @return \Illuminate\Http\Response
     */
    public function show(ReportTreatment $reportTreatment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportTreatments\ReportTreatment  $reportTreatment
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportTreatment $reportTreatment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ReportTreatment\UpdateReportTreatmentRequest  $request
     * @param  \App\Models\ReportTreatments\ReportTreatment  $reportTreatment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportTreatmentRequest $request, ReportTreatment $reportTreatment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportTreatments\ReportTreatment  $reportTreatment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportTreatment $reportTreatment)
    {
        //
    }
}
