<?php

namespace App\Http\Controllers\AnalysisRules;

use App\Http\Controllers\Controller;
use App\Models\AnalysisRules\AnalysisRuleThreshold;
use App\Http\Resources\AnalysisRules\AnalysisRuleThresholdResource;
use App\Http\Requests\AnalysisRuleThreshold\StoreAnalysisRuleThresholdRequest;
use App\Http\Requests\AnalysisRuleThreshold\UpdateAnalysisRuleThresholdRequest;

class AnalysisRuleThresholdController extends Controller
{
    public function fetchall() {
        return AnalysisRuleThresholdResource::collection(AnalysisRuleThreshold::all());
    }


    public function fetch()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAnalysisRuleThresholdRequest $request
     * @return void
     */
    public function store(StoreAnalysisRuleThresholdRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param AnalysisRuleThreshold $analysisrulethreshold
     * @return void
     */
    public function show(AnalysisRuleThreshold $analysisrulethreshold)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AnalysisRuleThreshold $analysisrulethreshold
     * @return void
     */
    public function edit(AnalysisRuleThreshold $analysisrulethreshold)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnalysisRuleThresholdRequest $request
     * @param AnalysisRuleThreshold $analysisrulethreshold
     * @return AnalysisRuleThresholdResource|void
     */
    public function update(UpdateAnalysisRuleThresholdRequest $request, AnalysisRuleThreshold $analysisrulethreshold)
    {
        $analysisrulethreshold->update([
            'threshold' => $request->threshold,
            'comment' => $request->comment,
        ]);
        $analysisrulethreshold->thresholdtype()->associate($request->thresholdtype)->save();

        return new AnalysisRuleThresholdResource($analysisrulethreshold);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AnalysisRuleThreshold $analysisrulethreshold
     * @return void
     */
    public function destroy(AnalysisRuleThreshold $analysisrulethreshold)
    {
        //
    }
}
