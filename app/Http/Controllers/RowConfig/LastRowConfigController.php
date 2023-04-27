<?php

namespace App\Http\Controllers\RowConfig;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\RowConfig\LastRowConfig;
use App\Http\Resources\RowConfig\LastRowConfigResource;
use App\Http\Requests\LastRowConfig\StoreLastRowConfigRequest;
use App\Http\Requests\LastRowConfig\UpdateLastRowConfigRequest;

class LastRowConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLastRowConfigRequest $request
     * @return LastRowConfigResource
     */
    public function store(StoreLastRowConfigRequest $request)
    {
        $lastrowconfig = $request->model->setLastRowConfig(
            $request->ref_by_row_num,
            $request->row_num,
            $request->ref_by_attribute_value,
            $request->dynamicattribute,$request->attribute_value,
            $request->status,
            $request->description,
        );
        return new LastRowConfigResource($lastrowconfig);
    }

    /**
     * Display the specified resource.
     *
     * @param LastRowConfig $lastrowconfig
     * @return Response
     */
    public function show(LastRowConfig $lastrowconfig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LastRowConfig $lastrowconfig
     * @return Response
     */
    public function edit(LastRowConfig $lastrowconfig)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLastRowConfigRequest $request
     * @param LastRowConfig $lastrowconfig
     * @return LastRowConfigResource
     */
    public function update(UpdateLastRowConfigRequest $request, LastRowConfig $lastrowconfig)
    {
        $lastrowconfig->updateThis(
            $request->ref_by_row_num,
            $request->row_num,
            $request->ref_by_attribute_value,
            $request->dynamicattribute,$request->attribute_value,
            $request->status,
            $request->description,
        );

        return new LastRowConfigResource($lastrowconfig);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param LastRowConfig $lastrowconfig
     * @return JsonResponse
     */
    public function destroy(LastRowConfig $lastrowconfig)
    {
        $lastrowconfig->delete();

        return response()->json(['status' => 'ok'], 200);
    }
}
