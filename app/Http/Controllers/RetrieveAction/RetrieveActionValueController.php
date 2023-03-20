<?php

namespace App\Http\Controllers\RetrieveAction;

use App\Http\Controllers\Controller;
use App\Models\RetrieveAction\RetrieveActionValue;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\RetrieveAction\RetrieveActionValueResource;
use App\Http\Requests\RetrieveActionValue\StoreRetrieveActionValueRequest;
use App\Http\Requests\RetrieveActionValue\UpdateRetrieveActionValueRequest;

class RetrieveActionValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function fetch(): AnonymousResourceCollection
    {
        return RetrieveActionValueResource::collection( RetrieveActionValue::all() );
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
     * @param StoreRetrieveActionValueRequest $request
     * @return RetrieveActionValueResource
     */
    public function store(StoreRetrieveActionValueRequest $request)
    {
        $retrieveactionvalue = RetrieveActionValue::createNew($request->selectedretrieveaction, $request->label, $request->type, $request->value_string, $request->value_int, $request->value_datetime, $request->status, $request->description);

        return new RetrieveActionValueResource($retrieveactionvalue);
    }

    /**
     * Display the specified resource.
     *
     * @param RetrieveActionValue $retrieveactionvalue
     * @return \Illuminate\Http\Response
     */
    public function show(RetrieveActionValue $retrieveactionvalue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param RetrieveActionValue $retrieveactionvalue
     * @return \Illuminate\Http\Response
     */
    public function edit(RetrieveActionValue $retrieveactionvalue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRetrieveActionValueRequest $request
     * @param RetrieveActionValue $retrieveactionvalue
     * @return RetrieveActionValueResource
     */
    public function update(UpdateRetrieveActionValueRequest $request, RetrieveActionValue $retrieveactionvalue)
    {
        $retrieveactionvalue->updateOne($request->selectedretrieveaction, $request->label, $request->type, $request->value_string, $request->value_int, $request->value_datetime, $request->status, $request->description);

        return new RetrieveActionValueResource($retrieveactionvalue);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RetrieveActionValue $retrieveactionvalue
     * @return \Illuminate\Http\Response
     */
    public function destroy(RetrieveActionValue $retrieveactionvalue)
    {
        $retrieveactionvalue->delete();

        return response('Delete Successfull', 200);
    }
}
