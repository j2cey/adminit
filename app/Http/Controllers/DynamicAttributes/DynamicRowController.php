<?php

namespace App\Http\Controllers\DynamicAttributes;

use App\Http\Controllers\Controller;
use App\Models\DynamicAttributes\DynamicRow;
use App\Http\Requests\DynamicRow\StoreDynamicRowRequest;
use App\Http\Requests\DynamicRow\UpdateDynamicRowRequest;

class DynamicRowController extends Controller
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
     * @param StoreDynamicRowRequest $request
     * @return void
     */
    public function store(StoreDynamicRowRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param DynamicRow $dynamicrow
     * @return void
     */
    public function show(DynamicRow $dynamicrow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DynamicRow $dynamicrow
     * @return void
     */
    public function edit(DynamicRow $dynamicrow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDynamicRowRequest $request
     * @param DynamicRow $dynamicrow
     * @return void
     */
    public function update(UpdateDynamicRowRequest $request, DynamicRow $dynamicrow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DynamicRow $dynamicrow
     * @return void
     */
    public function destroy(DynamicRow $dynamicrow)
    {
        //
    }
}
