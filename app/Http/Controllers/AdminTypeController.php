<?php

namespace App\Http\Controllers;

use App\Models\AdminType;
use App\Http\Requests\StoreAdminTypeRequest;
use App\Http\Requests\UpdateAdminTypeRequest;

class AdminTypeController extends Controller
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
     * @param  \App\Http\Requests\StoreAdminTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdminType  $adminType
     * @return \Illuminate\Http\Response
     */
    public function show(AdminType $adminType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdminType  $adminType
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminType $adminType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdminTypeRequest  $request
     * @param  \App\Models\AdminType  $adminType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminTypeRequest $request, AdminType $adminType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdminType  $adminType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminType $adminType)
    {
        //
    }
}
