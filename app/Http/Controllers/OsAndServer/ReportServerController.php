<?php

namespace App\Http\Controllers\OsAndServer;

use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Models\OsAndServer\ReportServer;
use Illuminate\Contracts\Foundation\Application;
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
     * @return Application|Factory|View
     */
    public function index()
    {
        $reportservers = ReportServerResource::collection(ReportServer::all());

        return view('reportservers.index')
            ->with('reportservers', $reportservers)
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
     * @param ReportServer $reportserver
     * @return Response
     */
    public function show(ReportServer $reportserver)
    {
        dd("reportservers.show: ",$reportserver);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReportServer $reportserver
     * @return Response
     */
    public function edit(ReportServer $reportserver)
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
