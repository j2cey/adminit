<?php

namespace App\Http\Controllers;

use App\Models\ReportFile\ReportFileReceiver;
use App\Http\Requests\StoreReportFileReceiverRequest;
use App\Http\Requests\UpdateReportFileReceiverRequest;

class ReportFileReceiverController extends Controller
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
     * @param  \App\Http\Requests\StoreReportFileReceiverRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportFileReceiverRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportFile\ReportFileReceiver  $reportFileReceiver
     * @return \Illuminate\Http\Response
     */
    public function show(ReportFileReceiver $reportFileReceiver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportFile\ReportFileReceiver  $reportFileReceiver
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportFileReceiver $reportFileReceiver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReportFileReceiverRequest  $request
     * @param  \App\Models\ReportFile\ReportFileReceiver  $reportFileReceiver
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportFileReceiverRequest $request, ReportFileReceiver $reportFileReceiver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportFile\ReportFileReceiver  $reportFileReceiver
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportFileReceiver $reportFileReceiver)
    {
        //
    }
}
