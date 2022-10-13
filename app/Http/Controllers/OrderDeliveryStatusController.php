<?php

namespace App\Http\Controllers;

use App\Models\OrderDeliveryStatus;
use App\Http\Requests\StoreOrderDeliveryStatusRequest;
use App\Http\Requests\UpdateOrderDeliveryStatusRequest;

class OrderDeliveryStatusController extends Controller
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
     * @param  \App\Http\Requests\StoreOrderDeliveryStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderDeliveryStatusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderDeliveryStatus  $orderDeliveryStatus
     * @return \Illuminate\Http\Response
     */
    public function show(OrderDeliveryStatus $orderDeliveryStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderDeliveryStatus  $orderDeliveryStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderDeliveryStatus $orderDeliveryStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderDeliveryStatusRequest  $request
     * @param  \App\Models\OrderDeliveryStatus  $orderDeliveryStatus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderDeliveryStatusRequest $request, OrderDeliveryStatus $orderDeliveryStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderDeliveryStatus  $orderDeliveryStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderDeliveryStatus $orderDeliveryStatus)
    {
        //
    }
}
