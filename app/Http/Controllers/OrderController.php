<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Payment;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Province;
use App\Models\OrderItem;
use App\Models\UserAddress;
use App\Models\OrderAddress;
use App\Models\OrderProduct;
use App\Models\ProductPromo;
use App\Models\UserPromoUse;
use Illuminate\Http\Request;
use App\Models\ProductOrigin;
use App\Models\SenderAddress;
use App\Models\ProductComment;
use App\Models\ProductVariant;
use App\Models\UserNotification;
use App\Models\OrderProductImage;
use App\Models\OrderStatusDetail;
use App\Models\UserPromoOrderUse;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
// use Pdf;

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
        } else if (request(['status'])['status'] == 'aktif') {
            $header = 'Pesanan Aktif';
        } else if (request(['status'])['status'] == 'belum bayar') {
            $header = 'Pesanan Belum Dibayar';
        } else if (request(['status'])['status'] == 'pesanan dibayarkan') {
            $header = 'Pesanan Menunggu Verifikasi';
        } else if (request(['status'])['status'] == 'pembayaran dikonfirmasi') {
            $header = 'Pembayaran Dikonfirmasi';
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
        // dd($request);

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

        // dd($userPromoUse);
        $discount = 0;
        // $userPromoUse = null;

        if (!is_null($request->promo_use_id)) {

            $userPromoUse = UserPromoUse::firstOrCreate(
                [
                    'user_id' => auth()->user()->id,
                    'promo_id' => $request->promo_use_id,
                ]
            );

            $promo = Promo::find($request->promo_use_id);

            if ((int)$request->checkout_total_prices >= (int)$promo->min_transaction) {
                // dd($promo->min_transaction);
                echo 'dapat diskon';
            }
            // dd($promo->min_transaction);
            // $productPromoGroup = $productPromo->groupBy('promo_id');
            // dd($productPromoGroup);

            if ($userPromoUse->promo_use >= $promo->quota) {
                return redirect()->back()->with('failed', 'Gagal menggunakan kode promo! Penggunaan kode promo melebihi batas quota yang ditentukan');
            } else {
                // $userPromoUse->promo_use +=1;
                // $userPromoUse->save();
                // dd($userPromoUse);
            }
        }
        // dd($promo);

        // dd($request);
        // dd(session()->get('items'));
        $this->expiredCheck();

        // $stockCheck = $this->stockCheck($request->cart_ids, 'cart.index', ['failed' => 'Stock produk saat ini sedang kosong, silakan pesan kembali jika stock product kembali ada']);
        // echo $stockCheck;
        // dd($request); 

        // cek stock cart items
        $req_cart = CartItem::whereIn('id', $request->cart_ids)->get();
        // dd($req_cart);
        foreach ($req_cart as $cart_item) {
            if ($cart_item) {
                if ($cart_item->product_variant_id != 0) {
                    if ($cart_item->productvariant->stock == 0) {
                        // dd($cart_item->productvariant->stock);
                        // echo "prod var stock";
                        // print_r($cart_item->productvariant->stock);
                        // echo "</br></br>";
                        // echo redirect()->route('cart.index')->with(['failed' => 'Stock produk saat ini sedang kosong, silakan pesan kembali jika stock product kembali ada']);
                        return redirect()->route('cart.index')->with(['failed' => 'Stock produk saat ini sedang kosong, silakan pesan kembali jika stock product kembali ada']);
                        // dd($id);
                    }
                } else {
                    if ($cart_item->product->stock == 0) {
                        // echo "prod stock";
                        // print_r($req_cart->product->stock);
                        // echo "</br></br>";
                        return redirect()->route('cart.index')->with(['failed' => 'Stock produk saat ini sedang kosong, silakan pesan kembali jika stock product kembali ada']);
                        // 
                    }
                }
            }
            // } elseif (!is_null($request->product_variant_id)) {
            //     $product = Product::where('id', '=', $request->product_id)->first();
            //     $prodVariant = ProductVariant::where('id', '=', $request->product_variant_id)->first();
            //     if ($prodVariant) {
            //         if ($prodVariant->stock == 0) {
            //             return redirect()->route('product.show', $product)->with(['failed' => 'Stock produk saat ini sedang kosong, silakan pesan kembali jika stock product kembali ada']);
            //         }
            //     }
            // } elseif (!is_null($request->product_id)) {
            //     $product = Product::where('id', '=', $request->product_id)->first();
            //     if ($product) {
            //         if ($product->stock) {
            //             return redirect()->route('product.show', $product)->with(['failed' => 'Stock produk saat ini sedang kosong, silakan pesan kembali jika stock product kembali ada']);
            //         }
            //     }
            // }
        }
        // dd($request);
        // retrieve user address yang order
        $userAddress = UserAddress::where([['user_id', '=', $request->user_id], ['is_active', '=', '1']])->first();

        // membuat alamat pengiriman untuk user di table orderAddress
        // jika alamat user tidak ditemukan maka membuat alamat baru
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

        // inisiasi val. $orderAddressId dari $orderAddress diatas
        $orderAddressId = $orderAddress->id;

        // echo "Order Address<br> : ";
        // print_r($orderAddress);
        // echo "<br><br>";

        // $unique_code = mt_rand(000, 999);
        // menambahkan kode unik ke pembayaran pesanan, estimasi jlh hari pengiriman, estimasi tanggal pengiriman sampai, dan batas pembayaran
        $unique_code = 000;
        $estimation_day = substr($request->estimation, -1);
        $estimation_date = date('Y-m-d H:i:s', strtotime('+' . $estimation_day . ' days'));
        $payment_due_date = date("Y-m-d H:i:s", strtotime('+24 hours'));

        // menambahkan variabel ke $request
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

        // melakukan validasi variabel yang ada di $request dengan rules yang diberikan
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

        // insert order/pesanan ke dalam DB 
        $order = Order::create($validatedData);
        // $order->discount = $discount;
        $order->save();

        $orderId = $order->id;

        // menambahkan variabel $orderId ke session() agar dapat diakses menggunakan session()
        $request->session()->put('orderId', $orderId);

        // status detail pesanan
        $statusDetail = 'batas pembayaran ' . \Carbon\Carbon::parse($order->payment_due_date)->isoFormat('dddd,D MMMM Y | HH:mm') . ' WIB';

        // insert status order ke dalam DB
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

        // cek apakah ada nilai yg kosong/null dalam array cart ids
        // case untuk order dari BUY NOW
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
            // insert data produk yg di BUY NOW ke dalam cart items
            $cart = CartItem::create($validatedData);
            // retrieve cart items yg baru di buat dan disimpan di $items
            $items = CartItem::where('id', '=', $cart->id)->with('product', 'productvariant')->get()->sortByDesc('created_at');
            // case dari CART (produk yang dipesan sudah masuk ke dalam cart items)
        } else {
            // retrieve cart items yg baru di buat dan disimpan di $items
            $items = CartItem::whereIn('id', $request->cart_ids)->with('product', 'productvariant')->get()->sortByDesc('created_at');
            // $items = session()->get('items');
        }

        // echo "Items<br> : ";
        // print_r($items);
        // echo "<br><br>";

        // Looping $items
        foreach ($items as $item) {
            // inisiasi array $orderProduct (product yang dipesan) dari data $items sebelumnya
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
            // retrieve apakah ada promo
            // $promo = Promo::where('id', '=', $item->product->promo_id)->first();
            // if ($promo) {
            //     $orderProduct['promo_name'] = $promo->name;
            //     $orderProduct['promo_discount'] = $promo->discount;
            // } else {
            //     $orderProduct['promo_name'] = '';
            //     $orderProduct['promo_discount'] = 0;
            // }
            // cek apakah item terdapat varian
            if ($item->product_variant_id == 0) {
                $orderProduct['stock'] = $item->product->stock;
                $orderProduct['weight'] = $item->product->weight_used;
                $orderProduct['price'] = $item->product->price;
            } else {
                $orderProduct['variant_name'] = $item->productvariant->variant_name;
                $orderProduct['variant_value'] = $item->productvariant->variant_name;
                $orderProduct['variant_code'] = $item->productvariant->variant_code;
                $orderProduct['stock'] = $item->productvariant->stock;
                $orderProduct['weight'] = $item->productvariant->weight_used;
                $orderProduct['price'] = $item->productvariant->price;
            }

            // insert data orderProduct ke dalam table order product
            $orderProducts = OrderProduct::firstOrCreate($orderProduct);

            // retrieve order product id ke dalam array
            $orderProductId = $orderProducts->id;
            $orderProductIds[] = $orderProducts->id;

            // echo "Order product<br> : ";
            // print_r($orderProducts);
            // echo "<br><br>";
            // echo "Order product image<br> : ";
            // print_r($item->product->productImage);
            // echo "<br><br>";

            // cek apakah ada product image dari product yang dipesan
            if ($item->product->productImage->count()) {
                // echo "image product issets";
                // echo "<br><br>";

                // looping product image
                foreach ($item->product->productImage as $image) {

                    $folderPathSave = 'user/' . auth()->user()->username . '/order/' . $orderId . '/' . $orderProductId . '/';

                    // img nantinya mengakses ke storage product image 
                    $img = $image->name;
                    $img = explode('/', $img);

                    // echo "user Image<br> : ";
                    // print_r($img);
                    // echo "<br><br>";

                    // inisiasi nama order product image 
                    $imageName = uniqid() . '.jpg';

                    // alamat penyimpanan serta nama order product image  
                    $imageFullPathSave = $folderPathSave . $imageName;

                    // $copy = Storage::copy($image->name, $imageFullPathSave);

                    // membuat folder / direktori untuk penyimoanan order product image
                    $createFolder = Storage::makeDirectory($folderPathSave);
                    // resize image menjadi resolusi 300x300 dan menyimpan sesuai $imagefullpathsave
                    $copy = Image::make(Storage::path($image->name))->resize(300, 300, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(Storage::path($imageFullPathSave));

                    // echo "copy<br> : ";
                    // print_r($copy);
                    // echo "<br><br>";

                    //inisiasi data order product image (order product id dan nama file image)
                    $orderProductImages = [
                        'order_product_id' => $orderProductId,
                        'name' => $imageFullPathSave
                    ];

                    // insert data order product image ke table order product image
                    $orderProductImage = OrderProductImage::create($orderProductImages);

                    // echo "Order Product Image<br> : ";
                    // print_r($orderProductImage);
                    // echo "<br><br>";
                }
            } else {
                // $folderPathSave = 'user/' . auth()->user()->username . '/order/' . $orderId . '/' . $orderProductId . '/';
                // // img nantinya mengakses ke storage product image 
                // $img = auth()->user()->profile_image;
                // $img = explode('/', $img);

                // // echo "user Image with no prod images<br> : ";
                // // print_r($img);
                // // echo "<br><br>";

                // $imageName = uniqid() . '.jpg';

                // $imageFullPathSave = $folderPathSave . $imageName;

                // $copy = Storage::copy(auth()->user()->profile_image, $imageFullPathSave);

                // // echo "copy<br> : ";
                // // print_r($copy);
                // // echo "<br><br>";

                // $orderProductImages = [
                //     'order_product_id' => $orderProductId,
                //     'name' => $imageFullPathSave
                // ];

                // $orderProductImage = OrderProductImage::create($orderProductImages);

                // // echo "Order Product Image<br> : ";
                // // print_r($orderProductImage);
                // // echo "<br><br>";
            }

            // membuat data yang akan dimasukkan ke order item
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

            // insert data order items
            $orderItems = OrderItem::create($data);
            // $orderItems->discount = $discount;
            $orderItems->save();

            $orderItemIds[] = $orderItems->id;

            // echo "Order Items<br> : ";
            // print_r($orderItems);
            // echo "<br><br>";
            if (!is_null($request->promo_use_id)) {
                // dd($promo);
                $productPromo = ProductPromo::whereIn('product_id', $request->product_ids)->get();

                if ((int)$request->checkout_total_prices >= (int)$promo->min_transaction) {
                    if ($promo->promo_type_id == 1 || $promo->promo_type_id == 2) {
                        foreach ($promo->productPromo as $productPromo) {
                            if ((int)$orderItems->product_id == (int)$productPromo->product_id) {
                                if ($promo->promo_type_id == 1) {
                                    $discount = $orderItems->total_price_item * $promo->discount / 100;
                                } elseif ($promo->promo_type_id == 2) {
                                    $discount = $orderItems->quantity * $promo->discount;
                                }
                                $orderItems->discount = $discount;
                                $order->discount = $discount;
                            } else {
                                $orderItems->discount = 0;
                            }
                            $order->save();
                            $orderItems->save();
                        }
                    } elseif ($promo->promo_type_id == 3 || $promo->promo_type_id == 4) {
                        if ($promo->promo_type_id == 3) {
                            $discount = $request->checkout_total_prices * $promo->discount / 100;
                        } elseif ($promo->promo_type_id == 4) {
                            $discount = $promo->discount;
                        }
                        $order->discount = $discount;
                        $order->save();
                    }
                    $userPromoUse->promo_use += 1;
                    $userPromoUse->save();
                    // $promo_name = 'Diskon Harga';

                } else {
                    return redirect()->back()->with('failed', 'Gagal menggunakan kode promo! Jumlah transaksi kurang dari minimal transaksi promo');
                }
            }
        }
        if (!is_null($request->promo_use_id)) {

            $promo_name = $promo->name;
            $promo_type = $promo->promoType->name;

            $userPromoOrderUse = UserPromoOrderUse::create([
                'user_id' => auth()->user()->id,
                'promo_id' => $promo->id,
                'order_id' => $order->id,
                'promo_name' => $promo_name,
                'promo_type' => $promo_type,
                'discount' => $order->discount,
            ]);
        }
        // menambahkan variabel $orderItemIds ke session() agar dapat diakses menggunakan session()
        $request->session()->put(['orderItemIds' => $orderItemIds]);
        // menambahkan variabel $orderproductIds ke session() agar dapat diakses menggunakan session()
        $request->session()->put(['orderProductIds' => $orderProductIds]);

        // menghapus cart item menggunakan fitur soft deletes agar dapat di retrieve kembali jika orde tidak dibayarkan
        foreach ($request->cart_ids as $ids) {
            $deleteCartItem = CartItem::where('id', $ids)->delete();
            // $deleteCartItem = CartItem::where('id', $ids)->forceDelete();
            // dd($ids);
            // dd($deleteCartItem);
        }

        $description = '';
        // $orderProductImageFirst = OrderProductImage::where('order_product_id', '=', $orderProductIds[0])->first();
        $shopBag = 'assets\shop-bag-success.png';
        $notifications = [
            'user_id' => auth()->user()->id,
            'slug' => auth()->user()->username . '-' . Crypt::encryptString($order->id) . '-pesanan-berhasil-dibuat',
            'type' => 'Pesanan',
            'description' => '<p>Pesanan kamu berhasil dibuat. Produk yang kamu pesan berjumlah ' . $order->orderitem->count() . ' item.</p>',
            'excerpt' => 'Pesanan kamu berhasil dibuat',
            'image' => $shopBag,
            // 'image' => 'storage/' . $orderProductImageFirst->name,
            'is_read' => 0
        ];
        // membuat notifikasi pembuatan pesanan untuk user
        $notification = UserNotification::create($notifications);

        return redirect()->route('payment.order.bind', ['id' => Crypt::encrypt($order->id)]);
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
            return redirect()->route('payment.order.bind', ['id' => Crypt::encrypt($id)]);
        } else {
            // dd($order->id);
            return redirect()->route('order.detail.bind', ['id' => Crypt::encrypt($id)]);
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
        $id = Crypt::decrypt($id);
        // dd($id);
        $this->expiredCheck();

        $order = Order::where('id', $id)->with(['orderitem', 'orderstatusdetail'])->first();
        // dd($order->orderitem[0]->product);
        if (!is_null($order)) {
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
        } else {
            return redirect()->route('order.index')->with(['failed' => 'pesanan sudah kedaluwarsa']);
        }
    }

    public function paymentOrderBindPDF($id)
    {
        // dd(public_path());
        $id = Crypt::decrypt($id);

        $order = Order::where('id', $id)->with(['orderitem', 'orderstatusdetail'])->first();
        // dd($order->orderitem[0]->product);
        $promoUse = UserPromoOrderUse::where('order_id', '=', $order->id)->first();
        if (!is_null($order)) {
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
            // $image = $order->paymentmethod->logo;
            // $getContent = \Illuminate\Support\Facades\File::get(public_path() . $image);
            // // dd($data);
            // // $getContent = $image->getContent();
            // dd($getContent);
            // $imageData = base64_encode($getContent);
            // $src = 'data:' . mime_content_type($getContent) . ';base64' . $imageData; 
            // return view(
            //     'order.invoice-pdf',
            //     [
            //         'title' => 'Pembayaran',
            //         'active' => 'order',
            //         'orders' => $orders,
            //         'orderItems' => $orderItems,
            //         'orderProducts' => $orderProducts,
            //         'weight' => $weight,
            //     ]
            // );
            // $dompdf = new Pdf();
            // $dompdf->setOptions('defaultFont', 'Helvetica');
            // $dompdf->setOptions('enable_php', true);
            // $dompdf->setOptions('enable_remote', true);
            // $dompdf->setPaper('A4');
            // $dompdf->set_protocol('klikspl.test');
            // $dompdf->load_html();
            // $dompdf->render();
            // echo $dompdf->stream('invoice-pdf', ['order' => $order], ['Attachment' => false]);
            // Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadview('order.invoice-pdf', [
                'order' => $order,
            ]);
            return $pdf->stream('invoice-pembayaran pesanan-'.auth()->user()->username.'-'.$orderProducts[0]->slug.'.pdf');
            // return view('order.invoice-pdf',[
            //     'order' => $order,
            //     'promoUse' => $promoUse,
            // ]);
        } else {
            return redirect()->route('order.index')->with(['failed' => 'pesanan sudah kedaluwarsa']);
        }
    }

    public function orderDetailBind($id)
    {
        $id = Crypt::decrypt($id);
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
                            // foreach ($orderItem->orderProduct->orderProductImage as $orderProductImage) {
                            // }
                            // echo "order item id: " . $orderItem->id;
                            // echo "<br><br>";
                            // echo "order item product id: " . $orderItem->product_id;
                            // echo "<br><br>";
                            // echo "order item product variant id: " . $orderItem->product_variant_id;
                            // echo "<br><br>";

                            $cartItem = CartItem::where([['user_id', '=', auth()->user()->id], ['product_id', '=', $orderItem->product_id], ['product_variant_id', '=', $orderItem->product_variant_id], ['quantity', '=', $orderItem->quantity], ['subtotal', '=', $orderItem->total_price_item], ['deleted_at', 'like', '%' . Carbon::parse($orderItem->created_at)->format('Y-m-d H:i') . '%'], ['updated_at', 'like', '%' . Carbon::parse($orderItem->created_at)->format('Y-m-d H:i') . '%']])->withTrashed()->first();
                            if (!is_null($cartItem)) {
                                $cartItem->deleted_at = NULL;
                                $cartItem->save();
                            }
                            // $orderProductImage->delete();
                            // $orderItem->orderProduct->delete();
                            // print_r($cartItem);
                        } else {
                            $cartItem = CartItem::where([['user_id', '=', auth()->user()->id], ['product_id', '=', $orderItem->product_id], ['product_variant_id', '=', $orderItem->product_variant_id], ['quantity', '=', $orderItem->quantity], ['subtotal', '=', $orderItem->total_price_item], ['deleted_at', 'like', '%' . Carbon::parse($orderItem->created_at)->format('Y-m-d H:i') . '%'], ['updated_at', 'like', '%' . Carbon::parse($orderItem->created_at)->format('Y-m-d H:i') . '%']])->withTrashed()->first();
                            if (!is_null($cartItem)) {
                                $cartItem->deleted_at = NULL;
                                $cartItem->save();
                            }
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

    public function orderProductDetail($id, OrderItem $orderItem)
    {
        // dd($orderItem);
        $orderProduct = $orderItem->orderProduct;
        // dd($orderProduct);
        $id = Crypt::decrypt($id);
        // dd($id);
        // $orderProduct = Crypt::decrypt($orderProduct);
        $order = Order::find($id);
        // dd($order);
        // dd($orderProduct);
        $city_origin = '36';
        $Key = 'product-' . $orderProduct->id;
        // if (!Session::has($Key)) {

        //     DB::table('products')
        //         ->where('id', $orderProduct->id)
        //         ->increment('view', 1);
        //     Session::put($Key, 1);
        // }
        // print_r(Session::all());
        $stock = 0;

        $stock = $orderProduct->stock;

        $product = $orderItem->product;
        // $orderProduct = Product::find($orderProduct->id);
        // $origin =  ProductOrigin::where('product_id', '=', $orderProduct->id)->with('city')->groupBy('sender_address_id')->get();
        // $orderProduct->productorigin->with('senderAddress')->unique('sender_address_id');
        $senderAddress = SenderAddress::where('is_active', '=', 1)->with('city')->get();
        // dd($senderAddress);
        $orderProductImages = OrderproductImage::where('name', 'like', 'user/'.auth()->user()->username.'/order/'.$order->id.'/'.$orderProduct->id.'%')->get();
        // dd($orderProductImages);
        return view('order.orderProduct', [
            'title' => $orderProduct->name,
            // "product" => $orderProduct,
            'active' => 'products',
            "orderProduct" => $orderProduct,
            "orderProductImages" => $orderProductImages,
            "product" => $product,
            "stock" => $stock,
        ]);
    }

    public function orderCancellationRequest(Request $request, Order $order)
    {
        // dd($order);
        // dd($request->order_cancellation_request);
        $order->order_status = 'pengajuan pembatalan';
        $order->save();
        if ($order->save()) {
            foreach ($order->orderitem as $item) {
                $item->order_item_status = 'pengajuan pembatalan';
                $item->save();
            }
            // $order->delete();
            $orderStatus = OrderStatusDetail::create(
                [
                    'order_id' => $order->id,
                    'status' => 'pengajuan pembatalan',
                    'status_detail' => 'Proses pengajuan pembatalan pesanan. Alasan pembatalan: ' . $request->order_cancellation_request,
                    'status_date' => date('Y-m-d H:i:s')
                ]
            );
            return redirect()->route('order.index')->with('success', 'Berhasil mengajukan pembatalan pesanan.');
        }
    }
}
