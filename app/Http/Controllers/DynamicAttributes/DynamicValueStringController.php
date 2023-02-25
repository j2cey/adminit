<?php

namespace App\Http\Controllers\DynamicAttributes;

use App\Http\Controllers\Controller;
use App\Http\Requests\DynamicValueString\StoreDynamicValueStringRequest;
use App\Http\Requests\DynamicValueString\UpdateDynamicValueStringRequest;
use App\Models\DynamicAttributes\DynamicValueString;

class DynamicValueStringController extends Controller
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
     * @param StoreDynamicValueStringRequest $request
     * @return void
     */
    public function store(StoreDynamicValueStringRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param DynamicValueString $dynamicvaluestring
     * @return void
     */
    public function show(DynamicValueString $dynamicvaluestring)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DynamicValueString $dynamicvaluestring
     * @return void
     */
    public function edit(DynamicValueString $dynamicvaluestring)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDynamicValueStringRequest $request
     * @param DynamicValueString $dynamicvaluestring
     * @return void
     */
    public function update(UpdateDynamicValueStringRequest $request, DynamicValueString $dynamicvaluestring)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DynamicValueString $dynamicvaluestring
     * @return void
     */
    public function destroy(DynamicValueString $dynamicvaluestring)
    {
        //
    }
}
