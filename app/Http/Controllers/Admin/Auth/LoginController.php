<?php

namespace App\Http\Controllers\Admin\Auth;

use Auth;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $guard = 'adminMiddle';
    protected $redirectTo = 'administrator/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function guard()
    {
        return auth()->guard('adminMiddle');
    }

    public function index(Request $request)
    {
        if (auth()->guard('adminMiddle')->user()) {
            return back();
        }
        return view('admin.login.index', [
            'title' => 'Admin Login'
        ]);
    }

    public function login(Request $request)
    {
        // dd($request);
        if (isset($request->remember)) {
            $remember = 1;
        } else {
            $remember = 0;
        }
        if (Str::contains($request->admin, '@')) {
            $email = $request->admin;
            $request->merge(['email' => $email]);
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if (auth()->guard('adminMiddle')->attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
                $admin = auth()->guard('adminMiddle')->user();
                // Session::put('success', 'Anda berhasil masuk!');
                if ($admin->admin_type == 1) {
                    return redirect()->route('admin.home');
                }elseif ($admin->admin_type == 2) {
                    return redirect()->route('admin.home');
                } elseif ($admin->admin_type == 3) {
                    return redirect()->route('finance.home');
                } elseif ($admin->admin_type == 4) {
                    return redirect()->route('warehouselogistic.home');
                }
            } else {
                return back()->with('loginError', 'email atau password salah!');
            }
        } elseif (preg_match("/^[0][0-9]*$/", $request->admin)) {
            // dd($request);
            $telp_no = $request->admin;
            $request->merge(['telp_no' => $telp_no]);
            $this->validate($request, [
                'telp_no' => 'required|min:12|max:13',
                'password' => 'required'
            ]);
            if (auth()->guard('adminMiddle')->attempt(['telp_no' => $request->telp_no, 'password' => $request->password], $remember)) {
                $admin = auth()->guard('adminMiddle')->user();
                // Session::put('success', 'Anda berhasil masuk!');
                if ($admin->admin_type == 1) {
                    return redirect()->route('admin.home');
                }elseif ($admin->admin_type == 2) {
                    return redirect()->route('admin.home');
                } elseif ($admin->admin_type == 3) {
                    return redirect()->route('finance.home');
                } elseif ($admin->admin_type == 4) {
                    return redirect()->route('warehouselogistic.home');
                }
            } else {
                return back()->with('loginError', 'Nomor Telepon atau password salah!');
            }
        } else {
            // dd($request);
            $username = $request->admin;
            $request->merge(['username' => $username]);
            $this->validate($request, [
                'username' => 'required',
                'password' => 'required'
            ]);
            if (auth()->guard('adminMiddle')->attempt(['username' => $request->username, 'password' => $request->password], $remember)) {
                $admin = auth()->guard('adminMiddle')->user();
                // Session::put('success', 'Anda berhasil masuk!');
                // dd($admin);
                // dd($admin->admin_type);
                if ($admin->admin_type == 1) {
                    return redirect()->route('admin.home');
                }elseif ($admin->admin_type == 2) {
                    return redirect()->route('admin.home');
                } elseif ($admin->admin_type == 3) {
                    return redirect()->route('finance.home');
                } elseif ($admin->admin_type == 4) {
                    return redirect()->route('warehouselogistic.home');
                }
            } else {
                return back()->with('loginError', 'username atau password salah!');
            }
        }
    }

    public function logout()
    {
        auth()->guard('adminMiddle')->logout();
        Session::flush();

        return redirect()->route('admin.login')->with('loginSuccess', 'Anda berhasil keluar');
    }

    public function logoutGet()
    {
        return redirect()->route('admin.logout');
    }
}
