<?php

namespace App\Http\Controllers;

use App\Models\OrderStatusDetail;
use App\Http\Requests\StoreOrderStatusDetailRequest;
use App\Http\Requests\UpdateOrderStatusDetailRequest;

class OrderStatusDetailController extends Controller
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
     * @param  \App\Http\Requests\StoreOrderStatusDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderStatusDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderStatusDetail  $orderStatusDetail
     * @return \Illuminate\Http\Response
     */
    public function show(OrderStatusDetail $orderStatusDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderStatusDetail  $orderStatusDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderStatusDetail $orderStatusDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderStatusDetailRequest  $request
     * @param  \App\Models\OrderStatusDetail  $orderStatusDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderStatusDetailRequest $request, OrderStatusDetail $orderStatusDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderStatusDetail  $orderStatusDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderStatusDetail $orderStatusDetail)
    {
        //
    }
}
