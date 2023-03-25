<?php

namespace App\Http\Controllers\AnalysisRuleComparison;

use App\Http\Controllers\Controller;
use App\Models\AnalysisRuleComparison\ComparisonEqual;
use App\Http\Requests\ComparisonEqual\StoreComparisonEqualRequest;
use App\Http\Requests\ComparisonEqual\UpdateComparisonEqualRequest;

class ComparisonEqualController extends Controller
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
     * @param  \App\Http\Requests\ComparisonEqual\StoreComparisonEqualRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComparisonEqualRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnalysisRuleComparison\ComparisonEqual  $comparisonEqual
     * @return \Illuminate\Http\Response
     */
    public function show(ComparisonEqual $comparisonEqual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnalysisRuleComparison\ComparisonEqual  $comparisonEqual
     * @return \Illuminate\Http\Response
     */
    public function edit(ComparisonEqual $comparisonEqual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ComparisonEqual\UpdateComparisonEqualRequest  $request
     * @param  \App\Models\AnalysisRuleComparison\ComparisonEqual  $comparisonEqual
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComparisonEqualRequest $request, ComparisonEqual $comparisonEqual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnalysisRuleComparison\ComparisonEqual  $comparisonEqual
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComparisonEqual $comparisonEqual)
    {
        //
    }
}
