<?php

namespace App\Http\Controllers\FormatRule;

use App\Http\Controllers\Controller;
use App\Models\FormatRule\FormatTextWeight;
use App\Http\Resources\FormatRule\FormatTextWeightResource;
use App\Http\Requests\FormatTextWeight\StoreFormatTextWeightRequest;
use App\Http\Requests\FormatTextWeight\UpdateFormatTextWeightRequest;

class FormatTextWeightController extends Controller
{
    public function fetchall() {
        return FormatTextWeightResource::collection(FormatTextWeight::all());
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
     * @param StoreFormatTextWeightRequest $request
     * @return void
     */
    public function store(StoreFormatTextWeightRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param FormatTextWeight $formattextweight
     * @return void
     */
    public function show(FormatTextWeight $formattextweight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FormatTextWeight $formattextweight
     * @return void
     */
    public function edit(FormatTextWeight $formattextweight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFormatTextWeightRequest $request
     * @param FormatTextWeight $formattextweight
     * @return FormatTextWeightResource
     */
    public function update(UpdateFormatTextWeightRequest $request, FormatTextWeight $formattextweight)
    {
        $formattextweight->update([
            'format_value' => $request->format_value,
            'comment' => $request->comment,
        ]);

        return new FormatTextWeightResource($formattextweight);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FormatTextWeight $formattextweight
     * @return void
     */
    public function destroy(FormatTextWeight $formattextweight)
    {
        //
    }
}
