<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ProductComment;
use App\Http\Controllers\Controller;

class AdminProductCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $productComments = ProductComment::whereNotNull('user_id')->get();
        // dd($productComments);
        return view('admin.productComment.index',[
            'title' => 'Komentar Produk',
            'active' => 'product-comment',
            'productComments' => $productComments,
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
        $deadline_to_comment = Carbon::createFromFormat('Y-m-d', $request->comment_date)->addDays(30)->format('Y-m-d');
        $request->merge(['deadline_to_comment' => $deadline_to_comment]);

        $validatedData = $request->validate([
            'id' => 'required',
            'admin_id' => 'required',
            'product_id' => 'required',
            'product_variant_id' => 'required',
            'comment' => 'required',
            'comment_date' => 'required|date|date_format:Y-m-d',
            'order_id' => 'required',
            'deadline_to_comment' => 'required|date|date_format:Y-m-d',
        ]);

        $productComment = ProductComment::create(
            [
                'admin_id' => $validatedData['admin_id'],
                'product_id' => $validatedData['product_id'],
                'product_variant_id' => $validatedData['product_variant_id'],
                'comment' => $validatedData['comment'],
                'star' => 0,
                'comment_date' => $validatedData['comment_date'],
                'order_id' => $validatedData['order_id'],
                'deadline_to_comment' => $validatedData['deadline_to_comment'],
                'reply_comment_id' => $validatedData['id'],
                'is_edit' => 0,
            ]
        );

        if($productComment){
            return redirect()->route('productcomment.index')->with(['success' => 'Berhasil membalas komentar produk']);
        }else{
            return redirect()->route('productcomment.index')->with(['failed' => 'Gagal membalas komentar produk']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductComment  $productComment
     * @return \Illuminate\Http\Response
     */
    public function show(ProductComment $productComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductComment  $productComment
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductComment $productComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductComment  $productComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductComment $productComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductComment  $productComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductComment $productComment)
    {
        //
    }
    public function commentReply(Request $request, ProductComment $comment)
    {
        // dd($comment);
        return view('admin.productComment.reply',[
            'title' => 'Komentar Produk',
            'active' => 'product-comment',
            'comment' => $comment,
        ]);
        dd($comment);
        dd($request);
    }
}
