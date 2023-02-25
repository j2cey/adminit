<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Resources\StatusResource;
use App\Http\Requests\Status\UpdateStatusRequest;
use App\Http\Requests\Status\ModelUpdateStatusRequest;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    public function fetch() {
        return StatusResource::collection(Status::all());
    }

    public function fetchone($id) {
        return Status::where('id', $id)->first();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Status $status
     * @return void
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Status $status
     * @return void
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStatusRequest $request
     * @param Status $status
     * @return Status
     */
    public function update(UpdateStatusRequest $request, Status $status)
    {
        $status->update([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $status->setDefault($request->is_default);

        return $status;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Status $status
     * @return void
     */
    public function destroy(Status $status)
    {
        //
    }

    public function modelupdate(ModelUpdateStatusRequest $request)
    {
        $request->model->status()->associate($request->status)->save();

        return new StatusResource($request->status);
    }
}
