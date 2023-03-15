<?php

namespace App\Http\Controllers\ReportFile;

use App\Http\Controllers\Controller;
use App\Models\ReportFile\ReportFileAccess;
use App\Http\Requests\ReportFileAccess\StoreReportFileAccessRequest;
use App\Http\Requests\ReportFileAccess\UpdateReportFileAccessRequest;

class ReportFileAccessController extends Controller
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
     * @param  \App\Http\Requests\ReportFileAccess\StoreReportFileAccessRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportFileAccessRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportFile\ReportFileAccess  $reportFileAccess
     * @return \Illuminate\Http\Response
     */
    public function show(ReportFileAccess $reportFileAccess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportFile\ReportFileAccess  $reportFileAccess
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportFileAccess $reportFileAccess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ReportFileAccess\UpdateReportFileAccessRequest  $request
     * @param  \App\Models\ReportFile\ReportFileAccess  $reportFileAccess
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportFileAccessRequest $request, ReportFileAccess $reportFileAccess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportFile\ReportFileAccess  $reportFileAccess
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportFileAccess $reportFileAccess)
    {
        //
    }
}
