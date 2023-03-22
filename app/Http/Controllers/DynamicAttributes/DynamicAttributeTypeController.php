<?php

namespace App\Http\Controllers\DynamicAttributes;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Models\DynamicAttributes\DynamicAttributeType;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\DynamicAttributes\DynamicAttributeTypeResource;
use App\Http\Requests\DynamicAttributeType\StoreDynamicAttributeTypeRequest;
use App\Http\Requests\DynamicAttributeType\UpdateDynamicAttributeTypeRequest;

class DynamicAttributeTypeController extends Controller
{
    /**
     * Fetch all values
     * @return AnonymousResourceCollection
     */
    public function fetchall() {
        return DynamicAttributeTypeResource::collection(DynamicAttributeType::all());
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
     * @param StoreDynamicAttributeTypeRequest $request
     * @return DynamicAttributeTypeResource
     */
    public function store(StoreDynamicAttributeTypeRequest $request)
    {
        $dynamicattributetype = DynamicAttributeType::createNew($request->name, $request->code, $request->model_type, $request->status, $request->description);

        return new DynamicAttributeTypeResource($dynamicattributetype);
    }

    /**
     * Display the specified resource.
     *
     * @param DynamicAttributeType $dynamicattributetype
     * @return void
     */
    public function show(DynamicAttributeType $dynamicattributetype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DynamicAttributeType $dynamicattributetype
     * @return void
     */
    public function edit(DynamicAttributeType $dynamicattributetype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDynamicAttributeTypeRequest $request
     * @param DynamicAttributeType $dynamicattributetype
     * @return DynamicAttributeTypeResource
     */
    public function update(UpdateDynamicAttributeTypeRequest $request, DynamicAttributeType $dynamicattributetype)
    {
        $dynamicattributetype->updateOne($request->name, $request->code, $request->model_type, $request->status, $request->description);

        return new DynamicAttributeTypeResource($dynamicattributetype);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DynamicAttributeType $dynamicattributetype
     * @return Application|Response|ResponseFactory
     */
    public function destroy(DynamicAttributeType $dynamicattributetype)
    {
        $dynamicattributetype->delete();

        return response('Delete Successfull', 200);
    }
}
