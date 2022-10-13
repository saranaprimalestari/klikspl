<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // dd($category);
        return view('categoriesMerks',[
            'title' => 'E-commerce resmi CV. SARANA PRIMA LESTARI | Product',
			"page" => 'Kategori',
			"imgSource" => '/assets/cart.svg',
            "queries" => ProductCategory::all(),
            
		]);
    }
    public function show(ProductCategory $category)
    {
        // dd($category);
        return view('productCategoriesMerks',[
            'title' => 'E-commerce resmi CV. SARANA PRIMA LESTARI | Product',
            'page' => 'Kategori',
			"var" => $category,
            "products" => Product::where('product_category_id',$category->id)->paginate(12),
            // "products" => Product::paginate(12),
            "queries" => ProductCategory::all(),
            
		]);
    }
}
