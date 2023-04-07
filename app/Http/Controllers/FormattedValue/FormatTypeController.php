<?php

namespace App\Http\Controllers\FormattedValue;

use App\Http\Controllers\Controller;
use App\Models\FormattedValue\FormatType;
use App\Http\Requests\FormatType\StoreFormatTypeRequest;
use App\Http\Requests\FormatType\UpdateFormatTypeRequest;
use App\Http\Resources\FormattedValue\FormatTypeResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FormatTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function fetchall(): AnonymousResourceCollection
    {
        return FormatTypeResource::collection( FormatType::all() );
    }

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
     * @param StoreFormatTypeRequest $request
     * @return FormatTypeResource
     */
    public function store(StoreFormatTypeRequest $request)
    {
        $formattype = FormatType::createNew($request->name, $request->code, $request->formattype_class, $request->status, $request->description);

        return new FormatTypeResource($formattype);
    }

    /**
     * Display the specified resource.
     *
     * @param FormatType $formattype
     * @return \Illuminate\Http\Response
     */
    public function show(FormatType $formattype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FormatType $formattype
     * @return \Illuminate\Http\Response
     */
    public function edit(FormatType $formattype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFormatTypeRequest $request
     * @param FormatType $formattype
     * @return FormatTypeResource
     */
    public function update(UpdateFormatTypeRequest $request, FormatType $formattype)
    {
        $formattype->updateThis($request->name, $request->code, $request->formattype_class, $request->status, $request->description);

        return new FormatTypeResource($formattype);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FormatType $formattype
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormatType $formattype)
    {
        $formattype->delete();

        return response('Delete Successfull', 200);
    }
}
