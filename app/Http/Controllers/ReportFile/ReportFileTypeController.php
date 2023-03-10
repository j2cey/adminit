<?php

namespace App\Http\Controllers\ReportFile;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ReportFile\ReportFileType;
use App\Http\Resources\ReportFile\ReportFileTypeResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\ReportFileType\StoreReportFileTypeRequest;
use App\Http\Requests\ReportFileType\UpdateReportFileTypeRequest;

class ReportFileTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function fetch()
    {
        $reportfiletypes = ReportFileType::all();

        return ReportFileTypeResource::collection($reportfiletypes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

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
     * @param StoreReportFileTypeRequest $request
     * @return ReportFileTypeResource
     */
    public function store(StoreReportFileTypeRequest $request): ReportFileTypeResource
    {
        $reportfiletype = ReportFileType::createNew($request->filemimetype, $request->name, $request->extension, $request->description);

        return new ReportFileTypeResource($reportfiletype);
    }

    /**
     * Display the specified resource.
     *
     * @param ReportFileType $reportfiletype
     * @return Response
     */
    public function show(ReportFileType $reportfiletype)
    {
        dd("reportfiletypes.show: ",$reportfiletype);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReportFileType $reportfiletype
     * @return Response
     */
    public function edit(ReportFileType $reportfiletype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReportFileTypeRequest $request
     * @param ReportFileType $reportfiletype
     * @return ReportFileTypeResource
     */
    public function update(updateReportFileTypeRequest $request, ReportFileType $reportfiletype)
    {
        $reportfiletype->updateOne($request->filemimetype,  $request->name, $request->extension, $request->description);

        return new ReportFileTypeResource($reportfiletype);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReportFileType $reportfiletype
     * @return Response
     */
    public function destroy(ReportFileType $reportfiletype)
    {
        $reportfiletype->delete();

        return response('Delete Successfull', 200);
    }

}
