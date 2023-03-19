<?php

namespace App\Http\Controllers\Access;

use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Access\AccessProtocole;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use App\Http\Resources\AccessProtocoleResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\AccessProtocole\StoreAccessProtocoleRequest;
use App\Http\Requests\AccessProtocole\UpdateAccessProtocoleRequest;

class AccessProtocoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function fetch()
    {
        $accessprotocoles = AccessProtocole::all();

        return AccessProtocoleResource::collection($accessprotocoles);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $accessprotocoles = AccessProtocole::all();

        return view('accessprotocoles.index')
            ->with('accessprotocoles', $accessprotocoles)
            ;
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
     * @param StoreAccessProtocoleRequest $request
     * @return AccessProtocoleResource
     */
    public function store(StoreAccessProtocoleRequest $request): AccessProtocoleResource
    {
        $accessprotocole = AccessProtocole::createNew($request->name, $request->code, $request->protocole_class, $request->status, $request->description);

        return new AccessProtocoleResource($accessprotocole);
    }

    /**
     * Display the specified resource.
     *
     * @param AccessProtocole $accessprotocole
     * @return Response
     */
    public function show(AccessProtocole $accessprotocole)
    {
        dd("accessprotocoles.show: ",$accessprotocole);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AccessProtocole $accessprotocole
     * @return Response
     */
    public function edit(AccessProtocole $accessprotocole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAccessProtocoleRequest $request
     * @param AccessProtocole $accessprotocole
     * @return AccessProtocoleResource
     */
    public function update(UpdateAccessProtocoleRequest $request, AccessProtocole $accessprotocole)
    {
        $accessprotocole->updateOne($request->name, $request->code, $request->protocole_class, $request->status, $request->description);

        return new AccessProtocoleResource($accessprotocole);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AccessProtocole $accessprotocole
     * @return Response
     */
    public function destroy(AccessProtocole $accessprotocole)
    {
        $accessprotocole->delete();

        return response('Delete Successfull', 200);
    }
//
}
