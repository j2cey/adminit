<?php

namespace App\Http\Controllers\AnalysisRules;

use App\Http\Controllers\Controller;
use App\Models\AnalysisRules\HighlightTextSize;
use App\Http\Requests\HighlightTextSize\StoreHighlightTextSizeRequest;
use App\Http\Requests\HighlightTextSize\UpdateHighlightTextSizeRequest;
use App\Http\Resources\AnalysisRules\HighlightTextSizeResource;

class HighlightTextSizeController extends Controller
{
    public function fetchall() {
        return HighlightTextSizeResource::collection(HighlightTextSize::all());
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
     * @param StoreHighlightTextSizeRequest $request
     * @return void
     */
    public function store(StoreHighlightTextSizeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param HighlightTextSize $highlighttextsize
     * @return void
     */
    public function show(HighlightTextSize $highlighttextsize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HighlightTextSize $highlighttextsize
     * @return void
     */
    public function edit(HighlightTextSize $highlighttextsize)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateHighlightTextSizeRequest $request
     * @param HighlightTextSize $highlighttextsize
     * @return HighlightTextSizeResource|void
     */
    public function update(UpdateHighlightTextSizeRequest $request, HighlightTextSize $highlighttextsize)
    {
        $highlighttextsize->update([
            'highlight' => $request->highlight,
            'comment' => $request->comment,
        ]);

        return new HighlightTextSizeResource($highlighttextsize);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HighlightTextSize $highlighttextsize
     * @return void
     */
    public function destroy(HighlightTextSize $highlighttextsize)
    {
        //
    }
}
