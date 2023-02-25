<?php

namespace App\Http\Controllers\DynamicAttributes;

use App\Http\Controllers\Controller;
use App\Models\DynamicAttributes\DynamicValueInteger;
use App\Http\Requests\DynamicValueInteger\StoreDynamicValueIntegerRequest;
use App\Http\Requests\DynamicValueInteger\UpdateDynamicValueIntegerRequest;

class DynamicValueIntegerController extends Controller
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
     * @param StoreDynamicValueIntegerRequest $request
     * @return void
     */
    public function store(StoreDynamicValueIntegerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param DynamicValueInteger $dynamicvalueinteger
     * @return void
     */
    public function show(DynamicValueInteger $dynamicvalueinteger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DynamicValueInteger $dynamicvalueinteger
     * @return void
     */
    public function edit(DynamicValueInteger $dynamicvalueinteger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDynamicValueIntegerRequest $request
     * @param DynamicValueInteger $dynamicvalueinteger
     * @return void
     */
    public function update(UpdateDynamicValueIntegerRequest $request, DynamicValueInteger $dynamicvalueinteger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DynamicValueInteger $dynamicvalueinteger
     * @return void
     */
    public function destroy(DynamicValueInteger $dynamicvalueinteger)
    {
        //
    }
}
