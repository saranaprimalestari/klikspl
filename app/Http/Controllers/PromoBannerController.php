<?php

namespace App\Http\Controllers;

use App\Models\PromoBanner;
use App\Http\Requests\StorePromoBannerRequest;
use App\Http\Requests\UpdatePromoBannerRequest;

class PromoBannerController extends Controller
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
     * @param  \App\Http\Requests\StorePromoBannerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePromoBannerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PromoBanner  $promoBanner
     * @return \Illuminate\Http\Response
     */
    public function show(PromoBanner $promoBanner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PromoBanner  $promoBanner
     * @return \Illuminate\Http\Response
     */
    public function edit(PromoBanner $promoBanner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePromoBannerRequest  $request
     * @param  \App\Models\PromoBanner  $promoBanner
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePromoBannerRequest $request, PromoBanner $promoBanner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PromoBanner  $promoBanner
     * @return \Illuminate\Http\Response
     */
    public function destroy(PromoBanner $promoBanner)
    {
        //
    }
}
