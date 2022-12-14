<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\UserNotification;
use App\Models\AdminNotification;
use App\Models\OrderStatusDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\MailController;

class AdminOrderController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('adminMiddle');
    //     // dd(auth()->guard('adminMiddle')->user());

    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request);
        $this->expiredCheck();
        // dd(request(['status'])['status']);

        if (empty(request(['status'])['status'])) {
            $request->request->add(['status' => '']);
        }
        if (auth()->guard('adminMiddle')->user()->admin_type == 1 || auth()->guard('adminMiddle')->user()->admin_type == 2) {
            if (request(['status'])['status'] == '') {
                $header = 'Semua Pesanan';
            } else if (request(['status'])['status'] == 'aktif') {
                $header = 'Pesanan Aktif';
            } else if (request(['status'])['status'] == 'belum bayar') {
                $header = 'Menunggu Pembayaran';
            } else if (request(['status'])['status'] == 'pesanan dibayarkan') {
                $header = 'Konfirmasi Pembayaran Pesanan';
            } else if (request(['status'])['status'] == 'pembayaran dikonfirmasi') {
                $header = 'Pesanan Perlu Diproses';
            } else if (request(['status'])['status'] == 'pesanan disiapkan') {
                $header = 'Pesanan Siap Dikirim';
            } else if (request(['status'])['status'] == 'pesanan dikirim') {
                $header = 'Pesanan Dalam Pengiriman';
            } else if (request(['status'])['status'] == 'sampai tujuan') {
                $header = 'Pesanan Sampai Tujuan';
            } else if (request(['status'])['status'] == 'selesai') {
                $header = 'Pesanan Selesai';
            } else if (request(['status'])['status'] == 'expired') {
                $header = 'Pesanan Dibatalkan';
            } else if (request(['status'])['status'] == 'pesanan dibatalkan') {
                $header = 'Pesanan Dibatalkan';
            } else if (request(['status'])['status'] == 'pengajuan pembatalan') {
                $header = 'Pengajuan Pembatalan';
            } else if (request(['status'])['status'] == 'pengajuan pengembalian dana') {
                $header = 'Pengajuan Pengembalian Dana';
            } else {
                return redirect()->route('adminorder.index');
            }
        } elseif (auth()->guard('adminMiddle')->user()->admin_type == 3) {
            if (request(['status'])['status'] == 'pesanan dibayarkan') {
                $header = 'Konfirmasi Pembayaran Pesanan';
            } else if (request(['status'])['status'] == 'expired') {
                $header = 'Pesanan Dibatalkan';
            } else if (request(['status'])['status'] == 'pesanan dibatalkan') {
                $header = 'Pesanan Dibatalkan';
            } else if (request(['status'])['status'] == 'pengajuan pembatalan') {
                $header = 'Pengajuan Pembatalan';
            } else {
                abort(403);
            }
        } elseif (auth()->guard('adminMiddle')->user()->admin_type == 4) {
            if (request(['status'])['status'] == 'pembayaran dikonfirmasi') {
                $header = 'Pesanan Perlu Disiapkan';
            } else if (request(['status'])['status'] == 'pesanan disiapkan') {
                $header = 'Pesanan Siap Dikirim';
            } else if (request(['status'])['status'] == 'pesanan dikirim') {
                $header = 'Pesanan Dalam Pengiriman';
            } else {
                abort(403);
            }
        } else {
            abort(403);
        }

        $request->session()->put('status', request(['status'])['status']);
        // dd(request(['date_start']));
        // if (auth()->guard('adminMiddle')->user()->admin_type == 1) {
        //     $orders =  Order::withTrashed()->with(['orderitem', 'orderstatusdetail'])->filterAdmin(request(['status', 'search', 'date_start', 'date_end', 'orderBy']))->paginate(100)->withquerystring();
        // } else 
        if (auth()->guard('adminMiddle')->user()->admin_type == 2 || auth()->guard('adminMiddle')->user()->admin_type == 4) {
            $orders =  Order::withTrashed()->with(['orderitem', 'orderstatusdetail'])->filterAdmin(request(['status', 'search', 'date_start', 'date_end', 'orderBy']))->where(['sender_address_id' => function ($query) {
                $query->select('sender_address_id')
                    ->from('admin_sender_addresses')
                    ->whereColumn('sender_address_id', 'orders.sender_address_id')
                    ->where('admin_id', '=', auth()->guard('adminMiddle')->user()->id);
            }])->paginate(100)->withquerystring();
        } else {
            $orders =  Order::withTrashed()->with(['orderitem', 'orderstatusdetail'])->filterAdmin(request(['status', 'search', 'date_start', 'date_end', 'orderBy']))->paginate(100)->withquerystring();
        }
        // dd($orders);
        // dd(request(['status']));
        return view('admin.order.index', [
            'title' => 'Pesanan Saya',
            'active' => 'order',
            'status' => request(['status'])['status'],
            'header' => $header,
            // 'orders' => $orders,
            'orders' => $orders,
        ]);
        // $orders = Order::withTrashed()->latest()->paginate(10);
        // return view('admin.order.index', [
        //     'title' => 'Pesanan',
        //     'active' => 'order',
        //     'orders' => $orders,
        // ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $this->isFinanceAndAdministrator();
        // dd($adminorder);
        $orders = Order::withTrashed()->find($id);
        // dd($orders);
        if (!is_null($orders)) {
            $status = session()->get('status');
            $orderItems = OrderItem::where('order_id', '=', $orders->id)->get();
            // dd($orderItems);
            // dd($adminorder);

            $weightGr = 0;
            foreach ($orderItems as $item) {
                $weightGr += ($item->quantity * $item->orderproduct->weight);
            }
            $weight = round(($weightGr / 1000), 2);

            return view('admin.order.detail', [
                'title' => 'Pesanan Saya',
                'active' => 'order',
                'status' => $status,
                // 'orders' => $orders,
                'orders' => $orders,
                'orderItems' => $orderItems,
                'weight' => $weight,

            ]);
        } else {
            return abort(404, 'Pesanan tidak ditemukan!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $adminorder)
    {
        dd($adminorder);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
    public function expiredCheck()
    {
        // dd(auth()->guard('adminMiddle')->user());

        $now = Carbon::now();

        $orders = Order::withTrashed()->orderByDesc('created_at')->get();

        foreach ($orders as $userOrder) {

            if (is_null($userOrder->deleted_at) && is_null($userOrder->invoice_no)) {

                $due_date = Carbon::createFromFormat('Y-m-d H:s:i', $userOrder->payment_due_date);

                if ($now > $due_date) {
                    $userOrder->order_status = 'expired';
                    $userOrder->save();

                    if ($userOrder->save()) {
                        foreach ($userOrder->orderitem as $item) {
                            $item->order_item_status = 'expired';
                            $item->save();
                        }
                    }
                    $userOrder->delete();
                }

                // check apakah sudah di delete dan tidak memiliki invoice no
            } elseif (!is_null($userOrder->deleted_at) && is_null($userOrder->invoice_no)) {

                // mengambil data waktu delete dan diubah menjadi hitungan jam
                $deleted_at = Carbon::createFromFormat('Y-m-d H:s:i', $userOrder->deleted_at);
                $diff_in_hours = $deleted_at->diffInHours($now);

                // jika waktu delete sudah melebihi 24 jam / 1 hari
                if ($diff_in_hours > 24) {

                    foreach ($userOrder->orderItem as $orderItem) {
                        if ($orderItem->orderproduct->orderproductimage->count()) {
                            foreach ($orderItem->orderProduct->orderProductImage as $orderProductImage) {
                            }
                            $cartItem = CartItem::where([['user_id', '=', $orderItem->user_id], ['product_id', '=', $orderItem->product_id], ['product_variant_id', '=', $orderItem->product_variant_id], ['quantity', '=', $orderItem->quantity], ['subtotal', '=', $orderItem->total_price_item], ['deleted_at', 'like', '%' . Carbon::parse($orderItem->created_at)->format('Y-m-d H:i') . '%'], ['updated_at', 'like', '%' . Carbon::parse($orderItem->created_at)->format('Y-m-d H:i') . '%']])->withTrashed()->first();

                            // echo "order item id : ";
                            // print_r($orderItem->id);
                            // echo "<br>";
                            // echo "<br>";
                            if (!is_null($cartItem)) {
                                // echo "cart item not null : ";
                                // echo "<br>";
                                $cartItem->deleted_at = NULL;
                                $cartItem->save();
                                // print_r($cartItem);
                                // echo "<br>";
                                // echo "<br>";
                                // print_r($cartItem->id);
                                // echo "<br>";
                                // echo "<br>";
                                // echo "<br>";
                            } else {
                                // $cartItemCreateNew = CartItem::create([
                                //     'user_id' => $orderItem->user_id,
                                //     'user_id' => $orderItem->user_id,
                                //     'user_id' => $orderItem->user_id,
                                // ]);

                                // echo "cart item null : ";
                                // echo "<br>";
                                // echo "user id : ";
                                // print_r($orderItem->user_id);
                                // echo "<br>";
                                // echo "product id : ";
                                // print_r($orderItem->product_id);
                                // echo "<br>";
                                // echo "product variant id : ";
                                // print_r($orderItem->product_variant_id);
                                // echo "<br>";
                                // echo "<br>";
                            }
                            // $orderProductImage->delete();
                            // $orderItem->orderProduct->delete();
                        } else {
                            $cartItem = CartItem::where([['user_id', '=', $orderItem->user_id], ['product_id', '=', $orderItem->product_id], ['product_variant_id', '=', $orderItem->product_variant_id], ['quantity', '=', $orderItem->quantity], ['subtotal', '=', $orderItem->total_price_item], ['deleted_at', 'like', '%' . Carbon::parse($orderItem->created_at)->format('Y-m-d H:i') . '%'], ['updated_at', 'like', '%' . Carbon::parse($orderItem->created_at)->format('Y-m-d H:i') . '%']])->withTrashed()->first();
                            $cartItem->deleted_at = NULL;
                            $cartItem->save();
                            // $orderItem->orderProduct->delete();
                        }
                        // $orderItem->delete();
                    }
                    // $userOrder->forceDelete();
                }
            }
        }
        // dd('test');
    }
    public function orderDetailBind($id)
    {
        // dd('ini detail');
        $this->isFinanceAndAdministrator();
        $this->expiredCheck();

        // dd($order->id);
        $order = Order::withTrashed()->where('id', $id)->first();
        foreach ($order->orderitem as $item) {
            $orderProductIds[] = $item->orderproduct->id;
        }
        $orders = Order::withTrashed()->where('id', $id)->get();
        // dd($orders);
        $orderItems = $order->orderitem;
        // $orderProducts = OrderProduct::whereIn('id', $orderProductIds)->get();
        return view(
            'order.detail',
            [
                'title' => 'Detail Pesanan',
                'active' => 'order',
                'orders' => $orders,
                'orderItems' => $orderItems,
                // 'orderProducts' => $orderProducts,
            ]
        );
    }

    public function orderDetailProofOfPayment(Request $request)
    {
        $this->expiredCheck();

        // dd($request);
        return view(
            'order.view-proof-of-payment',
            [
                'title' => 'Bukti Pembayaran',
                'active' => 'order',
                'img' => $request->proofOfPayment,
            ]
        );
    }
    public function downloadProofOfPayment(Request $request)
    {

        // dd($request);
        ob_end_clean();
        $headers = array(
            'Content-Type: image/png',
            'Content-Type: image/jpg',
            'Content-Type: image/jpeg',
        );
        return response()->download(storage_path("app/public") . '/' . $request->proofOfPayment, str_replace("/", "-", $request->inv_no) . '-' . auth()->guard('adminMiddle')->user()->username . '-proof-of-payment.png', $headers);
    }

    public function confirmPayment(Request $request, MailController $mailController)
    {
        $this->expiredCheck();
        // dd($request);
        $validatedData = $request->validate(
            [
                'proof_of_payment' => 'image|file||mimes:jpeg,png,jpg|max:2048'
            ],
            [
                'proof_of_payment.image' => 'Bukti Pembayaran harus berupa gambar',
                'proof_of_payment.file' => 'Bukti Pembayaran harus berupa file',
                'proof_of_payment.mimes' => 'Bukti Pembayaran harus memiliki format file .jpg, .jpeg, .png',
                'proof_of_payment.max' => 'Bukti Pembayaran berukuran maximal 2MB',
            ]
        );
        // dd($request);
        // dd($request->session()->get('status'));
        $order = Order::where('id', '=', $request->order_id)->first();
        if (is_null($order)) {
            $order = Order::withTrashed()->where('id', '=', $request->order_id)->first();
        }
        if (is_null($order->invoice_no)) {
            $stockVariant = 0;
            $soldVariant = 0;
            foreach ($order->orderitem as $orderitem) {
                $product = Product::where('id', '=', $orderitem->product_id)->first();
                if (!empty($orderitem->product_variant_id)) {
                    $productVariantId = ProductVariant::where('id', '=', $orderitem->product_variant_id)->first();
                    // echo "product variant stock before : " .$productVariantId->stock;
                    // echo "<br>";
                    // echo "product variant sold before : " .$productVariantId->sold;
                    // echo "<br>";
                    $productVariantId->stock = (int)$productVariantId->stock - (int)$orderitem->quantity;
                    $productVariantId->sold = (int)$orderitem->quantity + (int)$productVariantId->sold;
                    // echo "product variant stock : " .$productVariantId->stock;
                    // echo "<br>";
                    // echo "product variant sold : " .$productVariantId->sold;
                    // echo "<br>";
                    // echo "order item qty : " .$orderitem->quantity;
                    // echo "<br>";
                    $stockVariant += $productVariantId->stock;
                    $soldVariant += $productVariantId->sold;
                    $productVariantId->save();

                    // $product->stock = $stockVariant;
                    // $product->sold = $soldVariant;
                    // $product->save();
                } else {
                    $product->stock = (int)$product->stock - (int)$orderitem->quantity;
                    $product->sold = (int)$orderitem->quantity + (int)$product->sold;
                    // echo "product stock : " . $product->stock;
                    // echo "<br>";
                    // echo "product sold : " . $product->sold;
                    // echo "<br>";
                    // echo "order item qty : " . $orderitem->quantity;
                    // echo "<br>";
                    $product->save();
                }
                // echo "product id : " . $product->id;
                // echo "<br>";
                // echo "not empty : " . !empty($product->productvariant);
                // echo "<br>";
                // echo "not null : " . !is_null($product->productvariant);
                // echo "<br>";
                // echo "count : " . count($product->productvariant);
                // echo "<br>";
                if (count($product->productvariant) > 0) {
                    // echo ('ada product variant');
                    // echo "<br>";
                    $product->stock = $product->productvariant->sum('stock');
                    $product->sold = $product->productvariant->sum('sold');
                    $product->save();
                }
                // dd($request);
            }

            // dd(Order::whereNotNull('invoice_no')->exists());
            // dd(Order::orderBy('invoice_no','desc')->whereNotNull('invoice_no')->pluck('invoice_no')->first());


            if (Order::withTrashed()->whereNotNull('invoice_no')->exists()) {
                // dd(Order::where('invoice_no','like','%0822%')->max('invoice_no'));
                // $lastInvNo = Order::orderBy('invoice_no', 'desc')->whereNotNull('invoice_no')->pluck('invoice_no')->first();
                $lastInvNo = Order::withTrashed()->where('invoice_no', 'like', '%' . date('my') . '%')->max('invoice_no');
                // dd($lastInvNo);
                // if(is_null($lastInvNo)){
                //     $noInv = 'SPL/INVC/KLIKSPL/000001/'.date('my');
                // }else{
                // echo $lastInvNo;
                // echo "<br><br>";
                $exp = explode('/', $lastInvNo);
                // dd($exp);
                // echo($exp[4]);
                // echo "<br><br>";
                if (!is_null($lastInvNo)) {
                    if (($exp[4] != date('my'))) {
                        $noInv = 'SPL/INVC/KLIKSPL/000001/' . date('my');
                    } else {
                        // echo $exp[3];
                        // echo "<br><br>";
                        $seqTemp = ltrim($exp[3], '0');
                        // echo $seqTemp;
                        // echo "<br><br>";
                        $seqTemp = $seqTemp + 1;
                        $seq = sprintf("%'.06d", $seqTemp);
                        // echo $seq;
                        // echo "<br><br>";
                        $noInv = implode("/", array($exp[0], $exp[1], $exp[2], $seq, date('my')));
                        // echo $noInv;
                        // echo "<br><br>";
                    }
                } else {
                    $noInv = 'SPL/INVC/KLIKSPL/000001/' . date('my');
                }
                // }
            } else {
                $noInv = 'SPL/INVC/KLIKSPL/000001/' . date('my');
            }
            //commentes
            // dd($request->file('proof_of_payment')->guessExtension());
            if (!is_null($request->file('proof_of_payment')) || $request->file('proof_of_payment')) {
                $folderPathSave = 'user/' . $order->users->username . '/order/' . $request->order_id . '/proof-of-payment';

                // echo $folderPathSave;
                // echo "<br><br>";
                // echo $request->order_id;

                if ($request->file('proof_of_payment')) {
                    // echo 'if req proof';
                    $validatedData['proof_of_payment'] = $request->file('proof_of_payment')->store($folderPathSave);
                    // echo $validatedData['proof_of_payment'];
                }
                $order->proof_of_payment = $validatedData['proof_of_payment'];
            }
            $order->invoice_no = $noInv;
            $order->order_status = 'pesanan dibayarkan';
            $orderSave = $order->save();

            if ($orderSave) {
                foreach ($order->orderitem as $item) {
                    $item->order_item_status = 'pesanan dibayarkan';
                    $item->save();
                }
            }
            $orderStatus = OrderStatusDetail::create(
                [
                    'order_id' => $order->id,
                    'status' => 'pesanan dibayarkan',
                    'status_detail' => 'Menunggu Verifikasi Pembayaran oleh Admin KLIKSPL',
                    'status_date' => date('Y-m-d H:i:s')
                ]
            );
        }

        $status = str_replace(" ", "+", $request->session()->get('status'));
        // dd($request);

        // $order = Order::where('id', '=', $request->order_id)->first();

        $order->order_status = 'pembayaran dikonfirmasi';
        $order->save();

        if ($order->save()) {
            foreach ($order->orderitem as $item) {
                $item->order_item_status = 'pembayaran dikonfirmasi';
                $item->save();
            }
        }
        $orderStatus = OrderStatusDetail::create(
            [
                'order_id' => $order->id,
                'status' => 'pembayaran dikonfirmasi',
                'status_detail' => 'Pembayaran telah dikonfirmasi oleh Admin KLIKSPL, pesanan anda akan segera disiapkan',
                'status_date' => date('Y-m-d H:i:s')
            ]
        );

        $orderProduct = $order->orderitem[0]->orderProduct;
        $shopBag = 'assets\shop-bag-success.png';

        if (!is_null($order->users->email)) {
            $details = ['id' => '2', 'email' => $order->users->email, 'title' => 'KLIK SPL: Pembayaran Dikonfirmasi', 'message' => 'Pembayaran pesanan ' . $order->invoice_no . ' dikonfirmasi oleh ADMIN KLIKSPL. Pesanan anda sedang disiapkan dan segera dikirimkan. Untuk melihat detail pesanan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/order', 'closing' => '', 'footer' => ''];
            $detail = new Request($details);
            // $this->mailController = $mailController;
            // $this->mailController->sendMail($detail); 
            $sendMailController = $mailController;
            $sendMailController->sendMail($detail);
        }

        $notifications = [
            'user_id' => $order->user_id,
            'slug' => $order->users->username . '-' . Crypt::encryptString($order->id) . '-pembayaran-dikonfirmasi',
            'type' => 'Pesanan',
            'description' => '<p class="m-0">Pembayaran pesanan ' . $order->invoice_no . ' dikonfirmasi oleh ADMIN KLIKSPL. Pesanan anda sedang disiapkan dan segera dikirimkan.</p>',
            'excerpt' => 'Pembayaran Dikonfirmasi',
            // 'image' => $shopBag,
            'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
            'is_read' => 0
        ];
        // membuat notifikasi pembuatan pesanan untuk user
        $notification = UserNotification::create($notifications);

        $sendAdminNotification = Admin::whereIn('admin_type', [2, 4])->where('company_id', '=', $orderProduct->company_id)->get();

        foreach ($sendAdminNotification as $admin) {
            if (!is_null($admin->email)) {
                $details = ['id' => '2', 'email' => $admin->email, 'title' => 'KLIK SPL: Pembayaran Dikonfirmasi', 'message' => 'Pembayaran pesanan ' . $order->invoice_no . ' sudah dikonfirmasi. Segera siapkan dan kirim pesanan ke ' . $order->users->username . '. Untuk melihat detail pesanan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/administrator/adminorder', 'closing' => '', 'footer' => ''];
                $detail = new Request($details);
                // $this->mailController = $mailController;
                // $this->mailController->sendMail($detail); 
                $sendMailController = $mailController;
                $sendMailController->sendMail($detail);
            }
        }

        $adminNotifications = [
            'order_id' => $order->id,
            'admin_id' => auth()->guard('adminMiddle')->user()->id,
            'admin_type' => 4,
            'company_id' => $orderProduct->company_id,
            'slug' => Crypt::encryptString($order->id) . '-pembayaran-dikonfirmasi',
            'type' => 'Pesanan',
            'description' => '<p class="m-0">Pembayaran pesanan ' . $order->invoice_no . ' sudah dikonfirmasi. Segera siapkan dan kirim pesanan ke ' . $order->users->username . '</p>',
            'excerpt' => 'Pembayaran Dikonfirmasi',
            // 'image' => $shopBag,
            'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
            'is_read' => 0
        ];
        // membuat notifikasi pembuatan pesanan untuk admin
        $adminNotification = AdminNotification::create($adminNotifications);

        // return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi, segera siapkan pesanan pembeli');
        return redirect()->route('adminorder.index', ['status' => $request->session()->get('status')])->with('success', 'Pembayaran berhasil dikonfirmasi, segera siapkan pesanan pembeli');
    }

    public function prepareOrder(Request $request)
    {
        // dd($request);
        // dd($request->session()->get('status'));
        $status = str_replace(" ", "+", $request->session()->get('status'));
        // dd($request);

        $order = Order::where('id', '=', $request->order_id)->first();

        $order->order_status = 'pesanan disiapkan';
        $order->save();
        if ($order->save()) {
            foreach ($order->orderitem as $item) {
                $item->order_item_status = 'pesanan disiapkan';
                $item->save();
            }
        }
        $orderStatus = OrderStatusDetail::create(
            [
                'order_id' => $order->id,
                'status' => 'pesanan disiapkan',
                'status_detail' => 'pesanan sedang disiapkan oleh Tim KLIKSPL',
                'status_date' => date('Y-m-d H:i:s')
            ]
        );
        if ($orderStatus) {
            // return redirect()->bavk()->with('success', 'pesanan berhasil dikonfirmasi, segera siapkan pesanan pembeli');
            return redirect()->route('adminorder.index', ['status' => $request->session()->get('status')])->with('success', 'pesanann berhasil dikonfirmasi, segera siapkan pesanan pembeli');
        } else {
            // return redirect()->back()->with('failed', 'Terjadi kesalahan, pesanan gagal dikonfirmasi');
            return redirect()->route('adminorder.index', ['status' => $request->session()->get('status')])->with('failed', 'Terjadi kesalahan, pesanan gagal dikonfirmasi');
        }
    }

    public function deliveOrder(Request $request, MailController $mailController)
    {
        // dd($request);
        // dd($request->session()->get('status'));
        $status = str_replace(" ", "+", $request->session()->get('status'));
        // dd($request);

        $order = Order::where('id', '=', $request->order_id)->first();

        $order->order_status = 'pesanan dikirim';
        $order->save();

        if ($order->save()) {
            foreach ($order->orderitem as $item) {
                $item->order_item_status = 'pesanan dikirim';
                $item->save();
            }
        }

        $orderStatus = OrderStatusDetail::create(
            [
                'order_id' => $order->id,
                'status' => 'pesanan dikirim',
                'status_detail' => 'pesanan diantar kepada kurir pengirim oleh Tim KLIKSPL',
                'status_date' => date('Y-m-d H:i:s')
            ]
        );
        if ($orderStatus) {
            $orderProduct = $order->orderitem[0]->orderProduct;

            if (!is_null($order->users->email)) {
                $details = ['id' => '2', 'email' => $order->users->email, 'title' => 'KLIK SPL: Pesanan Dikirim', 'message' => 'Pesanan ' . $order->invoice_no . ' dikirimkan ke Kurir ' . $order->courier . ' dengan layanan ' . $order->courier_package_type . '. Nomor Resi akan terupdate jika proses di kurir selesai. Untuk melihat detail pesanan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/order', 'closing' => '', 'footer' => ''];
                $detail = new Request($details);
                // $this->mailController = $mailController;
                // $this->mailController->sendMail($detail); 
                $sendMailController = $mailController;
                $sendMailController->sendMail($detail);
            }

            $notifications = [
                'user_id' => $order->user_id,
                'slug' => $order->users->username . '-' . Crypt::encryptString($order->id) . '-pesanan-dikirim',
                'type' => 'Pesanan',
                'description' => '<p class="m-0">Pesanan ' . $order->invoice_no . ' dikirimkan ke Kurir ' . $order->courier . ' dengan layanan ' . $order->courier_package_type . '. Nomor Resi akan terupdate jika proses di kurir selesai</p>',
                'excerpt' => 'Pesanan Dikirim',
                // 'image' => $shopBag,
                'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
                'is_read' => 0
            ];
            // membuat notifikasi pembuatan pesanan untuk user
            $notification = UserNotification::create($notifications);

            $sendAdminNotification = Admin::whereIn('admin_type', [2, 4])->where('company_id', '=', $orderProduct->company_id)->get();

            foreach ($sendAdminNotification as $admin) {
                if (!is_null($admin->email)) {
                    $details = ['id' => '2', 'email' => $admin->email, 'title' => 'KLIK SPL: Pesanan Dikirim', 'message' => 'Pesanan ' . $order->invoice_no . ' dikirimkan ke Kurir ' . $order->courier . ' dengan layanan ' . $order->courier_package_type . '. Setelah berhasil mengantar ke kurir segera isi nomor resi pengiriman pesanan!. Untuk melihat detail pesanan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/administrator/adminorder', 'closing' => '', 'footer' => ''];
                    $detail = new Request($details);
                    // $this->mailController = $mailController;
                    // $this->mailController->sendMail($detail); 
                    $sendMailController = $mailController;
                    $sendMailController->sendMail($detail);
                }
            }

            $adminNotifications = [
                'order_id' => $order->id,
                'admin_id' => auth()->guard('adminMiddle')->user()->id,
                'admin_type' => 4,
                'company_id' => $orderProduct->company_id,
                'slug' => Crypt::encryptString($order->id) . '-pesanan-dikirim',
                'type' => 'Pesanan',
                'description' => '<p class="m-0">Pesanan ' . $order->invoice_no . ' dikirimkan ke Kurir ' . $order->courier . ' dengan layanan ' . $order->courier_package_type . '. Setelah berhasil mengantar ke kurir segera isi nomor resi pengiriman pesanan!</p>',
                'excerpt' => 'Pesanan Dikirim',
                // 'image' => $shopBag,
                'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
                'is_read' => 0
            ];
            // membuat notifikasi pembuatan pesanan untuk admin
            $adminNotification = AdminNotification::create($adminNotifications);

            return redirect()->route('adminorder.index', ['status' => $request->session()->get('status')])->with('success', 'status pesanan berhasil diperbarui');
        } else {
            return redirect()->route('adminorder.index', ['status' => $request->session()->get('status')])->with('failed', 'status pesanan gagal diperbarui');
        }
    }

    public function declinePayment(Request $request)
    {
        // dd($request);
        $this->expiredCheck();
        // dd($request);

        $order = Order::where('id', '=', $request->order_id)->first();

        $order->order_status = 'pembayaran ditolak';
        $order->save();

        if ($order->save()) {
            foreach ($order->orderitem as $item) {
                $item->order_item_status = 'pembayaran ditolak';
                $item->save();
            }
        }

        $orderStatus = OrderStatusDetail::create(
            [
                'order_id' => $order->id,
                'status' => 'pembayaran ditolak',
                'status_detail' => 'Pembayaran pesanan ditolak oleh Admin KLIKSPL, dengan alasan: ' . $request->cancel_order_detail,
                'status_date' => date('Y-m-d H:i:s')
            ]
        );
        if ($orderStatus) {
            return redirect()->back()->with('success', 'Penolakan Pembayaran berhasil, pembeli diberikan waktu 2 x 24 jam untuk mengirimkan bukti pembayaran yang valid');
        } else {
            return redirect()->back()->with('failed', 'Terjadi kesalahan dalam pembatalan bukti pembayaran');
        }
    }

    public function shippingReceiptUpload(Request $request, MailController $mailController)
    {
        // dd($request);
        $request->merge(['id' => $request->order_id]);
        $validatedData = $request->validate(
            [
                'id' => 'required',
                'resi' => 'required|unique:orders'
            ],
            [
                'resi.required' => 'Nomor Resi Wajid diisi!',
                'resi.unique' => 'Nomor Resi sudah digunakan, Nomor Resi harus unik!',
            ]
        );
        $order = Order::find($request->order_id);
        $order->resi = $validatedData['resi'];
        $update = $order->save();
        if ($update) {
            $orderStatus = OrderStatusDetail::create(
                [
                    'order_id' => $order->id,
                    'status' => 'Nomor resi telah terbit',
                    'status_detail' => 'Nomor Resi pesanan anda ' . $order->resi,
                    'status_date' => date('Y-m-d H:i:s')
                ]
            );
        }
        if ($update && $orderStatus) {

            $orderProduct = $order->orderitem[0]->orderProduct;

            if (!is_null($order->users->email)) {
                $details = ['id' => '2', 'email' => $order->users->email, 'title' => 'KLIK SPL: Pesanan Dikirim', 'message' => 'Pesanan ' . $order->invoice_no . ' sudah dikirim  dengan kurir ' . $order->courier . ' ' . $order->courier_package_type . ' dengan estimasi waktu ' . $order->estimation_day . ' hari, perkiraan tiba pada ' . \Carbon\Carbon::parse($order->estimation_date)->isoFormat('D MMMM Y') . '. Nomor Resi pesanan anda adalah ' . $order->resi . '. Silakan konfirmasi apabila pesanan sudah diterima. Untuk melihat detail pesanan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/order', 'closing' => '', 'footer' => ''];
                $detail = new Request($details);
                // $this->mailController = $mailController;
                // $this->mailController->sendMail($detail); 
                $sendMailController = $mailController;
                $sendMailController->sendMail($detail);
            }

            $notifications = [
                'user_id' => $order->user_id,
                'slug' => $order->users->username . '-' . Crypt::encryptString($order->id) . '-pesanan-dikirim',
                'type' => 'Pesanan',
                'description' =>
                '<p class="m-0">Pesanan ' . $order->invoice_no . ' sudah dikirim  dengan detail : </p>
                <ul>
                <li>Kurir : ' . $order->courier . '</li>
                <li>Layanan Kurir : ' . $order->courier_package_type . '</li>
                <li>Estimasi waktu : ' . $order->estimation_day . ' hari, perkiraan tiba pada ' . \Carbon\Carbon::parse($order->estimation_date)->isoFormat('D MMMM Y') . '</li>
                <li>Nomor Resi : ' . $order->resi . '</li>
                </ul>
                <p class="m-0">Silakan konfirmasi apabila pesanan sudah diterima.</p>',
                'excerpt' => 'Pesanan Dikirim',
                // 'image' => $shopBag,
                'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
                'is_read' => 0
            ];
            // membuat notifikasi pembuatan pesanan untuk user
            $notification = UserNotification::create($notifications);

            return redirect()->route('adminorder.index', ['status' => $request->session()->get('status')])->with('success', 'Status pesanan berhasil diperbarui');
        } else {
            return redirect()->route('adminorder.index', ['status' => $request->session()->get('status')])->with('failed', 'Status pesanan gagal diperbarui');
        }
    }

    public function shippingReceiptUpdate(Request $request, MailController $mailController)
    {
        // dd($request);
        $request->merge(['id' => $request->order_id]);
        $validatedData = $request->validate(
            [
                'id' => 'required',
                'resi' => 'required|unique:orders'
            ],
            [
                'resi.required' => 'Nomor Resi Wajid diisi!',
                'resi.unique' => 'Nomor Resi sudah digunakan, Nomor Resi harus unik!',
            ]
        );
        $order = Order::find($request->order_id);
        $order->resi = $validatedData['resi'];
        $update = $order->save();

        if ($update) {
            $orderStatus = OrderStatusDetail::create(
                [
                    'order_id' => $order->id,
                    'status' => 'Nomor resi diperbarui admin',
                    'status_detail' => 'Nomor Resi pesanan anda ' . $order->resi,
                    'status_date' => date('Y-m-d H:i:s')
                ]
            );
        }
        if ($update && $orderStatus) {
            $orderProduct = $order->orderitem[0]->orderProduct;

            if (!is_null($order->users->email)) {
                $details = ['id' => '2', 'email' => $order->users->email, 'title' => 'KLIK SPL: No.Resi Pesanan Diperbarui', 'message' => 'Nomor resi pesanan ' . $order->invoice_no . ' diperbarui oleh ADMIN KLIKSPL. Nomor resi terbaru pesanan anda : ' . $order->resi . '. Silakan konfirmasi apabila pesanan sudah diterima. Untuk melihat detail pesanan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/order', 'closing' => '', 'footer' => ''];
                $detail = new Request($details);
                // $this->mailController = $mailController;
                // $this->mailController->sendMail($detail); 
                $sendMailController = $mailController;
                $sendMailController->sendMail($detail);
            }

            $notifications = [
                'user_id' => $order->user_id,
                'slug' => $order->users->username . '-' . Crypt::encryptString($order->id) . '-nomor-resi-diperbarui',
                'type' => 'Pesanan',
                'description' =>
                '<p class="m-0">Nomor resi pesanan ' . $order->invoice_no . ' diperbarui oleh ADMIN KLIKSPL.</p>
                <p class="m-0">Nomor resi terbaru pesanan anda : ' . $order->resi . '.</p><br>
                <p class="m-0">Silakan konfirmasi apabila pesanan sudah diterima.</p>',
                'excerpt' => 'No.Resi Pesanan Diperbarui',
                // 'image' => $shopBag,
                'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
                'is_read' => 0
            ];
            // membuat notifikasi pembuatan pesanan untuk user
            $notification = UserNotification::create($notifications);

            return redirect()->route('adminorder.index', ['status' => $request->session()->get('status')])->with('success', 'Status pesanan berhasil diperbarui');
        } else {
            return redirect()->route('adminorder.index', ['status' => $request->session()->get('status')])->with('failed', 'Status pesanan gagal diperbarui');
        }
    }


    public function isAdministrator()
    {
        if (auth()->guard('adminMiddle')->user()->admin_type != 1) {
            abort(403);
        }
    }

    public function isFinanceAndAdministrator()
    {
        if (auth()->guard('adminMiddle')->user()->admin_type != 1  && auth()->guard('adminMiddle')->user()->admin_type != 2) {
            // dd(auth()->guard('adminMiddle')->user()->admin_type);
            abort(403);
        }
    }

    public function confirmCancellationOrder(Request $request, MailController $mailController)
    {
        $this->expiredCheck();
        $order = Order::where('id', '=', $request->order_id)->first();
        $orderDetail = OrderStatusDetail::where([['order_id', '=', $request->order_id], ['status', '=', 'pengajuan pembatalan']])->first();
        $cancel_order_detail = explode(': ', $orderDetail->status_detail);
        // dd($cancel_order_detail);

        // dd($orderDetail->status_detail);
        // dd($request);
        $stockVariant = 0;
        $soldVariant = 0;
        foreach ($order->orderitem as $orderitem) {
            $product = Product::where('id', '=', $orderitem->product_id)->first();
            if (!empty($orderitem->product_variant_id)) {
                $productVariantId = ProductVariant::where('id', '=', $orderitem->product_variant_id)->first();
                // echo "product variant stock before : " .$productVariantId->stock;
                // echo "<br>";
                // echo "product variant sold before : " .$productVariantId->sold;
                // echo "<br>";
                $productVariantId->stock = (int)$productVariantId->stock + (int)$orderitem->quantity;
                $productVariantId->sold = (int)$productVariantId->sold - (int)$orderitem->quantity;
                // echo "product variant stock : " .$productVariantId->stock;
                // echo "<br>";
                // echo "product variant sold : " .$productVariantId->sold;
                // echo "<br>";
                // echo "order item qty : " .$orderitem->quantity;
                // echo "<br>";
                $stockVariant += $productVariantId->stock;
                $soldVariant += $productVariantId->sold;
                $productVariantId->save();

                // $product->stock = $stockVariant;
                // $product->sold = $soldVariant;
                // $product->save();
            } else {
                $product->stock = (int)$product->stock + (int)$orderitem->quantity;
                $product->sold = (int)$product->sold - (int)$orderitem->quantity;
                // echo "product stock : " . $product->stock;
                // echo "<br>";
                // echo "product sold : " . $product->sold;
                // echo "<br>";
                // echo "order item qty : " . $orderitem->quantity;
                // echo "<br>";
                $product->save();
            }
            // echo "product id : " . $product->id;
            // echo "<br>";
            // echo "not empty : " . !empty($product->productvariant);
            // echo "<br>";
            // echo "not null : " . !is_null($product->productvariant);
            // echo "<br>";
            // echo "count : " . count($product->productvariant);
            // echo "<br>";
            if (count($product->productvariant) > 0) {
                // echo ('ada product variant');
                // echo "<br>";
                $product->stock = $product->productvariant->sum('stock');
                $product->sold = $product->productvariant->sum('sold');
                $product->save();
            }
            // dd($request);
        }
        $order->order_status = 'pengajuan pembatalan dikonfirmasi';
        $order->save();
        if ($order->save()) {
            
            foreach ($order->orderitem as $item) {
                $item->order_item_status = 'pengajuan pembatalan dikonfirmasi';
                $item->save();
            }
            $orderProduct = $order->orderitem[0]->orderProduct;
            // $order->delete();
            if (!is_null($order->users->email)) {
                $details = ['id' => '2', 'email' => $order->users->email, 'title' => 'KLIK SPL: Pengajuan Pembatalan Dikonfirmasi', 'message' => 'Pengajuan Pembatalan Dikonfirmasi oleh Admin KLIKSPL. Alasan pembatalan: ' . $cancel_order_detail[1] . '. Silakan isi form pengembalian dana agar admin dapat segera melakukan pengembalian dana. Untuk melihat detail pesanan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/order', 'closing' => '', 'footer' => ''];
                $detail = new Request($details);
                // $this->mailController = $mailController;
                // $this->mailController->sendMail($detail); 
                $sendMailController = $mailController;
                $sendMailController->sendMail($detail);
            }

            $notifications = [
                'user_id' => $order->user_id,
                'slug' => $order->users->username . '-' . Crypt::encryptString($order->id) . '-pengajuan-pembatalan-dikonfirmasi',
                'type' => 'Pesanan',
                'description' => '<p class="m-0">Pengajuan Pembatalan Dikonfirmasi oleh Admin KLIKSPL. Alasan pembatalan: ' . $cancel_order_detail[1] . '. Silakan isi form pengembalian dana agar admin dapat segera melakukan pengembalian dana.</p>',
                'excerpt' => 'Pengajuan Pembatalan Dikonfirmasi',
                // 'image' => $shopBag,
                'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
                'is_read' => 0
            ];
            // membuat notifikasi pembuatan pesanan untuk user
            $notification = UserNotification::create($notifications);

            $sendAdminNotification = Admin::whereIn('admin_type', [2, 3])->where('company_id', '=', $orderProduct->company_id)->get();
            foreach ($sendAdminNotification as $admin) {
                if (!is_null($admin->email)) {
                    $details = ['id' => '2', 'email' => $admin->email, 'title' => 'KLIK SPL: Pengajuan Pembatalan Dikonfirmasi', 'message' => 'Pengajuan Pembatalan Dikonfirmasi oleh Admin KLIKSPL. Alasan pembatalan: ' . $cancel_order_detail[1] . '. Silakan tunggu user mengisi form pengembalian dana kemudian lakukan pengembalian dana. Untuk melihat detail pesanan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/administrator/adminorder', 'closing' => '', 'footer' => ''];
                    $detail = new Request($details);
                    // $this->mailController = $mailController;
                    // $this->mailController->sendMail($detail); 
                    $sendMailController = $mailController;
                    $sendMailController->sendMail($detail);
                }
            }
            
            $adminNotifications = [
                'order_id' => $order->id,
                'admin_id' => auth()->guard('adminMiddle')->user()->id,
                'admin_type' => 3,
                'company_id' => $orderProduct->company_id,
                'slug' => Crypt::encryptString($order->id) . '-pengajuan-pembatalan-dikonfirmasi',
                'type' => 'Pesanan',
                'description' => '<p class="m-0">Pengajuan Pembatalan Dikonfirmasi oleh Admin KLIKSPL. Alasan pembatalan: ' . $cancel_order_detail[1] . '. Silakan tunggu user mengisi form pengembalian dana kemudian lakukan pengembalian dana.</p>',
                'excerpt' => 'Pengajuan Pembatalan Dikonfirmasi',
                // 'image' => $shopBag,
                'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
                'is_read' => 0
            ];
            // membuat notifikasi pembuatan pesanan untuk admin
            $adminNotification = AdminNotification::create($adminNotifications);

            $orderStatus = OrderStatusDetail::create(
                [
                    'order_id' => $order->id,
                    'status' => 'Pengajuan Pembatalan Dikonfirmasi',
                    // 'status_detail' => 'Pembatalan Dikonfirmasi oleh Admin KLIKSPL.',
                    'status_detail' => 'Pengajuan Pembatalan Dikonfirmasi oleh Admin KLIKSPL. Alasan pembatalan: ' . $cancel_order_detail[1] . '. Silakan isi form pengembalian dana agar admin dapat segera melakukan pengembalian dana',
                    'status_date' => date('Y-m-d H:i:s')
                    // Dana yang sudah dibayarkan akan dikembalikan ke nomor rekening yang digunakan saat melakukan pembayaran
                ]
            );
            return redirect()->route('adminorder.index')->with('success', 'Berhasil mengonfirmasi pembatalan pesanan.');
        }
    }
    public function cancelOrder(Request $request)
    {
        // dd($request);
        $this->expiredCheck();
        $order = Order::where('id', '=', $request->order_id)->first();

        $cancel_order_detail = '';
        if (!is_null($request->cancel_order_detail)) {
            $cancel_order_detail = $request->cancel_order_detail;
        }

        $stockVariant = 0;
        $soldVariant = 0;
        foreach ($order->orderitem as $orderitem) {
            $product = Product::where('id', '=', $orderitem->product_id)->first();
            if (!empty($orderitem->product_variant_id)) {
                $productVariantId = ProductVariant::where('id', '=', $orderitem->product_variant_id)->first();

                $productVariantId->stock = (int)$productVariantId->stock + (int)$orderitem->quantity;
                $productVariantId->sold = (int)$productVariantId->sold - (int)$orderitem->quantity;

                $stockVariant += $productVariantId->stock;
                $soldVariant += $productVariantId->sold;
                $productVariantId->save();
            } else {
                $product->stock = (int)$product->stock + (int)$orderitem->quantity;
                $product->sold = (int)$product->sold - (int)$orderitem->quantity;

                $product->save();
            }

            if (count($product->productvariant) > 0) {
                $product->stock = $product->productvariant->sum('stock');
                $product->sold = $product->productvariant->sum('sold');
                $product->save();
            }
        }

        $order->order_status = 'pesanan dibatalkan';
        $order->save();
        if ($order->save()) {
            foreach ($order->orderitem as $item) {
                $item->order_item_status = 'pesanan dibatalkan';
                $item->save();
            }
            $order->delete();
            $orderStatus = OrderStatusDetail::create(
                [
                    'order_id' => $order->id,
                    'status' => 'Pesanan Dibatalkan',
                    // 'status_detail' => 'Pembatalan Dikonfirmasi oleh Admin KLIKSPL.',
                    'status_detail' => 'Pesanan dibatalkan oleh Admin KLIKSPL. Alasan pembatalan: ' . $cancel_order_detail . '. Dana yang sudah dibayarkan akan dikembalikan ke nomor rekening yang digunakan saat melakukan pembayaran',
                    'status_date' => date('Y-m-d H:i:s')
                ]
            );
            return redirect()->route('adminorder.index')->with('success', 'Berhasil mengonfirmasi pembatalan pesanan.');
        }
    }

    public function declineCancellationOrder(Request $request)
    {
        // dd($request);
        $this->expiredCheck();
        // dd($request);

        $order = Order::where('id', '=', $request->order_id)->first();

        $order->order_status = 'pembayaran dikonfirmasi';
        $order->save();

        if ($order->save()) {
            foreach ($order->orderitem as $item) {
                $item->order_item_status = 'pembayaran dikonfirmasi';
                $item->save();
            }
        }

        $orderStatus = OrderStatusDetail::create(
            [
                'order_id' => $order->id,
                'status' => 'Pengajuan Pembatalan Ditolak',
                'status_detail' => 'Pengajuan pembatalan pesanan ditolak oleh Admin KLIKSPL, dengan alasan: ' . $request->cancel_order_detail,
                'status_date' => date('Y-m-d H:i:s')
            ]
        );

        if ($orderStatus) {
            return redirect()->back()->with('success', 'Penolakan Pembayaran berhasil, pembeli diberikan waktu 2 x 24 jam untuk mengirimkan bukti pembayaran yang valid');
        } else {
            return redirect()->back()->with('failed', 'Terjadi kesalahan dalam pembatalan bukti pembayaran');
        }
    }
}
