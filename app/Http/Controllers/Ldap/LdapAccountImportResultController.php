<?php

namespace App\Http\Controllers\Ldap;

use App\Http\Controllers\Controller;
use App\Models\LdapAccountImportResult;
use App\Http\Requests\LdapAccountImportResult\StoreLdapAccountImportResultRequest;
use App\Http\Requests\LdapAccountImportResult\UpdateLdapAccountImportResultRequest;

class LdapAccountImportResultController extends Controller
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
     * @param  \App\Http\Requests\LdapAccountImportResult\StoreLdapAccountImportResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLdapAccountImportResultRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LdapAccountImportResult  $ldapAccountImportResult
     * @return \Illuminate\Http\Response
     */
    public function show(LdapAccountImportResult $ldapAccountImportResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LdapAccountImportResult  $ldapAccountImportResult
     * @return \Illuminate\Http\Response
     */
    public function edit(LdapAccountImportResult $ldapAccountImportResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\LdapAccountImportResult\UpdateLdapAccountImportResultRequest  $request
     * @param  \App\Models\LdapAccountImportResult  $ldapAccountImportResult
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLdapAccountImportResultRequest $request, LdapAccountImportResult $ldapAccountImportResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LdapAccountImportResult  $ldapAccountImportResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(LdapAccountImportResult $ldapAccountImportResult)
    {
        //
    }
}
