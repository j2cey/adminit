<?php

namespace App\Http\Controllers\RetrieveAction;

use App\Http\Controllers\Controller;
use App\Models\RetrieveAction\RetrieveActionValue;
use App\Http\Requests\RetrieveActionValue\StoreRetrieveActionValueRequest;
use App\Http\Requests\RetrieveActionValue\UpdateRetrieveActionValueRequest;

class RetrieveActionValueController extends Controller
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
     * @param  \App\Http\Requests\RetrieveActionValue\StoreRetrieveActionValueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRetrieveActionValueRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RetrieveAction\RetrieveActionValue  $retrieveActionValue
     * @return \Illuminate\Http\Response
     */
    public function show(RetrieveActionValue $retrieveActionValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RetrieveAction\RetrieveActionValue  $retrieveActionValue
     * @return \Illuminate\Http\Response
     */
    public function edit(RetrieveActionValue $retrieveActionValue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RetrieveActionValue\UpdateRetrieveActionValueRequest  $request
     * @param  \App\Models\RetrieveAction\RetrieveActionValue  $retrieveActionValue
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRetrieveActionValueRequest $request, RetrieveActionValue $retrieveActionValue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RetrieveAction\RetrieveActionValue  $retrieveActionValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(RetrieveActionValue $retrieveActionValue)
    {
        //
    }
}
