<?php

namespace App\Http\Controllers\AnalysisRules;

use App\Http\Controllers\Controller;
use App\Models\AnalysisRules\HighlightTextWeight;
use App\Http\Resources\AnalysisRules\HighlightTextWeightResource;
use App\Http\Requests\HighlightTextWeight\StoreHighlightTextWeightRequest;
use App\Http\Requests\HighlightTextWeight\UpdateHighlightTextWeightRequest;

class HighlightTextWeightController extends Controller
{
    public function fetchall() {
        return HighlightTextWeightResource::collection(HighlightTextWeight::all());
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
     * @param StoreHighlightTextWeightRequest $request
     * @return void
     */
    public function store(StoreHighlightTextWeightRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param HighlightTextWeight $highlighttextweight
     * @return void
     */
    public function show(HighlightTextWeight $highlighttextweight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HighlightTextWeight $highlighttextweight
     * @return void
     */
    public function edit(HighlightTextWeight $highlighttextweight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateHighlightTextWeightRequest $request
     * @param HighlightTextWeight $highlighttextweight
     * @return HighlightTextWeightResource|void
     */
    public function update(UpdateHighlightTextWeightRequest $request, HighlightTextWeight $highlighttextweight)
    {
        $highlighttextweight->update([
            'highlight' => $request->highlight,
            'comment' => $request->comment,
        ]);

        return new HighlightTextWeightResource($highlighttextweight);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HighlightTextWeight $highlighttextweight
     * @return void
     */
    public function destroy(HighlightTextWeight $highlighttextweight)
    {
        //
    }
}
