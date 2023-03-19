<?php

namespace App\Http\Controllers\Access;

use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use App\Models\Access\AccessAccount;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Http\Resources\AccessAccountResource;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\AccessAccount\StoreAccessAccountRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\AccessAccount\UpdateAccessAccountRequest;

class AccessAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function fetch()
    {
        $accessaccounts = AccessAccount::all();

        return AccessAccountResource::collection($accessaccounts);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $accessaccounts = AccessAccountResource::collection(AccessAccount::all());

        return view('accessaccounts.index')
            ->with('accessaccounts', $accessaccounts)
            ;
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
     * @param StoreAccessAccountRequest $request
     * @return AccessAccountResource
     */
    public function store(StoreAccessAccountRequest $request): AccessAccountResource
    {
        $accessaccount = AccessAccount::createNew($request->login, $request->pwd, $request->email, $request->username, $request->status, $request->description);

        return new AccessAccountResource($accessaccount);
    }

    /**
     * Display the specified resource.
     *
     * @param AccessAccount $accessaccount
     * @return Response
     */
    public function show(AccessAccount $accessaccount)
    {
        dd("accessaccounts.show: ",$accessaccount);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AccessAccount $accessaccount
     * @return Response
     */
    public function edit(AccessAccount $accessaccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAccessAccountRequest $request
     * @param AccessAccount $accessaccount
     * @return AccessAccountResource
     */
    public function update(UpdateAccessAccountRequest $request, AccessAccount $accessaccount)
    {
        $accessaccount->updateOne($request->login, $request->pwd, $request->email, $request->username, $request->status, $request->description);

        return new AccessAccountResource($accessaccount);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AccessAccount $accessaccount
     * @return Response
     */
    public function destroy(AccessAccount $accessaccount)
    {
        $accessaccount->delete();

        return response('Delete Successfull', 200);
    }

}
