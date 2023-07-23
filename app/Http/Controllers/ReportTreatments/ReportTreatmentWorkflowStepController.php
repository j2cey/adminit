<?php

namespace App\Http\Controllers\ReportTreatments;

use App\Http\Controllers\Controller;
use App\Models\ReportTreatments\ReportTreatmentWorkflowStep;
use App\Http\Resources\ReportTreatments\ReportTreatmentWorkflowStepResource;
use App\Http\Requests\ReportTreatmentWorkflowStep\StoreReportTreatmentWorkflowStepRequest;
use App\Http\Requests\ReportTreatmentWorkflowStep\UpdateReportTreatmentWorkflowStepRequest;

class ReportTreatmentWorkflowStepController extends Controller
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
     * @param StoreReportTreatmentWorkflowStepRequest $request
     * @return ReportTreatmentWorkflowStepResource
     */
    public function store(StoreReportTreatmentWorkflowStepRequest $request)
    {
        $reporttreatmentworkflowstep = ReportTreatmentWorkflowStep::createNew(
            $request->treatmentworkflow, $request->code, $request->name, $request->status, $request->description
        );

        return new ReportTreatmentWorkflowStepResource($reporttreatmentworkflowstep);
    }

    /**
     * Display the specified resource.
     *
     * @param ReportTreatmentWorkflowStep $reporttreatmentworkflowstep
     * @return \Illuminate\Http\Response
     */
    public function show(ReportTreatmentWorkflowStep $reporttreatmentworkflowstep)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReportTreatmentWorkflowStep $reporttreatmentworkflowstep
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportTreatmentWorkflowStep $reporttreatmentworkflowstep)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReportTreatmentWorkflowStepRequest $request
     * @param ReportTreatmentWorkflowStep $reporttreatmentworkflowstep
     * @return ReportTreatmentWorkflowStepResource
     */
    public function update(UpdateReportTreatmentWorkflowStepRequest $request, ReportTreatmentWorkflowStep $reporttreatmentworkflowstep)
    {
        $reporttreatmentworkflowstep->updateThis(
            $request->code, $request->name, $request->status, $request->description
        );

        return new ReportTreatmentWorkflowStepResource($reporttreatmentworkflowstep);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReportTreatmentWorkflowStep $reporttreatmentworkflowstep
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportTreatmentWorkflowStep $reporttreatmentworkflowstep)
    {
        //
    }
}
