<?php

namespace App\Http\Controllers\OsAndServer;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\OsAndServer\OsArchitecture;
use App\Http\Resources\OsAndServer\OsArchitectureResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\OsArchitecture\StoreOsArchitectureRequest;
use App\Http\Requests\OsArchitecture\UpdateOsArchitectureRequest;

class OsArchitectureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function fetch()
    {
        $accessaccounts = OsArchitecture::all();

        return OsArchitectureResource::collection($accessaccounts);
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
     * @param StoreOsArchitectureRequest $request
     * @return OsArchitectureResource
     */
    public function store(StoreOsArchitectureRequest $request)
    {
        $osarchitecture = OsArchitecture::createNew($request->name, $request->code, $request->status, $request->description);

        return new OsArchitectureResource($osarchitecture);
    }

    /**
     * Display the specified resource.
     *
     * @param OsArchitecture $osarchitecture
     * @return Response
     */
    public function show(OsArchitecture $osarchitecture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param OsArchitecture $osarchitecture
     * @return Response
     */
    public function edit(OsArchitecture $osarchitecture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOsArchitectureRequest $request
     * @param OsArchitecture $osarchitecture
     * @return OsArchitectureResource
     */
    public function update(UpdateOsArchitectureRequest $request, OsArchitecture $osarchitecture)
    {
        $osarchitecture->updateOne($request->name, $request->code, $request->status, $request->description);

        return new OsArchitectureResource($osarchitecture);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param OsArchitecture $osarchitecture
     * @return Response
     */
    public function destroy(OsArchitecture $osarchitecture)
    {
        $osarchitecture->delete();

        return response('Delete Successfull', 200);
    }
}
