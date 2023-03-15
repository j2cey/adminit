<?php

namespace App\Http\Controllers\OsAndServer;

use App\Http\Controllers\Controller;
use App\Models\OsAndServer\ReportServer;
use App\Http\Requests\ReportServer\StoreReportServerRequest;
use App\Http\Requests\ReportServer\UpdateReportServerRequest;

class ReportServerController extends Controller
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
     * @param  \App\Http\Requests\ReportServer\StoreReportServerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportServerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OsAndServer\ReportServer  $reportServer
     * @return \Illuminate\Http\Response
     */
    public function show(ReportServer $reportServer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OsAndServer\ReportServer  $reportServer
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportServer $reportServer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ReportServer\UpdateReportServerRequest  $request
     * @param  \App\Models\OsAndServer\ReportServer  $reportServer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportServerRequest $request, ReportServer $reportServer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OsAndServer\ReportServer  $reportServer
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportServer $reportServer)
    {
        //
    }
}
