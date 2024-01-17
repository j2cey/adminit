<?php

namespace App\Http\Controllers\JobAndQueue;

use App\Models\Jobs\LaunchedJob;
use App\Http\Controllers\Controller;
use App\Http\Requests\LaunchedJob\StoreLaunchedJobRequest;
use App\Http\Requests\LaunchedJob\UpdateLaunchedJobRequest;

class LaunchedJobController extends Controller
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
     * @param  \App\Http\Requests\LaunchedJob\StoreLaunchedJobRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLaunchedJobRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jobs\LaunchedJob  $launchedJob
     * @return \Illuminate\Http\Response
     */
    public function show(LaunchedJob $launchedJob)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jobs\LaunchedJob  $launchedJob
     * @return \Illuminate\Http\Response
     */
    public function edit(LaunchedJob $launchedJob)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\LaunchedJob\UpdateLaunchedJobRequest  $request
     * @param  \App\Models\Jobs\LaunchedJob  $launchedJob
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLaunchedJobRequest $request, LaunchedJob $launchedJob)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jobs\LaunchedJob  $launchedJob
     * @return \Illuminate\Http\Response
     */
    public function destroy(LaunchedJob $launchedJob)
    {
        //
    }
}
