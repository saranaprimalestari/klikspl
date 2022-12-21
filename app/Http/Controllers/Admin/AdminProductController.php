<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\ProductMerk;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductOrigin;
use App\Models\SenderAddress;
use App\Models\ProductVariant;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class AdminProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminMiddle');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->isWhLogAndAdministrator();
        $currentURL = explode('/', url()->current());
        $currentPage = last($currentURL);
        Session::put('currentPage', $currentPage);

        if (auth()->guard('adminMiddle')->user()->admin_type == 1) {
            $product = Product::latest()->get();
        } else {
            $product = Product::latest()->where('company_id', '=', auth()->guard('adminMiddle')->user()->company_id)->get();
        }

        return view('admin.product.index', [
            'title' => 'Produk',
            'active' => 'adminproduct',
            'products' => $product,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->isAdministrator();
        return view('admin.product.create', [
            'title' => 'Tambah Produk',
            'active' => 'add-product',
            'categories' => ProductCategory::all(),
            'merks' => ProductMerk::all(),
            'senderAddresses' => SenderAddress::all(),
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
        // foreach ($request->sender as $key => $sender) {
        //     echo ($sender);
        //     echo "<br>";
        // }
        // dd($request);
        // dd(gettype($request->variant_stock));
        // for ($i = 0; $i < count($request->variant_name); $i++) {
        //     echo $request->variant_name[$i];
        //     echo "<br>";
        //     echo $request->variant_slug[$i];
        //     echo "<br>";
        //     echo $request->variant_code[$i];
        //     echo "<br>";
        //     echo $request->variant_stock[$i];
        //     echo "<br>";
        //     echo "<br>";
        // }
        $this->isAdministrator();
        if (isset($request->variant_name) || isset($request->variant_slug) || isset($request->variant_value) || isset($request->variant_code) || isset($request->variant_stock) || isset($request->variant_weight) || isset($request->variant_long) || isset($request->variant_width) || isset($request->variant_height) || isset($request->variant_price)) {
            // echo "ada varian";
            // echo '</br>';
            $request->merge([
                'stock' => '0',
                'weight' => '0',
                'long' => '0',
                'width' => '0',
                'height' => '0',
                'price' => '0',
            ]);
        } else {
            // echo "tidak ada varian";
            // echo '</br>';
        }

        $request->merge([
            'view' => '0',
            'sold' => '0',
            'stock_notification' => '1',
            'promo_id' => '0',
        ]);

        if (!isset($request->is_active)) {
            $request->merge(['is_active' => '0']);
            // echo "status tidak aktif";
            // echo '</br>';
        }

        if ($request->company_id !=  auth()->guard('adminMiddle')->user()->company_id) {
            return redirect()->back()->with(['addProductFailed' => 'Id perusahaan anda tidak match! Coba relogin kembali']);
        }

        $volume_weight = ($request->long * $request->width * $request->height) / 6000 * 1000;

        if ($volume_weight > $request->weight) {
            $weight_used = $volume_weight;
        } else {
            $weight_used = $request->weight;
        }

        $request->merge(['weight_used' => $weight_used]);
        // dd($request);
        $validatedData = $request->validate(
            [
                'name' => 'required',
                'specification' => 'required',
                'description' => 'required',
                'excerpt' => 'required',
                'slug' => 'required|unique:products',
                'product_code' => 'required|unique:products',
                'product_category_id' => 'required',
                'product_merk_id' => 'required',
                'stock' => 'required|integer',
                'sold' => 'required|integer',
                'view' => 'required|integer',
                'weight' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'long' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'width' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'height' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'weight_used' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'price' => 'required|integer',
                'is_active' => 'required',
                'stock_notification' => 'required',
                'promo_id' => 'required',
                'sender' => 'required',
                'company_id' => 'required',
            ],
            [
                'name.required' => 'Nama produk harus diisi!',
                'specification.required' => 'Spesifikasi produk harus diisi!',
                'description.required' => 'Deskripsi produk harus diisi!',
                'excerpt.required' => 'Deskripsi singkat produk harus diisi!',
                'slug.required' => 'Slug harus diisi!',
                'slug.unique' => 'Slug harus unik!',
                'product_code.required' => 'ID produk harus diisi!',
                'product_code.unique' => 'ID produk harus unik!',
                'product_category_id.required' => 'Kategori produk harus diisi',
                'product_merk_id.required' => 'Merk produk harus diisi',
                'weight.required' => 'Berat produk harus diisi',
                'weight.regex' => 'Berat produk harus berupa angka',
                'weight_used.required' => 'Berat produk harus diisi',
                'weight_used.regex' => 'Berat produk harus berupa angka',
                'long.required' => 'Panjang produk harus diisi',
                'long.regex' => 'Panjang produk harus berupa angka',
                'width.required' => 'Lebar produk harus diisi',
                'width.regex' => 'Lebar produk harus berupa angka',
                'height.required' => 'Tinggi produk harus diisi',
                'height.regex' => 'Tinggi produk harus berupa angka',
                'price.required' => 'Harga produk harus diisi',
                'sender.required' => 'Pilih setidaknya satu alamat pengiriman!',
                'company_id.required' => 'Id Perusahaan harus diisi!',
            ]
        );

        // dd($validatedData);

        $product = Product::create($validatedData);
        // print_r($product);
        // echo "<br>";
        // echo "<br>";

        // insert product variant
        if (isset($request->variant_name) || isset($request->variant_slug) || isset($request->variant_value) || isset($request->variant_code) || isset($request->variant_stock) || isset($request->variant_weight) || isset($request->variant_long) || isset($request->variant_width) || isset($request->variant_height) || isset($request->variant_price)) {
            $validatedDataVariant = $request->validate(
                [
                    'variant_name' => 'required',
                    'variant_slug' => 'required|unique:product_variants',
                    'variant_value' => 'required',
                    'variant_code' => 'required|unique:product_variants',
                    'variant_stock' => 'required|array',
                    'variant_stock.*' => 'required|numeric',
                    'variant_weight' => 'required|array',
                    'variant_weight.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                    'variant_long' => 'required|array',
                    'variant_long.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                    'variant_width' => 'required|array',
                    'variant_width.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                    'variant_height' => 'required|array',
                    'variant_height.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                    'variant_price' => 'required|array',
                    'variant_price.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                ],
                [
                    'variant_name.required' => 'Nama produk harus diisi!',
                    'variant_slug.required' => 'Slug harus diisi!',
                    'variant_value.required' => 'Slug harus diisi!',
                    'variant_slug.unique' => 'Slug harus unik!',
                    'variant_code.required' => 'ID produk harus diisi!',
                    'variant_code.unique' => 'ID produk harus unik!',
                    'variant_weight.required' => 'Berat produk harus diisi',
                    'variant_weight.*.regex' => 'Berat produk harus berupa angka',
                    'variant_long.required' => 'Panjang produk harus diisi',
                    'variant_long.*.regex' => 'Panjang produk harus berupa angka',
                    'variant_width.required' => 'Lebar produk harus diisi',
                    'variant_width.*.regex' => 'Lebar produk harus berupa angka',
                    'variant_height.required' => 'Tinggi produk harus diisi',
                    'variant_height.*.regex' => 'Tinggi produk harus berupa angka',
                    'variant_price.required' => 'Harga produk harus diisi',
                    'variant_price.*.regex' => 'Harga produk harus berupa angka',
                ]
            );

            for ($i = 0; $i < count($request->variant_name); $i++) {

                $variant_volume_weight = ($request->variant_long[$i] * $request->variant_width[$i] * $request->variant_height[$i]) / 6000 * 1000;

                if ($variant_volume_weight > $request->variant_weight[$i]) {
                    $variant_weight_used = $variant_volume_weight;
                } else {
                    $variant_weight_used = $request->variant_weight[$i];
                }

                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'variant_name' => $request->variant_name[$i],
                    'variant_slug' => $request->variant_slug[$i],
                    'variant_value' => $request->variant_value[$i],
                    'variant_code' => $request->variant_code[$i],
                    'sold' => $request->sold,
                    'stock' => $request->variant_stock[$i],
                    'weight' => $request->variant_weight[$i],
                    'long' => $request->variant_long[$i],
                    'width' => $request->variant_width[$i],
                    'height' => $request->variant_height[$i],
                    'weight_used' => $variant_weight_used,
                    'price' => $request->variant_price[$i],
                    'promo_id' => $request->promo_id,
                ]);
                // print_r($variant);
                // echo "<br>";
                // echo "<br>";
                foreach ($request->sender[$i] as $key => $sender) {
                    $productOrigin = ProductOrigin::create([
                        'product_id' => $product->id,
                        'product_variant_id' => $variant->id,
                        'city_ids' => $request->city_ids[$key],
                        'sender_address_id' => $sender,
                    ]);
                }
                // for ($i = 0; $i < count($request->sender); $i++) {
                //     // for ($j = 0; $j < count($request->sender[$i]); $j++) {
                //     foreach ($request->sender[$i] as $sender) {
                //         $productOrigin = ProductOrigin::create([
                //             'product_id' => $product->id,
                //             'product_variant_id' => $variant->id,
                //             // 'city_ids' => $request->city_ids[$i],
                //             'sender_address_id' => $sender,
                //         ]);
                //         foreach ($request->city_ids as $city_ids) {
                //             $productOrigin->city_ids = $city_ids;
                //             $productOrigin->save();
                //         }
                //         print_r($productOrigin);
                //         echo "<br>";
                //     }
                // }

                // echo "<br>";
            }
            $product->stock =  $product->stock + array_sum($request->variant_stock);
            $product->save();
        } else {
            // insert product origin
            foreach ($request->sender as $key => $sender) {
                $productOrigin = ProductOrigin::create([
                    'product_id' => $product->id,
                    'city_ids' => $request->city_ids_single[$key],
                    'sender_address_id' => $sender,
                ]);
            }
            // for ($i = 0; $i < count($request->sender); $i++) {
            //     $productOrigin = ProductOrigin::create([
            //         'product_id' => $product->id,
            //         'city_ids' => $request->city_ids_single[$i],
            //         'sender_address_id' => $request->sender[$i],
            //     ]);
            // }
        }

        $admin = Admin::find($request->admin_id);
        $loop = 0;
        foreach ($request->productImageUpload as $productImage) {
            $image_parts = explode(";base64,", $productImage);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            // echo $productImage;
            // print_r($image_parts);
            // print_r($image_type);

            $folderPathSave = 'admin/product/' . $product->id . '/';

            $imageName = uniqid() . '-' . $loop++  . '.' . $image_type;

            $imageFullPathSave = $folderPathSave . $imageName;

            $save = Storage::put($imageFullPathSave, $image_base64);

            $productImageSave = ProductImage::create([
                'product_id' => $product->id,
                'name' => $imageFullPathSave
            ]);
        }
        // dd($validatedData);


        // if ($request->admin_id == auth()->guard('adminMiddle')->user()->id) {
        //     echo 'admin id verified';
        //     echo '</br>';
        // } else {
        //     abort(403);
        // }
        // if (!isset($request->productImageUpload) || !($request->file('productImage'))) {
        //     echo "Upload foto produk minimal satu foto";
        //     echo '</br>';
        // }
        // if (!isset($request->productImageUpload) || !($request->file('productImage'))) {
        //     echo "Upload foto produk minimal satu foto";
        //     echo '</br>';
        // }
        // dd($request);
        if ($product || $variant && $productOrigin && $productImageSave) {
            return redirect()->route('adminproduct.create')->with('addProductSuccess', 'Berhasil menambahkan produk.');
        } else {
            return redirect()->back()->with('addProductFailed', 'Terdapat kesalahan saat menambahkan produk , mohon pastikan semua form sudah terisi dengan benar');
        }
        // dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // $this->isAdministrator();
        // dd($product);
        return view('admin.product.show', [
            'title' => 'Produk',
            'active' => 'adminproduct',
            'product' => $product,
            'categories' => ProductCategory::all(),
            'merks' => ProductMerk::all(),
            'senderAddresses' => SenderAddress::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Product $product)
    {
        $this->isAdministrator();
        $active = $request->session()->get('currentPage');
        // dd($active);
        // if($active == 'adminproduct'){
        //     $active = 'product';
        // }elseif($active == 'outstock'){
        //     $active = 'out-stock';
        // }
        return view('admin.product.edit', [
            'title' => 'Produk',
            'active' => $active,
            'product' => $product,
            'categories' => ProductCategory::all(),
            'merks' => ProductMerk::all(),
            'senderAddresses' => SenderAddress::all(),
            'companies' => Company::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->isAdministrator();
        // dd(url()->previous());
        // dd($request);
        // dd(count($request->variant_name));
        // echo array_key_last($request->variant_name);
        $admin = Admin::find($request->admin_id);
        $loop = 0;
        foreach ($request->productImageUpload as $productImage) {
            if (isset($productImage)) {
                $image_parts = explode(";base64,", $productImage);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);

                // echo $productImage;
                // print_r($image_parts);
                // print_r($image_type);

                $folderPathSave = 'admin/product/' . $product->id . '/';

                $imageName = uniqid() . '-' . $loop++  . '.' . $image_type;

                $imageFullPathSave = $folderPathSave . $imageName;

                $saveImage = Storage::put($imageFullPathSave, $image_base64);

                $productImageSave = ProductImage::create([
                    'product_id' => $product->id,
                    'name' => $imageFullPathSave
                ]);
            }
        }

        if (!isset($request->is_active)) {
            $request->merge(['is_active' => '0']);
            echo "status tidak aktif";
            echo '</br>';
        }
        if (!isset($request->stock_notification)) {
            $request->merge(['stock_notification' => '0']);
            echo "status tidak aktif";
            echo '</br>';
        }
        // dd($request);
        $validatedDataProduct = $request->validate(
            [
                'name' => 'required',
                'specification' => 'required',
                'description' => 'required',
                'excerpt' => 'required',
                'slug' => 'required',
                'product_code' => 'required',
                'product_category_id' => 'required',
                'product_merk_id' => 'required',
                'is_active' => 'required',
                'stock_notification' => 'required',
                'company_id' => 'required',

            ],
            [
                'name.required' => 'Nama produk harus diisi!',
                'specification.required' => 'Spesifikasi produk harus diisi!',
                'description.required' => 'Deskripsi produk harus diisi!',
                'excerpt.required' => 'Deskripsi singkat produk harus diisi!',
                'slug.required' => 'Slug harus diisi!',
                'product_code.required' => 'ID produk harus diisi!',
                'product_category_id.required' => 'Kategori produk harus diisi',
                'product_merk_id.required' => 'Merk produk harus diisi',
                'company_id.required' => 'Company Id harus diisi',

            ]
        );

        // cek apakah ada variant
        if (isset($request->variant_name)) {
            // cek alamat pengiriman tidak boleh kosong
            if (!isset($request->sender)) {
                return redirect()->back()->with(['failed' => 'Alamat Pengiriman tidak boleh kosong']);
            } else {
                foreach ($request->variant_name as $key => $sender) {
                    if (!isset($request->sender[$key])) {
                        return redirect()->back()->with(['failed' => 'Alamat Pengiriman tidak boleh kosong']);
                    }
                }
            }
            // validasi hasil input variant
            $validatedDataVariant = $request->validate(
                [
                    'variant_name' => 'required',
                    // 'variant_slug' => 'required|unique:product_variants',
                    'variant_value' => 'required',
                    // 'variant_code' => 'required|unique:product_variants',
                    'variant_stock' => 'required|array',
                    'variant_stock.*' => 'required|numeric',
                    'variant_weight' => 'required|array',
                    'variant_weight.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                    'variant_long' => 'required|array',
                    'variant_long.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                    'variant_width' => 'required|array',
                    'variant_width.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                    'variant_height' => 'required|array',
                    'variant_height.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                    'variant_price' => 'required|array',
                    'variant_price.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                ],
                [
                    'variant_name.required' => 'Nama produk harus diisi!',
                    'variant_slug.required' => 'Slug harus diisi!',
                    'variant_value.required' => 'Slug harus diisi!',
                    'variant_slug.unique' => 'Slug harus unik!',
                    'variant_code.required' => 'ID produk harus diisi!',
                    'variant_code.unique' => 'ID produk harus unik!',
                    'variant_weight.required' => 'Berat produk harus diisi',
                    'variant_weight.*.regex' => 'Berat produk harus berupa angka',
                    'variant_long.required' => 'Panjang produk harus diisi',
                    'variant_long.*.regex' => 'Panjang produk harus berupa angka',
                    'variant_width.required' => 'Lebar produk harus diisi',
                    'variant_width.*.regex' => 'Lebar produk harus berupa angka',
                    'variant_height.required' => 'Tinggi produk harus diisi',
                    'variant_height.*.regex' => 'Tinggi produk harus berupa angka',
                    'variant_price.required' => 'Harga produk harus diisi',
                    'variant_price.*.regex' => 'Harga produk harus berupa angka',
                ]
            );
            for ($i = 0; $i <= array_key_last($request->variant_name); $i++) {
                echo 'i : ' . $i;
                echo "<br>";
                // cek apakah variant yang ada telah sudah exist di DB dan melakukan update variant
                if (isset($request->variant_id[$i])) {
                    // task untuk menghapus variant yang ingin dihapus
                    for ($i = 0; $i < count($product->productvariant); $i++) {
                        $deleteVariant = ProductVariant::where('product_id', $product->id)->whereNotIn('id', $request->variant_id)->get();
                        // dd($product);
                        // dd(count($deleteVariant));
                        // dd($request->variant_id);
                        // dd($deleteVariant);
                        // dd($deleteVariant);
                        // dd(count($deleteVariant));
                        if (count($deleteVariant) > 0) {
                            // dd($deleteVariant);
                            foreach ($deleteVariant as $key => $delete) {
                                foreach ($delete->productorigin as $key => $origin) {
                                    $origin->delete();
                                }
                                $deleteVariants = $deleteVariant->each->delete();
                            }
                        } else {
                        }
                    }
                } else {
                    // echo "add variant after delete";
                    // echo "<br>";
                    // if (isset($request->variant_name[$i])) {

                    //     // $deleteVariant = ProductVariant::where('product_id', $product->id)->where
                    //     $addVariant = ProductVariant::create([
                    //         'product_id' => $product->id,
                    //         'variant_name' => $request->variant_name[$i],
                    //         'variant_slug' => $request->variant_slug[$i],
                    //         'variant_value' => $request->variant_value[$i],
                    //         'variant_code' => $request->variant_code[$i],
                    //         'sold' => 0,
                    //         'stock' => $request->variant_stock[$i],
                    //         'weight' => $request->variant_weight[$i],
                    //         'long' => $request->variant_long[$i],
                    //         'width' => $request->variant_width[$i],
                    //         'height' => $request->variant_height[$i],
                    //         'price' => $request->variant_price[$i],
                    //         'promo_id' => 0,
                    //     ]);

                    //     if ($addVariant) {
                    //         foreach ($request->sender[$i] as $key => $sender) {
                    //             $productOrigin = ProductOrigin::create([
                    //                 'product_id' => $product->id,
                    //                 'product_variant_id' => $addVariant->id,
                    //                 'city_ids' => $request->city_ids[$key],
                    //                 'sender_address_id' => $sender,
                    //             ]);
                    //         }
                    //     } else {
                    //     }
                    // }
                }
            }

            // task untuk menambahkan variant
            for ($i = 0; $i <= array_key_last($request->variant_name); $i++) {

                // cek apakah variant yang ada telah sudah exist di DB dan melakukan update variant
                if (isset($request->variant_id[$i])) {
                    $variantUpdate = ProductVariant::where('product_id', $product->id)->where('id', $request->variant_id[$i])->first();

                    $volume_weight[$i] = ($request->variant_long[$i] * $request->variant_width[$i] * $request->variant_height[$i]) / 6000 * 1000;

                    if ($volume_weight[$i] > $request->variant_weight[$i]) {
                        $variant_weight_used[$i] = $volume_weight[$i];
                    } else {
                        $variant_weight_used[$i] = $request->variant_weight[$i];
                    }

                    // query update variant
                    $updateVariant = $variantUpdate->fill([
                        'variant_name' => $request->variant_name[$i],
                        'variant_slug' => $request->variant_slug[$i],
                        'variant_value' => $request->variant_value[$i],
                        'variant_code' => $request->variant_code[$i],
                        'sold' => 0,
                        'stock' => $request->variant_stock[$i],
                        'weight' => $request->variant_weight[$i],
                        'long' => $request->variant_long[$i],
                        'width' => $request->variant_width[$i],
                        'height' => $request->variant_height[$i],
                        'weight_used' => $variant_weight_used[$i],
                        'price' => $request->variant_price[$i],
                    ]);

                    // task save update variant
                    $saveUpdateVariant = $updateVariant->save();

                    // dd($request);
                    // jika berhasil simpan maka selanjutnya dicek apakah ada perubahan di alamat pengiriman    
                    if ($saveUpdateVariant) {

                        if (count($variantUpdate->productorigin) > 0) {
                            if (isset($request->sender[$i])) {
                                // dd($variantUpdate->productorigin);
                                // dd($request->sender[$i]);
                                foreach ($request->sender[$i] as $key => $sender) {

                                    // query mencari variant origin yang tidak diceklist dari DB
                                    $originDelete = ProductOrigin::where('product_id', $product->id)->where('product_variant_id', $updateVariant->id)->whereNotIn('sender_address_id', $request->sender[$i])->get();

                                    // menghapus variant origin
                                    foreach ($originDelete as $deleteOrigin) {
                                        $deleteOrigins = $deleteOrigin->delete();
                                    }

                                    // query mencari variant origin yang tidak ada dari DB
                                    $originAdd = ProductOrigin::where('product_id', $product->id)->where('product_variant_id', $updateVariant->id)->whereIn('sender_address_id', $request->sender[$i])->pluck('sender_address_id')->toArray();

                                    if (isset($request->sender[$i][$key])) {
                                        if (!in_array($request->sender[$i][$key], $originAdd)) {
                                            $productOrigin = ProductOrigin::create([
                                                'product_id' => $product->id,
                                                'product_variant_id' => $updateVariant->id,
                                                'city_ids' => $request->city_ids[$key],
                                                'sender_address_id' => $request->sender[$i][$key],
                                            ]);
                                        }
                                    }
                                }
                            }
                        } else {
                            if (isset($request->sender[$i])) {
                                foreach ($request->sender[$i] as $key => $sender) {
                                    $productOrigin = ProductOrigin::create([
                                        'product_id' => $product->id,
                                        'product_variant_id' => $updateVariant->id,
                                        'city_ids' => $request->city_ids[$i],
                                        'sender_address_id' => $sender,
                                    ]);
                                }
                            }
                        }
                    }
                } else {
                    if (isset($request->variant_name[$i])) {
                        echo $request->variant_name[$i];
                        echo "<br>";

                        $volume_weight[$i] = ($request->variant_long[$i] * $request->variant_width[$i] * $request->variant_height[$i]) / 6000 * 1000;

                        if ($volume_weight[$i] > $request->variant_weight[$i]) {
                            $variant_weight_used[$i] = $volume_weight[$i];
                        } else {
                            $variant_weight_used[$i] = $request->variant_weight[$i];
                        }    

                        $addVariant = ProductVariant::create([
                            'product_id' => $product->id,
                            'variant_name' => $request->variant_name[$i],
                            'variant_slug' => $request->variant_slug[$i],
                            'variant_value' => $request->variant_value[$i],
                            'variant_code' => $request->variant_code[$i],
                            'sold' => 0,
                            'stock' => $request->variant_stock[$i],
                            'weight' => $request->variant_weight[$i],
                            'long' => $request->variant_long[$i],
                            'width' => $request->variant_width[$i],
                            'height' => $request->variant_height[$i],
                            'weight_used' => $variant_weight_used[$i],
                            'price' => $request->variant_price[$i],
                            'promo_id' => 0,
                        ]);

                        if ($addVariant) {

                            foreach ($request->sender[$i] as $key => $sender) {
                                $productOrigin = ProductOrigin::create([
                                    'product_id' => $product->id,
                                    'product_variant_id' => $addVariant->id,
                                    'city_ids' => $request->city_ids[$key],
                                    'sender_address_id' => $sender,
                                ]);
                            }
                        } else {
                        }
                    }
                }
            }
            
            $updateProduct = $product->fill($validatedDataProduct);
            // dd($updateProduct);
            $updateProductSave = $updateProduct->save();

            $product->stock = array_sum($request->variant_stock);
            $product->save();
        } elseif (!isset($request->variant_name) && count($product->productvariant) > 0) {
            echo "product variant dihapus";
            echo "<br>";
            echo "product variant : ";
            foreach ($product->productvariant as $variantId => $variant) {
                foreach ($variant->productorigin as $originId => $origin) {
                    echo "origin";
                    echo ($origin);
                    echo "<br>";
                    $origin->delete();
                }
                $deleteVariants = $variant->delete();
                echo "<br>";
            }
            echo "<br>";
            $product->stock = array_sum($request->variant_stock);
            $product->save();
        } elseif (!isset($request->variant_name) && count($product->productvariant) == 0) {
            echo "product update";

            if (isset($request->sender_no_variant)) {
                $request->merge(['sender' => $request->sender_no_variant]);
            }

            $validatedDataProduct2 = $request->validate(
                [
                    'stock' => 'required|integer',
                    'weight' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                    'long' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                    'width' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                    'height' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                    'price' => 'required|integer',
                    'sender' => 'required',
                ],
                [
                    'stock.required' => 'Stock produk harus diisi',
                    'weight.required' => 'Berat produk harus diisi',
                    'weight.regex' => 'Berat produk harus berupa angka',
                    'long.required' => 'Panjang produk harus diisi',
                    'long.regex' => 'Panjang produk harus berupa angka',
                    'width.required' => 'Lebar produk harus diisi',
                    'width.regex' => 'Lebar produk harus berupa angka',
                    'height.required' => 'Tinggi produk harus diisi',
                    'height.regex' => 'Tinggi produk harus berupa angka',
                    'price.required' => 'Harga produk harus diisi',
                    'sender.required' => 'Pilih setidaknya satu alamat pengiriman!',
                ]
            );


            $volume_weight = ($request->long * $request->width * $request->height) / 6000 * 1000;

            if ($volume_weight > $request->weight) {
                $weight_used = $volume_weight;
            } else {
                $weight_used = $request->weight;
            }

            $validated = array_merge($validatedDataProduct, $validatedDataProduct2);
            // dd($validated);
            $updateProductOnly = $product->fill($validated);
            $product->weight_used = $weight_used;
            // dd($updateProductOnly);
            $updateProductSave = $updateProductOnly->save();

            if ($updateProductSave) {
                if (count($product->productorigin) > 0) {
                    foreach ($request->sender_no_variant as $key => $sender) {
                        // dd($product->productorigin);
                        echo $sender;
                        echo "<br>";
                        // query mencari variant origin yang tidak diceklist dari DB
                        $originDelete = ProductOrigin::where('product_id', $product->id)->whereNotIn('sender_address_id', $request->sender_no_variant)->get();
                        // dd($originDelete);
                        echo "<br>";
                        // menghapus variant origin
                        foreach ($originDelete as $deleteOrigin) {
                            $deleteOrigins = $deleteOrigin->delete();
                        }

                        // query mencari variant origin yang tidak ada dari DB
                        $originAdd = ProductOrigin::where('product_id', $product->id)->whereIn('sender_address_id', $request->sender_no_variant)->pluck('sender_address_id')->toArray();
                        // dd($originAdd);
                        if (isset($request->sender_no_variant[$key])) {
                            if (!in_array($request->sender_no_variant[$key], $originAdd)) {
                                $productOrigin = ProductOrigin::create([
                                    'product_id' => $product->id,
                                    'product_variant_id' => 0,
                                    'city_ids' => $request->city_ids_single[$key],
                                    'sender_address_id' => $request->sender_no_variant[$key],
                                ]);
                            }
                        }
                    }
                } else {
                    foreach ($request->sender_no_variant as $key => $sender) {
                        $productOrigin = ProductOrigin::create([
                            'product_id' => $product->id,
                            'product_variant_id' => 0,
                            'city_ids' => $request->city_ids_single[$key],
                            'sender_address_id' => $sender,
                        ]);
                    }
                }
            }
        }
        print_r([isset($saveImage), isset($productImageSave), isset($deleteVariants), isset($saveUpdateVariant), isset($deleteOrigins), isset($productOrigin), isset($addVariant), isset($updateProductSave)]);
        // dd($request);
        if (isset($saveImage) || isset($productImageSave) || isset($deleteVariants) || isset($saveUpdateVariant) || isset($deleteOrigins) || isset($productOrigin) || isset($addVariant) || isset($updateProductSave)) {
            return redirect('http://klikspl.test/administrator/adminproduct/' . $product->slug . '/edit')->with(['success' => 'Berhasil memperbarui produk']);
        } else {
            return redirect('http://klikspl.test/administrator/adminproduct/' . $product->slug . '/edit')->with(['failed' => 'Gagal memperbarui produk']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->isAdministrator();
        //
    }

    public function checkSlug(Request $request)
    {
        $this->isAdministrator();
        $slug = SlugService::createSlug(Product::class, 'slug', $request->name);

        return response()->json(['slug' => $slug]);
    }

    public function deleteProductImage(Request $request)
    {
        $this->isAdministrator();
        // dd('ini delete image');
        $deleteImage = ProductImage::find($request->image_id);

        if ($deleteImage) {
            Storage::delete($deleteImage->name);
            $delete = $deleteImage->delete();
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

    public function updateStatus(Request $request)
    {
        $this->isAdministrator();
        // dd($cart);
        // $city = CartItem::where('id', $id)->get();
        // return response()->json($city);
        // dd($request);
        // if ($request->id) {
        $status = Product::find($request->id);
        $status->is_active = $request->status;
        $status->save();
        // }
        // session()->flash('success', 'Berhasil memperbarui jumlah item');
        $update = Product::where('id', $request->id)->first();
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

    public function updateStatusStockNotification(Request $request)
    {
        $this->isAdministrator();
        // dd($cart);
        // $city = CartItem::where('id', $id)->get();
        // return response()->json($city);
        // dd($request);
        // if ($request->id) {
        $status = Product::find($request->id);
        $status->stock_notification = $request->status;
        $status->save();
        // }
        // session()->flash('success', 'Berhasil memperbarui jumlah item');
        $update = Product::where('id', $request->id)->first();
        if ($update) {
            $message = 'success';
        } else {
            $message = 'failed';
        }
        return response()->json([
            'message' => $message,
            'data' => $update,
            'id' => $update->id,
            'status' => $update->stock_notification,
        ]);
    }

    public function outStock(Request $request)
    {
        $this->isAdministrator();
        $currentURL = explode('/', url()->current());
        $currentPage = last($currentURL);
        Session::put('currentPage', $currentPage);
        if (auth()->guard('adminMiddle')->user()->admin_type == 1) {
            $outStock =  Product::with(['productvariant' => fn ($query) => $query->where('stock', '=', '0')])
                ->whereHas(
                    'productvariant',
                    fn ($query) =>
                    $query->where('stock', '=', '0')
                )->orWhere('stock', '=', '0')
                ->get();
        } else {
            $outStock =  Product::where('company_id', '=', auth()->guard('adminMiddle')->user()->company_id)->with(['productvariant' => fn ($query) => $query->where('stock', '=', '0')])
                ->whereHas(
                    'productvariant',
                    fn ($query) =>
                    $query->where('stock', '=', '0')
                )->orWhere('stock', '=', '0')
                ->get();
        }

        // dd($outStock);
        return view('admin.product.index', [
            'title' => 'Produk Habis',
            'active' => 'outstock',
            'products' => $outStock,
        ]);
    }

    public function isAdministrator()
    {
        if (auth()->guard('adminMiddle')->user()->admin_type != 1 && auth()->guard('adminMiddle')->user()->admin_type != 2) {
            abort(403);
        }
    }

    public function isWhLogAndAdministrator()
    {
        if (auth()->guard('adminMiddle')->user()->admin_type != 1 && auth()->guard('adminMiddle')->user()->admin_type != 2  && auth()->guard('adminMiddle')->user()->admin_type != 4) {
            // dd(auth()->guard('adminMiddle')->user()->admin_type);

            abort(403);
        }
    }
}
