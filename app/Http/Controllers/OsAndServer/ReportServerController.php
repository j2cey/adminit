<?php

namespace App\Http\Controllers\OsAndServer;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\OsAndServer\ReportServer;
use App\Http\Resources\OsAndServer\ReportServerResource;
use App\Http\Requests\ReportServer\StoreReportServerRequest;
use App\Http\Requests\ReportServer\UpdateReportServerRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportServerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function fetch()
    {
        $reportservers= ReportServer::all();

        return ReportServerResource::collection($reportservers);
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
     * @param StoreReportServerRequest $request
     * @return ReportServerResource
     */
    public function store(StoreReportServerRequest $request)
    {
        $reportserver = ReportServer::createNew($request->osserver, $request->name, $request->ip_address, $request->domain_name, $request->status, $request->description);

        return new ReportServerResource($reportserver);
    }

    /**
     * Display the specified resource.
     *
     * @param ReportServer $reportServer
     * @return Response
     */
    public function show(ReportServer $reportServer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReportServer $reportServer
     * @return Response
     */
    public function edit(ReportServer $reportServer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReportServerRequest $request
     * @param ReportServer $reportserver
     * @return ReportServerResource
     */
    public function update(UpdateReportServerRequest $request, ReportServer $reportserver)
    {
        $reportserver->updateOne($request->osserver, $request->name, $request->ip_address, $request->domain_name ,$request->status, $request->description);

        return new ReportServerResource($reportserver);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReportServer $reportserver
     * @return Response
     */
    public function destroy(ReportServer $reportserver)
    {
        $reportserver->delete();

        return response('Delete Successfull', 200);
    }
}
