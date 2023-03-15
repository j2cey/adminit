<?php

namespace App\Http\Controllers\OsAndServer;

use App\Http\Controllers\Controller;
use App\Models\OsAndServer\OsFamily;
use App\Http\Requests\OsFamily\StoreOsFamilyRequest;
use App\Http\Resources\OsAndServer\OsFamilyResource;
use App\Http\Requests\OsFamily\UpdateOsFamilyRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OsFamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function fetch()
    {
        $osfamilies = OsFamily::all();

        return OsFamilyResource::collection($osfamilies);
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
     * @param StoreOsFamilyRequest $request
     * @return OsFamilyResource
     */
    public function store(StoreOsFamilyRequest $request)
    {
        $osfamily = OsFamily::createNew($request->name, $request->code, $request->status, $request->description);

        return new OsFamilyResource($osfamily);
    }

    /**
     * Display the specified resource.
     *
     * @param  OsFamily  $osfamily
     * @return \Illuminate\Http\Response
     */
    public function show(OsFamily $osfamily)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  OsFamily  $osfamily
     * @return \Illuminate\Http\Response
     */
    public function edit(OsFamily $osfamily)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOsFamilyRequest $request
     * @param  OsFamily  $osfamily
     * @return OsFamilyResource
     */
    public function update(UpdateOsFamilyRequest $request, OsFamily $osfamily)
    {
        $osfamily->updateOne($request->name, $request->code, $request->status, $request->description);

        return new OsFamilyResource($osfamily);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  OsFamily  $osfamily
     * @return \Illuminate\Http\Response
     */
    public function destroy(OsFamily $osfamily)
    {
        $osfamily->delete();

        return response('Delete Successfull', 200);
    }
}
