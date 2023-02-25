<?php

namespace App\Http\Controllers\AnalysisRules;

use App\Http\Controllers\Controller;
use App\Models\AnalysisRules\ThresholdType;
use App\Http\Requests\ThresholdType\StoreThresholdTypeRequest;
use App\Http\Requests\ThresholdType\UpdateThresholdTypeRequest;
use App\Http\Resources\AnalysisRules\ThresholdTypeResource;

class ThresholdTypeController extends Controller
{
    public function fetchall() {
        return ThresholdTypeResource::collection(ThresholdType::all());
    }


    public function fetch()
    {

    }

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
     * @param  \App\Http\Requests\StoreThresholdTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreThresholdTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ThresholdType  $thresholdType
     * @return \Illuminate\Http\Response
     */
    public function show(ThresholdType $thresholdType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ThresholdType  $thresholdType
     * @return \Illuminate\Http\Response
     */
    public function edit(ThresholdType $thresholdType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateThresholdTypeRequest  $request
     * @param  \App\Models\ThresholdType  $thresholdType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateThresholdTypeRequest $request, ThresholdType $thresholdType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThresholdType  $thresholdType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThresholdType $thresholdType)
    {
        //
    }
}
