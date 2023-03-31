<?php

namespace App\Http\Controllers\FormatRule;

use App\Http\Controllers\Controller;
use App\Models\FormatRule\FormatTextColor;
use App\Http\Resources\FormatRule\FormatTextColorResource;
use App\Http\Requests\FormatTextColor\StoreFormatTextColorRequest;
use App\Http\Requests\FormatTextColor\UpdateFormatTextColorRequest;

class FormatTextColorController extends Controller
{
    public function fetchall() {
        return FormatTextColorResource::collection(FormatTextColor::all());
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
     * @param StoreFormatTextColorRequest $request
     * @return void
     */
    public function store(StoreFormatTextColorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param FormatTextColor $formattextcolor
     * @return void
     */
    public function show(FormatTextColor $formattextcolor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FormatTextColor $formattextcolor
     * @return void
     */
    public function edit(FormatTextColor $formattextcolor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFormatTextColorRequest $request
     * @param FormatTextColor $formattextcolor
     * @return FormatTextColorResource
     */
    public function update(UpdateFormatTextColorRequest $request, FormatTextColor $formattextcolor)
    {
        $formattextcolor->update([
            'format_value' => $request->format_value,
            'comment' => $request->comment,
        ]);

        return new FormatTextColorResource($formattextcolor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FormatTextColor $formattextcolor
     * @return void
     */
    public function destroy(FormatTextColor $formattextcolor)
    {
        //
    }
}
