<?php

namespace App\Http\Controllers\FormattedValue;

use App\Http\Controllers\Controller;
use App\Models\FormattedValue\FormattedValueSms;
use App\Http\Requests\FormattedValueSms\StoreFormattedValueSmsRequest;
use App\Http\Requests\FormattedValueSms\UpdateFormattedValueSmsRequest;

class FormattedValueSmsController extends Controller
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
     * @param  \App\Http\Requests\FormattedValueSms\StoreFormattedValueSmsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormattedValueSmsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FormattedValue\FormattedValueSms  $formattedValueSms
     * @return \Illuminate\Http\Response
     */
    public function show(FormattedValueSms $formattedValueSms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FormattedValue\FormattedValueSms  $formattedValueSms
     * @return \Illuminate\Http\Response
     */
    public function edit(FormattedValueSms $formattedValueSms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\FormattedValueSms\UpdateFormattedValueSmsRequest  $request
     * @param  \App\Models\FormattedValue\FormattedValueSms  $formattedValueSms
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormattedValueSmsRequest $request, FormattedValueSms $formattedValueSms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FormattedValue\FormattedValueSms  $formattedValueSms
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormattedValueSms $formattedValueSms)
    {
        //
    }
}
