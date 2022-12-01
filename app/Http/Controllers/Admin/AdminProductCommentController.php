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
    public function index(Request $request)
    {  
        // dd($request);
        // $productComments = ProductComment::whereNotNull('user_id')->get();
        if(auth()->guard('adminMiddle')->user()->admin_type == 1 || auth()->guard('adminMiddle')->user()->admin_type == 2){
            $productComments = ProductComment::whereNotNull('product_comments.user_id')
            ->join('orders', function($join){
                $join->on('product_comments.order_id','=','orders.id');})
            ->join('admin_sender_addresses', function($join){
                $join->on('admin_sender_addresses.sender_address_id', '=', 'orders.sender_address_id');})
            ->join("admins", function($join){
                $join->on("admins.id", "=", "admin_sender_addresses.admin_id")
                ->where('admins.id', '=', auth()->guard('adminMiddle')->user()->id);
            })->filterAdmin(request(['invoice_no', 'created_at', 'star']))->get('product_comments.*');
        }else{
            $productComments = ProductComment::whereNotNull('product_comments.user_id')
            ->join('orders', function($join){
                $join->on('product_comments.order_id','=','orders.id');})
            ->join('admin_sender_addresses', function($join){
                $join->on('admin_sender_addresses.sender_address_id', '=', 'orders.sender_address_id');})
            ->join("admins", function($join){
                $join->on("admins.id", "=", "admin_sender_addresses.admin_id");
            })->groupBy('product_comments.id')->filterAdmin(request(['invoice_no', 'created_at', 'star']))->get('product_comments.*');
        }

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
     * @param  \App\Models\ProductComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(ProductComment $productcomment)
    {
        // dd(($productcomment));

        if ($productcomment->is_edit != 1){
            return redirect()->route('productcomment.reply', $productcomment);
        }else{
            return redirect()->route('comment.show', $productcomment);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductComment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductComment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductComment $comment)
    {
        //
    }
    public function commentReply(Request $request, ProductComment $comment)
    {
        if(count($comment->children) == 0 && !is_null($comment->user_id) && !empty($comment->star) && is_null($comment->admin_id)){
            return view('admin.productComment.reply',[
                'title' => 'Komentar Produk',
                'active' => 'product-comment',
                'comment' => $comment,
            ]);
        }else{
            abort(404);
        }
    }
}
