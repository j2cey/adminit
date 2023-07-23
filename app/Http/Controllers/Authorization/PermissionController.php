<?php

namespace App\Http\Controllers\Authorization;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Models\Authorization\Permission;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;

class PermissionController extends Controller
{
    public function fetch(Request $request)
    {
        return Permission::whereNull('deleted_at')->orderBy('name','ASC')->get();
    }

    public function fetchall()
    {
        return Permission::whereNull('deleted_at')->orderBy('name','ASC')->get();
    }

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
     * @param StorePermissionRequest $request
     * @return Builder|Model|Response
     */
    public function store(StorePermissionRequest $request)
    {
        return Permission::create([
            'name' => $request->name,
            'level' => $request->level,
            'description' => $request->description,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePermissionRequest $request
     * @param Permission $permission
     * @return Permission|Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update([
            'name' => $request->name,
            'level' => $request->level,
            'guard_name' => $request->guard_name,
            'description' => $request->description,
        ]);

        return $permission;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     * @return JsonResponse|Response
     */
    public function destroy(Permission $permission)
    {
        $data = ["success" => $permission->forceDelete()];

        return response()->json($data);
    }

    public function permissions() {
        return Permission::all();
    }
}
