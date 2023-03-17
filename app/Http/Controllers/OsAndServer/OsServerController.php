<?php

namespace App\Http\Controllers\OsAndServer;

use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use App\Models\OsAndServer\OsServer;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\OsServer\StoreOsServerRequest;
use App\Http\Resources\OsAndServer\OsServerResource;
use App\Http\Resources\OsAndServer\OsFamilyResource;
use App\Http\Requests\OsServer\UpdateOsServerRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OsServerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function fetch(): AnonymousResourceCollection
    {
        $osservers = OsServer::all();

        return OsServerResource::collection($osservers);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $osservers = OsServer::all();

        return view('osservers.index')
            ->with('osservers', $osservers)
            ;
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
     * @param StoreOsServerRequest $request
     * @return OsServerResource
     */
    public function store(StoreOsServerRequest $request): OsServerResource
    {
        $osserver = OsServer::createNew($request->osarchitecture, $request->osfamily, $request->name, $request->status, $request->description);

        return new OsServerResource($osserver);
    }

    /**
     * Display the specified resource.
     *
     * @param OsServer $osserver
     * @return Response
     */
    public function show(OsServer $osserver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param OsServer $osserver
     * @return Response
     */
    public function edit(OsServer $osserver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOsServerRequest $request
     * @param OsServer $osserver
     * @return OsServerResource
     */
    public function update(UpdateOsServerRequest $request, OsServer $osserver): OsServerResource
    {
        $osserver->updateOne($request->osarchitecture, $request->osfamily, $request->name, $request->status, $request->description);

        return new OsServerResource($osserver);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param OsServer $osserver
     * @return Response
     */
    public function destroy(OsServer $osserver)
    {
        $osserver->delete();

        return response('Delete Successfull', 200);
    }
}
