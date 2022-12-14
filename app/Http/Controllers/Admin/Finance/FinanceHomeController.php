<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Models\Order;
use App\Models\Promo;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AdminOrderController;

class FinanceHomeController extends Controller
{
    protected $adminOrderController;
    public function __construct(AdminOrderController $adminOrderController)
    {
        $this->middleware('adminMiddle');
        $this->adminOrderController = $adminOrderController->expiredCheck(); 
    }
    public function index(Request $request, HomeController $homeController)
    {
        
        $incomeValues = Order::where('order_status', 'like', '%selesai%')->select(DB::raw('sum(courier_price + total_price + unique_code - discount) as total_income'))->first()->total_income;

        $incomeThisMonth = Order::where('order_status', 'like', '%selesai%')->whereYear('updated_at', '=', date('Y'))->whereMonth('updated_at', '=', date('m'))->select(DB::raw('sum(courier_price + total_price + unique_code - discount) as total_income'))->first()->total_income;

        $incomePerMonth = Order::where('order_status','like','%selesai%')->select("id",DB::raw('sum(courier_price + total_price + unique_code - discount) as total_income_per_month'),DB::raw("(payment_method_id) as payment_method"),DB::raw("DATE_FORMAT(updated_at, '%Y-%m') as month_year_income")
        )->orderBy('updated_at')->groupBy(DB::raw("DATE_FORMAT(updated_at, '%Y-%m')"))->get();

        return view('admin.home',[
            'title' => 'Admin Dashboard',
            'active' => 'dashboard',
            'cartItems' => CartItem::all(),
            'waitingPayment' => Order::where('order_status','=', 'belum bayar')->get(),
            'confirmPayment' => Order::where('order_status','=', 'pesanan dibayarkan')->get(),
            'mustBeProcess' => Order::where('order_status','=', 'pembayaran dikonfirmasi')->get(),
            'mustBeSent' => Order::where('order_status','=', 'perlu dikirim')->get(),
            'onDelivery' => Order::where('order_status','=', 'dalam pengiriman')->get(),
            'arrive' => Order::where('order_status','=', 'sampai tujuan')->get(),
            'canceled' => Order::withTrashed()->where('order_status','=', 'expired')->orWhere('order_status','=', 'pesanan dibatalkan')->get(),
            'outStock' => Product::with(['productvariant' => fn ($query) => $query->where('stock', '=', '0')])
            ->whereHas(
                'productvariant',
                fn ($query) =>
                $query->where('stock', '=', '0')
            )->orWhere('stock','=','0')
            ->get(),
            'activedPromo' => Promo::where('is_active','=',1)->get(),
            'orderStatistics' => Order::all(),
            'incomePerMonth' => $incomePerMonth,
            'incomeValues' => $incomeValues,
            'incomeThisMonth' => $incomeThisMonth,
        ]);
    }
}
