<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use Illuminate\Http\Request;

class PriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $priorities = Priority::get();

        return $priorities;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function add(Request $request)
    {
        $model_type = $request->model_type;
        $model = $model_type::where('id', $request->model_id)->first();
        if ($model) {
            $priority = Priority::where('id', $request->priority["id"])->first();
            $model->addPriority($priority);
            return $priority->load(['status']);
        }
        return response('Model not found', 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Priority  $priority
     * @return \Illuminate\Http\Response
     */
    public function show(Priority $priority)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Priority  $priority
     * @return \Illuminate\Http\Response
     */
    public function edit(Priority $priority)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Priority  $priority
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Priority $priority)
    {
        $model_type = $request->model_type;
        $model = $model_type::where('id', $request->model_id)->first();
        if ($model) {
            $priority_sel = json_decode($request->priority, true);
            $priority = Priority::where('id', $priority_sel["id"])->first();
            $model->syncDifficulty([
                $priority->id => [
                    "model_type" => $request->model_type,
                    "model_id" => $request->model_id,
                ]
            ]);
            return $priority->load(['status']);
        }
        return response('Model not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Priority  $priority
     * @return \Illuminate\Http\Response
     */
    public function destroy(Priority $priority)
    {
        //
    }
}
