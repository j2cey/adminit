<?php

namespace App\Http\Controllers\FormatRule;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\FormatRule\FormatRule;
use App\Http\Resources\FormatRule\FormatRuleResource;
use App\Http\Requests\FormatRule\StoreFormatRuleRequest;
use App\Http\Requests\FormatRule\UpdateFormatRuleRequest;
use function response;

class FormatRuleController extends Controller
{
    public function fetchall() {
        return FormatRuleResource::collection(FormatRule::all());
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
     * @param StoreFormatRuleRequest $request
     * @return FormatRuleResource
     */
    public function store(StoreFormatRuleRequest $request)
    {
        $formatrule = $request->model->addFormatRule(
            $request->formatruletype,
            $request->title,
            null,
            $request->rule_result,
            $request->status,
            $request->description,
        );
        return new FormatRuleResource($formatrule);
    }

    /**
     * Display the specified resource.
     *
     * @param FormatRule $formatrule
     * @return void
     */
    public function show(FormatRule $formatrule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FormatRule $formatrule
     * @return void
     */
    public function edit(FormatRule $formatrule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFormatRuleRequest $request
     * @param FormatRule $formatrule
     * @return FormatRuleResource
     */
    public function update(UpdateFormatRuleRequest $request, FormatRule $formatrule)
    {
        //dd("request: ", $request->all(), $formatrule);
        $formatrule->updateOne(
            $request->formatruletype, $request->title, $request->innerformatrule, $request->rule_result, $request->status, $request->description, $request->num_ord
        );

        return new FormatRuleResource($formatrule);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FormatRule $formatrule
     * @return JsonResponse
     */
    public function destroy(FormatRule $formatrule)
    {
        $formatrule->delete();

        return response()->json(['status' => 'ok'], 200);
    }
}
