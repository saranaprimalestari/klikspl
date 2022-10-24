<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductMerk;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class AdminMerkController extends Controller
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
        $merk = ProductMerk::latest()->get();
        return view('admin.merk.index', [
            'title' => 'Merk',
            'active' => 'merk',
            'merks' => $merk,
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
        return redirect()->route('adminmerk.index');

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
        // dd($request);

        $validatedData = $request->validate(
            [
                'image' => 'image|file||mimes:jpeg,png,jpg|max:2048',
                'name' => 'required|regex:/^[a-zA-Z\s]*$/',
                'slug' => 'required|regex:/^[a-zA-Z0-9\s\W]*$/',
            ],
            [
                'image.image' => 'Logo merk harus berupa gambar',
                'image.file' => 'Logo merk harus berupa file',
                'image.mimes' => 'Logo merk harus memiliki format file .jpg, .jpeg, .png',
                'image.max' => 'Logo merk berukuran maximal 2MB',
                'name.required' => 'Nama Merk harus diisi!',
                'name.regex' => 'Nama Merk tidak boleh mengandung angka, simbol!, atau karakter khusus',
                'slug.required' => 'Nama Merk harus diisi!',
                'slug.regex' => 'Nama Merk tidak boleh mengandung angka, simbol!, atau karakter khusus',
            ]
        );
        
        $merk = ProductMerk::create([
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
        ]);
        
        if(!is_null($request->file('image'))){
            $folderPathSave = 'img/merk/';
    
            $imageName = date('Ymd') . '-' . $request->slug . '.' . $request->file('image')->extension();
            $upload  = $request->file('image')->move($folderPathSave, $imageName);

            $merk->image = $folderPathSave . $imageName;
            $merk->save();
        }
        if ($merk) {
            return redirect()->back()->with('addSuccess', 'Sukses menambahkan Merk');
        } else {
            return redirect()->back()->with('addFailed', 'Gagal menambahkan Merk');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductMerk  $adminmerk
     * @return \Illuminate\Http\Response
     */
    public function show(ProductMerk $adminmerk)
    {
        $this->isAdministrator();
        return redirect()->route('adminmerk.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductMerk  $adminmerk
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductMerk $adminmerk)
    {
        $this->isAdministrator();
        return redirect()->route('adminmerk.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductMerk  $adminmerk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductMerk $adminmerk)
    {
        $this->isAdministrator();
        $merk = ProductMerk::find($request->merk_id);

        $validatedData = $request->validate(
            [
                'name' => 'required|regex:/^[a-zA-Z\s]*$/',
                'slug' => 'required|regex:/^[a-zA-Z0-9\s\W]*$/',
            ],
            [
                'name.required' => 'Nama merk harus diisi!',
                'name.regex' => 'Nama merk tidak boleh mengandung angka, simbol!, atau karakter khusus',
                'slug.required' => 'Nama merk harus diisi!',
                'slug.regex' => 'Nama merk tidak boleh mengandung angka, simbol!, atau karakter khusus',
            ]
        );

        if (!is_null($request->file('image'))) {
            $validatedImage = $request->validate(
                [
                    'image' => 'image|file||mimes:jpeg,png,jpg|max:2048',
                ],
                [
                    'image.image' => 'Logo merk harus berupa gambar',
                    'image.file' => 'Logo merk harus berupa file',
                    'image.mimes' => 'Logo merk harus memiliki format file .jpg, .jpeg, .png',
                    'image.max' => 'Logo merk berukuran maximal 2MB',
                ]
            );
            $folderPathSave = 'img/merk/';
            $imageName = date('Ymd') . '-' . $request->slug . '.' . $request->file('image')->extension();
            $upload  = $request->file('image')->move($folderPathSave, $imageName);

            $merk->image = $folderPathSave . $imageName;
        }
        
        $merk->name = $validatedData['name'];
        $merk->slug = $validatedData['slug'];
        $update = $merk->save();

        if ($update) {
            return redirect()->back()->with('addSuccess', 'Sukses memperbarui merk');
        } else {
            return redirect()->back()->with('addFailed', 'Gagal memperbarui merk');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductMerk  $adminmerk
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductMerk $adminmerk)
    {
        $this->isAdministrator();
        if (auth()->guard('adminMiddle')->user()->id) {
            $delete = $adminmerk->delete();
            if ($delete) {
                return redirect()->back()->with('addSuccess', 'Berhasil menghapus Merk.');
            } else {
                return redirect()->back()->with('addFailed', 'Terjadi kesalahan menghapus Merk.');
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
        $slug = SlugService::createSlug(ProductMerk::class, 'slug', $request->name);

        return response()->json(['slug' => $slug]);
    }
    
    public function isAdministrator()
    {
        if (auth()->guard('adminMiddle')->user()->admin_type != 2) {
            abort(403);
        }
    }
}
