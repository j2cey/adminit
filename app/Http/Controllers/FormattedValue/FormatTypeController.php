<?php

namespace App\Http\Controllers\FormattedValue;

use App\Http\Controllers\Controller;
use App\Models\FormattedValue\FormatType;
use App\Http\Requests\FormatType\StoreFormatTypeRequest;
use App\Http\Requests\FormatType\UpdateFormatTypeRequest;

class FormatTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\FormatType\StoreFormatTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormatTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FormattedValue\FormatType  $formatType
     * @return \Illuminate\Http\Response
     */
    public function show(FormatType $formatType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FormattedValue\FormatType  $formatType
     * @return \Illuminate\Http\Response
     */
    public function edit(FormatType $formatType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\FormatType\UpdateFormatTypeRequest  $request
     * @param  \App\Models\FormattedValue\FormatType  $formatType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormatTypeRequest $request, FormatType $formatType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FormattedValue\FormatType  $formatType
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormatType $formatType)
    {
        //
    }
}
