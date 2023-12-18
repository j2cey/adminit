<?php

namespace App\Http\Controllers;

use App\Models\Jobs\JobLauncher;
use App\Http\Requests\StoreJobLauncherRequest;
use App\Http\Requests\UpdateJobLauncherRequest;

class JobLauncherController extends Controller
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
     * @param  \App\Http\Requests\StoreJobLauncherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobLauncherRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jobs\JobLauncher  $jobLauncher
     * @return \Illuminate\Http\Response
     */
    public function show(JobLauncher $jobLauncher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jobs\JobLauncher  $jobLauncher
     * @return \Illuminate\Http\Response
     */
    public function edit(JobLauncher $jobLauncher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJobLauncherRequest  $request
     * @param  \App\Models\Jobs\JobLauncher  $jobLauncher
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJobLauncherRequest $request, JobLauncher $jobLauncher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jobs\JobLauncher  $jobLauncher
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobLauncher $jobLauncher)
    {
        //
    }
}
