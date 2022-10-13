<?php

namespace App\Http\Controllers;

use App\Models\ProductComment;
use App\Http\Requests\StoreProductCommentRequest;
use App\Http\Requests\UpdateProductCommentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = ProductComment::where('user_id', '=', auth()->user()->id)->get();

        return view('user.comment.index', [
            'title' => 'Komentar Produk',
            'active' => 'comment',
            'productComments' => $comments,
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
     * @param  \App\Http\Requests\StoreProductCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductCommentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(ProductComment $comment)
    {
        return view('user.comment.show', [
            'title' => 'Penilaian Produk',
            'active' => 'comment',
            'comment' => $comment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductComment $comment)
    {
        if($comment->is_edit == 1){
            return redirect()->route('comment.index')->with(['failed' => 'Tidak dapat mengubah komentar! Komentar hanya dapat diperbarui maksimal satu kali']);
        }
        if($comment->deadline_to_comment < \Carbon\Carbon::now()->format('Y-m-d')){
            return redirect()->route('comment.index')->with(['failed' => 'Tidak dapat mengubah komentar! Batas waktu memperbarui komentar maksimal 30 hari setelah komentar dibuat.']);
        }
        // dd($comment);
        return view('user.comment.edit', [
            'title' => 'Penilaian Produk',
            'active' => 'comment',
            'comment' => $comment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductCommentRequest  $request
     * @param  \App\Models\ProductComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductComment $comment)
    {
        // dd($request);
        // dd($comment);
        if($comment->is_edit == 1){
            return redirect()->route('comment.index')->with(['failed' => 'Tidak dapat mengubah komentar! Komentar hanya dapat diperbarui maksimal satu kali']);
        }
        if($comment->deadline_to_comment < \Carbon\Carbon::now()->format('Y-m-d')){
            return redirect()->route('comment.index')->with(['failed' => 'Tidak dapat mengubah komentar! Batas waktu memperbarui komentar maksimal 30 hari setelah komentar dibuat.']);
        }
        $validatedData = $request->validate(
            [
                'id' => 'required',
                'user_id' => 'required',
                'product_id' => 'required',
                'product_variant_id' => 'required',
                'comment' => 'nullable',
                'star' => 'required',
                'comment_date' => 'required|date|date_format:Y-m-d',
                'order_id' => 'required',
                // 'deadline_to_comment' => 'required|date|date_format:Y-m-d',
                'comment_image' => 'image|file||mimes:jpeg,png,jpg|max:2048',

            ],
            [
                'star.required' => 'Bintang penilaian tidak boleh kosong',
                'star.required' => 'Bintang penilaian tidak boleh kosong',
                'comment_image.image' => 'Foto yang diupluad harus berupa gambar',
                'comment_image.file' => 'Foto yang diupluad harus berupa file',
                'comment_image.mimes' => 'Foto yang diupluad harus memiliki format file .jpg, .jpeg, .png',
                'comment_image.max' => 'Foto yang diupluad berukuran maximal 2MB',
            ]
        );
        if($request->id == $comment->id){
            if($comment->is_edit != 1){
                if (isset($request->comment_image)) {
                    $folderPathSave = 'user/' . auth()->user()->username . '/order/' . $request->order_id . '/comment';
        
                    if ($request->file('comment_image')) {
                        $uploadCommentImage = ProductComment::find($comment->id);
                        $uploadCommentImage->comment_image = $request->file('comment_image')->store($folderPathSave);
                        $uploadCommentImage->save();
                    }
                    $previousCommentImage = $comment->comment_image;
        
                    if ($previousCommentImage) {
                        $deleteImage = Storage::delete($previousCommentImage);
                    }
        
                    if ($deleteImage) {
                        $comment->comment_image = $request->file('comment_image')->store($folderPathSave);
                    }
                }
        
                $comment->comment = $validatedData['comment'];
                $comment->star = $validatedData['star'];
                $comment->is_edit = 1;
        
                $update = $comment->save();
    
                if($update){
                    return redirect()->route('comment.index')->with(['success' => 'Berhasil memperbarui komentar']);
                }else{
                    return redirect()->route('comment.index')->with(['failed' => 'Gagal memperbarui komentar']);
                }
            }else{
                return redirect()->route('comment.index')->with(['failed' => 'Gagal memperbarui komentar']);
            }
        }
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
}
