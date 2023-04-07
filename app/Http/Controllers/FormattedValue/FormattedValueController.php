<?php

namespace App\Http\Controllers\FormattedValue;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\FormattedValue\FormattedValue;
use App\Http\Resources\FormattedValue\FormattedValueResource;
use App\Http\Requests\FormattedValue\StoreFormattedValueRequest;
use App\Http\Requests\FormattedValue\UpdateFormattedValueRequest;

class FormattedValueController extends Controller
{
    public function fetch() {
        return FormattedValueResource::collection(FormattedValue::all());
    }

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
     * @param StoreFormattedValueRequest $request
     * @return FormattedValueResource
     */
    public function store(StoreFormattedValueRequest $request)
    {
        $formattedvalue = $request->model->setFormattedValue(
            $request->formattype,
            $request->title,
            $request->status,
            $request->description
        );
        return new FormattedValueResource($formattedvalue);
    }

    /**
     * Display the specified resource.
     *
     * @param FormattedValue $formattedvalue
     * @return \Illuminate\Http\Response
     */
    public function show(FormattedValue $formattedvalue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FormattedValue $formattedvalue
     * @return \Illuminate\Http\Response
     */
    public function edit(FormattedValue $formattedvalue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFormattedValueRequest $request
     * @param FormattedValue $formattedvalue
     * @return FormattedValueResource
     */
    public function update(UpdateFormattedValueRequest $request, FormattedValue $formattedvalue)
    {
        $formattedvalue->updateOne(
            $request->formattype,
            $request->title,
            $request->status,
            $request->description
        );

        return new FormattedValueResource($formattedvalue);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FormattedValue  $formattedvalue
     * @return JsonResponse
     */
    public function destroy(FormattedValue $formattedvalue)
    {
        $formattedvalue->delete();

        return response()->json(['status' => 'ok'], 200);
    }
}
