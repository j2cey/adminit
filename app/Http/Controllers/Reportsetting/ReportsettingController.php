<?php

namespace App\Http\Controllers\Reportsetting;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\OsAndServer\OsServer;
use App\Models\Access\AccessProtocole;
use Illuminate\Contracts\View\Factory;
use App\Models\ReportFile\FileMimeType;
use App\Models\ReportFile\ReportFileType;
use Illuminate\Contracts\Foundation\Application;

class ReportsettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $filemimetypes = FileMimetype::all();
        $reportfiletypes = ReportFileType::all()->load('filemimetype');
        $accessprotocoles = AccessProtocole::all();
        $osservers = OsServer::all();

        return view('reportsetting.index')
            ->with('filemimetypes', $filemimetypes)
            ->with('reportfiletypes', $reportfiletypes)
            ->with('accessprotocoles', $accessprotocoles)
            ->with('osservers', $osservers)
            ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('reportsetting.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
