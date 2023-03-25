<?php

namespace App\Http\Controllers\ReportTreatments;

use App\Http\Controllers\Controller;
use App\Models\ReportTreatments\OperationResult;
use App\Http\Requests\OperationResult\StoreOperationResultRequest;
use App\Http\Requests\OperationResult\UpdateOperationResultRequest;

class OperationResultController extends Controller
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
     * @param  \App\Http\Requests\OperationResult\StoreOperationResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOperationResultRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportTreatments\OperationResult  $operationResult
     * @return \Illuminate\Http\Response
     */
    public function show(OperationResult $operationResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportTreatments\OperationResult  $operationResult
     * @return \Illuminate\Http\Response
     */
    public function edit(OperationResult $operationResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\OperationResult\UpdateOperationResultRequest  $request
     * @param  \App\Models\ReportTreatments\OperationResult  $operationResult
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOperationResultRequest $request, OperationResult $operationResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportTreatments\OperationResult  $operationResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(OperationResult $operationResult)
    {
        //
    }
}
