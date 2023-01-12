<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::where('is_active','=',1)->get();

        return view('payment-method-available',[
            'title' => 'Metode Pembayaran',
            'active' => 'payment-method',
            'paymentMethods' => $paymentMethods
        ]);

    }
}
