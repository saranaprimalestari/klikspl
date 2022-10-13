<?php

namespace App\Http\Controllers\Admin;

use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\SenderAddress;
use App\Http\Controllers\Controller;

class SenderAddressController extends Controller
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
        $senderAddress = SenderAddress::all();
        return view('admin.senderAddress.index', [
            'title' => 'Alamat Pengirim',
            'active' => 'senderAddress',
            'senderAddresses' => $senderAddress,
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

        return view('admin.senderAddress.create', [
            'title' => 'Alamat Pengirim',
            'active' => 'senderAddress',
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
                'name' => ['required', 'regex:/^(?![\s.]+$)[a-zA-Z\s\-.]*$/'],
                'telp_no' => ['required', 'min:11', 'max:13', 'regex:/^[0-9]*$/'],
                'province_ids' => 'required',
                'city_ids' => 'required',
                'district' => 'required',
                'postal_code' => 'nullable',
                'address' => 'required',
                'is_active' => 'required',
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
        $addUsedAddress = SenderAddress::create($validatedData);

        if($addUsedAddress){
            return redirect()->route('senderaddress.index')->with('success', 'Berhasil menambahkan alamat');
        }else{
            return redirect()->route('senderaddress.index')->with('failed', 'Terdapat kesalahan saat menambahkan alamat, pastikan dengan benar alamat yang diisi');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SenderAddress  $senderAddress
     * @return \Illuminate\Http\Response
     */
    public function show(SenderAddress $senderAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SenderAddress  $senderAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(SenderAddress $senderaddress)
    {
        //    dd($senderaddress);
           $provinces = Province::pluck('name', 'province_id');

           return view('admin.senderAddress.edit', [
               'title' => 'Alamat Pengirim',
               'active' => 'senderAddress',
               'provinces' => $provinces,
               'address' => $senderaddress,
           ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SenderAddress  $senderAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SenderAddress $senderaddress)
    {
        $validatedData = $request->validate(
            [
                'name' => ['required', 'regex:/^(?![\s.]+$)[a-zA-Z\s\-.]*$/'],
                'telp_no' => ['required', 'min:11', 'max:13', 'regex:/^[0-9]*$/'],
                'province_ids' => 'required',
                'city_ids' => 'required',
                'district' => 'required',
                'postal_code' => 'nullable',
                'address' => 'required',
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

        $updateAddress = $senderaddress->fill($validatedData)->save();
        if($updateAddress){
            return redirect()->route('senderaddress.index')->with('success', 'Berhasil memperbarui alamat');
        }else{
            return redirect()->route('senderaddress.index')->with('failed', 'Gagal memperbarui alamat');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SenderAddress  $senderAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(SenderAddress $senderAddress)
    {
        //
    }

    public function update_status(Request $request)
    {
        // dd($cart);
        // $city = CartItem::where('id', $id)->get();
        // return response()->json($city);
        // dd($request);
        // if ($request->id) {
            $status = SenderAddress::find($request->id);
            $status->is_active = $request->status;
            $status->save();
        // }
        // session()->flash('success', 'Berhasil memperbarui jumlah item');
        $update = SenderAddress::where('id', $request->id)->first();
        if($update){
            $message = 'success';
        }else{
            $message = 'failed';
        }
        return response()->json([
            'message' => $message,
            'data' => $update, 
            'id' => $update->id, 
            'status' => $update->is_active, 
        ]);
    }
}
