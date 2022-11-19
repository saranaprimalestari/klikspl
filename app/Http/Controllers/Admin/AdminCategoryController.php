<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class AdminCategoryController extends Controller
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
        $this->isAdministrator();
        $category = ProductCategory::latest()->get();
        return view('admin.category.index', [
            'title' => 'Kategori',
            'active' => 'category',
            'categories' => $category,
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->isAdministrator();
        $validatedData = $request->validate(
            [
                'name' => 'required|regex:/^[a-zA-Z\s]*$/',
                'slug' => 'required|regex:/^[a-zA-Z0-9\s\W]*$/',
            ],
            [
                'name.required' => 'Nama kategori harus diisi!',
                'name.regex' => 'Nama kategori tidak boleh mengandung angka, simbol!, atau karakter khusus',
                'slug.required' => 'Nama kategori harus diisi!',
                'slug.regex' => 'Nama kategori tidak boleh mengandung angka, simbol!, atau karakter khusus',
            ]
        );

        $category = ProductCategory::create($validatedData);
        if($category){
            return redirect()->back()->with('addSuccess', 'Sukses menambahkan kategori');
        }else{
            return redirect()->back()->with('addFailed', 'Gagal menambahkan kategori');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $category)
    {
        $this->isAdministrator();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $category)
    {
        $this->isAdministrator();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCategory $category)
    {
        $this->isAdministrator();
        // dd($request); 
        $validatedData = $request->validate(
            [
                'name' => 'required|regex:/^[a-zA-Z\s]*$/',
                'slug' => 'required|regex:/^[a-zA-Z0-9\s\W]*$/',
            ],
            [
                'name.required' => 'Nama kategori harus diisi!',
                'name.regex' => 'Nama kategori tidak boleh mengandung angka, simbol!, atau karakter khusus',
                'slug.required' => 'Nama kategori harus diisi!',
                'slug.regex' => 'Nama kategori tidak boleh mengandung angka, simbol!, atau karakter khusus',
            ]
        );

        $category = ProductCategory::find($request->category_id);
        $category->name = $validatedData['name'];
        $category->slug = $validatedData['slug'];
        $update = $category->save();
        if($update){
            return redirect()->back()->with('addSuccess', 'Sukses memperbarui kategori');
        }else{
            return redirect()->back()->with('addFailed', 'Gagal memperbarui kategori');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $admincategory)
    {
        $this->isAdministrator();
        // dd($admincategory);
        if (auth()->guard('adminMiddle')->user()->id) {
            $delete = $admincategory->delete();
            if($delete){
                return redirect()->back()->with('addSuccess', 'Berhasil menghapus kategori produk.');
            }else{
                return redirect()->back()->with('addFailed', 'Terjadi kesalahan menghapus kategori produk.');

            }
            // Post::destroy($post->id);
        } else {
            // return redirect('/dashboard/posts')->with('failed','Delete post failed!');
            abort(403);
        }
    }

    public function checkSlug(Request $request)
    {
        $this->isAdministrator();
        $slug = SlugService::createSlug(ProductCategory::class, 'slug', $request->name);

        return response()->json(['slug' => $slug]);
    }
    
    public function isAdministrator()
    {
        if (auth()->guard('adminMiddle')->user()->admin_type != 1 && auth()->guard('adminMiddle')->user()->admin_type != 2) {
            abort(403);
        }
    }
}
