<?php

namespace App\Http\Controllers\AnalysisRuleComparison;

use App\Http\Controllers\Controller;
use App\Models\AnalysisRuleComparison\AnalysisRuleComparison;
use App\Http\Resources\AnalysisRules\AnalysisRuleComparisonResource;
use App\Http\Requests\AnalysisRuleComparison\StoreAnalysisRuleComparisonRequest;
use App\Http\Requests\AnalysisRuleComparison\UpdateAnalysisRuleComparisonRequest;

class AnalysisRuleComparisonController extends Controller
{
    public function fetchall() {
        return AnalysisRuleComparisonResource::collection(AnalysisRuleComparison::all());
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
     * @param  \App\Http\Requests\AnalysisRuleComparison\StoreAnalysisRuleComparisonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnalysisRuleComparisonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnalysisRuleComparison\AnalysisRuleComparison  $analysisRuleComparison
     * @return \Illuminate\Http\Response
     */
    public function show(AnalysisRuleComparison $analysisRuleComparison)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnalysisRuleComparison\AnalysisRuleComparison  $analysisRuleComparison
     * @return \Illuminate\Http\Response
     */
    public function edit(AnalysisRuleComparison $analysisRuleComparison)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AnalysisRuleComparison\UpdateAnalysisRuleComparisonRequest  $request
     * @param  \App\Models\AnalysisRuleComparison\AnalysisRuleComparison  $analysisRuleComparison
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnalysisRuleComparisonRequest $request, AnalysisRuleComparison $analysisRuleComparison)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnalysisRuleComparison\AnalysisRuleComparison  $analysisRuleComparison
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnalysisRuleComparison $analysisRuleComparison)
    {
        //
    }
}
