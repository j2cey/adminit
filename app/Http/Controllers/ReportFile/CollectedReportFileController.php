<?php

namespace App\Http\Controllers\ReportFile;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\Report\ReportResource;
use App\Models\ReportFile\CollectedReportFile;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Resources\ReportFile\CollectedReportFileResource;
use App\Http\Requests\CollectedReportFile\CollectedReportFileRequest;
use App\Http\Requests\CollectedReportFile\StoreCollectedReportFileRequest;
use App\Http\Requests\CollectedReportFile\UpdateCollectedReportFileRequest;

class CollectedReportFileController extends Controller
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
     * @param StoreCollectedReportFileRequest $request
     * @return CollectedReportFileResource
     */
    public function store(StoreCollectedReportFileRequest $request): CollectedReportFileResource
    {
        $collectedreportfile = CollectedReportFile::createNew($request->reportfile,$request->initial_file_name, $request-> local_file_name, $request-> file_size, $request->status,  $request->description);

        return new CollectedReportFileResource($collectedreportfile);
    }

    /**
     * Display the specified resource.
     *
     * @param CollectedReportFile $collectedreportfile
     * @return Application|Factory|View
     */
    public function show(CollectedReportFile $collectedreportfile)
    {
        //dd(CollectedReportFileResource::make($collectedreportfile->load(['reportfile','reportfile.report'])));
        //dd( json_decode( $collectedreportfile->lines_values ) );
        return view('collectedreportfiles.show')
            ->with('collectedreportfile', new CollectedReportFileResource($collectedreportfile))
            ->with('report', new ReportResource($collectedreportfile->reportfile->report))
            ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CollectedReportFile $collectedreportfile
     * @return Response
     */
    public function edit(CollectedReportFile $collectedreportfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCollectedReportFileRequest $request
     * @param CollectedReportFile $collectedreportfile
     * @return CollectedReportFileResource
     */
    public function update(UpdateCollectedReportFileRequest $request, CollectedReportFile $collectedreportfile)
    {
        $collectedreportfile->updateOne($request->reportfile, $request->initial_file_name, $request-> local_file_name, $request->file_size, $request->status,$request->description);

        return new CollectedReportFileResource($collectedreportfile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CollectedReportFile $collectedreportfile
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(CollectedReportFile $collectedreportfile)
    {
        $collectedreportfile->delete();

        return response('Delete Successfull', 200);
    }
}
