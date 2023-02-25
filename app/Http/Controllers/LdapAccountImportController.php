<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLdapAccountImportRequest;
use App\Http\Requests\UpdateLdapAccountImportRequest;
use App\Models\LdapAccountImport;

class LdapAccountImportController extends Controller
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
     * @param  \App\Http\Requests\StoreLdapAccountImportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLdapAccountImportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LdapAccountImport  $ldapAccountImport
     * @return \Illuminate\Http\Response
     */
    public function show(LdapAccountImport $ldapAccountImport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LdapAccountImport  $ldapAccountImport
     * @return \Illuminate\Http\Response
     */
    public function edit(LdapAccountImport $ldapAccountImport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLdapAccountImportRequest  $request
     * @param  \App\Models\LdapAccountImport  $ldapAccountImport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLdapAccountImportRequest $request, LdapAccountImport $ldapAccountImport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LdapAccountImport  $ldapAccountImport
     * @return \Illuminate\Http\Response
     */
    public function destroy(LdapAccountImport $ldapAccountImport)
    {
        //
    }
}
