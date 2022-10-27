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
        // dd(auth()->guard('adminMiddle')->user()->adminsenderaddress);
        // dd(auth()->guard('adminMiddle')->user()->admin_type);
        // dd(Order::where('order_status','=', 'pesanan disiapkan')->get());
        return view('admin.home',[
            'title' => 'Admin Dashboard',
            'active' => 'dashboard',
            'cartItems' => CartItem::all(),
            'waitingPayment' => Order::where('order_status','=', 'belum bayar')->where(['sender_address_id' => function($query){
                $query->select('sender_address_id')
                ->from('admin_sender_addresses')
                ->whereColumn('sender_address_id', 'orders.sender_address_id')
                ->where('admin_id','=', auth()->guard('adminMiddle')->user()->id);
            }])->get(),
            'confirmPayment' => Order::where('order_status','=', 'pesanan dibayarkan')->where(['sender_address_id' => function($query){
                $query->select('sender_address_id')
                ->from('admin_sender_addresses')
                ->whereColumn('sender_address_id', 'orders.sender_address_id')
                ->where('admin_id','=', auth()->guard('adminMiddle')->user()->id);
            }])->get(),
            'mustBeProcess' => Order::where('order_status','=', 'pembayaran dikonfirmasi')->where(['sender_address_id' => function($query){
                $query->select('sender_address_id')
                ->from('admin_sender_addresses')
                ->whereColumn('sender_address_id', 'orders.sender_address_id')
                ->where('admin_id','=', auth()->guard('adminMiddle')->user()->id);
            }])->get(),
            'mustBeSent' => Order::where('order_status','=', 'pesanan disiapkan')->where(['sender_address_id' => function($query){
                $query->select('sender_address_id')
                ->from('admin_sender_addresses')
                ->whereColumn('sender_address_id', 'orders.sender_address_id')
                ->where('admin_id','=', auth()->guard('adminMiddle')->user()->id);
            }])->get(),
            'onDelivery' => Order::where('order_status','=', 'dalam pengiriman')->where(['sender_address_id' => function($query){
                $query->select('sender_address_id')
                ->from('admin_sender_addresses')
                ->whereColumn('sender_address_id', 'orders.sender_address_id')
                ->where('admin_id','=', auth()->guard('adminMiddle')->user()->id);
            }])->get(),
            'arrive' => Order::where('order_status','=', 'sampai tujuan')->where(['sender_address_id' => function($query){
                $query->select('sender_address_id')
                ->from('admin_sender_addresses')
                ->whereColumn('sender_address_id', 'orders.sender_address_id')
                ->where('admin_id','=', auth()->guard('adminMiddle')->user()->id);
            }])->get(),
            'canceled' => Order::withTrashed()->where(['sender_address_id' => function($query){
                $query->select('sender_address_id')
                ->from('admin_sender_addresses')
                ->whereColumn('sender_address_id', 'orders.sender_address_id')
                ->where('admin_id','=', auth()->guard('adminMiddle')->user()->id);
            }])->where('order_status','=', 'expired')->orWhere('order_status','=', 'pesanan dibatalkan')->get(),
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
