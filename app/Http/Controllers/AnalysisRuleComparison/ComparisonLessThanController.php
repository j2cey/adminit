<?php

namespace App\Http\Controllers\AnalysisRuleComparison;

use App\Http\Controllers\Controller;
use App\Models\AnalysisRuleComparison\ComparisonLessThan;
use App\Http\Resources\AnalysisRules\ComparisonLessThanResource;
use App\Http\Requests\ComparisonLessThan\StoreComparisonLessThanRequest;
use App\Http\Requests\ComparisonLessThan\UpdateComparisonLessThanRequest;

class ComparisonLessThanController extends Controller
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
     * @param  \App\Http\Requests\ComparisonLessThan\StoreComparisonLessThanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComparisonLessThanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnalysisRuleComparison\ComparisonLessThan  $comparisonLessThan
     * @return \Illuminate\Http\Response
     */
    public function show(ComparisonLessThan $comparisonLessThan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnalysisRuleComparison\ComparisonLessThan  $comparisonLessThan
     * @return \Illuminate\Http\Response
     */
    public function edit(ComparisonLessThan $comparisonLessThan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ComparisonLessThan\UpdateComparisonLessThanRequest  $request
     * @param  \App\Models\AnalysisRuleComparison\ComparisonLessThan  $comparisonLessThan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComparisonLessThanRequest $request, ComparisonLessThan $comparisonLessThan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnalysisRuleComparison\ComparisonLessThan  $comparisonLessThan
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComparisonLessThan $comparisonLessThan)
    {
        //
    }
}
