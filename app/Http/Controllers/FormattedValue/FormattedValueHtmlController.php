<?php

namespace App\Http\Controllers\FormattedValue;

use App\Http\Controllers\Controller;
use App\Models\FormattedValue\FormattedValueHtml;
use App\Http\Requests\FormattedValueHtml\StoreFormattedValueHtmlRequest;
use App\Http\Requests\FormattedValueHtml\UpdateFormattedValueHtmlRequest;

class FormattedValueHtmlController extends Controller
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
     * @param  \App\Http\Requests\FormattedValueHtml\StoreFormattedValueHtmlRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormattedValueHtmlRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FormattedValue\FormattedValueHtml  $formattedValueHtml
     * @return \Illuminate\Http\Response
     */
    public function show(FormattedValueHtml $formattedValueHtml)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FormattedValue\FormattedValueHtml  $formattedValueHtml
     * @return \Illuminate\Http\Response
     */
    public function edit(FormattedValueHtml $formattedValueHtml)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\FormattedValueHtml\UpdateFormattedValueHtmlRequest  $request
     * @param  \App\Models\FormattedValue\FormattedValueHtml  $formattedValueHtml
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormattedValueHtmlRequest $request, FormattedValueHtml $formattedValueHtml)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FormattedValue\FormattedValueHtml  $formattedValueHtml
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormattedValueHtml $formattedValueHtml)
    {
        //
    }
}
