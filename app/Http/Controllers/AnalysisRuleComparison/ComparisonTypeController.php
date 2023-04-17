<?php

namespace App\Http\Controllers\AnalysisRuleComparison;

use App\Http\Controllers\Controller;
use App\Models\AnalysisRuleComparison\ComparisonType;
use App\Http\Resources\AnalysisRules\ComparisonTypeResource;
use App\Http\Requests\ComparisonType\StoreComparisonTypeRequest;
use App\Http\Requests\ComparisonType\UpdateComparisonTypeRequest;

class ComparisonTypeController extends Controller
{
    public function fetchall() {
        return ComparisonType::all();
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
     * @param  \App\Http\Requests\ComparisonType\StoreComparisonTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComparisonTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnalysisRuleComparison\ComparisonType  $comparisonType
     * @return \Illuminate\Http\Response
     */
    public function show(ComparisonType $comparisonType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnalysisRuleComparison\ComparisonType  $comparisonType
     * @return \Illuminate\Http\Response
     */
    public function edit(ComparisonType $comparisonType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ComparisonType\UpdateComparisonTypeRequest  $request
     * @param  \App\Models\AnalysisRuleComparison\ComparisonType  $comparisonType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComparisonTypeRequest $request, ComparisonType $comparisonType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnalysisRuleComparison\ComparisonType  $comparisonType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComparisonType $comparisonType)
    {
        //
    }
}
