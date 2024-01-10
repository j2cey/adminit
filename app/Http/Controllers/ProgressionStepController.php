<?php

namespace App\Http\Controllers;

use App\Models\Progression\ProgressionStep;
use App\Http\Requests\StoreProgressionStepRequest;
use App\Http\Requests\UpdateProgressionStepRequest;

class ProgressionStepController extends Controller
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
     * @param  \App\Http\Requests\StoreProgressionStepRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProgressionStepRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Progression\ProgressionStep  $progressionStep
     * @return \Illuminate\Http\Response
     */
    public function show(ProgressionStep $progressionStep)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Progression\ProgressionStep  $progressionStep
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgressionStep $progressionStep)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProgressionStepRequest  $request
     * @param  \App\Models\Progression\ProgressionStep  $progressionStep
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProgressionStepRequest $request, ProgressionStep $progressionStep)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Progression\ProgressionStep  $progressionStep
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgressionStep $progressionStep)
    {
        //
    }
}
