<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTreatmentResultRequest;
use App\Http\Requests\UpdateTreatmentResultRequest;
use App\Models\TreatmentResult;

class TreatmentResultController extends Controller
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
     * @param  \App\Http\Requests\StoreTreatmentResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTreatmentResultRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TreatmentResult  $treatmentResult
     * @return \Illuminate\Http\Response
     */
    public function show(TreatmentResult $treatmentResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TreatmentResult  $treatmentResult
     * @return \Illuminate\Http\Response
     */
    public function edit(TreatmentResult $treatmentResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTreatmentResultRequest  $request
     * @param  \App\Models\TreatmentResult  $treatmentResult
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTreatmentResultRequest $request, TreatmentResult $treatmentResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TreatmentResult  $treatmentResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(TreatmentResult $treatmentResult)
    {
        //
    }
}
