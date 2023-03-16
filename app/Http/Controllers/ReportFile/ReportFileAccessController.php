<?php

namespace App\Http\Controllers\ReportFile;

use App\Http\Controllers\Controller;
use App\Models\ReportFile\ReportFileAccess;
use App\Http\Resources\ReportFile\ReportFileAccessResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\ReportFileAccess\StoreReportFileAccessRequest;
use App\Http\Requests\ReportFileAccess\UpdateReportFileAccessRequest;

class ReportFileAccessController extends Controller
{
    public function fetch(): AnonymousResourceCollection
    {
        return ReportFileAccessResource::collection(ReportFileAccess::all());
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
     * @param StoreReportFileAccessRequest $request
     * @return ReportFileAccessResource
     */
    public function store(StoreReportFileAccessRequest $request): ReportFileAccessResource
    {
        $reportfileaccess = ReportFileAccess::createNew($request->reportfile, $request->accessaccount, $request->reportserver, $request->accessprotocole, $request->name, $request->code, $request->status, $request->retrieve_by_name, $request->retrieve_by_wildcard, $request->description);

        return new ReportFileAccessResource($reportfileaccess);
    }

    /**
     * Display the specified resource.
     *
     * @param ReportFileAccess $reportfileaccess
     * @return \Illuminate\Http\Response
     */
    public function show(ReportFileAccess $reportfileaccess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReportFileAccess $reportfileaccess
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportFileAccess $reportfileaccess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReportFileAccessRequest $request
     * @param ReportFileAccess $reportfileaccess
     * @return ReportFileAccessResource
     */
    public function update(UpdateReportFileAccessRequest $request, ReportFileAccess $reportfileaccess): ReportFileAccessResource
    {
        $reportfileaccess->updateOne($request->reportfile, $request->accessaccount, $request->reportserver, $request->accessprotocole, $request->name, $request->code, $request->status, $request->retrieve_by_name, $request->retrieve_by_wildcard, $request->description);

        return new ReportFileAccessResource($reportfileaccess);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReportFileAccess $reportfileaccess
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportFileAccess $reportfileaccess)
    {
        $reportfileaccess->delete();

        return response('Delete Successfull', 200);
    }
}
