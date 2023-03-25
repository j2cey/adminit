<?php

namespace App\Http\Controllers\AnalysisRules;

use App\Http\Controllers\Controller;
use App\Models\AnalysisRuleThreshold\ThresholdMax;
use App\Http\Requests\ThresholdMax\StoreThresholdMaxRequest;
use App\Http\Requests\ThresholdMax\UpdateThresholdMaxRequest;

class ThresholdMaxController extends Controller
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
     * @param  \App\Http\Requests\ThresholdMax\StoreThresholdMaxRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreThresholdMaxRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnalysisRuleThreshold\ThresholdMax  $thresholdMax
     * @return \Illuminate\Http\Response
     */
    public function show(ThresholdMax $thresholdMax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnalysisRuleThreshold\ThresholdMax  $thresholdMax
     * @return \Illuminate\Http\Response
     */
    public function edit(ThresholdMax $thresholdMax)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ThresholdMax\UpdateThresholdMaxRequest  $request
     * @param  \App\Models\AnalysisRuleThreshold\ThresholdMax  $thresholdMax
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateThresholdMaxRequest $request, ThresholdMax $thresholdMax)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnalysisRuleThreshold\ThresholdMax  $thresholdMax
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThresholdMax $thresholdMax)
    {
        //
    }
}
