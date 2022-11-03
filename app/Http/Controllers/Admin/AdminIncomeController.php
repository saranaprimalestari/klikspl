<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AdminIncomeController extends Controller
{
    public function index()
    {
        $incomeValues = Order::where('order_status','like','%selesai%')->select(DB::raw('sum(courier_price + total_price + unique_code - discount) as total_income'))->first()->total_income;
        
        $incomeThisMonth = Order::where('order_status','like','%selesai%')->whereYear('updated_at','=',date('Y'))->whereMonth('updated_at','=',date('m'))->select(DB::raw('sum(courier_price + total_price + unique_code - discount) as total_income'))->first()->total_income;
        
        $incomePerMonth = Order::where('order_status','like','%selesai%')->select("id",DB::raw('sum(courier_price + total_price + unique_code - discount) as total_income_per_month'),DB::raw("(payment_method_id) as payment_method"),DB::raw("DATE_FORMAT(updated_at, '%Y-%m') as month_year_income")
        )->orderBy('updated_at')->groupBy(DB::raw("DATE_FORMAT(updated_at, '%Y-%m')"))->get();

        $incomePerPaymentMethod = Order::with('paymentmethod')->where('order_status','like','%selesai%')->select("id",DB::raw('sum(courier_price + total_price + unique_code - discount) as total_income_per_payment_method'),DB::raw("(payment_method_id)"))->orderBy('updated_at')->groupBy('payment_method_id')->get();
        
        // dd($incomePerPaymentMethod);
        // dd($incomePerMonth);
        // dd(Carbon::parse($incomePerMonth[1]->month_year)->isoFormat('MMMM Y'));
        $orders = Order::where('order_status','like','%selesai%')->get();
        $ordersThisMonth =  Order::where('order_status','like','%selesai%')->whereYear('updated_at','=',date('Y'))->whereMonth('updated_at','=',date('m'))->get();
        
        $allOrders = Order::withTrashed()->get();
        // dd($allOrders);

        // dd($orders);
        // dd(date('Y'));
        // dd($orderThisMonth);
        // dd($incomeValues);
        // dd($incomeThisMonth);
        return view ('admin.finance.income',[
            'title' => 'Penghasilan Saya',
            'active' => 'income',
            'incomeValues' => $incomeValues,
            'incomeThisMonth' => $incomeThisMonth,
            'incomesPerMonth' => $incomePerMonth,
            'incomesPerPaymentMethod' => $incomePerPaymentMethod,
            'orders' => $orders,
            'ordersThisMonth' => $ordersThisMonth,
        ]);
    }
}
