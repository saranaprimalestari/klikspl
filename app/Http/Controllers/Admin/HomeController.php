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
use App\Models\ProductComment;
use Illuminate\Support\Facades\DB;
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
        if (auth()->guard('adminMiddle')->user()->admin_type == 1) {
            $waitingPayment =  Order::where('order_status', '=', 'belum bayar')->get();
            $confirmPayment = Order::where('order_status', '=', 'pesanan dibayarkan')->get();
            $mustBeProcess = Order::where('order_status', '=', 'pembayaran dikonfirmasi')->get();
            $mustBeSent = Order::where('order_status', '=', 'pesanan disiapkan')->get();
            $onDelivery = Order::where('order_status', '=', 'pesanan dikirim')->get();
            $arrived = Order::where('order_status', '=', 'selesai')->whereIn('id', function ($query) {
                $query->select('order_id')->from(with(new OrderItem)->getTable())->where('is_review', '=', '0');
            })->get();
            $finish = Order::where('order_status', '=', 'selesai')->whereIn('id', function ($query) {
                $query->select('order_id')->from(with(new OrderItem)->getTable())->where('is_review', '=', '1');
            })->get();
            $canceled = Order::withTrashed()->where('order_status', '=', 'expired')->orWhere(
                'order_status',
                '=',
                'pesanan dibatalkan'
            )->get();
            $outStock = Product::with(['productvariant' => fn ($query) => $query->where('stock', '=', '0')])
                ->whereHas(
                    'productvariant',
                    fn ($query) =>
                    $query->where('stock', '=', '0')
                )->orWhere('stock', '=', '0')
                ->get();
            $activedPromo = Promo::where('is_active', '=', 1)->get();
            $activedBannerPromo = PromoBanner::where('is_active', '=', 1)->get();
            $productComments = ProductComment::whereNotNull('product_comments.user_id')
                ->join('orders', function ($join) {
                    $join->on('product_comments.order_id', '=', 'orders.id');
                })
                ->join('admin_sender_addresses', function ($join) {
                    $join->on('admin_sender_addresses.sender_address_id', '=', 'orders.sender_address_id');
                })
                ->join("admins", function ($join) {
                    $join->on("admins.id", "=", "admin_sender_addresses.admin_id");
                })->get('product_comments.*');
        } else {
            $waitingPayment =  Order::where('order_status', '=', 'belum bayar')->where(['sender_address_id' => function ($query) {
                $query->select('sender_address_id')
                    ->from('admin_sender_addresses')
                    ->whereColumn('sender_address_id', 'orders.sender_address_id')
                    ->where('admin_id', '=', auth()->guard('adminMiddle')->user()->id);
            }])->get();

            $confirmPayment = Order::where('order_status', '=', 'pesanan dibayarkan')->where(['sender_address_id' => function ($query) {
                $query->select('sender_address_id')
                    ->from('admin_sender_addresses')
                    ->whereColumn('sender_address_id', 'orders.sender_address_id')
                    ->where('admin_id', '=', auth()->guard('adminMiddle')->user()->id);
            }])->get();

            $mustBeProcess = Order::where('order_status', '=', 'pembayaran dikonfirmasi')->where(['sender_address_id' => function ($query) {
                $query->select('sender_address_id')
                    ->from('admin_sender_addresses')
                    ->whereColumn('sender_address_id', 'orders.sender_address_id')
                    ->where('admin_id', '=', auth()->guard('adminMiddle')->user()->id);
            }])->get();

            $mustBeSent = Order::where('order_status', '=', 'pesanan disiapkan')->where(['sender_address_id' => function ($query) {
                $query->select('sender_address_id')
                    ->from('admin_sender_addresses')
                    ->whereColumn('sender_address_id', 'orders.sender_address_id')
                    ->where('admin_id', '=', auth()->guard('adminMiddle')->user()->id);
            }])->get();

            $onDelivery = Order::where('order_status', '=', 'pesanan dikirim')->where(['sender_address_id' => function ($query) {
                $query->select('sender_address_id')
                    ->from('admin_sender_addresses')
                    ->whereColumn('sender_address_id', 'orders.sender_address_id')
                    ->where('admin_id', '=', auth()->guard('adminMiddle')->user()->id);
            }])->get();

            $arrived = Order::where('order_status', '=', 'selesai')->where(['sender_address_id' => function ($query) {
                $query->select('sender_address_id')
                    ->from('admin_sender_addresses')
                    ->whereColumn('sender_address_id', 'orders.sender_address_id')
                    ->where('admin_id', '=', auth()->guard('adminMiddle')->user()->id);
            }])
            ->join('order_items', function($join){
                $join->on('orders.id','=','order_items.order_id')
                ->where('order_items.is_review','=', '0');
            })
            ->get();

            $finish = Order::where('order_status', '=', 'selesai')->where(['sender_address_id' => function ($query) {
                $query->select('sender_address_id')
                    ->from('admin_sender_addresses')
                    ->whereColumn('sender_address_id', 'orders.sender_address_id')
                    ->where('admin_id', '=', auth()->guard('adminMiddle')->user()->id);
            }])->whereIn('id', function ($query) {
                $query->select('order_id')->from(with(new OrderItem)->getTable())->where('is_review', '=', '1');
            })->get();

            $canceled = Order::withTrashed()->join('admin_sender_addresses', function ($join) {
                $join->on('orders.sender_address_id', '=', 'admin_sender_addresses.sender_address_id')
                    ->where('admin_sender_addresses.admin_id', '=', auth()->guard('adminMiddle')->user()->id);
            })->where('orders.order_status', '=', 'expired')
                ->orWhere('orders.order_status', '=', 'pesanan dibatalkan')
                ->get();
            // $canceled = DB::table('orders')
            // ->select('*')
            // ->join('admin_sender_addresses',function($join) {
            //     $join->on('orders.sender_address_id','=','admin_sender_addresses.sender_address_id')
            //     ->where('admin_sender_addresses.admin_id','=',auth()->guard('adminMiddle')->user()->id);
            // })
            // ->where('orders.order_status','=','expired')
            // ->orWhere('orders.order_status','=','pesanan dibatalkan')
            // ->get();

            // $canceled = Order::withTrashed()->where(['sender_address_id' => function($query){
            //     $query->select('sender_address_id')
            //     ->from('admin_sender_addresses')
            //     ->whereColumn('sender_address_id', 'orders.sender_address_id')
            //     ->where('admin_id','=', auth()->guard('adminMiddle')->user()->id);
            // }])->where('order_status', '=', 'expired')->orWhere('order_status', '=', 
            // 'pesanan dibatalkan')->get();

            $outStock = Product::where('company_id', '=', auth()->guard('adminMiddle')->user()->company_id)->with(['productvariant' => fn ($query) => $query->where('stock', '=', '0')])
                ->whereHas(
                    'productvariant',
                    fn ($query) =>
                    $query->where('stock', '=', '0')
                )->orWhere('stock', '=', '0')
                ->get();

            $activedPromo = Promo::where('company_id', '=', auth()->guard('adminMiddle')->user()->company_id)->where('is_active', '=', 1)->get();

            $activedBannerPromo = PromoBanner::where('company_id', '=', auth()->guard('adminMiddle')->user()->company_id)->where('is_active', '=', 1)->get();

            $productComments = ProductComment::whereNotNull('product_comments.user_id')
                ->join('orders', function ($join) {
                    $join->on('product_comments.order_id', '=', 'orders.id');
                })
                ->join('admin_sender_addresses', function ($join) {
                    $join->on('admin_sender_addresses.sender_address_id', '=', 'orders.sender_address_id');
                })
                ->join("admins", function ($join) {
                    $join->on("admins.id", "=", "admin_sender_addresses.admin_id")
                        ->where('admins.id', '=', auth()->guard('adminMiddle')->user()->id);
                })->get('product_comments.*');
        }

        $incomeValues = Order::where('order_status', 'like', '%selesai%')->select(DB::raw('sum(courier_price + total_price + unique_code - discount) as total_income'))->first()->total_income;

        $incomeThisMonth = Order::where('order_status', 'like', '%selesai%')->whereYear('updated_at', '=', date('Y'))->whereMonth('updated_at', '=', date('m'))->select(DB::raw('sum(courier_price + total_price + unique_code - discount) as total_income'))->first()->total_income;

        $incomePerMonth = Order::where('order_status','like','%selesai%')->select("id",DB::raw('sum(courier_price + total_price + unique_code - discount) as total_income_per_month'),DB::raw("(payment_method_id) as payment_method"),DB::raw("DATE_FORMAT(updated_at, '%Y-%m') as month_year_income")
        )->orderBy('updated_at')->groupBy(DB::raw("DATE_FORMAT(updated_at, '%Y-%m')"))->get();

        $productCommentsCount = 0;
        foreach ($productComments as $comment) {
            if (count($comment->children) <= 0) {
                $productCommentsCount += 1;
            }
        }

        // dd($productComments->children);
        return view('admin.home', [
            'title' => 'Admin Dashboard',
            'active' => 'dashboard',
            'cartItems' => CartItem::all(),
            'waitingPayment' => $waitingPayment,
            'confirmPayment' => $confirmPayment,
            'mustBeProcess' => $mustBeProcess,
            'mustBeSent' => $mustBeSent,
            'onDelivery' => $onDelivery,
            'arrived' => $arrived,
            'finish' => $finish,
            'canceled' => $canceled,
            'outStock' => $outStock,
            'activedPromo' => $activedPromo,
            'activedBannerPromo' => $activedBannerPromo,
            'incomeValues' => $incomeValues,
            'incomeThisMonth' => $incomeThisMonth,
            'incomePerMonth' => $incomePerMonth,
            'productCommentsCount' => $productCommentsCount,
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
