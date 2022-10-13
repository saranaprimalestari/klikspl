<?php

namespace App\Http\Controllers;

use App\Models\ProductOrigin;
use App\Http\Requests\StoreProductOriginRequest;
use App\Http\Requests\UpdateProductOriginRequest;

class ProductOriginController extends Controller
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
     * @param  \App\Http\Requests\StoreProductOriginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductOriginRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductOrigin  $productOrigin
     * @return \Illuminate\Http\Response
     */
    public function show(ProductOrigin $productOrigin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductOrigin  $productOrigin
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductOrigin $productOrigin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductOriginRequest  $request
     * @param  \App\Models\ProductOrigin  $productOrigin
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductOriginRequest $request, ProductOrigin $productOrigin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductOrigin  $productOrigin
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductOrigin $productOrigin)
    {
        //
    }
}
