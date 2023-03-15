<?php

namespace App\Http\Controllers\ReportFile;

use App\Http\Controllers\Controller;
use App\Models\ReportFile\FileMimeType;
use App\Http\Resources\ReportFile\FileMimeTypeResource;
use App\Http\Requests\FileMimeType\StoreFileMimeTypeRequest;
use App\Http\Requests\FileMimeType\UpdateFileMimeTypeRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FileMimeTypeController extends Controller
{
    public function fetch(): AnonymousResourceCollection
    {
        return FileMimeTypeResource::collection(FileMimeType::all());
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
     * @param  \App\Http\Requests\FileMimeType\StoreFileMimeTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileMimeTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportFile\FileMimeType  $fileMimeType
     * @return \Illuminate\Http\Response
     */
    public function show(FileMimeType $fileMimeType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportFile\FileMimeType  $fileMimeType
     * @return \Illuminate\Http\Response
     */
    public function edit(FileMimeType $fileMimeType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\FileMimeType\UpdateFileMimeTypeRequest  $request
     * @param  \App\Models\ReportFile\FileMimeType  $fileMimeType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileMimeTypeRequest $request, FileMimeType $fileMimeType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportFile\FileMimeType  $fileMimeType
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileMimeType $fileMimeType)
    {
        //
    }
}
