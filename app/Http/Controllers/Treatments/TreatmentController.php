<?php

namespace App\Http\Controllers\Treatments;

use Illuminate\Contracts\View\View;
use App\Models\Treatments\Treatment;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Resources\Treatments\TreatmentResource;
use App\Http\Requests\Treatment\StoreTreatmentRequest;
use App\Http\Resources\Treatments\TreatmentCollection;
use App\Http\Requests\Treatment\UpdateTreatmentRequest;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $treatments = TreatmentResource::collection(Treatment::isMain()->get());

        $waiting_count = Treatment::isMain()->waiting()->count();
        $queued_count = Treatment::isMain()->queued()->count();
        $running_count = Treatment::isMain()->running()->count();
        $retrying_count = Treatment::isMain()->retrying()->count();
        $success_count = Treatment::isMain()->success()->count();
        $failed_count = Treatment::isMain()->failed()->count();

        //dd($treatments[0]->subs_success_count);

        return view('treatments.index')
            ->with('treatments', $treatments)
            ->with('waiting_count', $waiting_count)
            ->with('queued_count', $queued_count)
            ->with('running_count', $running_count)
            ->with('retrying_count', $retrying_count)
            ->with('success_count', $success_count)
            ->with('failed_count', $failed_count)
            ;
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
     * @param  \App\Http\Requests\Treatment\StoreTreatmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTreatmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Treatment $treatment
     * @return Application|Factory|View
     */
    public function show(Treatment $treatment)
    {
        $subtreatments = new TreatmentCollection($treatment->subtreatments()->get());
        $treatment = new TreatmentResource($treatment);

        //dd($subtreatments->collection);

        return view('treatments.show')
            ->with('treatment', $treatment)
            ->with('subtreatments', $subtreatments->collection)
            ;
    }

    public function subs($id) {
        $treatment = Treatment::getById($id);
        if ( $treatment->subsRunningCount > 0 || $treatment->subsRetryingCount ) {
            $lastsusbs = ($treatment->subtreatments()->runningOrRetrying()->count() > 0) ? TreatmentResource::collection($treatment->subtreatments()->runningOrRetrying()->get()) : [];
        } else {
            $lastsusbs = $treatment->lastestsubtreatment ? [new TreatmentResource($treatment->lastestsubtreatment)] : [];
        }

        if ($treatment) {
            $waiting_count = $treatment->subsWaitingCount;
            $queued_count = $treatment->subsQueuedCount;
            $running_count = $treatment->subsRunningCount;
            $retrying_count = $treatment->subsRetryingCount;
            $success_count = $treatment->subsSuccessCount;
            $failed_count = $treatment->subsFailedCount;

            return ['lastsusbs'=>$lastsusbs,'waiting_count'=>$waiting_count,'queued_count'=>$queued_count,'running_count'=>$running_count,'retrying_count'=>$retrying_count,'success_count'=>$success_count,'failed_count'=>$failed_count];
        } else {
            return [];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Treatment $treatment
     * @return \Illuminate\Http\Response
     */
    public function edit(Treatment $treatment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Treatment\UpdateTreatmentRequest  $request
     * @param Treatment $treatment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTreatmentRequest $request, Treatment $treatment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Treatment $treatment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Treatment $treatment)
    {
        //
    }
}
