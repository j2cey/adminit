<?php

namespace App\Http\Controllers\DynamicAttributes;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Models\DynamicAttributes\DynamicAttribute;
use App\Http\Resources\DynamicAttributes\DynamicAttributeResource;
use App\Http\Requests\DynamicAttribute\StoreDynamicAttributeRequest;
use App\Http\Requests\DynamicAttribute\UpdateDynamicAttributeRequest;

class DynamicAttributeController extends Controller
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
     * @param StoreDynamicAttributeRequest $request
     * @return DynamicAttributeResource|void
     */
    public function store(StoreDynamicAttributeRequest $request)
    {
        $dyn_attr = $request->model->addDynamicAttribute($request->name, $request->attributetype, $request->description);

        return new DynamicAttributeResource($dyn_attr);
    }

    /**
     * Display the specified resource.
     *
     * @param DynamicAttribute $dynamicattribute
     * @return void
     */
    public function show(DynamicAttribute $dynamicattribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DynamicAttribute $dynamicattribute
     * @return void
     */
    public function edit(DynamicAttribute $dynamicattribute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDynamicAttributeRequest $request
     * @param DynamicAttribute $dynamicattribute
     * @return DynamicAttributeResource|void
     */
    public function update(UpdateDynamicAttributeRequest $request, DynamicAttribute $dynamicattribute)
    {
        $dynamicattribute->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        $dynamicattribute->attributetype()->associate($request->attributetype);

        return new DynamicAttributeResource($dynamicattribute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DynamicAttribute $dynamicattribute
     * @return Application|ResponseFactory|Response|void
     */
    public function destroy(DynamicAttribute $dynamicattribute)
    {
        $dynamicattribute->delete();

        return response('Delete Successfull', 200);
    }
}
