<?php

namespace App\Http\Controllers\AnalysisRules;

use App\Http\Controllers\Controller;
use App\Models\AnalysisRules\AnalysisHighlightType;
use App\Http\Resources\AnalysisRules\AnalysisHighlightTypeResource;
use App\Http\Requests\AnalysisHighlightType\StoreAnalysisHighlightTypeRequest;
use App\Http\Requests\AnalysisHighlightType\UpdateAnalysisHighlightTypeRequest;

class AnalysisHighlightTypeController extends Controller
{
    public function fetchall() {
        return AnalysisHighlightTypeResource::collection(AnalysisHighlightType::all());
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
     * @param StoreAnalysisHighlightTypeRequest $request
     * @return void
     */
    public function store(StoreAnalysisHighlightTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param AnalysisHighlightType $analysishighlighttype
     * @return void
     */
    public function show(AnalysisHighlightType $analysishighlighttype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AnalysisHighlightType $analysishighlighttype
     * @return void
     */
    public function edit(AnalysisHighlightType $analysishighlighttype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnalysisHighlightTypeRequest $request
     * @param AnalysisHighlightType $analysishighlighttype
     * @return void
     */
    public function update(UpdateAnalysisHighlightTypeRequest $request, AnalysisHighlightType $analysishighlighttype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AnalysisHighlightType $analysishighlighttype
     * @return void
     */
    public function destroy(AnalysisHighlightType $analysishighlighttype)
    {
        //
    }
}
