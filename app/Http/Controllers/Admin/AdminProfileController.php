<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adminprofile = Admin::find(auth()->guard('adminMiddle')->user()->id);

        return view('admin.account.profile.index', [
            'title' => 'Akun saya',
            'active' => 'profile',
            'admin' => $adminprofile,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $adminprofile
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $adminprofile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $adminprofile
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $adminprofile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $adminprofile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $adminprofile)
    {
        // dd($adminprofile);  
        $validatedData = $request->validate(
            [
                'firstname' => ['required', 'regex:/^(?![\s.]+$)[a-zA-Z\s.]*$/'],
                'lastname' => ['nullable', 'regex:/^(?![\s.]+$)[a-zA-Z\s.]*$/'],
                'email' => ['required', 'email', 'regex:/.*\.(com|co.id)$/'],
                'telp_no' => 'required|min:10|max:13|regex:/^[0-9]*$/',
            ],
            [
                'firstname.regex' => 'Nama hanya boleh menggunakan huruf',
                'firstname.required' => 'Nama depan harus diisi',
                'lastname.regex' => 'Nama hanya boleh menggunakan huruf',
                'lastname.required' => 'Nama belakang harus diisi',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid! Pastikan mengisi email dengan benar',
                'email.regex' => 'Domain email yang dapat digunakan .com dan .co.id',
                'telp_no.required' => 'Nomor telepon harus diisi',
                'telp_no.min' => 'Nomor telepon minimal terdiri dari 10 digit',
                'telp_no.max' => 'Nomor telepon maksimal terdiri dari 13 digit',
                'telp_no.regex' => 'Format nomor telepon tidak valid! No telepon hanya dapat diisi dengan angka',
            ]
            
        );  
        $adminprofile->fill($request->all())->save();

        return back()->with('success', 'Berhasil memperbarui profil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $adminprofile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $adminprofile)
    {
        //
    }
}
