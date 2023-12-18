<?php

namespace App\Http\Controllers\ReportTreatments;

use App\Http\Controllers\Controller;
use App\Models\ReportTreatments\TreatmentWorkflowStep;
use App\Http\Resources\ReportTreatments\TreatmentWorkflowStepResource;
use App\Http\Requests\TreatmentWorkflowStep\StoreTreatmentWorkflowStepRequest;
use App\Http\Requests\TreatmentWorkflowStep\UpdateTreatmentWorkflowStepRequest;

class TreatmentWorkflowStepController extends Controller
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
     * @param StoreTreatmentWorkflowStepRequest $request
     * @return TreatmentWorkflowStepResource
     */
    public function store(StoreTreatmentWorkflowStepRequest $request)
    {
        $treatmentworkflowstep = TreatmentWorkflowStep::createNew(
            $request->treatmentworkflow, $request->code, $request->name, $request->status, $request->description
        );

        return new TreatmentWorkflowStepResource($treatmentworkflowstep);
    }

    /**
     * Display the specified resource.
     *
     * @param TreatmentWorkflowStep $treatmentworkflowstep
     * @return \Illuminate\Http\Response
     */
    public function show(TreatmentWorkflowStep $treatmentworkflowstep)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TreatmentWorkflowStep $treatmentworkflowstep
     * @return \Illuminate\Http\Response
     */
    public function edit(TreatmentWorkflowStep $treatmentworkflowstep)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTreatmentWorkflowStepRequest $request
     * @param TreatmentWorkflowStep $treatmentworkflowstep
     * @return TreatmentWorkflowStepResource
     */
    public function update(UpdateTreatmentWorkflowStepRequest $request, TreatmentWorkflowStep $treatmentworkflowstep)
    {
        $treatmentworkflowstep->updateThis(
            $request->code, $request->name, $request->status, $request->description
        );

        return new TreatmentWorkflowStepResource($treatmentworkflowstep);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TreatmentWorkflowStep $treatmentworkflowstep
     * @return \Illuminate\Http\Response
     */
    public function destroy(TreatmentWorkflowStep $treatmentworkflowstep)
    {
        //
    }
}
