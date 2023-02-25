<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\Factory;
use App\Http\Resources\SearchCollection;
use App\Http\Requests\Subject\FetchRequest;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Resources\SubjectResource as SubjectResource;
use App\Http\Requests\Subject\CreateSubjectRequest;
use App\Repositories\Contracts\ISubjectRepositoryContract;

use Exception;
use \Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;

class SubjectController extends Controller
{
    /**
     * @var ISubjectRepositoryContract
     */
    private $repository;

    /**
     * ParticipantController constructor.
     *
     * @param ISubjectRepositoryContract $repository [description]
     */
    public function __construct(ISubjectRepositoryContract $repository) {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function index()
    {
        $statuts = Status::all();
        return view('subjects.index')
            ->with('perPage', new Collection(config('system.per_page')))
            ->with('defaultPerPage', config('system.default_per_page'))
            ->with('statuts', $statuts);
    }

    /**
     * Fetch records.
     *
     * @param  FetchRequest     $request [description]
     * @return SearchCollection          [description]
     */
    public function fetch(FetchRequest $request)
    {
        return new SearchCollection(
            $this->repository->search($request), SubjectResource::class
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function create()
    {
        return view('subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Subject
     */
    public function store(Request $request)
    {
        //dd($request->category["id"], $request->title);
        $new_subject = new Subject();
        $new_subject->title = $request->title;
        $new_subject->description = $request->description;
        $new_subject->save();

        $new_subject->setCategory($request->category["id"]);

        return $new_subject;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return Response
     */
    public function show(Subject $subject)
    {
        $subject->load(['category','subjectparent','tasks']);
        return view('subjects.show')
            ->with('subject', $subject);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return Response
     */
    public function edit(Subject $subject)
    {
        $subject->load(['category','subjectparent']);
        return view('subjects.edit')
            ->with('subject', $subject);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\Subject  $subject
     * @return Response
     */
    public function update(Request $request, Subject $subject)
    {
        //TODO: check if there is a selected category
        $category = json_decode($request->category, true);

        $subject->title = $request->title;
        $subject->description = $request->description;
        $subject->save();

        $subject->setCategory($category["id"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return Response
     */
    public function destroy(Subject $subject)
    {
        //
    }
}
