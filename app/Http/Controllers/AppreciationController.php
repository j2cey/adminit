<?php

namespace App\Http\Controllers;

use App\Models\Appreciation;
use Illuminate\Http\Request;

class AppreciationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appreciations = Appreciation::get();

        return $appreciations;
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
            $appreciation = Appreciation::where('id', $request->appreciation["id"])->first();
            $model->addAppreciation($appreciation);
            return $appreciation->load(['status']);
        }
        return response('Model not found', 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appreciation  $appreciation
     * @return \Illuminate\Http\Response
     */
    public function show(Appreciation $appreciation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appreciation  $appreciation
     * @return \Illuminate\Http\Response
     */
    public function edit(Appreciation $appreciation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appreciation  $appreciation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appreciation $appreciation)
    {
        $model_type = $request->model_type;
        $model = $model_type::where('id', $request->model_id)->first();
        if ($model) {
            $appreciation_sel = json_decode($request->appreciation, true);
            $appreciation = Appreciation::where('id', $appreciation_sel["id"])->first();
            $model->syncAppreciation([
                $appreciation->id => [
                    "model_type" => $request->model_type,
                    "model_id" => $request->model_id,
                ]
            ]);
            return $appreciation->load(['status']);
        }
        return response('Model not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appreciation  $appreciation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appreciation $appreciation)
    {
        //
    }
}
