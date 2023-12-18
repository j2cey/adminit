<?php

namespace App\Http\Controllers;

use App\Models\Import\ImportResult;
use App\Http\Requests\StoreImportResultRequest;
use App\Http\Requests\UpdateImportResultRequest;

class ImportResultController extends Controller
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
     * @param  \App\Http\Requests\StoreImportResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImportResultRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Import\ImportResult  $importResult
     * @return \Illuminate\Http\Response
     */
    public function show(ImportResult $importResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Import\ImportResult  $importResult
     * @return \Illuminate\Http\Response
     */
    public function edit(ImportResult $importResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateImportResultRequest  $request
     * @param  \App\Models\Import\ImportResult  $importResult
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImportResultRequest $request, ImportResult $importResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Import\ImportResult  $importResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImportResult $importResult)
    {
        //
    }
}
