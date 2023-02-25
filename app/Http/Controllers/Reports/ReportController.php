<?php

namespace App\Http\Controllers\Reports;

use App\Models\Status;
use App\Models\Reports\Report;
use Illuminate\Http\Response;
use App\Models\Reports\ReportType;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Http\Resources\SearchCollection;
use App\Http\Requests\Report\FetchRequest;
use App\Http\Resources\Report\ReportResource;
use App\Http\Requests\Report\StoreReportRequest;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\Report\UpdateReportRequest;
use App\Repositories\Contracts\IReportRepositoryContract;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportController extends Controller
{
    /**
     * @var IReportRepositoryContract
     */
    private $repository;

    /**
     * ChequeController constructor.
     *
     * @param IReportRepositoryContract $repository [description]
     */
    public function __construct(IReportRepositoryContract $repository) {
        $this->repository = $repository;
    }

    /**
     * Get all Reports
     * @return AnonymousResourceCollection
     */
    public function fetchall() {
        return ReportResource::collection(Report::all());
    }

    /**
     * @param FetchRequest $request
     * @return SearchCollection
     */
    public function fetch(FetchRequest $request)
    {
        return new SearchCollection(
            $this->repository->search($request), ReportResource::class
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|void
     */
    public function index()
    {
        //dd(ReportResource::collection(Report::all()));
        $statuses = Status::all();
        $reporttypes = ReportType::all();

        return view('reports.index')
            ->with('perPage', new \Illuminate\Support\Collection(config('system.per_page')))
            ->with('defaultPerPage', config('system.default_per_page'))
            ->with('statuses', $statuses)
            ->with('reporttypes', $reporttypes)
            ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreReportRequest $request
     * @return ReportResource|void
     */
    public function store(StoreReportRequest $request)
    {
        $report = Report::createNew($request->title,$request->reporttype,$request->description);
        return new ReportResource($report);
    }

    /**
     * Display the specified resource.
     *
     * @param Report $report
     * @return Application|Factory|View|void
     */
    public function show(Report $report)
    {
        return view('reports.show')
            ->with('report', new ReportResource($report))
            ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Report $report
     * @return Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReportRequest $request
     * @param Report $report
     * @return void
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Report $report
     * @return void
     */
    public function destroy(Report $report)
    {
        //
    }
}
