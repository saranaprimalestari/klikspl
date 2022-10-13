<?php

namespace App\Http\Controllers\Admin\WarehouseLogistic;

use App\Models\Order;
use App\Models\Promo;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminOrderController;

class WarehouseLogisticHomeController extends Controller
{
    protected $adminOrderController;
    public function __construct(AdminOrderController $adminOrderController)
    {
        $this->middleware('adminMiddle');
        $this->adminOrderController = $adminOrderController->expiredCheck(); 
    }
    public function index(Request $request)
    {
        // dd(Order::where('order_status','=', 'pesanan disiapkan')->get());
        return view('admin.home',[
            'title' => 'Admin Dashboard',
            'active' => 'dashboard',
            'cartItems' => CartItem::all(),
            'waitingPayment' => Order::where('order_status','=', 'belum bayar')->get(),
            'confrimPayment' => Order::where('order_status','=', 'pesanan dibayarkan')->get(),
            'mustBeProcess' => Order::where('order_status','=', 'pembayaran dikonfirmasi')->get(),
            'mustBeSent' => Order::where('order_status','=', 'pesanan disiapkan')->get(),
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
        ]);
    }
}
