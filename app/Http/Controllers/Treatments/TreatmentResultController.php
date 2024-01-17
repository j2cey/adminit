<?php

namespace App\Http\Controllers\Treatments;

use App\Http\Controllers\Controller;
use App\Models\Treatments\TreatmentResult;
use App\Http\Requests\TreatmentResult\StoreTreatmentResultRequest;
use App\Http\Requests\TreatmentResult\UpdateTreatmentResultRequest;

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
     * @param  \App\Http\Requests\TreatmentResult\StoreTreatmentResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTreatmentResultRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(TreatmentResult $treatmentresult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(TreatmentResult $treatmentresult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TreatmentResult\UpdateTreatmentResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTreatmentResultRequest $request, TreatmentResult $treatmentresult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(TreatmentResult $treatmentresult)
    {
        //
    }
}
