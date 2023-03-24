<?php

namespace App\Http\Controllers\AnalysisRules;

use App\Http\Controllers\Controller;
use App\Models\AnalysisRuleThreshold\ThresholdMin;
use App\Http\Requests\ThresholdMin\StoreThresholdMinRequest;
use App\Http\Requests\ThresholdMin\UpdateThresholdMinRequest;

class ThresholdMinController extends Controller
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
     * @param  \App\Http\Requests\ThresholdMin\StoreThresholdMinRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreThresholdMinRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnalysisRuleThreshold\ThresholdMin  $thresholdMin
     * @return \Illuminate\Http\Response
     */
    public function show(ThresholdMin $thresholdMin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnalysisRuleThreshold\ThresholdMin  $thresholdMin
     * @return \Illuminate\Http\Response
     */
    public function edit(ThresholdMin $thresholdMin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ThresholdMin\UpdateThresholdMinRequest  $request
     * @param  \App\Models\AnalysisRuleThreshold\ThresholdMin  $thresholdMin
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateThresholdMinRequest $request, ThresholdMin $thresholdMin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnalysisRuleThreshold\ThresholdMin  $thresholdMin
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThresholdMin $thresholdMin)
    {
        //
    }
}
