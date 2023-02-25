<?php

namespace App\Http\Controllers\AnalysisRules;

use App\Http\Controllers\Controller;
use App\Models\AnalysisRules\HighlightTextColor;
use App\Http\Requests\HighlightTextColor\StoreHighlightTextColorRequest;
use App\Http\Requests\HighlightTextColor\UpdateHighlightTextColorRequest;
use App\Http\Resources\AnalysisRules\HighlightTextColorResource;

class HighlightTextColorController extends Controller
{
    public function fetchall() {
        return HighlightTextColorResource::collection(HighlightTextColor::all());
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
     * @param StoreHighlightTextColorRequest $request
     * @return void
     */
    public function store(StoreHighlightTextColorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param HighlightTextColor $highlighttextcolor
     * @return void
     */
    public function show(HighlightTextColor $highlighttextcolor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HighlightTextColor $highlighttextcolor
     * @return void
     */
    public function edit(HighlightTextColor $highlighttextcolor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateHighlightTextColorRequest $request
     * @param HighlightTextColor $highlighttextcolor
     * @return HighlightTextColorResource|void
     */
    public function update(UpdateHighlightTextColorRequest $request, HighlightTextColor $highlighttextcolor)
    {
        $highlighttextcolor->update([
            'highlight' => $request->highlight,
            'comment' => $request->comment,
        ]);

        return new HighlightTextColorResource($highlighttextcolor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HighlightTextColor $highlighttextcolor
     * @return void
     */
    public function destroy(HighlightTextColor $highlighttextcolor)
    {
        //
    }
}
