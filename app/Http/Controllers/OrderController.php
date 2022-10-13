<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\UserAddress;
use App\Models\OrderAddress;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\UserNotification;
use App\Models\OrderProductImage;
use App\Models\OrderStatusDetail;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->expiredCheck();
        // dd(request(['status'])['status']);

        if (empty(request(['status'])['status'])) {
            $request->request->add(['status' => '']);
        }

        if (request(['status'])['status'] == '') {
            $header = 'Semua Pesanan';
        } else if (request(['status'])['status'] == 'belum bayar') {
            $header = 'Pesanan Belum Dibayar';
        } else if (request(['status'])['status'] == 'pesanan dibayarkan') {
            $header = 'Pesanan Menunggu Verifikasi';
        } else if (request(['status'])['status'] == 'pesanan disiapkan') {
            $header = 'Pesanan Disiapkan';
        } else if (request(['status'])['status'] == 'pesanan dikirim') {
            $header = 'Pesanan Dikirim';
        } else if (request(['status'])['status'] == 'selesai') {
            $header = 'Pesanan Selesai';
        } else if (request(['status'])['status'] == 'expired') {
            $header = 'Pesanan Dibatalkan';
        } else if (request(['status'])['status'] == 'pesanan dibatalkan') {
            $header = 'Pesanan Dibatalkan';
        } else {
            return redirect()->route('order.index');
        }
        $orders =  Order::where('user_id', '=', auth()->user()->id)->withTrashed()->with(['orderitem', 'orderstatusdetail'])->orderByDesc('created_at')->filter(request(['status']))->get();
        // dd(Order::where('order_status', 'like', '%' .request(['status'])['status'] . '%')->get());
        // dd(request(['status']));
        return view('order.index', [
            'title' => 'Pesanan Saya',
            'active' => 'order',
            'status' => request(['status'])['status'],
            'header' => $header,
            // 'orders' => $orders,
            'orders' => $orders,
        ]);
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
        
        $request->session()->put(['courier' => $request->courier]);
        $request->session()->put(['courier_package_type' => $request->courier_package_type]);
        $request->session()->put(['estimation' => $request->estimation]);
        $request->session()->put(['courier_price' => $request->courier_price]);
        $request->session()->put(['sender_address_id' => $request->sender_address_id]);
        $request->session()->put(['payment_method_id' => $request->payment_method_id]);
        $request->session()->put(['checkout_total_prices' => $request->checkout_total_prices]);
        $request->session()->put(['checkout_payment_total_price' => $request->checkout_payment_total_price]);
        // dd(auth()->user());
        // dd(session()->all());
        // dd($request);
        // dd(session()->get('items'));
        $this->expiredCheck();

        // $stockCheck = $this->stockCheck($request->cart_ids, 'cart.index', ['failed' => 'Stock produk saat ini sedang kosong, silakan pesan kembali jika stock product kembali ada']);
        // echo $stockCheck;
        // dd($request); 

        $req_cart = CartItem::where('id', '=', $request->cart_ids)->first();
        // dd($req_cart);
        if ($req_cart) {

            if ($req_cart->product_variant_id != 0) {
                if ($req_cart->productvariant->stock == 0) {
                    // dd($req_cart->productvariant->stock);
                    // echo "prod var stock";
                    // print_r($req_cart->productvariant->stock);
                    // echo "</br></br>";
                    // echo redirect()->route('cart.index')->with(['failed' => 'Stock produk saat ini sedang kosong, silakan pesan kembali jika stock product kembali ada']);
                    return redirect()->route('cart.index')->with(['failed' => 'Stock produk saat ini sedang kosong, silakan pesan kembali jika stock product kembali ada']);
                    // dd($id);
                }
            } else {
                if ($req_cart->product->stock == 0) {
                    // echo "prod stock";
                    // print_r($req_cart->product->stock);
                    // echo "</br></br>";
                    return redirect()->route('cart.index')->with(['failed' => 'Stock produk saat ini sedang kosong, silakan pesan kembali jika stock product kembali ada']);
                    // 
                }
            }
        } elseif (!is_null($request->product_variant_id)) {
            $product = Product::where('id', '=', $request->product_id)->first();
            $prodVariant = ProductVariant::where('id', '=', $request->product_variant_id)->first();
            if ($prodVariant) {
                if ($prodVariant->stock == 0) {
                    return redirect()->route('product.show', $product)->with(['failed' => 'Stock produk saat ini sedang kosong, silakan pesan kembali jika stock product kembali ada']);
                }
            }
        } elseif (!is_null($request->product_id)) {
            $product = Product::where('id', '=', $request->product_id)->first();
            if ($product) {
                if ($product->stock) {
                    return redirect()->route('product.show', $product)->with(['failed' => 'Stock produk saat ini sedang kosong, silakan pesan kembali jika stock product kembali ada']);
                }
            }
        }
        // dd($request);
        $userAddress = UserAddress::where([['user_id', '=', $request->user_id], ['is_active', '=', '1']])->first();
        $orderAddress = OrderAddress::firstOrCreate(
            [
                'user_id' => $userAddress->user_id,
                'name' => $userAddress->name,
                'address' => $userAddress->address,
                'district' => $userAddress->district,
                'city_ids' => $userAddress->city_ids,
                'province_ids' => $userAddress->province_ids,
                'postal_code' => $userAddress->postal_code,
                'telp_no' => $userAddress->telp_no,
            ]
        );
        $orderAddressId = $orderAddress->id;

        // echo "Order Address<br> : ";
        // print_r($orderAddress);
        // echo "<br><br>";

        // $unique_code = mt_rand(000, 999);
        $unique_code = 000;
        $estimation_day = substr($request->estimation, -1);
        $estimation_date = date('Y-m-d H:i:s', strtotime('+' . $estimation_day . ' days'));
        $payment_due_date = date("Y-m-d H:i:s", strtotime('+24 hours'));

        $request->merge([
            'order_address_id' => $orderAddressId,
            'unique_code' => $unique_code,
            'estimation_day' => $estimation_day,
            'estimation_date' => $estimation_date,
            'total_price' => $request->checkout_total_prices,
            'order_status' => 'belum bayar',
            'retur' => '0',
            'payment_due_date' => $payment_due_date,
            'sender_address_id' => $request->sender_address_id,

        ]);

        $validatedData = $request->validate([
            'user_id' => 'required',
            'order_address_id' => 'required',
            'courier' => 'required',
            'courier_package_type' => 'required',
            'estimation_day' => 'required',
            'estimation_date' => 'required',
            'courier_price' => 'required',
            'total_price' => 'required',
            'order_status' => 'nullable',
            'retur' => 'nullable',
            'unique_code' => 'required',
            'payment_method_id' => 'required',
            'payment_due_date' => 'required',
            'sender_address_id' => 'required',
        ]);

        $order = Order::create($validatedData);
        $order->save();
        $orderId = $order->id;
        $request->session()->put('orderId', $orderId);

        $statusDetail = 'batas pembayaran ' . \Carbon\Carbon::parse($order->payment_due_date)->isoFormat('dddd,D MMMM Y | HH:mm') . ' WIB';
        $orderStatus = OrderStatusDetail::create(
            [
                'order_id' => $orderId,
                'status' => 'Pesanan Dibuat',
                'status_detail' => $statusDetail,
                'status_date' => date('Y-m-d H:i:s')
            ]
        );

        // echo "Order<br> : ";
        // print_r($order);
        // echo "<br><br>";

        if (empty(array_filter($request->cart_ids))) {
            // echo 'empty';
            $validatedData = $request->validate(
                [
                    'user_id' => 'required',
                    'product_id' => 'required',
                    'product_variant_id' => 'required',
                    'quantity' => 'required',
                    'subtotal' => 'required',
                ],
                [
                    'product_variant_id.required' => 'Pilih varian produk terlebih dahulu'
                ]
            );
            $cart = CartItem::create($validatedData);
            $items = CartItem::where('id', '=', $cart->id)->with('product', 'productvariant')->get()->sortByDesc('created_at');
        } else {
            $items = CartItem::whereIn('id', $request->cart_ids)->with('product', 'productvariant')->get()->sortByDesc('created_at');
            // $items = session()->get('items');
        }

        // echo "Items<br> : ";
        // print_r($items);
        // echo "<br><br>";

        foreach ($items as $item) {

            $orderProduct = [
                'name' => $item->product->name,
                'specification' => $item->product->specification,
                'description' => $item->product->description,
                'excerpt' => $item->product->excerpt,
                'slug' => $item->product->slug,
                'product_code' => $item->product->product_code,
                'product_category' => $item->product->productCategory->name,
                'product_merk' => $item->product->productMerk->name,
            ];
            $promo = Promo::where('id', '=', $item->product->promo_id)->first();
            if ($promo) {
                $orderProduct['promo_name'] = $promo->name;
                $orderProduct['promo_discount'] = $promo->discount;
            } else {
                $orderProduct['promo_name'] = '';
                $orderProduct['promo_discount'] = 0;
            }

            if ($item->product_variant_id == 0) {
                $orderProduct['stock'] = $item->product->stock;
                $orderProduct['weight'] = $item->product->weight;
                $orderProduct['price'] = $item->product->price;
            } else {
                $orderProduct['variant_name'] = $item->productvariant->variant_name;
                $orderProduct['variant_value'] = $item->productvariant->variant_name;
                $orderProduct['variant_code'] = $item->productvariant->variant_code;
                $orderProduct['stock'] = $item->productvariant->stock;
                $orderProduct['weight'] = $item->productvariant->weight;
                $orderProduct['price'] = $item->productvariant->price;
            }

            $orderProducts = OrderProduct::firstOrCreate($orderProduct);
            $orderProductId = $orderProducts->id;
            $orderProductIds[] = $orderProducts->id;

            // echo "Order product<br> : ";
            // print_r($orderProducts);
            // echo "<br><br>";
            // echo "Order product image<br> : ";
            // print_r($item->product->productImage);
            // echo "<br><br>";
            if ($item->product->productImage->count()) {
                // echo "image product issets";
                // echo "<br><br>";
                foreach ($item->product->productImage as $image) {

                    $folderPathSave = 'user/' . auth()->user()->username . '/order/' . $orderId . '/' . $orderProductId . '/';

                    // img nantinya mengakses ke storage product image 
                    $img = $image->name;
                    $img = explode('/', $img);

                    // echo "user Image<br> : ";
                    // print_r($img);
                    // echo "<br><br>";

                    $imageName = uniqid() . '.jpg';

                    $imageFullPathSave = $folderPathSave . $imageName;

                    // $copy = Storage::copy($image->name, $imageFullPathSave);
                    $createFolder = Storage::makeDirectory($folderPathSave);
                    $copy = Image::make(Storage::path($image->name))->resize(300, 300, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(Storage::path($imageFullPathSave));

                    // echo "copy<br> : ";
                    // print_r($copy);
                    // echo "<br><br>";

                    $orderProductImages = [
                        'order_product_id' => $orderProductId,
                        'name' => $imageFullPathSave
                    ];

                    $orderProductImage = OrderProductImage::create($orderProductImages);

                    // echo "Order Product Image<br> : ";
                    // print_r($orderProductImage);
                    // echo "<br><br>";
                }
            } else {
                $folderPathSave = 'user/' . auth()->user()->username . '/order/' . $orderId . '/' . $orderProductId . '/';
                // img nantinya mengakses ke storage product image 
                $img = auth()->user()->profile_image;
                $img = explode('/', $img);

                // echo "user Image with no prod images<br> : ";
                // print_r($img);
                // echo "<br><br>";

                $imageName = uniqid() . '.jpg';

                $imageFullPathSave = $folderPathSave . $imageName;

                $copy = Storage::copy(auth()->user()->profile_image, $imageFullPathSave);

                // echo "copy<br> : ";
                // print_r($copy);
                // echo "<br><br>";

                $orderProductImages = [
                    'order_product_id' => $orderProductId,
                    'name' => $imageFullPathSave
                ];

                $orderProductImage = OrderProductImage::create($orderProductImages);

                // echo "Order Product Image<br> : ";
                // print_r($orderProductImage);
                // echo "<br><br>";
            }

            $data = [
                'order_id' => $orderId,
                'user_id' => $request->user_id,
                'product_id' => $item->product_id,
                'product_variant_id' => $item->product_variant_id,
                'order_product_id' => $orderProductId,
                'quantity' => $item->quantity,
                'total_price_item' => $item->subtotal,
                'order_item_status' => 'belum bayar',
                'retur' => '0',
            ];

            if ($item->product_variant_id == 0) {
                $data['price'] = $item->product->price;
            } else {
                $data['price'] = $item->productvariant->price;
            }

            $orderItems = OrderItem::create($data);
            $orderItemIds[] = $orderItems->id;

            // echo "Order Items<br> : ";
            // print_r($orderItems);
            // echo "<br><br>";
        }
        $request->session()->put(['orderItemIds' => $orderItemIds]);
        $request->session()->put(['orderProductIds' => $orderProductIds]);

        foreach ($request->cart_ids as $ids) {
            $deleteCartItem = CartItem::where('id', $ids)->delete();
        }
        $description = '';
        $notifications = [
            'user_id' => auth()->user()->id,
            'slug' => auth()->user()->username . '-' . $order->id . '-pesanan-berhasil-dibuat',
            'type' => 'Pesanan',
            'description' => '<p>Pesanan kamu berhasil dibuat. Produk yang kamu pesan berjumlah ' . $order->orderitem->count() . ' item.</p>',
            'excerpt' => 'Pesanan kamu berhasil dibuat',
            'image' => 'storage/' . $orderProductImage->name,
            'is_read' => 0
        ];

        $notification = UserNotification::create($notifications);

        return redirect()->route('payment.order.bind', $order);
    }

    public function stockCheck($id, $route, $failedMessage)
    {
        foreach ($id as $cartId) {
            $req_cart = CartItem::where('id', '=', $cartId)->first();
            // dd($req_cart);
            // echo "req cart";
            // print_r($req_cart);
            // echo "</br></br>";
            // echo "route";
            // print_r($route);
            // echo "</br></br>";
            // echo "failed Message";
            // print_r(array_values($failedMessage));
            // echo "</br></br>";
            // dd($req_cart->productvariant->stock);
            if ($req_cart->product_variant_id != 0) {
                if ($req_cart->productvariant->stock == 0) {
                    // dd($req_cart->productvariant->stock);
                    // echo "prod var stock";
                    // print_r($req_cart->productvariant->stock);
                    // echo "</br></br>";
                    // echo redirect()->route('cart.index')->with(['failed' => 'Stock produk saat ini sedang kosong, silakan pesan kembali jika stock product kembali ada']);
                    return redirect()->route($route)->with($failedMessage);
                    // dd($id);
                }
            } else {
                if ($req_cart->product->stock == 0) {
                    // echo "prod stock";
                    // print_r($req_cart->product->stock);
                    // echo "</br></br>";
                    return redirect()->route($route)->with($failedMessage);
                    // dd($id);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->expiredCheck();
        // dd($id);
        $order = Order::withTrashed()->find($id);
        // dd($order);
        if ($order->order_status === 'belum bayar') {
            // dd(1);
            return redirect()->route('payment.order.bind', $id);
        } else {
            // dd($order->id);
            return redirect()->route('order.detail.bind', $id);
        }
    }

    // public function orderCanceledDetail($id)
    // {
    //     // dd($id);
    //     $order = Order::withTrashed()->find($id);
    //     // dd($order);

    //     foreach ($order->orderitem as $item) {
    //         $orderProductIds[] = $item->orderproduct->id;
    //     }
    //     $orders = Order::withTrashed()->where('id','=', $order->id)->get();
    //     // dd($orders);
    //     $orderItems = $order->orderitem;
    //     $orderProducts = OrderProduct::whereIn('id', $orderProductIds)->get();
    //     return view(
    //         'order.canceled-detail',
    //         [
    //             'title' => 'Pembayaran',
    //             'active' => 'order',
    //             'orders' => $orders,
    //             'orderItems' => $orderItems,
    //             'orderProducts' => $orderProducts,
    //         ]
    //     );
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        dd($order);
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
        dd($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order, Request $request)
    {
        // ddd($order->orderItem);

        // foreach ($order->orderItem as $orderItem) {
        //     // echo "order item: <br>";
        //     // print_r($orderItem);
        //     // echo "<br><br>";
        //     echo "order product: <br>";
        //     print_r($orderItem->orderProduct);
        //     echo "<br><br>";

        //     foreach ($orderItem->orderProduct->orderProductImage as $orderProductImage) {
        //         echo "order product: <br>";
        //         print_r($orderProductImage->name);
        //         echo "<br><br>";

        //     }
        // }
        // dd($request);
        $folderPathSave = 'user/' . auth()->user()->username . '/order/' . $order->id;
        if (auth()->user()->id == $order->user_id) {
            foreach ($order->orderItem as $orderItem) {
                foreach ($orderItem->orderProduct->orderProductImage as $orderProductImage) {
                    $orderProductImage->delete();
                    $orderItem->orderProduct->delete();
                }
                $orderItem->delete();
            }
            foreach ($order->orderstatusdetail as $orderDetail) {
                $orderDetail->delete();
            }
            Storage::deleteDirectory($folderPathSave);
            $order->forceDelete();
            return redirect()->route('order.index')->with('success', 'Berhasil membatalkan pesanan.');
        } else {
            // return redirect('/dashboard/posts')->with('failed','Delete post failed!');
            abort(403);
        }
    }

    public function deleteOrder(Request $request, Order $order)
    {
        // dd($order);
        // dd($request);
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
                    'status_detail' => 'Pesanan akan dihapus otomatis 60 hari setelah hari pembatalan. Alasan pembatalan: ' . $request->cancel_order_detail,
                    'status_date' => date('Y-m-d H:i:s')
                ]
            );
            return redirect()->route('order.index')->with('success', 'Berhasil membatalkan pesanan.');
        }
    }

    public function orderDetail(Request $request)
    {
        $this->expiredCheck();
        $orderItemIds = session()->get('orderItemIdsDetail');
        $orderProductIds = session()->get('orderProductIdsDetail');

        $order = Order::where('id', session()->get('orderIdDetail'))->get();
        $orderItems = OrderItem::whereIn('id', $orderItemIds)->get();
        $orderProducts = OrderProduct::whereIn('id', $orderProductIds)->get();

        // print_r(session()->get('orderId'));
        // print_r(session()->get('orderItemIds'));
        // print_r(session()->get('orderProductIds'));
        return view(
            'order.detail',
            [
                'title' => 'Detail Pesanan',
                'active' => 'order',
                'orders' => $order,
                'orderItems' => $orderItems,
                'orderProducts' => $orderProducts,
            ]
        );
    }

    public function paymentOrder(Request $request)
    {
        $this->expiredCheck();

        // dd(session()->all());
        // dd($orderItemIds);
        // print_r(session()->get('orderId'));
        // print_r(session()->get('orderItemIds'));
        // print_r(session()->get('orderProductIds'));

        $orderItemIds = session()->get('orderItemIdsPayment');
        $orderProductIds = session()->get('orderProductIdsPayment');

        $order = Order::where('id', session()->get('orderIdPayment'))->get();
        $orderItems = OrderItem::whereIn('id', $orderItemIds)->get();
        $orderProducts = OrderProduct::whereIn('id', $orderProductIds)->get();

        $weightGr = 0;
        foreach ($orderItems as $item) {
            $weightGr += ($item->quantity * $item->orderproduct->weight);
        }
        $weight = round(($weightGr / 1000), 2);
        // echo "<br><br> order  <br>";
        // print_r($order[0]);
        // echo "<br><br> order items <br>";
        // print_r($orderItems);
        // echo "<br><br> order products <br>";
        // print_r($orderProducts);

        // print_r($orderId->orderitem);
        // dd($orderItemIds->order);

        return view(
            'order.payment',
            [
                'title' => 'Pembayaran',
                'active' => 'order',
                'orders' => $order,
                'orderItems' => $orderItems,
                'orderProducts' => $orderProducts,
                'weight' => $weight,
            ]
        );
    }

    public function paymentCompleted(Request $request)
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

        $order = Order::where('id', '=', $request->order_id)->first();

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


        if (Order::whereNotNull('invoice_no')->exists()) {
            // dd(Order::where('invoice_no','like','%0822%')->max('invoice_no'));
            // $lastInvNo = Order::orderBy('invoice_no', 'desc')->whereNotNull('invoice_no')->pluck('invoice_no')->first();
            $lastInvNo = Order::where('invoice_no', 'like', '%' . date('my') . '%')->max('invoice_no');
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

        $folderPathSave = 'user/' . auth()->user()->username . '/order/' . $request->order_id . '/proof-of-payment';

        // echo $folderPathSave;
        // echo "<br><br>";
        // echo $request->order_id;

        if ($request->file('proof_of_payment')) {
            // echo 'if req proof';
            $validatedData['proof_of_payment'] = $request->file('proof_of_payment')->store($folderPathSave);
            // echo $validatedData['proof_of_payment'];
        }
        $order = Order::where('id', '=', $request->order_id)->first();

        $order->proof_of_payment = $validatedData['proof_of_payment'];
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
        // // img nantinya mengakses ke storage product image 
        // $img = auth()->user()->profile_image;
        // $img = explode('/', $img);

        // echo "user Image<br> : ";
        // print_r($img);
        // echo "<br><br>";

        // $imageName = uniqid() . '.jpg';

        // $imageFullPathSave = $folderPathSave . $imageName;

        // $copy = Storage::copy(auth()->user()->profile_image, $imageFullPathSave);


        return redirect()->route('order.index')->with('success', 'Terimakasih telah menyelesaikan pembayaran, silakan menunggu untuk konfirmasi oleh admin KLIKSPL selanjutnya');
    }

    public function paymentReupload(Request $request)
    {
        $order = Order::where('id', '=', $request->order_id)->first();

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

        $folderPathSave = 'user/' . auth()->user()->username . '/order/' . $request->order_id . '/proof-of-payment';

        // echo $folderPathSave;
        // echo "<br><br>";
        // echo $request->order_id;
        $proof_of_payment_prev = $order->proof_of_payment;
        if ($proof_of_payment_prev) {
            Storage::delete($proof_of_payment_prev);
        }

        if ($request->file('proof_of_payment')) {
            // echo 'if req proof';
            $validatedData['proof_of_payment'] = $request->file('proof_of_payment')->store($folderPathSave);
            // echo $validatedData['proof_of_payment'];
        }
        $order = Order::where('id', '=', $request->order_id)->first();

        $order->proof_of_payment = $validatedData['proof_of_payment'];
        $order->order_status = 'upload ulang bukti pembayaran';
        $updateOrder = $order->save();

        if ($updateOrder) {
            foreach ($order->orderitem as $item) {
                $item->order_item_status = 'upload ulang bukti pembayaran';
                $item->save();
            }
        }

        $orderStatus = OrderStatusDetail::create(
            [
                'order_id' => $order->id,
                'status' => 'upload ulang bukti pembayaran',
                'status_detail' => 'Beerhasil mengupload ulang bukti pembayaran! Menunggu Verifikasi Pembayaran oleh Admin KLIKSPL',
                'status_date' => date('Y-m-d H:i:s')
            ]
        );
        if ($updateOrder && $orderStatus) {
            return redirect()->back()->with(['success' => 'Berhasil mengupload ulang bukti pembayaran']);
        } else {
            return redirect()->back()->with(['failed' => 'Gagal mengupload ulang bukti pembayaran! Error code: OCxPaymentReuploadx00001']);
        }
    }

    public function paymentOrderBind($id)
    {
        $this->expiredCheck();

        $order = Order::where('id', $id)->with(['orderitem', 'orderstatusdetail'])->first();
        // dd($order->orderitem[0]->product);

        if (!is_null($order->invoice_no)) {
            return redirect()->route('order.index');
        }
        // $now = Carbon::now();
        // echo $now;
        // echo "<br><br>";
        // $due_date = Carbon::createFromFormat('Y-m-d H:s:i', $order->payment_due_date);
        // echo $due_date;
        // echo "<br><br>";
        // if ($due_date > $now) {
        //     dd('telat');
        // }
        foreach ($order->orderitem as $item) {
            $orderProductIds[] = $item->orderproduct->id;
        }
        $orders = Order::where('id', $order->id)->with(['orderitem', 'orderstatusdetail', 'paymentmethod', 'orderaddress'])->get();
        $orderItems = $order->orderitem;
        $orderProducts = OrderProduct::whereIn('id', $orderProductIds)->with(['orderitem', 'orderproductimage'])->get();

        $weightGr = 0;
        foreach ($orderItems as $item) {
            $weightGr += ($item->quantity * $item->orderproduct->weight);
        }
        $weight = round(($weightGr / 1000), 2);

        return view(
            'order.payment',
            [
                'title' => 'Pembayaran',
                'active' => 'order',
                'orders' => $orders,
                'orderItems' => $orderItems,
                'orderProducts' => $orderProducts,
                'weight' => $weight,
            ]
        );
    }

    public function orderDetailBind($id)
    {
        $this->expiredCheck();

        // dd($order->id);
        $order = Order::withTrashed()->where('id', $id)->first();
        foreach ($order->orderitem as $item) {
            $orderProductIds[] = $item->orderproduct->id;
        }
        $orders = Order::withTrashed()->where('id', $id)->get();
        // dd($orders);
        $orderItems = $order->orderitem;
        $orderProducts = OrderProduct::whereIn('id', $orderProductIds)->get();

        $weightGr = 0;
        foreach ($orderItems as $item) {
            $weightGr += ($item->quantity * $item->orderproduct->weight);
        }
        $weight = round(($weightGr / 1000), 2);
        return view(
            'order.detail',
            [
                'title' => 'Detail Pesanan',
                'active' => 'order',
                'orders' => $orders,
                'orderItems' => $orderItems,
                'orderProducts' => $orderProducts,
                'weight' => $weight,
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
        return response()->download(storage_path("app/public") . '/' . $request->proofOfPayment, str_replace("/", "-", $request->inv_no) . '-' . auth()->user()->username . '-proof-of-payment.png', $headers);
    }

    public function expiredCheck()
    {
        $now = Carbon::now();

        $orders = Order::where('user_id', '=', auth()->user()->id)->withTrashed()->orderByDesc('created_at')->get();
        // print_r($orders);
        // dd($orders[0]->orderitem[0]->orderproduct->orderproductimage[0]->name);
        // dd($orders[0]->orderitem->count());
        foreach ($orders as $userOrder) {
            // echo "order: ";
            // print_r($userOrder->id);
            // echo "<br><br>";
            // $userOrder->uuid = Hash::make($userOrder->id);

            if (is_null($userOrder->deleted_at) && is_null($userOrder->invoice_no)) {

                $due_date = Carbon::createFromFormat('Y-m-d H:s:i', $userOrder->payment_due_date);
                // dd($due_date);
                if ($now > $due_date) {
                    // dd('expired');
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
            } elseif (!is_null($userOrder->deleted_at) && is_null($userOrder->invoice_no)) {
                $deleted_at = Carbon::createFromFormat('Y-m-d H:s:i', $userOrder->deleted_at);
                $diff_in_hours = $deleted_at->diffInHours($now);
                if ($diff_in_hours > 24) {
                    // echo $deleted_at;
                    // echo "<br><br>";
                    // echo $now;
                    // echo "<br><br>";
                    // echo "arr : ";
                    // print_r($diff_in_hours);
                    // echo "<br><br>";
                    // $userOrder->forceDelete();

                    foreach ($userOrder->orderItem as $orderItem) {
                        // echo "order item : ";
                        // print_r($orderItem->orderproduct);
                        // echo "<br><br>";
                        // echo "prod image count : ";
                        // echo count($orderItem->orderproduct->orderproductimage);
                        if ($orderItem->orderproduct->orderproductimage->count()) {
                            // print_r($orderItem->product->productImage->id);
                            // echo "<br><br>";
                            foreach ($orderItem->orderProduct->orderProductImage as $orderProductImage) {
                            }
                            // echo "order item id: " . $orderItem->id;
                            // echo "<br><br>";
                            // echo "order item product id: " . $orderItem->product_id;
                            // echo "<br><br>";
                            // echo "order item product variant id: " . $orderItem->product_variant_id;
                            // echo "<br><br>";

                            $cartItem = CartItem::where([['user_id', '=', auth()->user()->id], ['product_id', '=', $orderItem->product_id], ['product_variant_id', '=', $orderItem->product_variant_id]])->withTrashed()->first();
                            $cartItem->deleted_at = NULL;
                            $cartItem->save();
                            // $orderProductImage->delete();
                            // $orderItem->orderProduct->delete();
                            // print_r($cartItem);
                        } else {
                            $cartItem = CartItem::where([['user_id', '=', auth()->user()->id], ['product_id', '=', $orderItem->product_id], ['product_variant_id', '=', $orderItem->product_variant_id]])->withTrashed()->first();
                            $cartItem->deleted_at = NULL;
                            $cartItem->save();
                            // $orderProductImage->delete();
                            // $orderItem->orderProduct->delete();
                        }
                        // $orderItem->delete();
                    }
                    // $userOrder->forceDelete();   
                    // foreach ($orders->orderItem as $orderItem) {
                    //     foreach ($orderItem->orderProduct->orderProductImage as $orderProductImage) {
                    //         $orderProductImage->delete();
                    //         $orderItem->orderProduct->delete();
                    //     }
                    //     $orderItem->delete();
                    // }
                    // $orders->forceDelete();
                }
            }
        }
    }
    public function confirmOrder(Request $request)
    {
        $request->merge(['id' => $request->orderId]);

        $validatedData = $request->validate(
            [
                'id' => 'required'
            ],
            [
                'id.required' => 'Pilih pesanan yang akan dikonfirmasi'
            ]
        );

        $order = Order::find($validatedData['id']);
        $order->order_status = 'selesai';
        $OrderDelivered = $order->save();

        if ($OrderDelivered) {
            foreach ($order->orderitem as $item) {
                $item->order_item_status = 'selesai';
                $item->save();
            }
        }
        $orderStatus = OrderStatusDetail::create(
            [
                'order_id' => $order->id,
                'status' => 'selesai',
                'status_detail' => 'Pesanan sudah diterima pada ' . Carbon::now()->isoFormat('D MMMM Y, HH:mm') . ' WIB',
                'status_date' => date('Y-m-d H:i:s')
            ]
        );

        if ($OrderDelivered && $orderStatus) {
            return redirect()->back()->with('success', 'Pesanan sudah diterima Terimakasih sudah berbelanja di KLIKSPL :)');
        } else {
            return redirect()->back()->with('failed', 'Gagal menerima pesanan.');
        }
        // dd($request);

    }
}