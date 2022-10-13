<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Product;
use App\Models\Province;
use App\Models\ProductMerk;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductOrigin;
use App\Models\SenderAddress;
use App\Models\ProductComment;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Session\SessionUtils;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(request());
        // if(request('sortby')){
        //     dd(request('sortby'));
        // }

        $products = Product::latest()->where('is_active','=',1)->with('productcomment')->addSelect(['star'=> ProductComment::selectRaw('avg(star)')->where('star','!=','0')->whereColumn('product_id','products.id')])->orderByDesc(ProductComment::selectRaw('avg(star)')->where('star','!=','0')->whereColumn('product_id','products.id'))->filter(request(['keyword','category','merk','sortby']))->paginate(80)->withquerystring();

        $promos = array();
        foreach ($products as $i => $product) {
            $key = 0;
            foreach ($product->productpromo as $j => $productPromo) {
                if ($productPromo->promo->is_active == 1) {
                    $promos[$i] = ((object)['id' =>$product->id,'promoActive' => $key+1]);
                    $key +=1;
                }
            }
        }
        // dd($products);
        return view('products', [
            'title' => 'Semua Produk',
            'active' => 'products',
            'products' => $products,
            'promos' => $promos,
            'categories' => ProductCategory::all(),
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $city_origin = '36';
        $Key = 'product-' . $product->id;
        if (!Session::has($Key)) {

            DB::table('products')
                ->where('id', $product->id)
                ->increment('view', 1);
            Session::put($Key, 1);
        }
        // print_r(Session::all());
        $stock = 0;
        if (count($product->productvariant) > 0) {
            foreach ($product->productVariant as $variant) {
                if($variant->stock > 0){
                    $stock += $variant->stock;
                }
            }
        } else {
            $stock = $product->stock;
        }
        
        $product = Product::find($product->id);
        $origin =  ProductOrigin::where('product_id','=',$product->id)->with('city')->groupBy('sender_address_id')->get();
        // $product->productorigin->with('senderAddress')->unique('sender_address_id');
        $senderAddress = SenderAddress::where('is_active','=',1)->with('city')->get();
        // dd($senderAddress);
        return view('product', [
            'title' => $product->name,
            // "product" => $product,
            'active' => 'products',
            "product" => $product,
            "stock" => $stock,
            "comments" => ProductComment::where('product_id', $product->id)->with('user','children')->get(),
            "star" => ProductComment::where('product_id','=',$product->id)->where('star','!=','0')->avg('star'),
            "count_comments" => ProductComment::where('product_id','=',$product->id)->where('star','!=','0')->count(),
            "provinces" => Province::pluck('name', 'province_id'),
            "from_city" => City::where('city_id','=',$city_origin)->first(),
            "origin" => $origin,
            "senderAddress" => $senderAddress
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
