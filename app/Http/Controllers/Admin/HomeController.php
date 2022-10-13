<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\PromoBanner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Admin\AdminOrderController;

class HomeController extends Controller
{

    protected $adminOrderController;
    public function __construct(AdminOrderController $adminOrderController)
    {
        $this->middleware('adminMiddle');
        $this->adminOrderController = $adminOrderController->expiredCheck();
        $this->promoVoucherExpiredCheck();
        $this->promoBannerExpiredCheck();
    }

    public function index()
    {
        // $this->superAdmin();

        // dd(auth()->guard('adminMiddle')->user());
        //    dd(Order::where('order_status','=', 'expired')->orwhere('order_status','=', 'pesanan dibatalkan')->get());
        // dd(Order::where('order_status', '=', 'selesai')->get());
        // dd(Order::where('order_status', '=', 'selesai')->whereIn('id', function ($query) {
        //     $query->select('order_id')->from(with(new OrderItem)->getTable())->where('is_review', '=', '1');
        // })->get());

        return view('admin.home', [
            'title' => 'Admin Dashboard',
            'active' => 'dashboard',
            'cartItems' => CartItem::all(),
            'waitingPayment' => Order::where('order_status', '=', 'belum bayar')->get(),
            'confrimPayment' => Order::where('order_status', '=', 'pesanan dibayarkan')->get(),
            'mustBeProcess' => Order::where('order_status', '=', 'pembayaran dikonfirmasi')->get(),
            'mustBeSent' => Order::where('order_status', '=', 'pesanan disiapkan')->get(),
            'onDelivery' => Order::where('order_status', '=', 'pesanan dikirim')->get(),
            'arrived' => Order::where('order_status', '=', 'selesai')->get(),
            'finish' => Order::where('order_status', '=', 'selesai')->whereIn('id', function ($query) {
                $query->select('order_id')->from(with(new OrderItem)->getTable())->where('is_review', '=', '1');
            })->get(),
            'canceled' => Order::withTrashed()->where('order_status', '=', 'expired')->orWhere('order_status', '=', 'pesanan dibatalkan')->get(),
            'outStock' => Product::with(['productvariant' => fn ($query) => $query->where('stock', '=', '0')])
                ->whereHas(
                    'productvariant',
                    fn ($query) =>
                    $query->where('stock', '=', '0')
                )->orWhere('stock', '=', '0')
                ->get(),
            'activedPromo' => Promo::where('is_active', '=', 1)->get(),
            'activedBannerPromo' => PromoBanner::where('is_active', '=', 1)->get(),
            'orderStatistics' => Order::all(),
        ]);
    }

    public function test()
    {
        $product = Product::latest()->get();
        return view('test', [
            'title' => 'Produk',
            'active' => 'product',
            'products' => $product,
        ]);
        // $product = User::where('id','=', 2)->get();
        // dd($product);
        // $product = Product::with(['productvariant' => fn ($query) => $query->where('stock', '=', '14')])
        //     ->whereHas(
        //         'productvariant',
        //         fn ($query) =>
        //         $query->where('stock', '=', '14')
        //     )
        //     ->get();
        $authors = Product::with(['productvariant' => fn ($query) => $query->where('stock', '=', '0')])
            ->whereHas(
                'productvariant',
                fn ($query) =>
                $query->where('stock', '=', '0')
            )->orwhere('stock', '=', '0')
            ->get();
        // dd($authors);
        // dd($product);
        // foreach ($product as $prd) {
        //     echo $prd->productvariant;
        //     echo "</br></br>";
        // }
        // dd($product->productvariant);
    }

    public function isAuthorize()
    {
        if (auth()->guard('adminMiddle')->user()->admin_type != 2) {
            abort(403);
        }
    }
    
    public function promoBannerExpiredCheck()
    {
        $expiredCheck = PromoBanner::all();
        foreach ($expiredCheck as $banner) {
            if ($banner->end_period < Carbon::now()) {
                $banner->is_active = 0;
                $banner->save();
            }
        }
    }

    public function promoVoucherExpiredCheck()
    {
        $expiredCheck = Promo::all();
        foreach ($expiredCheck as $banner) {
            if ($banner->end_period < Carbon::now()) {
                $banner->is_active = 0;
                $banner->save();
            }
        }
    }
}
