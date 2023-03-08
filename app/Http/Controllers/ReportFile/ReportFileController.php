<?php

namespace App\Http\Controllers\ReportFile;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\ReportFile\ReportFile;
use App\Http\Resources\ReportFileResource;
use App\Http\Requests\ReportFile\StoreReportFileRequest;
use App\Http\Requests\ReportFile\UpdateReportFileRequest;

class ReportFileController extends Controller
{
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
     * @param StoreReportFileRequest $request
     * @return ReportFileResource
     */
    public function store(StoreReportFileRequest $request): ReportFileResource
    {
        $reportfile = ReportFile::createNew($request->reportfiletype, $request->status, $request->name, $request->wildcard, $request->retrieve_by_name, $request->retrieve_by_wildcard);

        return new ReportFileResource($reportfile);
    }

    /**
     * Display the specified resource.
     *
     * @param ReportFile $reportfile
     * @return Response
     */
    public function show(ReportFile $reportfile)
    {
        dd("reportfiles.show: ",reportfile);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReportFile $reportfile
     * @return Response
     */
    public function edit(ReportFile $reportfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReportFileRequest $request
     * @param ReportFile $reportfile
     * @return ReportFileResource
     */
    public function update(UpdateReportFileRequest $request, ReportFile $reportfile)
    {
        $reportfile->updateOne($request->reportfiletype, $request->status, $request->name, $request->wildcard, $request->retrieve_by_name, $request->retrieve_by_wildcard);

        return new ReportFileResource($reportfile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReportFile $reportfile
     * @return Response
     */
    public function destroy(ReportFile $reportfile)
    {
        $reportfile->delete();

        return response('Delete Successfull', 200);
    }
}
