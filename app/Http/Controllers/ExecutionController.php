<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Execution;
use App\Models\GradeUnit;
use Illuminate\Http\Request;

class ExecutionController extends Controller
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
            $execution = Execution::create([
                'title' => "exec for " . str_replace("\\", "_", $model_type) . " " . $model->id,
                'status_id' => Status::active()->first()->id,
            ]);
            $model->addExecution($execution);

            // set grade
            $unit = GradeUnit::where('id', $request->gradeunit['id'])->first();
            $execution->setGrade($request->gradevalue, $unit, "");

            // set duration
            $execution->setDuration($request->startat, "");

            // set progression
            $execution->setProgression($request->execprogression, "");

            return $execution->load(['status']);
        }
        return response('Model not found', 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Execution  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function show(Execution $evaluation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Execution  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(Execution $evaluation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Execution  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Execution $evaluation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Execution  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Execution $evaluation)
    {
        //
    }
}
