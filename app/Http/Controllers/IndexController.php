<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Promo;
use App\Models\Product;
use App\Models\ProductMerk;
use App\Models\PromoBanner;
use App\Models\ProductPromo;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\ProductCategory;
use App\Models\ProductComment;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        $this->promoBannerExpiredCheck();
        $this->promoVoucherExpiredCheck();

        $productsLatest = Product::where('is_active', '=', 1)->with('productcomment')->addSelect(['star'=> ProductComment::selectRaw('avg(star)')->where('star','!=','0')->whereColumn('product_id','products.id')])->latest()->take(12)->get();
        $productsBestSeller =  Product::where('is_active', '=', 1)->with('productcomment')->addSelect(['star'=> ProductComment::selectRaw('avg(star)')->where('star','!=','0')->whereColumn('product_id','products.id')])->orderBy('sold', 'desc')->take(12)->get();
        // Product::where('is_active', '=', 1)->with('productcomment')->orderBy('sold', 'desc')->take(12)->get();
        $productsStar =  Product::where('is_active', '=', 1)->with('productcomment')->addSelect(['star'=> ProductComment::selectRaw('avg(star)')->where('star','!=','0')->whereColumn('product_id','products.id')])->orderByDesc(ProductComment::selectRaw('avg(star)')->where('star','!=','0')->whereColumn('product_id','products.id'))->take(12)->get();
        // $productsStar =  Product::where('is_active', '=', 1)->with('productcomment')->get()->sortByDesc(function ($products) {
        //     return $products->productComment->avg('star');
        // })->take(12);
        $promoBanner = PromoBanner::where('is_active', '=', 1)->where('start_period', '<=', Carbon::now())->where('end_period', '>=', Carbon::now())->orderBy("id", "desc")->get();
        // dd($productsBestSeller);
        // dd($productsStar);
        $promosPL = array();
        // dd(
        //     Product::where('is_active', '=', 1)->with('productcomment')->addSelect(['star'=> ProductComment::selectRaw('avg(star)')->where('star','!=','0')->whereColumn('product_id','products.id')])->get()
        // );
        foreach ($productsLatest as $i => $itemPL) {
            $key = 0;
            // echo "key : " . $key;
            // echo "<br>";
            // echo "i : " . $i;
            // echo "<br>";
            // echo "item id : ";
            // echo $itemPL->id;
            // echo "<br>";
            // $promosPL = collect();
            foreach ($itemPL->productpromo as $j => $itemPromo) {
                // echo "j : " . $j;
                // echo "<br>";
                // echo "--prod promo id : ";
                // echo $itemPromo->id;
                // echo "<br>";
                if ($itemPromo->promo->is_active == 1) {
                    // echo "----promo id : ";
                    // echo $itemPromo->promo->id;
                    // echo "<br>";
                    // echo "----promo name : ";
                    // echo $itemPromo->promo->name;
                    // echo "<br>";
                    // $promosPL[$i]['id'] = $itemPL->id;
                    // $promosPL[$i]['promoActive'] = $key+ 1;
                    $promosPL[$i] = ((object)['id' =>$itemPL->id,'promoActive' => $key+1]);
                    $key +=1;
                    // $promosPL->push([(object) $itemPromo->promo]);
                }
                // echo "<br>";
            }
            // echo "<br>";
        }
        // dd($promosPL);
        $promosBS = array();
        foreach ($productsBestSeller as $i => $itemBS) {
            $key = 0;
            foreach ($itemBS->productpromo as $j => $itemPromo) {
                if ($itemPromo->promo->is_active == 1) {
                    $promosBS[$i] = ((object)['id' =>$itemBS->id,'promoActive' => $key+1]);
                    $key +=1;
                }
            }
        }
        // dd($promosBS);
        $promosStar = array();
        foreach ($productsStar as $i => $itemStar) {
            $key = 0;
            foreach ($itemStar->productpromo as $j => $itemPromo) {
                if ($itemPromo->promo->is_active == 1) {
                    $promosStar[$i] = ((object)['id' =>$itemStar->id,'promoActive' => $key+1]);
                    $key +=1;
                }
            }
        }

        // dd($promosStar);

        $merksIndex = ProductMerk::take(12)->get();

        return view('index', [
            'title' => 'E-commerce resmi CV. SARANA PRIMA LESTARI',
            'active' => 'index',
            'productsLatest' => $productsLatest,
            'productsBestSeller' => $productsBestSeller,
            'productsStar' => $productsStar,
            'promoBanner' => $promoBanner,
            'promosPL' => $promosPL,
            'promosBS' => $promosBS,
            'promosStar' => $promosStar,
            'merksIndex' => $merksIndex,
        ]);
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
