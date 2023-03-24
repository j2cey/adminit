<?php

namespace App\Http\Controllers\AnalysisRuleComparison;

use App\Http\Controllers\Controller;
use App\Models\AnalysisRuleComparison\ComparisonGreaterThan;
use App\Http\Requests\ComparisonGreaterThan\StoreComparisonGreaterThanRequest;
use App\Http\Requests\ComparisonGreaterThan\UpdateComparisonGreaterThanRequest;

class ComparisonGreaterThanController extends Controller
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
     * @param  \App\Http\Requests\ComparisonGreaterThan\StoreComparisonGreaterThanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComparisonGreaterThanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnalysisRuleComparison\ComparisonGreaterThan  $comparisonGreaterThan
     * @return \Illuminate\Http\Response
     */
    public function show(ComparisonGreaterThan $comparisonGreaterThan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnalysisRuleComparison\ComparisonGreaterThan  $comparisonGreaterThan
     * @return \Illuminate\Http\Response
     */
    public function edit(ComparisonGreaterThan $comparisonGreaterThan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ComparisonGreaterThan\UpdateComparisonGreaterThanRequest  $request
     * @param  \App\Models\AnalysisRuleComparison\ComparisonGreaterThan  $comparisonGreaterThan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComparisonGreaterThanRequest $request, ComparisonGreaterThan $comparisonGreaterThan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnalysisRuleComparison\ComparisonGreaterThan  $comparisonGreaterThan
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComparisonGreaterThan $comparisonGreaterThan)
    {
        //
    }
}
