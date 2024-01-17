<?php

namespace App\Http\Controllers\Progression;

use App\Http\Controllers\Controller;
use App\Models\Progression\ProgressionStep;
use App\Http\Requests\ProgressionStep\StoreProgressionStepRequest;
use App\Http\Requests\ProgressionStep\UpdateProgressionStepRequest;

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
     * @param  \App\Http\Requests\ProgressionStep\StoreProgressionStepRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProgressionStepRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Progression\ProgressionStep  $progressionstep
     * @return \Illuminate\Http\Response
     */
    public function show(ProgressionStep $progressionstep)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Progression\ProgressionStep  $progressionstep
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgressionStep $progressionstep)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProgressionStep\UpdateProgressionStepRequest  $request
     * @param  \App\Models\Progression\ProgressionStep  $progressionstep
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProgressionStepRequest $request, ProgressionStep $progressionstep)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Progression\ProgressionStep  $progressionstep
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgressionStep $progressionstep)
    {
        //
    }
}
