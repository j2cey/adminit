<?php

namespace App\Http\Controllers\Treatments;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use App\Models\Treatments\OperationResult;
use App\Models\Treatments\ReportTreatmentStepResult;
use App\Http\Resources\Treatments\ReportTreatmentStepResultResource;
use App\Http\Requests\ReportTreatmentStepResult\StoreReportTreatmentStepResultRequest;
use App\Http\Requests\ReportTreatmentStepResult\UpdateReportTreatmentStepResultRequest;

class ReportTreatmentStepResultController extends Controller
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
     * @param  \App\Http\Requests\ReportTreatmentStepResult\StoreReportTreatmentStepResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportTreatmentStepResultRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param ReportTreatmentStepResult $reporttreatmentstepresult
     * @return Application|Factory|View
     */
    public function show(ReportTreatmentStepResult $reporttreatmentstepresult)
    {
        //dd(OperationResult::find(1)->isLastOperation);
        return view('reporttreatmentstepresults.show')
            ->with('reporttreatmentstepresult', new ReportTreatmentStepResultResource($reporttreatmentstepresult))
            ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReportTreatmentStepResult $reporttreatmentstepresult
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportTreatmentStepResult $reporttreatmentstepresult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ReportTreatmentStepResult\UpdateReportTreatmentStepResultRequest  $request
     * @param ReportTreatmentStepResult $reporttreatmentstepresult
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportTreatmentStepResultRequest $request, ReportTreatmentStepResult $reporttreatmentstepresult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReportTreatmentStepResult $reporttreatmentstepresult
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportTreatmentStepResult $reporttreatmentstepresult)
    {
        //
    }
}
