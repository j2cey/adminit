<?php

namespace App\Http\Controllers\AnalysisRuleComparison;

use App\Http\Controllers\Controller;
use App\Models\AnalysisRuleComparison\ComparisonNotEqual;
use App\Http\Requests\ComparisonNotEqual\StoreComparisonNotEqualRequest;
use App\Http\Requests\ComparisonNotEqual\UpdateComparisonNotEqualRequest;

class ComparisonNotEqualController extends Controller
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
     * @param  \App\Http\Requests\ComparisonNotEqual\StoreComparisonNotEqualRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComparisonNotEqualRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnalysisRuleComparison\ComparisonNotEqual  $comparisonNotEqual
     * @return \Illuminate\Http\Response
     */
    public function show(ComparisonNotEqual $comparisonNotEqual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnalysisRuleComparison\ComparisonNotEqual  $comparisonNotEqual
     * @return \Illuminate\Http\Response
     */
    public function edit(ComparisonNotEqual $comparisonNotEqual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ComparisonNotEqual\UpdateComparisonNotEqualRequest  $request
     * @param  \App\Models\AnalysisRuleComparison\ComparisonNotEqual  $comparisonNotEqual
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComparisonNotEqualRequest $request, ComparisonNotEqual $comparisonNotEqual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnalysisRuleComparison\ComparisonNotEqual  $comparisonNotEqual
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComparisonNotEqual $comparisonNotEqual)
    {
        //
    }
}
