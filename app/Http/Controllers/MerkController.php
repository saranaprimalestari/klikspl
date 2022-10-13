<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductMerk;
use App\Models\Product;

class MerkController extends Controller
{
    public function index()
    {
        // dd($category);
        return view('categoriesMerks',[
            'title' => 'E-commerce resmi CV. SARANA PRIMA LESTARI | Product',
			"page" => 'Merk',
			"imgSource" => '',
            "queries" => ProductMerk::all(),
            
		]);
    }
    public function show(ProductMerk $merk)
    {
        return view('productCategoriesMerks',[
            'title' => 'E-commerce resmi CV. SARANA PRIMA LESTARI | Product',
            'page' => 'Merk',
			"var" => $merk,
            "products" => Product::where('product_merk_id',$merk->id)->paginate(12),
            // "products" => Product::paginate(12),
            "queries" => ProductMerk::all(),
		]);
    }
}
