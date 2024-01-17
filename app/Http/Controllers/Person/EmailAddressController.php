<?php

namespace App\Http\Controllers\Person;

use App\Models\Person\EmailAddress;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmailAddress\StoreEmailAddressRequest;
use App\Http\Requests\EmailAddress\UpdateEmailAddressRequest;

class EmailAddressController extends Controller
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
     * @param  \App\Http\Requests\EmailAddress\StoreEmailAddressRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmailAddressRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person\EmailAddress  $emailAddress
     * @return \Illuminate\Http\Response
     */
    public function show(EmailAddress $emailAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person\EmailAddress  $emailAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailAddress $emailAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EmailAddress\UpdateEmailAddressRequest  $request
     * @param  \App\Models\Person\EmailAddress  $emailAddress
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmailAddressRequest $request, EmailAddress $emailAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\EmailAddress  $emailAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailAddress $emailAddress)
    {
        //
    }
}
