<?php

namespace App\Http\Controllers\ReportFile;

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
     * @param  \App\Http\Requests\ReportFile\StoreReportFileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportFileRequest $request): ReportFileResource
    {
        $reportfile = ReportFile::createNew($request->reportfiletype, $request->status, $request->name, $request->wildcard, $request->retrieve_by_name,$request->retrieve_by_wildcard);

        return new ReportFileResource($reportfile);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportFile\ReportFile  $reportfile
     * @return \Illuminate\Http\Response
     */
    public function show(ReportFile $reportfile)
    {
        dd("reportfiles.show: ",reportfile);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportFile\ReportFile  $reportfile
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportFile $reportfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ReportFile\UpdateReportFileRequest  $request
     * @param  \App\Models\ReportFile\ReportFile  $reportfile
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportFileRequest $request, ReportFile $reportfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportFile\ReportFile  $reportfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportFile $reportfile)
    {
        //
    }
}
