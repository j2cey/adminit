<?php

namespace App\Http\Controllers\ReportTreatments;

use App\Http\Controllers\Controller;
use App\Models\ReportTreatments\ReportTreatmentWorkflow;
use App\Http\Resources\ReportTreatments\ReportTreatmentWorkflowResource;
use App\Http\Requests\ReportTreatmentWorkflow\StoreReportTreatmentWorkflowRequest;
use App\Http\Requests\ReportTreatmentWorkflow\UpdateReportTreatmentWorkflowRequest;

class ReportTreatmentWorkflowController extends Controller
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
     * @param StoreReportTreatmentWorkflowRequest $request
     * @return ReportTreatmentWorkflowResource
     */
    public function store(StoreReportTreatmentWorkflowRequest $request)
    {
        $reporttreatmentworkflow = ReportTreatmentWorkflow::createNew(
            $request->report, $request->name, $request->status, $request->description
        );

        return new ReportTreatmentWorkflowResource($reporttreatmentworkflow);
    }

    /**
     * Display the specified resource.
     *
     * @param ReportTreatmentWorkflow $reporttreatmentworkflow
     * @return \Illuminate\Http\Response
     */
    public function show(ReportTreatmentWorkflow $reporttreatmentworkflow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReportTreatmentWorkflow $reporttreatmentworkflow
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportTreatmentWorkflow $reporttreatmentworkflow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReportTreatmentWorkflowRequest $request
     * @param ReportTreatmentWorkflow $reporttreatmentworkflow
     * @return ReportTreatmentWorkflowResource
     */
    public function update(UpdateReportTreatmentWorkflowRequest $request, ReportTreatmentWorkflow $reporttreatmentworkflow)
    {
        $reporttreatmentworkflow->updateThis(
            $request->name, $request->status, $request->description
        );

        return new ReportTreatmentWorkflowResource($reporttreatmentworkflow);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReportTreatmentWorkflow $reporttreatmentworkflow
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportTreatmentWorkflow $reporttreatmentworkflow)
    {
        //
    }
}
