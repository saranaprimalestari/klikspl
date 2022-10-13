<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function index()
    {
        return view('admin.login.index', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        if (Str::contains($request->admin, '@')) {
            // dd($request);
            $email = $request->admin;
            $request->merge(['email' => $email]);
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
        } elseif (preg_match("/^[0][0-9]*$/",$request->admin)) {
            // dd($request);
            $telp_no = $request->admin;
            $request->merge(['telp_no' => $telp_no]);
            $credentials = $request->validate([
                'telp_no' => 'required|min:12|max:13',
                'password' => 'required'
            ]);
        } else {
            $username = $request->admin;
            $request->merge(['username' => $username]);
            $credentials = $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);
        }
        // dd($request);
        // $credentials = $request->validate([
        //     'password' => 'required'
        // ]);
        // dd($credentials);

        // dd($credentials);
        if(isset($request->remember)){
            $remember=1;
        }else{
            $remember=0;
        }
        if (Auth::attempt($credentials,$remember)) {
            //regenerate berfungsi untuk menghindari session fixation (pura-pura masuk dengan session yang sebelumnya)
            $request->session()->regenerate();
            //intended -> redirect user ke URL sebelum melewati autentikasi middleware
            return redirect()->intended('/');
        }

        return back()->with('loginError', 'Login gagal');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
