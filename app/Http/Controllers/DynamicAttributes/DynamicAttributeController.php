<?php

namespace App\Http\Controllers\DynamicAttributes;

use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
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
     * @return DynamicAttributeResource
     */
    public function store(StoreDynamicAttributeRequest $request)
    {
        $dynamicattribute = $request->model->addDynamicAttribute(
            $request->name,
            $request->dynamicattributetype,
            $request->status,
            $request->description,
            $request->offset,
            $request->max_length,
            $request->searchable,
            $request->sortable
        );

        return new DynamicAttributeResource($dynamicattribute);
    }

    /**
     * Display the specified resource.
     *
     * @param DynamicAttribute $dynamicattribute
     * @return Application|Factory|View
     */
    public function show(DynamicAttribute $dynamicattribute)
    {
        return view('dynamicattributes.show')
            ->with('dynamicattribute', new DynamicAttributeResource($dynamicattribute) )
            ->with('model', $dynamicattribute->hasdynamicattribute);//str_replace(["\\"],["\\\\"],$dynamicattribute->hasdynamicattribute->getClass()));
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
     * @return DynamicAttributeResource
     */
    public function update(UpdateDynamicAttributeRequest $request, DynamicAttribute $dynamicattribute)
    {
        $dynamicattribute->updateThis(
            $request->dynamicattributetype,
            $request->name,
            $request->status,
            $request->description,
            $request->offset,
            $request->max_length,
            $request->searchable,
            $request->sortable
        );

        return new DynamicAttributeResource($dynamicattribute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DynamicAttribute $dynamicattribute
     * @return Application|Response|ResponseFactory
     */
    public function destroy(DynamicAttribute $dynamicattribute)
    {
        $dynamicattribute->delete();

        return response('Delete Successfull', 200);
    }
}
