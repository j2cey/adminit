<?php

namespace App\Http\Controllers\Treatments;

use App\Http\Controllers\Controller;
use App\Models\Treatments\TreatmentService;
use App\Http\Requests\StoreTreatmentServiceRequest;
use App\Http\Requests\UpdateTreatmentServiceRequest;

class TreatmentServiceController extends Controller
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
     * @param  \App\Http\Requests\StoreTreatmentServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTreatmentServiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Treatments\TreatmentService  $treatmentService
     * @return \Illuminate\Http\Response
     */
    public function show(TreatmentService $treatmentService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Treatments\TreatmentService  $treatmentService
     * @return \Illuminate\Http\Response
     */
    public function edit(TreatmentService $treatmentService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTreatmentServiceRequest  $request
     * @param  \App\Models\Treatments\TreatmentService  $treatmentService
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTreatmentServiceRequest $request, TreatmentService $treatmentService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Treatments\TreatmentService  $treatmentService
     * @return \Illuminate\Http\Response
     */
    public function destroy(TreatmentService $treatmentService)
    {
        //
    }
}
