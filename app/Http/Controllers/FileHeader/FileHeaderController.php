<?php

namespace App\Http\Controllers\FileHeader;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\FileHeader\FileHeader;
use App\Http\Resources\FileHeader\FileHeaderResource;
use App\Http\Requests\FileHeader\StoreFileHeaderRequest;
use App\Http\Requests\FileHeader\UpdateFileHeaderRequest;

class FileHeaderController extends Controller
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
     * @param StoreFileHeaderRequest $request
     * @return FileHeaderResource
     */
    public function store(StoreFileHeaderRequest $request)
    {
        $fileheader = $request->model->setFileheader(
            $request->title,
            $request->status,
            $request->description,
        );
        return new FileHeaderResource($fileheader);
    }

    /**
     * Display the specified resource.
     *
     * @param FileHeader $fileheader
     * @return Response
     */
    public function show(FileHeader $fileheader)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FileHeader $fileheader
     * @return Response
     */
    public function edit(FileHeader $fileheader)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFileHeaderRequest $request
     * @param FileHeader $fileheader
     * @return FileHeaderResource
     */
    public function update(UpdateFileHeaderRequest $request, FileHeader $fileheader)
    {
        $fileheader->updateThis(
            $request->title, $request->status,$request->description
        );

        return new FileHeaderResource($fileheader);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FileHeader $fileheader
     * @return JsonResponse
     */
    public function destroy(FileHeader $fileheader)
    {
        $fileheader->delete();

        return response()->json(['status' => 'ok'], 200);
    }
}
