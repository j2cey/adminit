<?php

namespace App\Http\Controllers;

use App\Models\Difficulty;
use Illuminate\Http\Request;

class DifficultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $difficulties = Difficulty::get();

        return $difficulties;
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
            $difficulty = Difficulty::where('id', $request->difficulty["id"])->first();
            $model->addDifficulty($difficulty);
            return $difficulty->load(['status']);
        }
        return response('Model not found', 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Difficulty  $difficulty
     * @return \Illuminate\Http\Response
     */
    public function show(Difficulty $difficulty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Difficulty  $difficulty
     * @return \Illuminate\Http\Response
     */
    public function edit(Difficulty $difficulty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Difficulty  $difficulty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Difficulty $difficulty)
    {
        $model_type = $request->model_type;
        $model = $model_type::where('id', $request->model_id)->first();
        if ($model) {
            $difficulty_sel = json_decode($request->difficulty, true);
            $difficulty = Difficulty::where('id', $difficulty_sel["id"])->first();
            $model->syncDifficulty([
                $difficulty->id => [
                    "model_type" => $request->model_type,
                    "model_id" => $request->model_id,
                    ]
            ]);
            return $difficulty->load(['status']);
        }
        return response('Model not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Difficulty  $difficulty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Difficulty $difficulty)
    {
        //
    }
}
