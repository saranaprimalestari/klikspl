<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminStatisticController extends Controller
{
    public function index()
    {
        $visitorPerMonth = Visitor::select("id",DB::raw('count(id) as visitor_per_month'),DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month_year"))->orderBy('created_at')->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))->get();

        $incomePerMonth = Order::where('order_status','like','%selesai%')->select("id",DB::raw('sum(courier_price + total_price + unique_code - discount) as total_income_per_month'),DB::raw("(payment_method_id) as payment_method"),DB::raw("DATE_FORMAT(updated_at, '%Y-%m') as month_year_income")
        )->orderBy('updated_at')->groupBy(DB::raw("DATE_FORMAT(updated_at, '%Y-%m')"))->get();
        
        return view('admin.statistic.index',[
            'title' => 'Statistik',
            'active' => 'statistic',
            'visitorPerMonth' => $visitorPerMonth,
            'incomePerMonth' => $incomePerMonth,
        ]);
    }
}
