<?php

namespace App\Http\Controllers\RetrieveAction;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use App\Models\RetrieveAction\RetrieveActionType;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\RetrieveAction\RetrieveActionTypeResource;
use App\Http\Requests\RetrieveActionType\StoreRetrieveActionTypeRequest;
use App\Http\Requests\RetrieveActionType\UpdateRetrieveActionTypeRequest;

class RetrieveActionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function fetch(): AnonymousResourceCollection
    {
        return RetrieveActionTypeResource::collection( RetrieveActionType::all() );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRetrieveActionTypeRequest $request
     * @return RetrieveActionTypeResource
     */
    public function store(StoreRetrieveActionTypeRequest $request)
    {
        $retrieveactiontype = RetrieveActionType::createNew($request->name, $request->code, $request->status, $request->description);

        return new RetrieveActionTypeResource($retrieveactiontype);
    }

    /**
     * Display the specified resource.
     *
     * @param RetrieveActionType $retrieveactiontype
     * @return Response
     */
    public function show(RetrieveActionType $retrieveactiontype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param RetrieveActionType $retrieveactiontype
     * @return Response
     */
    public function edit(RetrieveActionType $retrieveactiontype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRetrieveActionTypeRequest $request
     * @param RetrieveActionType $retrieveactiontype
     * @return RetrieveActionTypeResource
     */
    public function update(UpdateRetrieveActionTypeRequest $request, RetrieveActionType $retrieveactiontype)
    {
        $retrieveactiontype->updateOne($request->name, $request->code, $request->status, $request->description);

        return new RetrieveActionTypeResource($retrieveactiontype);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RetrieveActionType $retrieveactiontype
     * @return Application|Response|ResponseFactory
     */
    public function destroy(RetrieveActionType $retrieveactiontype)
    {
        $retrieveactiontype->delete();

        return response('Delete Successfull', 200);
    }
}
