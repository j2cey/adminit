<?php

namespace App\Http\Controllers\ReportFile;

use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\ReportFile\ReportFile;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Resources\ReportFile\ReportFileResource;
use App\Http\Requests\ReportFile\StoreReportFileRequest;
use App\Http\Requests\ReportFile\UpdateReportFileRequest;
use App\Http\Resources\DynamicAttributes\DynamicAttributeResource;

class ReportFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
     * @param StoreReportFileRequest $request
     * @return ReportFileResource
     */
    public function store(StoreReportFileRequest $request): ReportFileResource
    {
        $reportfile = ReportFile::createNew(
            $request->report,
            $request->reportfiletype,
            $request->status,
            $request->name,
            $request->label,
            $request->wildcard,
            $request->description,
            $request->remotedir_relative_path,
            $request->remotedir_absolute_path,
            $request->use_file_extension,
            $request->has_headers
        );

        return new ReportFileResource($reportfile);
    }

    /**
     * Display the specified resource.
     *
     * @param ReportFile $reportfile
     * @return Application|Factory|View
     */
    public function show(ReportFile $reportfile)
    {
        return view('reportfiles.show')
            ->with('reportfile', new ReportFileResource($reportfile))
            ;
    }

    /**
     * Display the specified resource.
     *
     * @param $uuid
     * @return Application|Factory|View
     */
    public function attributes($uuid)
    {
        $reportfile = ReportFile::where('uuid', $uuid)->first();
        $dynamicattributes = DynamicAttributeResource::collection($reportfile->dynamicattributes);

        return view('dynamicattributes.index')
            ->with('reportfile', new ReportFileResource( $reportfile) )
            ->with('dynamicattributes', $dynamicattributes)
            ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReportFile $reportfile
     * @return Response
     */
    public function edit(ReportFile $reportfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReportFileRequest $request
     * @param ReportFile $reportfile
     * @return ReportFileResource
     */
    public function update(UpdateReportFileRequest $request, ReportFile $reportfile)
    {
        $reportfile->updateOne(
            $request->report,
            $request->reportfiletype,
            $request->status,
            $request->name,
            $request->label,
            $request->wildcard,
            $request->description,
            $request->remotedir_relative_path,
            $request->remotedir_absolute_path,
            $request->use_file_extension,
            $request->has_headers
        );

        return new ReportFileResource($reportfile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReportFile $reportfile
     * @return Response
     */
    public function destroy(ReportFile $reportfile)
    {
        $reportfile->delete();

        return response('Delete Successfull', 200);
    }
}
