<?php

namespace App\Http\Controllers;

use App\Models\promo_payment_method;
use App\Http\Requests\Storepromo_payment_methodRequest;
use App\Http\Requests\Updatepromo_payment_methodRequest;

class PromoPaymentMethodController extends Controller
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
     * @param  \App\Http\Requests\Storepromo_payment_methodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storepromo_payment_methodRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\promo_payment_method  $promo_payment_method
     * @return \Illuminate\Http\Response
     */
    public function show(promo_payment_method $promo_payment_method)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\promo_payment_method  $promo_payment_method
     * @return \Illuminate\Http\Response
     */
    public function edit(promo_payment_method $promo_payment_method)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatepromo_payment_methodRequest  $request
     * @param  \App\Models\promo_payment_method  $promo_payment_method
     * @return \Illuminate\Http\Response
     */
    public function update(Updatepromo_payment_methodRequest $request, promo_payment_method $promo_payment_method)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\promo_payment_method  $promo_payment_method
     * @return \Illuminate\Http\Response
     */
    public function destroy(promo_payment_method $promo_payment_method)
    {
        //
    }
}
