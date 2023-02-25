<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubSubjectController extends Controller
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
        $new_subject = new Subject();
        $new_subject->title = $request->title;
        $new_subject->description = $request->description;
        $new_subject->save();

        $new_subject->setSubjectParent($request->subject_parent_id);

        return $new_subject->load(['status','tasks','tasks.status','tasks.subtasks','tasks.subtasks.status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $subject = Subject::where('uuid', $id)->first();
        $subject->title = $request->title;
        $subject->description = $request->description;
        $subject->save();

        $subject->setSubjectParent($request->subject_parent_id);

        return $subject->load(['status','tasks','tasks.status','tasks.subtasks','tasks.subtasks.status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Subject::where('uuid', $id)->first();
        $task->delete();
        return response('Delete Successfull', 200);
    }
}
