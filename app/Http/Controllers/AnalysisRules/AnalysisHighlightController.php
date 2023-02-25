<?php

namespace App\Http\Controllers\AnalysisRules;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\AnalysisRules\AnalysisHighlight;
use App\Http\Resources\AnalysisRules\AnalysisHighlightResource;
use App\Http\Requests\AnalysisHighlight\StoreAnalysisHighlightRequest;
use App\Http\Requests\AnalysisHighlight\UpdateAnalysisHighlightRequest;

class AnalysisHighlightController extends Controller
{
    public function fetchall() {
        return AnalysisHighlightResource::collection(AnalysisHighlight::all());
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
     * @param StoreAnalysisHighlightRequest $request
     * @return AnalysisHighlightResource|void
     */
    public function store(StoreAnalysisHighlightRequest $request)
    {
        $analysishighlight = AnalysisHighlight::createNew(
            $request->analysisrule,
            $request->highlighttype,
            $request->title,
            $request->when_rule_result_is,
            $request->description
        );
        return new AnalysisHighlightResource($analysishighlight);
    }

    /**
     * Display the specified resource.
     *
     * @param AnalysisHighlight $analysishighlight
     * @return void
     */
    public function show(AnalysisHighlight $analysishighlight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AnalysisHighlight $analysishighlight
     * @return void
     */
    public function edit(AnalysisHighlight $analysishighlight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnalysisHighlightRequest $request
     * @param AnalysisHighlight $analysishighlight
     * @return AnalysisHighlightResource|void
     */
    public function update(UpdateAnalysisHighlightRequest $request, AnalysisHighlight $analysishighlight)
    {
        $analysishighlight = $analysishighlight->updateOne(
            $request->highlighttype, $request->title, $request->when_rule_result_is, $request->description
        );

        return new AnalysisHighlightResource($analysishighlight);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AnalysisHighlight $analysishighlight
     * @return JsonResponse|void
     */
    public function destroy(AnalysisHighlight $analysishighlight)
    {
        $analysishighlight->delete();

        return response()->json(['status' => 'ok'], 200);
    }
}
