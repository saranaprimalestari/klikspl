<?php

namespace App\Http\Controllers;

use App\Models\SenderAddress;
use App\Http\Requests\StoreSenderAddressRequest;
use App\Http\Requests\UpdateSenderAddressRequest;
use Illuminate\Http\Request;

class SenderAddressController extends Controller
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
     * @param  \App\Http\Requests\StoreSenderAddressRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SenderAddress  $senderAddress
     * @return \Illuminate\Http\Response
     */
    public function show(SenderAddress $senderAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SenderAddress  $senderAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(SenderAddress $senderAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSenderAddressRequest  $request
     * @param  \App\Models\SenderAddress  $senderAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SenderAddress $senderAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SenderAddress  $senderAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(SenderAddress $senderAddress)
    {
        //
    }
}
