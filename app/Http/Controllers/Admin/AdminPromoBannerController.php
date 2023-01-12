<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\PromoBanner;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;

class AdminPromoBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->expiredCheck();

        if (empty(request(['status'])['status'])) {
            $request->request->add(['status' => '']);
        }
        if (request(['status'])['status'] == '') {
            $request->session()->put('status', '');
        } else if (request(['status'])['status'] == 'aktif') {
            $request->session()->put('status', 'aktif');
        } else if (request(['status'])['status'] == 'tidak aktif') {
            $request->session()->put('status', 'tidak aktif');
        } else if (request(['status'])['status'] == 'akan datang') {
            $request->session()->put('status', 'akan datang');
        } else if (request(['status'])['status'] == 'sudah berakhir') {
            $request->session()->put('status', 'sudah berakhir');
        } else {
            abort(404);
        }
        // dd(request(['status'])['status']);
        if (auth()->guard('adminMiddle')->user()->admin_type == 1) {
            $promobanner = PromoBanner::latest()->filter(request(['status']))->get();
        } else {
            $promobanner = PromoBanner::latest()->where('company_id', '=', auth()->guard('adminMiddle')->user()->company_id)->filter(request(['status']))->get();
        }
        
        return view('admin.promo.banner.index', [
            'title' => 'Promo Banner',
            'active' => 'promo-banner',
            'promoBanners' => $promobanner
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.promo.banner.create', [
            'title' => 'Promo Banner',
            'active' => 'promo-banner',
            'companies' => Company::all(),
        ]);
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
        // dd(auth()->guard('adminMiddle')->user()->company->name);
        if (!isset($request->is_active)) {
            $request->merge(['is_active' => '0']);
            echo "status tidak aktif";
            echo '</br>';
        }

        if ($request->start_period > $request->end_period) {
            return redirect()->back()->with('failed', 'Tanggal mulai promo tidak boleh lebih besar dari tanggal akhir promo');
        }

        $validatedData = $request->validate(
            [
                'name' => 'required',
                'slug' => 'required',
                'start_period' => 'required|date',
                'end_period' => 'required|date',
                'is_active' => 'required',
                'company_id' => 'required',

            ],
            [
                'name.required' => 'Nama promo harus diisi!',
                'slug.required' => 'Slug promo harus diisi!',
                'start_period.required' => 'Tanggal awal promo harus diisi!',
                'end_period.required' => 'Tanggal akhir promo harus diisi!',
                'company_id.required' => 'Perusahaan harus diisi!',
            ]
        );
        $start_period = (Carbon::parse($request->start_period)->isoFormat('Y-MM-DD HH:mm'));
        $end_period = (Carbon::parse($request->end_period)->isoFormat('Y-MM-DD HH:mm'));

        $banner = PromoBanner::create([
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
            'start_period' => $start_period,
            'end_period' => $end_period,
            'is_active' => $validatedData['is_active'],
            'admin_id' =>  auth()->guard('adminMiddle')->user()->id,
            'company_id' => $validatedData['company_id']
        ]);

        $image_parts = explode(";base64,", $request->promoBannerImageUpload);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        // echo $productImage;
        // print_r($image_parts);
        // print_r($image_type);

        // $folderPathSave = 'img/banner/' .$banner->id . '/';
        $folderPathSave = 'admin/banner/' . auth()->guard('adminMiddle')->user()->company_id . '/';

        $imageName = uniqid() . '-' . $banner->id . '.' . $image_type;

        $imageFullPathSave = $folderPathSave . $imageName;
        // dd($imageFullPathSave);
        $save = Storage::put($imageFullPathSave, $image_base64);
        // dd($save);

        $bannerStored = PromoBanner::find($banner->id);

        $bannerStored->image = $imageFullPathSave;
        $bannerStored->save();

        if ($banner && $bannerStored) {
            return redirect()->route('promobanner.index')->with('success', 'Berhasil menambahkan promo.');
        } else {
            return redirect()->back()->with('failed', 'Terdapat kesalahan saat menambahkan promo , mohon pastikan semua form sudah terisi dengan benar');
        }
        // $productImageSave = ProductImage::create([
        //     'product_id' => $product->id,
        //     'name' => $imageFullPathSave
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PromoBanner  $promobanner
     * @return \Illuminate\Http\Response
     */
    public function show(PromoBanner $promobanner)
    {
        // dd($promobanner);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PromoBanner  $promobanner
     * @return \Illuminate\Http\Response
     */
    public function edit(PromoBanner $promobanner)
    {
        // dd($promobanner);
        return view('admin.promo.banner.edit', [
            'title' => 'Promo Banner',
            'active' => 'promo-banner',
            'promoBanner' => $promobanner,
            'companies' => Company::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PromoBanner  $promobanner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PromoBanner $promobanner)
    {
        // dd($promobanner->image);
        // dd(auth()->guard('adminMiddle')->user()->company_id);

        // dd($request);

        if (!isset($request->is_active)) {
            $request->merge(['is_active' => '0']);
            echo "status tidak aktif";
            echo '</br>';
        }

        if ($request->start_period > $request->end_period) {
            return redirect()->back()->with('failed', 'Tanggal mulai promo tidak boleh lebih besar dari tanggal akhir promo');
        }

        $validatedData = $request->validate(
            [
                'name' => 'required',
                'slug' => 'required',
                'start_period' => 'required|date',
                'end_period' => 'required|date',
                'is_active' => 'required',
                'company_id' => 'required',

            ],
            [
                'name.required' => 'Nama promo harus diisi!',
                'slug.required' => 'Slug promo harus diisi!',
                'specification.required' => 'Spesifikasi produk harus diisi!',
                'description.required' => 'Deskripsi produk harus diisi!',
                'company_id.required' => 'Perusahaan harus diisi!',
            ]
        );
        // dd($validatedData);
        $start_period = (Carbon::parse($request->start_period)->isoFormat('Y-MM-DD HH:mm'));
        $end_period = (Carbon::parse($request->end_period)->isoFormat('Y-MM-DD HH:mm'));

        if (isset($request->promoBannerImageUpload)) {

            $image_parts = explode(";base64,", $request->promoBannerImageUpload);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            // echo $productImage;
            // print_r($image_parts);
            // print_r($image_type);

            $folderPathSave = 'admin/banner/' . auth()->guard('adminMiddle')->user()->company_id . '/';
            $imageName = uniqid() . '-' . $promobanner->id . '.' . $image_type;
            $imageFullPathSave = $folderPathSave . $imageName;
            $previousPromoBannerImage = $promobanner->image;

            if ($previousPromoBannerImage) {
                Storage::delete($previousPromoBannerImage);
            }

            $saveUpdateImage = Storage::put($imageFullPathSave, $image_base64);

            if ($saveUpdateImage) {
                $promobanner->image = $imageFullPathSave;
            }
        }

        $promobanner->name = $validatedData['name'];
        $promobanner->slug = $validatedData['slug'];
        $promobanner->start_period = $start_period;
        $promobanner->end_period = $end_period;
        $promobanner->is_active = $validatedData['is_active'];
        $promobanner->company_id = $validatedData['company_id'];

        $promobanner->save();

        // $updateProfileImage = User::firstwhere('id', '=', auth()->user()->id)->update(['profile_image' => $imageFullPathSave]);

        if ($promobanner) {
            return redirect()->route('promobanner.index')->with('success', 'Berhasil memperbarui promo.');
        } else {
            return redirect()->back()->with('failed', 'Terdapat kesalahan saat memperbarui promo , mohon pastikan semua form sudah terisi dengan benar');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PromoBanner  $promobanner
     * @return \Illuminate\Http\Response
     */
    public function destroy(PromoBanner $promobanner)
    {
        // dd($promobanner);
        if (auth()->guard('adminMiddle')->user()->id) {
            Storage::delete($promobanner->image);
            $delete = $promobanner->delete();
            if ($delete) {
                return redirect()->back()->with('success', 'Berhasil menghapus Promo.');
            } else {
                return redirect()->back()->with('failed', 'Terjadi kesalahan menghapus Promo.');
            }
            // Post::destroy($post->id);
        } else {
            // return redirect('/dashboard/posts')->with('failed','Delete post failed!');
            abort(403);
        }
    }

    public function expiredCheck()
    {
        $promoBanner = PromoBanner::where('company_id', '=', auth()->guard('adminMiddle')->user()->company_id)->get();
        foreach ($promoBanner as $banner) {
            if ($banner->end_period < Carbon::now()) {
                $banner->is_active = 0;
                $banner->save();
            }
        }
    }
    
    public function isAdministrator()
    {
        if (auth()->guard('adminMiddle')->user()->admin_type != 1 && auth()->guard('adminMiddle')->user()->admin_type != 2) {
            abort(403);
        }
    }

    public function checkSlug(Request $request)
    {
        $this->isAdministrator();
        $slug = SlugService::createSlug(PromoBanner::class, 'slug', $request->name);

        return response()->json(['slug' => $slug]);
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
