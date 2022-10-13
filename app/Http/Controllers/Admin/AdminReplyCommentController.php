<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProductComment;
use App\Http\Controllers\Controller;

class AdminReplyCommentController extends Controller
{
    public function index()
    {
        $productComments = ProductComment::where('admin_id', '=', auth()->guard('adminMiddle')->user()->id)->get();
        // dd($productComments);
        return view('admin.productComment.adminComment',[
            'title' => 'Komentar Produk',
            'active' => 'product-comment-replied',
            'productComments' => $productComments,
        ]);
    }
}
