<?php

namespace App\Http\Controllers\ReportTreatments;

use App\Http\Controllers\Controller;
use App\Models\ReportTreatments\TreatmentOperation;
use App\Http\Requests\TreatmentOperation\StoreTreatmentOperationRequest;
use App\Http\Requests\TreatmentOperation\UpdateTreatmentOperationRequest;

class TreatmentOperationController extends Controller
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
     * @param  \App\Http\Requests\TreatmentOperation\StoreTreatmentOperationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTreatmentOperationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportTreatments\TreatmentOperation  $treatmentOperation
     * @return \Illuminate\Http\Response
     */
    public function show(TreatmentOperation $treatmentOperation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportTreatments\TreatmentOperation  $treatmentOperation
     * @return \Illuminate\Http\Response
     */
    public function edit(TreatmentOperation $treatmentOperation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TreatmentOperation\UpdateTreatmentOperationRequest  $request
     * @param  \App\Models\ReportTreatments\TreatmentOperation  $treatmentOperation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTreatmentOperationRequest $request, TreatmentOperation $treatmentOperation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportTreatments\TreatmentOperation  $treatmentOperation
     * @return \Illuminate\Http\Response
     */
    public function destroy(TreatmentOperation $treatmentOperation)
    {
        //
    }
}
