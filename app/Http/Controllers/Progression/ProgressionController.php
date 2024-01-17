<?php

namespace App\Http\Controllers\Progression;

use App\Http\Controllers\Controller;
use App\Models\Progression\Progression;
use App\Http\Requests\Progression\StoreProgressionRequest;
use App\Http\Requests\Progression\UpdateProgressionRequest;

class ProgressionController extends Controller
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
     * @param  \App\Http\Requests\Progression\StoreProgressionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProgressionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  $progression
     * @return \Illuminate\Http\Response
     */
    public function show(Progression $progression)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $progression
     * @return \Illuminate\Http\Response
     */
    public function edit(Progression $progression)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Progression\UpdateProgressionRequest  $request
     * @param  $progression
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProgressionRequest $request, Progression $progression)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $progression
     * @return \Illuminate\Http\Response
     */
    public function destroy(Progression $progression)
    {
        //
    }
}
