<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AdminTestController extends Controller
{
    public function index(Request $request)
    {
        $currentURL = explode('/', url()->current());
        $currentPage = last($currentURL);
        Session::put('currentPage', $currentPage);

        if (auth()->guard('adminMiddle')->user()->admin_type == 1) {
            $product = Product::latest()->get();
        } else {
            $product = Product::latest()->where('company_id', '=', auth()->guard('adminMiddle')->user()->company_id)->get();
        }

        return view('admin.test', [
            'title' => 'Produk',
            'active' => 'adminproduct',
            'products' => $product,
        ]);
    }
}
