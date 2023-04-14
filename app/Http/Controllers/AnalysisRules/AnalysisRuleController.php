<?php

namespace App\Http\Controllers\AnalysisRules;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\AnalysisRule\AnalysisRule;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Resources\AnalysisRules\AnalysisRuleResource;
use App\Http\Requests\AnalysisRule\StoreAnalysisRuleRequest;
use App\Http\Requests\AnalysisRule\UpdateAnalysisRuleRequest;

class AnalysisRuleController extends Controller
{
    public function fetchone($id) {
        return new AnalysisRuleResource(AnalysisRule::find($id));
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
     * @param StoreAnalysisRuleRequest $request
     * @return AnalysisRuleResource
     */
    public function store(StoreAnalysisRuleRequest $request)
    {
        $analysisrule = $request->model->addAnalysisRule(
            $request->analysisruletype,
            $request->title,
            [],
            $request->rule_result_for_notification,
            $request->status,
            $request->description
        );
        return new AnalysisRuleResource($analysisrule);
    }

    /**
     * Display the specified resource.
     *
     * @param AnalysisRule $analysisrule
     * @return void
     */
    public function show(AnalysisRule $analysisrule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AnalysisRule $analysisrule
     * @return void
     */
    public function edit(AnalysisRule $analysisrule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnalysisRuleRequest $request
     * @param AnalysisRule $analysisrule
     * @return AnalysisRuleResource
     */
    public function update(UpdateAnalysisRuleRequest $request, AnalysisRule $analysisrule)
    {
        $analysisrule->updateOne(
            $request->analysisruletype,
            $request->title,
            $request->rule_result_for_notification,
            $request->inneranalysisrule_attributes,
            $request->status,
            $request->description,
            $request->num_ord
        );

        return new AnalysisRuleResource($analysisrule);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AnalysisRule $analysisrule
     * @return Application|ResponseFactory|Response
     */
    public function destroy(AnalysisRule $analysisrule)
    {
        $analysisrule->delete();

        return response('Delete Successfull', 200);
    }
}
