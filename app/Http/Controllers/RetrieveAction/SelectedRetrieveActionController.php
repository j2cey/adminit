<?php

namespace App\Http\Controllers\RetrieveAction;

use Illuminate\Http\Response;
use App\Models\Reports\Report;
use App\Models\Reports\ReportType;
use App\Http\Controllers\Controller;
use App\Models\ReportFile\ReportFileType;
use App\Models\RetrieveAction\RetrieveAction;
use App\Models\RetrieveAction\SelectedRetrieveAction;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\RetrieveAction\SelectedRetrieveActionResource;
use App\Http\Requests\SelectedRetrieveAction\StoreSelectedRetrieveActionRequest;
use App\Http\Requests\SelectedRetrieveAction\UpdateSelectedRetrieveActionRequest;
use App\Http\Requests\SelectedRetrieveAction\FromModelAddSelectedRetrieveActionRequest;
use App\Http\Requests\SelectedRetrieveAction\FromModelRemoveSelectedRetrieveActionRequest;

class SelectedRetrieveActionController extends Controller
{
    public function test() {
        $reporttype = ReportType::defaultReport()->first();
        $report = Report::createNew("New Report",$reporttype,"new report desc");
        $reportfile = $report->addReportFile(ReportFileType::txt()->first(),$file_name ?? "new report file");
        $selectedaction = $reportfile->addSelectedAction(RetrieveAction::retrieveByName()->first());

        $selectedaction->updateOne(RetrieveAction::renameFile()->first());
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function fetch(): AnonymousResourceCollection
    {
        $selectedretrieveactions = SelectedRetrieveAction::all();

        return SelectedRetrieveActionResource::collection($selectedretrieveactions);
    }

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
     * @param StoreSelectedRetrieveActionRequest $request
     * @return SelectedRetrieveActionResource
     */
    public function store(StoreSelectedRetrieveActionRequest $request)
    {
        $selectedretrieveaction = $request->model->addSelectedAction(
            $request->retrieveaction,
            $request->status,
            $request->description);

        return new SelectedRetrieveActionResource($selectedretrieveaction);
    }

    /**
     * Display the specified resource.
     *
     * @param SelectedRetrieveAction $selectedretrieveaction
     * @return Response
     */
    public function show(SelectedRetrieveAction $selectedretrieveaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SelectedRetrieveAction $selectedretrieveaction
     * @return Response
     */
    public function edit(SelectedRetrieveAction $selectedretrieveaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSelectedRetrieveActionRequest $request
     * @param SelectedRetrieveAction $selectedretrieveaction
     * @return SelectedRetrieveActionResource
     */
    public function update(UpdateSelectedRetrieveActionRequest $request, SelectedRetrieveAction $selectedretrieveaction)
    {
        $selectedretrieveaction->updateOne($request->retrieveaction, $request->code, $request->status, $request->description);

        return new SelectedRetrieveActionResource($selectedretrieveaction);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SelectedRetrieveAction $selectedretrieveaction
     * @return Response
     */
    public function destroy(SelectedRetrieveAction $selectedretrieveaction)
    {
        $selectedretrieveaction->delete();

        return response('Delete Successfull', 200);
    }

    /*public function addtomodel(FromModelAddSelectedRetrieveActionRequest $request) {
        $selectedretrieveaction = $request->model->addSelectedAction($request->retrieveaction,$request->label,$request->valuetype,$request->actionvalue,$request->description);

        return new SelectedRetrieveActionResource($selectedretrieveaction);
    }

    public function removefrommodel(FromModelRemoveSelectedRetrieveActionRequest $request) {
        $request->model->removeSelectedAction($request->selectedretrieveaction);

        return response('Delete Successfull', 200);
    }*/
}
