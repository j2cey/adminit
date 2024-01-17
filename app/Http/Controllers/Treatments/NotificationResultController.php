<?php

namespace App\Http\Controllers\Treatments;

use App\Http\Controllers\Controller;
use App\Models\Notify\NotificationResult;
use App\Http\Requests\NotificationResult\StoreNotificationResultRequest;
use App\Http\Requests\NotificationResult\UpdateNotificationResultRequest;

class NotificationResultController extends Controller
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
     * @param  \App\Http\Requests\NotificationResult\StoreNotificationResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationResultRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notify\NotificationResult  $notificationResult
     * @return \Illuminate\Http\Response
     */
    public function show(NotificationResult $notificationResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notify\NotificationResult  $notificationResult
     * @return \Illuminate\Http\Response
     */
    public function edit(NotificationResult $notificationResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\NotificationResult\UpdateNotificationResultRequest  $request
     * @param  \App\Models\Notify\NotificationResult  $notificationResult
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotificationResultRequest $request, NotificationResult $notificationResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notify\NotificationResult  $notificationResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationResult $notificationResult)
    {
        //
    }
}
