<?php

namespace App\Http\Controllers\Admin;

use File;
use Carbon\Carbon;
use App\Models\Promo;
use App\Models\Company;
use App\Models\Product;
use App\Models\PromoType;
use App\Models\ProductPromo;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\PromoPaymentMethod;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;

class AdminPromoVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->expiredCheck();
        // dd('index voucher');
        // dd('index voucher');
        if (empty(request(['status'])['status'])) {
            $request->request->add(['status' => '']);
        }
        if (request(['status'])['status'] == '') {
            $request->session()->put('status', '');
        } else if (request(['status'])['status'] == 'aktif') {
            $request->session()->put('status', 'aktif');
        } else if (request(['status'])['status'] == 'tidak aktif') {
            $request->session()->put('status', 'tidak aktif');
        } else if (request(['status'])['status'] == 'akan datang') {
            $request->session()->put('status', 'akan datang');
        } else if (request(['status'])['status'] == 'sudah berakhir') {
            $request->session()->put('status', 'sudah berakhir');
        } else {
            abort(404);
        }
        // dd(request(['status'])['status']);
        if(auth()->guard('adminMiddle')->user()->admin_type == 1){
            $promos = Promo::latest()->filterIndex(request(['status']))->get();
        }else{
            $promos = Promo::latest()->where('company_id', '=', auth()->guard('adminMiddle')->user()->company_id)->filterIndex(request(['status']))->get();
        }
        return view('admin.promo.voucher.index', [
            'title' => 'Promo Voucher',
            'active' => 'promo-voucher',
            'promos' => $promos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $promoType = PromoType::all();
        if (auth()->guard('adminMiddle')->user()->admin_type == 1 ) {
            $products = Product::where('is_active', '=', 1)->get();
        } else {
            $products = Product::where('is_active', '=', 1)->where('company_id', '=', auth()->guard('adminMiddle')->user()->company_id)->get();
        }
        
        $paymentMethod = PaymentMethod::where('is_active', '=', 1)->get();
        return view('admin.promo.voucher.create', [
            'title' => 'Tambah Promo Voucher Baru',
            'active' => 'promo-voucher',
            'promoTypes' => $promoType,
            'paymentMethods' => $paymentMethod,
            'products' => $products,
            'companies' => Company::all(),
        ]);
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
        if (!isset($request->is_active)) {
            $request->merge(['is_active' => '0']);
            echo "status tidak aktif";
            echo '</br>';
        }

        if ($request->start_period > $request->end_period) {
            return redirect()->back()->with('failed', 'Tanggal mulai promo tidak boleh lebih besar dari tanggal akhir promo');
        }

        // if ($request->promo_type_id)

        $validatedData = $request->validate(
            [
                'name' => 'required',
                'slug' => 'required',
                'code' => ['required', 'unique:promos', 'string', 'alpha_dash', 'max:12', 'regex:/^(?=.*[0-9])(?=.*[A-Z])([A-Z0-9]+)$/'],
                'promo_type_id' => 'required',
                'start_period' => 'required|date',
                'end_period' => 'required|date',
                'description' => 'required',
                'min_transaction' => 'required',
                'discount' => 'required',
                'quota' => 'required',
                'is_active' => 'required',
                'admin_id' => 'required',
                'company_id' => 'required',
            ],
            [
                'name.required' => 'Nama promo harus diisi!',
                'code.required' => 'Kode promo harus diisi!',
                'code.unique' => 'Kode promo sudah digunakan. Kode promo harus unik!',
                'code.regex' => 'format kode promo tidak valid! Awali dengan huruf, hindari penggunaan angka ditengah kode, jangan gunakan simbol !@#$%^&*()_+|}{":?><',
                'code.max' => 'Kode promo maksimal 12 karakter',
                'promo_type_id.required' => 'Jenis/Tipe promo harus diisi!',
                'start_period.required' => 'Tanggal awal promo harus diisi!',
                'start_period.date' => 'Format tanggal awal promo tidak valid!',
                'end_period.required' => 'Tanggal akhir promo harus diisi!',
                'end_period.date' => 'Format tanggal akhir promo tidak valid!',
                'description.required' => 'Deskripsi promo harus diisi!',
                'min_transaction.required' => 'Minimal transaksi harus diisi!',
                'discount.required' => 'Diskon promo harus diisi!',
                'quota.required' => 'Kuota promo harus diisi!',
                'is_active.required' => 'Status promo harus diisi!',
                'admin_id.required' => 'Admin Id harus diisi!',
                'company_id.required' => 'Company Id harus diisi!',
            ]
        );
        $start_period = (Carbon::parse($request->start_period)->isoFormat('Y-MM-DD HH:mm'));
        $end_period = (Carbon::parse($request->end_period)->isoFormat('Y-MM-DD HH:mm'));

        $voucher = Promo::create([
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
            'code' => $validatedData['code'],
            'promo_type_id' => $validatedData['promo_type_id'],
            'start_period' => $start_period,
            'end_period' => $end_period,
            'description' => $validatedData['description'],
            'min_transaction' => $validatedData['min_transaction'],
            'discount' => $validatedData['discount'],
            'quota' => $validatedData['quota'],
            'is_active' => $validatedData['is_active'],
            'admin_id' => $validatedData['admin_id'],
            'company_id' => $validatedData['company_id'],
        ]);

        if ($voucher) {
            foreach ($request->paymentMethod as $id => $paymentMethod) {
                PromoPaymentMethod::create([
                    'promo_id' => $voucher->id,
                    'payment_method_id' => $paymentMethod
                ]);
            }
            if (!is_null($request->promoVoucherImageUpload)) {
                $image_parts = explode(";base64,", $request->promoVoucherImageUpload);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);

                // echo $productImage;
                // print_r($image_parts);
                // print_r($image_type);

                // $folderPathSave = 'img/banner/' .$voucher->id . '/';
                $folderPathSave = 'admin/voucher/' . auth()->guard('adminMiddle')->user()->company_id . '/';

                $imageName = uniqid() . '-' . $voucher->id . '.' . $image_type;

                $imageFullPathSave = $folderPathSave . $imageName;
                // dd($imageFullPathSave);
                $save = Storage::put($imageFullPathSave, $image_base64);
                // dd($save);

                $voucherStored = Promo::find($voucher->id);

                $voucherStored->image = $imageFullPathSave;
                $voucherStored->save();
            } else {
                // $voucherStored = Promo::find($voucher->id);

                // $voucherStored->image = 'assets/voucher.png';
                // $voucherStored->save();
            }
            $products = Product::where('is_active', '=', 1)->where('company_id', '=', auth()->guard('adminMiddle')->user()->company_id)->get();

            if (isset($request->all_product_promos) || $request->all_product_promos == 'all') {
                foreach ($products as $product) {
                    $promoProducts = ProductPromo::create([
                        'product_id' => $product->id,
                        'promo_id' => $voucher->id,
                    ]);
                }
            } elseif (isset($request->product_promos)) {
                foreach ($request->product_promos as $product_promo) {
                    $promoProducts = ProductPromo::create([
                        'product_id' => $product_promo,
                        'promo_id' => $voucher->id,
                    ]);
                }
            }
        }


        if ($voucher) {
            return redirect()->route('promovoucher.index')->with('success', 'Berhasil menambahkan promo.');
        } else {
            return redirect()->back()->with('failed', 'Terdapat kesalahan saat menambahkan promo , mohon pastikan semua form sudah terisi dengan benar');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promo  $promovoucher
     * @return \Illuminate\Http\Response
     */
    public function show(Promo $promovoucher)
    {
        return view('admin.promo.voucher.show', [
            'title' => 'Promo Voucher',
            'active' => 'promo-voucher',
            'promos' => $promovoucher
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promo  $promovoucher
     * @return \Illuminate\Http\Response
     */
    public function edit(Promo $promovoucher)
    {
        // dd($promovoucher);
        $promoType = PromoType::all();
        $products = Product::where('is_active', '=', 1)->where('company_id', '=', auth()->guard('adminMiddle')->user()->company_id)->get();
        $paymentMethod = PaymentMethod::where('is_active', '=', 1)->get();
        return view('admin.promo.voucher.edit', [
            'title' => 'Tambah Promo Voucher Baru',
            'active' => 'promo-voucher',
            'promo' => $promovoucher,
            'promoTypes' => $promoType,
            'paymentMethods' => $paymentMethod,
            'products' => $products,
            'companies' => Company::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promo  $promovoucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promo $promovoucher)
    {
        // dd($request);
        if (!isset($request->is_active)) {
            $request->merge(['is_active' => '0']);
            echo "status tidak aktif";
            echo '</br>';
        }

        if ($request->start_period > $request->end_period) {
            return redirect()->back()->with('failed', 'Tanggal mulai promo tidak boleh lebih besar dari tanggal akhir promo');
        }

        $validatedData = $request->validate(
            [
                'name' => 'required',
                'slug' => 'required',
                'code' => ['required', 'string', 'alpha_dash', 'max:12', 'regex:/^(?=.*[0-9])(?=.*[A-Z])([A-Z0-9]+)$/'],
                'promo_type_id' => 'required',
                'start_period' => 'required|date',
                'end_period' => 'required|date',
                'description' => 'required',
                'min_transaction' => 'required',
                'discount' => 'required',
                'quota' => 'required',
                'is_active' => 'required',
                'company_id' => 'required',
            ],
            [
                'name.required' => 'Nama promo harus diisi!',
                'slug.required' => 'Slug promo harus diisi!',
                'code.required' => 'Kode promo harus diisi!',
                // 'code.unique' => 'Kode promo sudah digunakan. Kode promo harus unik!',
                'code.regex' => 'format kode promo tidak valid! Awali dengan huruf, hindari penggunaan angka ditengah kode, jangan gunakan simbol !@#$%^&*()_+|}{":?><',
                'code.max' => 'Kode promo maksimal 12 karakter',
                'promo_type_id.required' => 'Jenis/Tipe promo harus diisi!',
                'start_period.required' => 'Tanggal awal promo harus diisi!',
                'start_period.date' => 'Format tanggal awal promo tidak valid!',
                'end_period.required' => 'Tanggal akhir promo harus diisi!',
                'end_period.date' => 'Format tanggal akhir promo tidak valid!',
                'description.required' => 'Deskripsi promo harus diisi!',
                'min_transaction.required' => 'Minimal transaksi harus diisi!',
                'discount.required' => 'Diskon promo harus diisi!',
                'quota.required' => 'Kuota promo harus diisi!',
                'is_active.required' => 'Status promo harus diisi!',
            ]
        );
        $start_period = (Carbon::parse($request->start_period)->isoFormat('Y-MM-DD HH:mm'));
        $end_period = (Carbon::parse($request->end_period)->isoFormat('Y-MM-DD HH:mm'));

        if (count($promovoucher->promopaymentmethod) > 0) {
            if (isset($request->paymentMethod)) {
                foreach ($request->paymentMethod as $key => $paymentMethod) {
                    // query mencari payment method yang tidak diceklist dari DB dan menghapus
                    $promoPaymentMethodDelete = PromoPaymentMethod::where('promo_id', $promovoucher->id)->whereNotIn('payment_method_id', $request->paymentMethod)->delete();

                    // query mencari payment method yang tidak ada dari DB
                    $promoPaymentMethodAdd = PromoPaymentMethod::where('promo_id', $promovoucher->id)->whereIn('payment_method_id', $request->paymentMethod)->pluck('payment_method_id')->toArray();

                    if (isset($request->paymentMethod[$key])) {
                        if (!in_array($request->paymentMethod[$key], $promoPaymentMethodAdd)) {
                            echo ($request->paymentMethod[$key]);
                            echo "<br>";
                            $promoPaymentMethodCreate = PromoPaymentMethod::create([
                                'promo_id' => $promovoucher->id,
                                'payment_method_id' => $request->paymentMethod[$key],
                            ]);
                        }
                    }
                }
            } else {
                return redirect()->back()->with('failed', 'Metode pembayaran tidak boleh kosong');
            }
            // dd($request);
        } else {
            if (isset($request->paymentMethod)) {
                foreach ($request->paymentMethod as $key => $paymentMethod) {
                    $promoPaymentMethodCreate = PromoPaymentMethod::create([
                        'promo_id' => $promovoucher->id,
                        'payment_method_id' => $request->paymentMethod[$key],
                    ]);
                }
            }
        }

        if (count($promovoucher->productpromo) > 0) {
            if (isset($request->product_promos)) {
                foreach ($request->product_promos as $key => $productPromo) {
                    // query mencari payment method yang tidak diceklist dari DB dan menghapus
                    $productPromoDelete = ProductPromo::where('promo_id', $promovoucher->id)->whereNotIn('product_id', $request->product_promos)->delete();

                    // query mencari payment method yang tidak ada dari DB
                    $productPromoAdd = ProductPromo::where('promo_id', $promovoucher->id)->whereIn('product_id', $request->product_promos)->pluck('product_id')->toArray();

                    if (isset($request->product_promos[$key])) {
                        if (!in_array($request->product_promos[$key], $productPromoAdd)) {
                            echo ($request->product_promos[$key]);
                            echo "<br>";
                            $productPromoCreate = ProductPromo::create([
                                'promo_id' => $promovoucher->id,
                                'product_id' => $request->product_promos[$key],
                            ]);
                        }
                    }
                }
            } elseif (isset($request->all_product_promos) || $request->all_product_promos == 'all') {
                $products = Product::where('is_active', '=', 1)->where('company_id', '=', auth()->guard('adminMiddle')->user()->company_id)->get();
                foreach ($products as $key => $product) {
                    // query mencari payment method yang tidak diceklist dari DB dan menghapus
                    // $productPromoDelete = productPromo::where('promo_id', $promovoucher->id)->whereNotIn('product_id', $request->productPromo)->delete();

                    // query mencari payment method yang tidak ada dari DB
                    // dd($request->productPromo);
                    $productPromoAdd = ProductPromo::where('promo_id', $promovoucher->id)->whereIn('product_id', $product->pluck('id'))->pluck('product_id')->toArray();
                    // dd($productPromoAdd);
                    echo "<br>";

                    if ((!in_array($product->id, $productPromoAdd))) {
                        echo ($product->id);
                        echo ('');
                        echo "<br>";
                        // dd($productPromoAdd);
                        $productPromoCreate = ProductPromo::create([
                            'promo_id' => $promovoucher->id,
                            'product_id' => $product->id,
                        ]);
                    }
                }
                // dd($request);
            } else {
                return redirect()->back()->with('failed', 'Produk promo tidak boleh kosong');
            }
            // dd($request);
        } else {
            if (isset($request->product_promos)) {
                foreach ($request->product_promos as $key => $productPromo) {
                    // query mencari payment method yang tidak diceklist dari DB dan menghapus
                    $productPromoDelete = ProductPromo::where('promo_id', $promovoucher->id)->whereNotIn('product_id', $request->product_promos)->delete();

                    // query mencari payment method yang tidak ada dari DB
                    $productPromoAdd = ProductPromo::where('promo_id', $promovoucher->id)->whereIn('product_id', $request->product_promos)->pluck('product_id')->toArray();

                    if (isset($request->product_promos[$key])) {
                        if (!in_array($request->product_promos[$key], $productPromoAdd)) {
                            echo ($request->product_promos[$key]);
                            echo "<br>";
                            $productPromoCreate = ProductPromo::create([
                                'promo_id' => $promovoucher->id,
                                'product_id' => $request->product_promos[$key],
                            ]);
                        }
                    }
                }
            }
        }

        if (isset($request->promoVoucherImageUpload)) {

            $image_parts = explode(";base64,", $request->promoVoucherImageUpload);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            // echo $productImage;
            // print_r($image_parts);
            // print_r($image_type);

            $folderPathSave = 'admin/voucher/' . auth()->guard('adminMiddle')->user()->company_id . '/';
            $imageName = uniqid() . '-' . $promovoucher->id . '.' . $image_type;
            $imageFullPathSave = $folderPathSave . $imageName;
            $previousPromoVoucherImage = $promovoucher->image;

            if (!empty($previousPromoVoucherImage)) {
                Storage::delete($previousPromoVoucherImage);
            }

            $saveUpdateImage = Storage::put($imageFullPathSave, $image_base64);

            if ($saveUpdateImage) {
                $promovoucher->image = $imageFullPathSave;
            }
        }

        $promovoucher->fill([
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
            'code' => $validatedData['code'],
            'promo_type_id' => $validatedData['promo_type_id'],
            'start_period' => $start_period,
            'end_period' => $end_period,
            'description' => $validatedData['description'],
            'min_transaction' => $validatedData['min_transaction'],
            'discount' => $validatedData['discount'],
            'quota' => $validatedData['quota'],
            'is_active' => $validatedData['is_active'],
        ]);
        $update = $promovoucher->save();

        if ($update) {
            return redirect()->route('promovoucher.index')->with('success', 'Berhasil memperbarui promo.');
        } else {
            return redirect()->back()->with('failed', 'Terdapat kesalahan saat memperbarui promo, mohon pastikan semua form sudah terisi dengan benar');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promo  $promovoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promo $promovoucher)
    {
        if (auth()->guard('adminMiddle')->user()->id) {
            $productPromo = ProductPromo::where('promo_id','=',$promovoucher->id)->get();
            foreach($productPromo as $deleteProductPromo){
                $productPromoDelete = $deleteProductPromo->delete();
            }
            Storage::delete($promovoucher->image);
            $delete = $promovoucher->delete();
            if ($delete && $productPromoDelete) {
                return redirect()->back()->with('success', 'Berhasil menghapus Promo.');
            } else {
                return redirect()->back()->with('failed', 'Terjadi kesalahan menghapus Promo.');
            }
            // Post::destroy($post->id);
        } else {
            // return redirect('/dashboard/posts')->with('failed','Delete post failed!');
            abort(403);
        }
    }

    public function updateStatus(Request $request)
    {
        // dd($cart);
        // $city = CartItem::where('id', $id)->get();
        // return response()->json($city);
        // dd($request);
        // if ($request->id) {
        $status = Promo::find($request->id);
        $status->is_active = $request->status;
        $status->save();
        // }
        // session()->flash('success', 'Berhasil memperbarui jumlah item');
        $update = Promo::where('id', $request->id)->first();
        if ($update) {
            $message = 'success';
        } else {
            $message = 'failed';
        }
        return response()->json([
            'message' => $message,
            'data' => $update,
            'id' => $update->id,
            'status' => $update->is_active,
        ]);
    }

    public function PromoCodeCheck(Request $request)
    {
        $promoCode = Promo::where('code', '=', $request->code)->exists();
        return response()->json(['result' => $promoCode]);
    }

    public function deleteImage(Request $request)
    {
        $deleteImage = Promo::find($request->id);

        if ($deleteImage) {
            if (Storage::exists($deleteImage->image)) {
                Storage::delete($deleteImage->image);
                $deleteImage->image = '';
                $delete = $deleteImage->save();
            }
        }

        if ($delete) {
            // return redirect()->back()->with(['success' => 'Berhasil menghapus produk']);
            $message = 'success';
        } else {
            $message = 'faied';
            // return redirect()->back()->with(['failed' => 'Gagal menghapus foto produk']);
        }
        return response()->json([
            'message' => $message,
            'data' => $deleteImage,
            'id' => $deleteImage->id,
            // 'status' => $update->is_active, 
        ]);
    }
    
    public function isAdministrator()
    {
        if (auth()->guard('adminMiddle')->user()->admin_type != 1 && auth()->guard('adminMiddle')->user()->admin_type != 2) {
            abort(403);
        }
    }

    public function expiredCheck()
    {
        // dd(auth()->guard('adminMiddle')->user()->company_id);
        $promoVoucher = Promo::where('company_id', '=', auth()->guard('adminMiddle')->user()->company_id)->get();
        foreach ($promoVoucher as $voucher) {
            if ($voucher->end_period < Carbon::now()) {
                $voucher->is_active = 0;
                $voucher->save();
            }
        }
    }
    
    public function checkSlug(Request $request)
    {
        $this->isAdministrator();
        $slug = SlugService::createSlug(Promo::class, 'slug', $request->name);

        return response()->json(['slug' => $slug]);
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
