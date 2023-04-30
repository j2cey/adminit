<?php

namespace App\Http\Controllers\ReportTreatments;

use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Http\Resources\ReportTreatments\ReportTreatmentResultResource;
use App\Http\Requests\ReportTreatmentResult\StoreReportTreatmentResultRequest;
use App\Http\Requests\ReportTreatmentResult\UpdateReportTreatmentResultRequest;

class ReportTreatmentResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $reporttreatmentresults = ReportTreatmentResultResource::collection(ReportTreatmentResult::all());

        return view('reporttreatmentresults.index')
            ->with('reporttreatmentresults', $reporttreatmentresults)
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
     * @param  \App\Http\Requests\ReportTreatmentResult\StoreReportTreatmentResultRequest  $request
     * @return Response
     */
    public function store(StoreReportTreatmentResultRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param ReportTreatmentResult $reporttreatmentresult
     * @return Application|Factory|View
     */
    public function show(ReportTreatmentResult $reporttreatmentresult)
    {
        return view('reporttreatmentresults.show')
            ->with('reporttreatmentresult', new ReportTreatmentResultResource($reporttreatmentresult))
            ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReportTreatmentResult $reporttreatmentresult
     * @return Response
     */
    public function edit(ReportTreatmentResult $reporttreatmentresult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ReportTreatmentResult\UpdateReportTreatmentResultRequest  $request
     * @param ReportTreatmentResult $reporttreatmentresult
     * @return Response
     */
    public function update(UpdateReportTreatmentResultRequest $request, ReportTreatmentResult $reporttreatmentresult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReportTreatmentResult $reporttreatmentresult
     * @return Response
     */
    public function destroy(ReportTreatmentResult $reporttreatmentresult)
    {
        //
    }
}
