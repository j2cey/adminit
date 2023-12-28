<?php

namespace App\Http\Controllers\ReportTreatments;

use App\Http\Controllers\Controller;
use App\Models\Treatments\TreatmentWorkflow;
use App\Http\Resources\ReportTreatments\TreatmentWorkflowResource;
use App\Http\Requests\TreatmentWorkflow\StoreTreatmentWorkflowRequest;
use App\Http\Requests\TreatmentWorkflow\UpdateTreatmentWorkflowRequest;

class TreatmentWorkflowController extends Controller
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
     * @param StoreTreatmentWorkflowRequest $request
     * @return TreatmentWorkflowResource
     */
    public function store(StoreTreatmentWorkflowRequest $request)
    {
        $treatmentworkflow = TreatmentWorkflow::createNew(
            $request->report, $request->name, $request->status, $request->description
        );

        return new TreatmentWorkflowResource($treatmentworkflow);
    }

    /**
     * Display the specified resource.
     *
     * @param TreatmentWorkflow $treatmentworkflow
     * @return \Illuminate\Http\Response
     */
    public function show(TreatmentWorkflow $treatmentworkflow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TreatmentWorkflow $treatmentworkflow
     * @return \Illuminate\Http\Response
     */
    public function edit(TreatmentWorkflow $treatmentworkflow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTreatmentWorkflowRequest $request
     * @param TreatmentWorkflow $treatmentworkflow
     * @return TreatmentWorkflowResource
     */
    public function update(UpdateTreatmentWorkflowRequest $request, TreatmentWorkflow $treatmentworkflow)
    {
        $treatmentworkflow->updateThis(
            $request->name, $request->status, $request->description
        );

        return new TreatmentWorkflowResource($treatmentworkflow);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TreatmentWorkflow $treatmentworkflow
     * @return \Illuminate\Http\Response
     */
    public function destroy(TreatmentWorkflow $treatmentworkflow)
    {
        //
    }
}
