<?php

namespace App\Http\Controllers\AnalysisRules;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnalysisRules\AnalysisRuleTypeResource;
use App\Http\Requests\AnalysisRuleType\StoreAnalysisRuleTypeRequest;
use App\Http\Requests\AnalysisRuleType\UpdateAnalysisRuleTypeRequest;
use App\Models\AnalysisRules\AnalysisRuleType;

class AnalysisRuleTypeController extends Controller
{
    public function fetchall() {
        return AnalysisRuleTypeResource::collection(AnalysisRuleType::all());
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
     * @param StoreAnalysisRuleTypeRequest $request
     * @return void
     */
    public function store(StoreAnalysisRuleTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param AnalysisRuleType $analysisruletype
     * @return void
     */
    public function show(AnalysisRuleType $analysisruletype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AnalysisRuleType $analysisruletype
     * @return void
     */
    public function edit(AnalysisRuleType $analysisruletype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnalysisRuleTypeRequest $request
     * @param AnalysisRuleType $analysisruletype
     * @return void
     */
    public function update(UpdateAnalysisRuleTypeRequest $request, AnalysisRuleType $analysisruletype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AnalysisRuleType $analysisruletype
     * @return void
     */
    public function destroy(AnalysisRuleType $analysisruletype)
    {
        //
    }
}
