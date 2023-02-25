<?php

namespace App\Http\Controllers\DynamicAttributes;

use App\Http\Controllers\Controller;
use App\Models\DynamicAttributes\DynamicValueBoolean;
use App\Http\Requests\DynamicValueBoolean\StoreDynamicValueBooleanRequest;
use App\Http\Requests\DynamicValueBoolean\UpdateDynamicValueBooleanRequest;

class DynamicValueBooleanController extends Controller
{
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
     * @param StoreDynamicValueBooleanRequest $request
     * @return void
     */
    public function store(StoreDynamicValueBooleanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param DynamicValueBoolean $dynamicvalueboolean
     * @return void
     */
    public function show(DynamicValueBoolean $dynamicvalueboolean)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DynamicValueBoolean $dynamicvalueboolean
     * @return void
     */
    public function edit(DynamicValueBoolean $dynamicvalueboolean)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDynamicValueBooleanRequest $request
     * @param DynamicValueBoolean $dynamicvalueboolean
     * @return void
     */
    public function update(UpdateDynamicValueBooleanRequest $request, DynamicValueBoolean $dynamicvalueboolean)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DynamicValueBoolean $dynamicvalueboolean
     * @return void
     */
    public function destroy(DynamicValueBoolean $dynamicvalueboolean)
    {
        //
    }
}
