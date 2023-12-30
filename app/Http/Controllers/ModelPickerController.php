<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModelPickerRequest;
use App\Http\Requests\UpdateModelPickerRequest;
use App\Models\ModelPicker;

class ModelPickerController extends Controller
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
     * @param  \App\Http\Requests\StoreModelPickerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModelPickerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ModelPicker  $modelPicker
     * @return \Illuminate\Http\Response
     */
    public function show(ModelPicker $modelPicker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModelPicker  $modelPicker
     * @return \Illuminate\Http\Response
     */
    public function edit(ModelPicker $modelPicker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateModelPickerRequest  $request
     * @param  \App\Models\ModelPicker  $modelPicker
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateModelPickerRequest $request, ModelPicker $modelPicker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ModelPicker  $modelPicker
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelPicker $modelPicker)
    {
        //
    }
}