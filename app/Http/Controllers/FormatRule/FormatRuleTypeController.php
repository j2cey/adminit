<?php

namespace App\Http\Controllers\FormatRule;

use App\Http\Controllers\Controller;
use App\Models\FormatRule\FormatRuleType;
use App\Http\Resources\FormatRule\FormatRuleTypeResource;
use App\Http\Requests\FormatRuleType\StoreFormatRuleTypeRequest;
use App\Http\Requests\FormatRuleType\UpdateFormatRuleTypeRequest;

class FormatRuleTypeController extends Controller
{
    public function fetchall() {
        return FormatRuleTypeResource::collection(FormatRuleType::all());
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
     * @param StoreFormatRuleTypeRequest $request
     * @return void
     */
    public function store(StoreFormatRuleTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param FormatRuleType $formatruletype
     * @return void
     */
    public function show(FormatRuleType $formatruletype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FormatRuleType $formatruletype
     * @return void
     */
    public function edit(FormatRuleType $formatruletype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFormatRuleTypeRequest $request
     * @param FormatRuleType $formatruletype
     * @return void
     */
    public function update(UpdateFormatRuleTypeRequest $request, FormatRuleType $formatruletype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FormatRuleType $formatruletype
     * @return void
     */
    public function destroy(FormatRuleType $formatruletype)
    {
        //
    }
}
