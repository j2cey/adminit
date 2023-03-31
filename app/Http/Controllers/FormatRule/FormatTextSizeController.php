<?php

namespace App\Http\Controllers\FormatRule;

use App\Http\Controllers\Controller;
use App\Models\FormatRule\FormatTextSize;
use App\Http\Resources\FormatRule\FormatTextSizeResource;
use App\Http\Requests\FormatTextSize\StoreFormatTextSizeRequest;
use App\Http\Requests\FormatTextSize\UpdateFormatTextSizeRequest;

class FormatTextSizeController extends Controller
{
    public function fetchall() {
        return FormatTextSizeResource::collection(FormatTextSize::all());
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
     * @param StoreFormatTextSizeRequest $request
     * @return void
     */
    public function store(StoreFormatTextSizeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param FormatTextSize $formattextsize
     * @return void
     */
    public function show(FormatTextSize $formattextsize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FormatTextSize $formattextsize
     * @return void
     */
    public function edit(FormatTextSize $formattextsize)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFormatTextSizeRequest $request
     * @param FormatTextSize $formattextsize
     * @return FormatTextSizeResource
     */
    public function update(UpdateFormatTextSizeRequest $request, FormatTextSize $formattextsize)
    {
        $formattextsize->update([
            'format_value' => $request->format_value,
            'comment' => $request->comment,
        ]);

        return new FormatTextSizeResource($formattextsize);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FormatTextSize $formattextsize
     * @return void
     */
    public function destroy(FormatTextSize $formattextsize)
    {
        //
    }
}
