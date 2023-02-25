<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLdapAccountRequest;
use App\Http\Requests\UpdateLdapAccountRequest;
use App\Models\LdapAccount;

class LdapAccountController extends Controller
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
     * @param  \App\Http\Requests\StoreLdapAccountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLdapAccountRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LdapAccount  $ldapAccount
     * @return \Illuminate\Http\Response
     */
    public function show(LdapAccount $ldapAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LdapAccount  $ldapAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(LdapAccount $ldapAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLdapAccountRequest  $request
     * @param  \App\Models\LdapAccount  $ldapAccount
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLdapAccountRequest $request, LdapAccount $ldapAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LdapAccount  $ldapAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(LdapAccount $ldapAccount)
    {
        //
    }
}
