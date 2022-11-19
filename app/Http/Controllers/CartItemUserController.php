<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Promo;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Province;
use App\Models\UserAddress;
use App\Models\ProductPromo;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\SenderAddress;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\HttpFoundation\Session\Session;

class CartItemUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cartitems.index', [
            'title' => 'Keranjang saya',
            'active' => 'cart',
            // 'cartItem' => CartItem::where('user_id', auth()->user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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

        if ($request->sender_address_id == 0) {
            return redirect()->back()->with('failed', 'Pilih alamat pengirim terlebih dahulu');
        }

        if (!empty($request->product_variant_id)) {
            $productVariantCheck = ProductVariant::where('id', '=', $request->product_variant_id)->first();
            // dd($productVariantCheck);
            if ($request->quantity > $productVariantCheck->stock) {
                // dd('jumlah pesanan melebihi stock yang tersedia');
                return redirect()->back()->with('failed', 'Terdapat kesalahan saat menambahkan produk ke keranjang, Jumlah pesanan produk melebihi stock yang tersedia');
            }
        } else {
            $productCheck = Product::where('id', '=', $request->product_id)->first();
            // dd($productCheck);
            if ($request->quantity > $productCheck->stock) {
                return redirect()->back()->with('failed', 'Terdapat kesalahan saat menambahkan produk ke keranjang, Jumlah pesanan produk melebihi stock yang tersedia');
            }
        }
        $validatedData = $request->validate(
            [
                'user_id' => 'required',
                'product_id' => 'required',
                'product_variant_id' => 'required',
                'quantity' => 'required',
                'subtotal' => 'required',
                'sender_address_id' => 'required',
            ],
            [
                'product_variant_id.required' => 'Pilih varian produk terlebih dahulu',
                'sender_address_id.required' => 'Pilih alamat pengirim terlebih dahulu',
                // 'quantity.required' => 'Pilih varian produk terlebih dahulu',
                // 'subtotal.required' => 'Pilih varian produk terlebih dahulu',
            ]
        );
        $found = CartItem::where([['product_id', '=', $request->product_id], ['product_variant_id', '=', $request->product_variant_id], ['is_checkout_view', '=', '0'], ['user_id', '=', auth()->user()->id]])->first();
        if ($found) {
            // dd($found);
            // dd($found->id);
            $found->quantity = (int)$found->quantity + (int)$request->quantity;
            $found->subtotal = (int)$found->subtotal + (int)$request->subtotal;
            $found->save();
            if ($found->save()) {
                if ($request->type === 'cart') {
                    return redirect()->back()->with('success', 'Berhasil menambahkan produk ke keranjang.');
                } elseif ($request->type === 'buyNow') {
                    return redirect()->route('cart.index')->with([
                        'success' => 'Berhasil menambahkan produk ke keranjang.',
                        'cartitems' => $found,
                    ]);
                }
            } else {
                return redirect()->back()->with('failed', 'Terdapat kesalahan saat menambahkan produk ke keranjang, mohon pastikan memilih varian produk atau mengisi alamat dengan benar');
            }
        } else {
            $create = CartItem::create($validatedData);
            if ($create) {
                if ($request->type === 'cart') {
                    return redirect()->back()->with('success', 'Berhasil menambahkan produk ke keranjang.');
                } elseif ($request->type === 'buyNow') {
                    return redirect()->route('cart.index')->with('success', 'Berhasil menambahkan produk ke keranjang.');
                }
            } else {
                return redirect()->back()->with('failed', 'Terdapat kesalahan saat menambahkan produk ke keranjang, mohon pastikan memilih varian produk atau mengisi alamat dengan benar');
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartItem  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(CartItem $cart)
    {
        dd($cart);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CartItem  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(CartItem $cart)
    {
        dd($cart);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartItem  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartItem $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartItem  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItem $cart)
    {
        // dd($cart);
        if (auth()->user()->id == $cart->user_id) {
            // $cart->delete();
            $cart->forceDelete();
            // Post::destroy($post->id);
            return redirect()->back()->with('success', 'Berhasil menghapus item dari keranjang.');
        } else {
            // return redirect('/dashboard/posts')->with('failed','Delete post failed!');
            abort(403);
        }
    }

    public function deleteCartItem(CartItem $cart)
    {
        dd($cart);
        if (auth()->user()->id == $cart->user_id) {
            $cart->delete();
            // Post::destroy($post->id);
            return redirect()->back()->with('success', 'Berhasil menghapus item dari keranjang.');
        } else {
            // return redirect('/dashboard/posts')->with('failed','Delete post failed!');
            abort(403);
        }
    }


    public function destroy_all(Request $request)
    {
        // dd($request);
        if (empty(array_filter($request->ids))) {
            return back()->with('failed', 'Pilih setidaknya 1 item untuk dihapus');
        }
        if (auth()->user()->id == $request->user_id) {
            foreach ($request->ids as $ids) {
                // $delete = CartItem::where('id', $ids)->delete();
                $delete = CartItem::where('id', $ids)->forceDelete();
                // Post::destroy($post->id);
            }
            return redirect()->back()->with('success', 'Berhasil menghapus item dari keranjang.');
        } else {
            // return redirect('/dashboard/posts')->with('failed','Delete post failed!');
            abort(403);
        }
    }

    public function update_quantity(Request $request)
    {
        // dd($cart);
        // $city = CartItem::where('id', $id)->get();
        // return response()->json($city);
        // dd($request);
        if ($request->id && $request->quantity) {
            $qty = CartItem::find($request->id);
            $qty->quantity = $request->quantity;
            $qty->subtotal = (int)$request->quantity * (int)$request->subtotal;
            $qty->save();
        }
        // session()->flash('success', 'Berhasil memperbarui jumlah item');
        $qty = CartItem::where('id', $request->id)->get(['id', 'quantity', 'subtotal']);
        return response()->json($qty);
    }

    public function update_sender_address(Request $request)
    {
        // dd($cart);
        // $city = CartItem::where('id', $id)->get();
        // return response()->json($city);
        // dd($request);
        if ($request->id && $request->senderAddressId) {
            $sender = CartItem::find($request->id);
            $sender->sender_address_id = $request->senderAddressId;
            // return response()->json($sender);
            $sender->save();
        }
        // session()->flash('success', 'Berhasil memperbarui jumlah item');
        $sender = CartItem::where('id', $request->id)->get();
        return response()->json($sender);
    }

    public function get_update_quantity(Request $request)
    {
        // $city = City::where('province_id', $id)->pluck('name', 'city_id');
        $qty = CartItem::where('id', $request->id)->get(['id', 'quantity', 'subtotal']);
        return response()->json($qty);
    }

    public function checkout(Request $request, CheckOngkirController $cekOngkir)
    {
        // print_r($request->ids);
        if (empty(array_filter($request->ids))) {
            return back()->with('failed', 'Pilih setidaknya 1 item untuk membuat pesanan');
        }

        // $activeAddress = UserAddress::where('user_id', '=', auth()->user()->id)->where('is_active', '=', '1')->get();

        // $request->merge([
        //     '_token' => csrf_token(),
        //     'city_origin' => 35,
        //     'city_destination' => 35,
        //     'weight' => 2000,
        //     'courier' => 'all'
        // ]);

        // $this->cekOngkir = $cekOngkir;
        // $telp_no ='085248466297';
        // $request->session()->put('telp_no', $telp_no);
        // $cek = $this->cekOngkir->check_ongkir_curl($request);
        // $request->session()->put('cek', $cek);
        // $session = new Session();
        // $session->set('ceks', $cek);
        // dd(gettype($ceks));
        // foreach (session()->get('cek') as $value) {
        //     echo $value;
        // }
        // foreach ($request->ids as $key => $value) {
        //     if($value == ''){
        //         echo 'null';
        //     }else {
        //         echo $value;
        //     }
        // }
        // dd($request->ids);
        $request->session()->forget('items');

        $request->session()->put(['ids' => $request->ids]);
        // $ids = session()->get('ids');
        $checkout_items = CartItem::whereIn('id', $request->ids)->get()->sortByDesc('created_at');
        foreach ($checkout_items as $item) {
            echo $item;
            $item->is_checkout_view = 1;
            $item->save();
        }
        // dd($checkout_items);
        if ($checkout_items->isEmpty()) {
            return redirect()->route('cart.index');
        }

        // $unique_code = mt_rand(000,999);
        // dd($checkout_items);
        // dd(session()->get('ids'));
        $request->session()->put(['items' => $checkout_items]);
        // dd(session()->get('items'));
        return redirect()->route('cart.checkout.view');
    }

    public function checkoutView(Request $request)
    {
        // dd($request);
        $items = session()->get('items');
        // dd($items);
        // foreach ($items as $item) {
        //     // echo $item;
        //     // print_r($item->product->productpromo);
        //     foreach ($item->product->productpromo as $productpromo) {
        //         print_r($productpromo->promo);
        //     }
        // }
        // dd($items);
        // dd($items[0]->product);
        if (session()) {
            if (!isset($items)) {
                return redirect()->route('home');
            }
        }
        if (is_null($items)) {
            return redirect()->route('cart.index')->with('failed', 'Terdapat kesalahan saat melakukan checkout pesanan, silakan coba lagi');
        }else{
            $productIds = $items->pluck('product_id');
            $productPromo = ProductPromo::whereIn('product_id', $productIds)->get();
            $productPromoGroup = $productPromo->groupBy('promo_id');
            $promos = Promo::where('is_active', '=', 1)->with('productPromo', 'PromoPaymentMethod', 'promoType')->get();
        }
        // dd($productId);
       
        // dd($promos);
        // foreach ($productPromoGroup as $productPromo) {
        //     echo "promo id : ";
        //     print_r($productPromo[0]->promo->id);
        //     echo "<br>";
        //     print_r($productPromo[0]->promo->userPromoUse);
        //     echo "<br>";
        //     echo count($productPromo[0]->promo->userPromoUse);
        //     echo "<br>";
        //     echo isset($productPromo[0]->promo->userPromoUse);
        //     echo "<br>";
        //     echo !is_null($productPromo[0]->promo->userPromoUse);
        //     echo "<br>";
        //     echo !empty($productPromo[0]->promo->userPromoUse);
        //     echo "<br>";
        //     if (count($productPromo[0]->promo->userPromoUse)) {
        //         // foreach ($productPromo[0]->promo as $key => $promo) {
        //         foreach ($productPromo[0]->promo->userPromoUse as $key => $userPromoUse) {
        //             echo "user Id : ";
        //             echo "<br>";
        //             print_r($userPromoUse->user_id);
        //             if ($userPromoUse->promo_use <= $productPromo[0]->promo->quota) {
        //                 echo "-masih bisa digunakan";
        //                 echo "<br>";
        //             }else{
        //                 echo "-tidak bisa digunakan";
        //                 echo "<br>";
        //             }
        //             echo "<br>";
        //             echo "<br>";
        //         }
        //         // }
        //     }
        //     echo "<br>";
        //     echo "<br>";
        // }
        // dd($productPromoGroup);
        // foreach ($productPromo->groupBy('promo_id') as $prodPromo) {
        //     foreach ($prodPromo as $promo) {
        //         if (count($prodPromo) > 1) {
        //             echo "group";
        //             echo $promo->promo_id;
        //             echo "<br>";
        //         } else {
        //             echo $promo->promo_id;
        //             echo "<br>";
        //         }
        //     }
        // }
        // dd($productPromo->groupBy('promo_id'));

        $paymentMethods = PaymentMethod::where('is_active', '=', 1)->get();
        if (session()) {
            if (!isset($items)) {
                return redirect()->route('home');
            }
        }
        $items = session()->get('items');
        foreach ($items as $index => $item) {
            // echo $item->product_id;
            // echo "<br>";
            if (!empty($item->productvariant)) {
                // print_r($item->productvariant->id);
                // echo "<br>";
                foreach ($item->productvariant->productorigin as $idx => $i) {
                    if (count($items) > 1) {
                        $arr[$item->productvariant->id][$idx] = ($i->senderaddress->id);
                        // echo ($i->senderaddress->id);
                        // echo "<br>";
                    } elseif (count($items) == 1) {
                        $arr[$idx] = ($i->senderaddress->id);
                    } else {
                        return redirect()->route('cart.index')->with('failed', 'Terdapat kesalahan saat menambahkan produk ke keranjang, keranjang yang dicheckout tidak boleh kosong');
                    }
                }
            } else {
                foreach ($item->product->productorigin as $idx => $i) {
                    // echo $item->product->id;
                    // echo "<br>";
                    if (count($items) > 1) {
                        $arr[$item->product->id][$idx] = ($i->senderaddress->id);
                        // echo ($i->senderaddress->id);
                        // echo "<br>";
                    } elseif (count($items) == 1) {
                        $arr[$idx] = ($i->senderaddress->id);
                    } else {
                        return redirect()->route('cart.index')->with('failed', 'Terdapat kesalahan saat menambahkan produk ke keranjang, keranjang yang dicheckout tidak boleh kosong');
                    }
                }
            }
        }
        // dd($arr);
        if (count($items) > 1) {
            $senderIdAddr = (call_user_func_array('array_intersect', $arr));
        } elseif (count($items) == 1) {
            $senderIdAddr = $arr;
        } else {
            return redirect()->route('cart.index')->with('failed', 'Terdapat kesalahan saat menambahkan produk ke keranjang, keranjang yang dicheckout tidak boleh kosong');
        }
        // dd(empty($senderIdAddr));
        // echo "sender address : ";
        // print_r(($senderIdAddr));
        // echo "<br>";
        $senderAddress = SenderAddress::whereIn('id', $senderIdAddr)->get();
        if ((count($senderAddress) == 0) || (empty($senderIdAddr))) {
            return redirect()->route('cart.index')->with('failed', 'Terdapat kesalahan saat menambahkan produk ke keranjang, tidak ada satupun alamat pengirim yang sama antar produk! Pilih setidaknya produk yang memiliki alamat pengirim yang sama');
        }
        // dd($items);

        return view('cartitems.checkout', [
            'title' => 'Checkout',
            'items' => $items,
            'userAddress' => auth()->user()->useraddress,
            'provinces' => Province::pluck('name', 'province_id'),
            // 'unique_code' => $unique_code,
            'paymentMethods' => $paymentMethods,
            'senderAddress' => $senderAddress,
            'productPromos' => $productPromoGroup,
            'promos' => $promos,
            'productIds' => $productIds,
        ]);
    }

    public function buyNow(Request $request)
    {
        // dd($request);
        if ($request->sender_address_id == 0) {
            return redirect()->back()->with('failed', 'Pilih alamat pengirim terlebih dahulu');
        }
        if (!empty($request->product_variant_id)) {
            $productVariantCheck = ProductVariant::where('id', '=', $request->product_variant_id)->first();
            // dd($productVariantCheck);
            if ($request->quantity > $productVariantCheck->stock) {
                // dd('jumlah pesanan melebihi stock yang tersedia');
                return redirect()->back()->with('failed', 'Terdapat kesalahan saat menambahkan produk ke keranjang, Jumlah pesanan produk melebihi stock yang tersedia');
            }
        } else {
            $productCheck = Product::where('id', '=', $request->product_id)->first();
            // dd($productCheck);
            if ($request->quantity > $productCheck->stock) {
                return redirect()->back()->with('failed', 'Terdapat kesalahan saat menambahkan produk ke keranjang, Jumlah pesanan produk melebihi stock yang tersedia');
            }
        }
        $request->session()->forget('itemBuyNow');
        // dd($request);
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
        $validatedData['id'] = Null;
        $validatedData['product'] = Product::where('id', '=', $request->product_id)->first();
        $validatedData['productVariant'] = ProductVariant::where([['id', '=', $request->product_variant_id], ['product_id', '=', $request->product_id]])->first();
        $itemBuyNow = [(object) $validatedData];

        $request->session()->put('itemBuyNow', $itemBuyNow);
        // dd($request);
        return redirect()->route('buy.now.view');
    }

    public function buyNowView(Request $request)
    {
        $itemBuyNow = session()->get('itemBuyNow');
        // $unique_code = mt_rand(000,999);
        // dd($itemBuyNow[0]);

        if (is_null($itemBuyNow)) {
            return redirect()->route('cart.index')->with('failed', 'Terdapat kesalahan saat melakukan checkout pesanan, silakan coba lagi');
        }else{
            $productIds = $itemBuyNow[0]->product_id;
            $productPromo = ProductPromo::where('product_id', $productIds)->get();
            $productPromoGroup = $productPromo->groupBy('promo_id');
            $promos = Promo::where('is_active', '=', 1)->with('productPromo', 'PromoPaymentMethod', 'promoType')->get();
        }

        $paymentMethods = PaymentMethod::where('is_active', '=', 1)->get();
        if (session()) {
            if (!isset($itemBuyNow)) {
                return redirect()->route('home');
            }
        }

        foreach ($itemBuyNow as $index => $item) {
            // echo "<br>";
            // dd($item);
            if (!empty($item->productVariant)) {
                // print_r($item->productvariant->id);
                // echo "<br>";
                foreach ($item->productVariant->productorigin as $idx => $i) {
                    if (count($itemBuyNow) > 1) {
                        $arr[$item->productVariant->id][$idx] = ($i->senderaddress->id);
                        // echo ($i->senderaddress->id);
                        // echo "<br>";
                    } elseif (count($itemBuyNow) == 1) {
                        $arr[$idx] = ($i->senderaddress->id);
                    } else {
                        return redirect()->route('cart.index')->with('failed', 'Terdapat kesalahan saat menambahkan produk ke keranjang, keranjang yang dicheckout tidak boleh kosong');
                    }
                }
            } else {
                foreach ($item->product->productorigin as $idx => $i) {
                    if (count($itemBuyNow) > 1) {
                        $arr[$item->product->product_id][$idx] = ($i->senderaddress->id);
                        // echo ($i->senderaddress->id);
                        // echo "<br>";
                    } elseif (count($itemBuyNow) == 1) {
                        $arr[$idx] = ($i->senderaddress->id);
                    } else {
                        return redirect()->route('cart.index')->with('failed', 'Terdapat kesalahan saat menambahkan produk ke keranjang, keranjang yang dicheckout tidak boleh kosong');
                    }
                }
            }
        }
        // dd($arr);
        if (count($itemBuyNow) > 1) {
            $senderIdAddr = (call_user_func_array('array_intersect', $arr));
        } elseif (count($itemBuyNow) == 1) {
            $senderIdAddr = $arr;
        } else {
            return redirect()->route('cart.index')->with('failed', 'Terdapat kesalahan saat menambahkan produk ke keranjang, keranjang yang dicheckout tidak boleh kosong');
        }
        $senderAddress = SenderAddress::whereIn('id', $senderIdAddr)->get();

        // dd($senderAddress);
        return view('cartitems.buy-now', [
            'title' => 'Checkout',
            'itemBuyNow' => $itemBuyNow,
            'userAddress' => auth()->user()->useraddress,
            "provinces" => Province::pluck('name', 'province_id'),
            'paymentMethods' => $paymentMethods,
            'senderAddress' => $senderAddress,
            // 'unique_code' => $unique_code
            'productPromos' => $productPromoGroup,
            'promos' => $promos,
            'productIds' => $productIds,

        ]);
    }

    public function expiredCheck()
    {
        $now = Carbon::now();

        $cartItems = CartItem::where('user_id', '=', auth()->user()->id)->onlyTrashed()->orderByDesc('created_at')->get();
    }
    // public function checkoutPromoPost(Request $request)
    // {
    //     dd($request);
    // }

    // public function payment(Request $request)
    // {
    //     dd($request);

    //     // session()->put('$checkOutItems', $request);
    //     // return redirect()->route('checkout.payment.view');
    // }

    // public function paymentView(Request $request)
    // {
    //     dd($request);
    // }
}
