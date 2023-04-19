<?php

namespace App\Http\Controllers\RetrieveAction;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\RetrieveAction\RetrieveAction;
use App\Http\Resources\RetrieveAction\RetrieveActionResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\RetrieveAction\StoreRetrieveActionRequest;
use App\Http\Requests\RetrieveAction\UpdateRetrieveActionRequest;

class RetrieveActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function fetch(): AnonymousResourceCollection
    {
        $retrieveactions = RetrieveAction::all();

        return RetrieveActionResource::collection($retrieveactions);
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
     * @param StoreRetrieveActionRequest $request
     * @return RetrieveActionResource
     */
    public function store(StoreRetrieveActionRequest $request)
    {
        $retrieveaction = RetrieveAction::createNew(
            $request->retrieveactiontype,
            $request->name,
            $request->action_class,
            $request->code,
            $request->status,
            $request->description
        );

        return new RetrieveActionResource($retrieveaction);
    }

    /**
     * Display the specified resource.
     *
     * @param RetrieveAction $retrieveaction
     * @return Response
     */
    public function show(RetrieveAction $retrieveaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param RetrieveAction $retrieveaction
     * @return Response
     */
    public function edit(RetrieveAction $retrieveaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRetrieveActionRequest $request
     * @param RetrieveAction $retrieveaction
     * @return RetrieveActionResource
     */
    public function update(UpdateRetrieveActionRequest $request, RetrieveAction $retrieveaction)
    {
        $retrieveaction->updateOne($request->retrieveactiontype, $request->name, $request->action_class, $request->code, $request->status, $request->description);

        return new RetrieveActionResource($retrieveaction);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RetrieveAction $retrieveaction
     * @return Response
     */
    public function destroy(RetrieveAction $retrieveaction)
    {
        $retrieveaction->delete();

        return response('Delete Successfull', 200);
    }
}
