<?php

namespace App\Http\Controllers\Treatments;

use App\Http\Controllers\Controller;
use App\Models\Format\FormattingResult;
use App\Http\Requests\FormattingResult\StoreFormattingResultRequest;
use App\Http\Requests\FormattingResult\UpdateFormattingResultRequest;

class FormattingResultController extends Controller
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
     * @param  \App\Http\Requests\FormattingResult\StoreFormattingResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormattingResultRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Format\FormattingResult  $formattingResult
     * @return \Illuminate\Http\Response
     */
    public function show(FormattingResult $formattingResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Format\FormattingResult  $formattingResult
     * @return \Illuminate\Http\Response
     */
    public function edit(FormattingResult $formattingResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\FormattingResult\UpdateFormattingResultRequest  $request
     * @param  \App\Models\Format\FormattingResult  $formattingResult
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormattingResultRequest $request, FormattingResult $formattingResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Format\FormattingResult  $formattingResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormattingResult $formattingResult)
    {
        //
    }
}
