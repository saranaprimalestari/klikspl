<?php

namespace App\Http\Controllers;

use App\Models\AdminSenderAddress;
use App\Http\Requests\StoreAdminSenderAddressRequest;
use App\Http\Requests\UpdateAdminSenderAddressRequest;

class AdminSenderAddressController extends Controller
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
     * @param  \App\Http\Requests\StoreAdminSenderAddressRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminSenderAddressRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdminSenderAddress  $adminSenderAddress
     * @return \Illuminate\Http\Response
     */
    public function show(AdminSenderAddress $adminSenderAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdminSenderAddress  $adminSenderAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminSenderAddress $adminSenderAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdminSenderAddressRequest  $request
     * @param  \App\Models\AdminSenderAddress  $adminSenderAddress
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminSenderAddressRequest $request, AdminSenderAddress $adminSenderAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdminSenderAddress  $adminSenderAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminSenderAddress $adminSenderAddress)
    {
        //
    }
}
