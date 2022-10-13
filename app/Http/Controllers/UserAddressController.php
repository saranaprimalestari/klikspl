<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use App\Models\User;
use App\Models\Province;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.address', [
            'title' => 'Alamat Saya',
            'active' => 'manageAddress',

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = Province::pluck('name', 'province_id');

        return view('user.address-create', [
            'title' => 'Alamat Saya',
            'active' => 'manageAddress',
            'provinces' => $provinces,
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
        $validatedData = $request->validate(
            [
                'name' => ['required', 'regex:/^(?![\s.]+$)[a-zA-Z\s.]*$/'],
                'telp_no' => ['required', 'min:10', 'max:13', 'regex:/^[0-9]*$/'],
                'province_ids' => 'required',
                'city_ids' => 'required',
                'district' => 'required',
                'postal_code' => 'nullable',
                'address' => 'required',
                'user_id' => 'required'
            ],
            [
                'name.required' => 'Nama pemilik alamat harus diisi',
                'name.regex' => 'Nama pemilik alamat hanya boleh menggunakan huruf',
                'telp_no.required' => 'Nomor telepon harus diisi',
                'telp_no.min' => 'Nomor telepon minimal terdiri dari 11 digit',
                'telp_no.max' => 'Nomor telepon maksimal terdiri dari 13 digit',
                'telp_no.regex' => 'Nomor telepon hanya boleh menggunakan angka',
                'province_ids.required' => 'Provinsi harus diisi',
                'city_ids.required' => 'Kabupaten/kota harus diisi',
                'address.required' => 'Alamat harus diisi',
            ]
        );
        if(is_null($validatedData['postal_code'])){
            $validatedData['postal_code'] = '';
        }
        // dd($request);
        $addUsedAddress = UserAddress::create($validatedData);
        $countUserAddress = UserAddress::where('user_id','=',auth()->user()->id)->count();
        // dd($countUserAddress);
        if($countUserAddress == 1){
            // dd()
            $addUsedAddress->is_active = 1;
            $addUsedAddress->save();
        }

        if($addUsedAddress){
            return redirect()->route('useraddress.index')->with('success', 'Berhasil menambahkan alamat');
        }else{
            return redirect()->route('useraddress.index')->with('failed', 'Terdapat kesalahan saat menambahkan alamat, pastikan dengan benar alamat yang diisi');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAddress  $useraddress
     * @return \Illuminate\Http\Response
     */
    public function show(UserAddress $useraddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserAddress  $useraddress
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAddress $useraddress)
    {
        // dd($useraddress);
        $provinces = Province::pluck('name', 'province_id');

        return view('user.address-edit', [
            'title' => 'Alamat Saya',
            'active' => 'manageAddress',
            'provinces' => $provinces,
            'address' => $useraddress,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAddress  $useraddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAddress $useraddress)
    {
        // dd($request);
        $validatedData = $request->validate(
            [
                'name' => ['required', 'regex:/^(?![\s.]+$)[a-zA-Z\s.]*$/'],
                'telp_no' => ['required', 'min:11', 'max:13', 'regex:/^[0-9]*$/'],
                'province_ids' => 'required',
                'city_ids' => 'required',
                'district' => 'required',
                'postal_code' => 'nullable',
                'address' => 'required',
                'user_id' => 'required'
            ],
            [
                'name.required' => 'Nama pemilik alamat harus diisi',
                'name.regex' => 'Nama pemilik alamat hanya boleh menggunakan huruf',
                'telp_no.required' => 'Nomor telepon harus diisi',
                'telp_no.min' => 'Nomor telepon minimal terdiri dari 11 digit',
                'telp_no.max' => 'Nomor telepon maksimal terdiri dari 13 digit',
                'telp_no.regex' => 'Nomor telepon hanya boleh menggunakan angka',
                'province_ids.required' => 'Provinsi harus diisi',
                'city_ids.required' => 'Kabupaten/kota harus diisi',
                'address.required' => 'Alamat harus diisi',
            ]
        );

        $updateAddress = $useraddress->fill($validatedData)->save();
        if($updateAddress){
            return redirect()->route('useraddress.index')->with('success', 'Berhasil memperbarui alamat');
        }else{
            return redirect()->route('useraddress.index')->with('failed', 'Gagal memperbarui alamat');
        }
        // dd($useraddress);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAddress  $useraddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAddress $useraddress)
    {
        // dd($useraddress);
        if (auth()->user()->id == $useraddress->user_id) {
            $useraddress->delete();
            // Post::destroy($post->id);
            return redirect()->back()->with('success', 'Berhasil menghapus alamat.');
        } else {
            // return redirect('/dashboard/posts')->with('failed','Delete post failed!');
            abort(403);
        }
    }

    public function changeAddress(Request $request)
    {
        // dd($request);
        if ($request->userId == auth()->user()->id) {
            $active = UserAddress::where('user_id', '=', auth()->user()->id)->where('is_active', '=', '1')->update(['is_active' => 0]);
            // dd($active);
            // $active->is_active = 0;
            // $activeSave = $active->save();

            $updateActive = UserAddress::where('user_id', '=', auth()->user()->id)->where('id', '=', $request->addressId)->update(['is_active' => 1]);
            // $updateActive->is_active = 1;
            // $updateActiveSave = $updateActive->save();

            if ($active or $updateActive) {
                // return redirect()->back()->with('success', 'Berhasil mengganti alamat utama')->withInput();
                return back()->with('successChangeAddress', 'Berhasil mengganti alamat utama')->withInput();
            } else {
                return back()->with('failedChangeAddress', 'Gagal mengganti alamat utama')->withInput();
            }
        } else {
            abort(403);
        }
    }
}
