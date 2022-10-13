<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\user;
use Illuminate\Http\Request;
use App\Models\UserNotification;

class UserPhoneController extends Controller
{

    public function addPhone(Request $request)
    {
        if(is_null(auth()->user()->telp_no)){
            return view('user.add-phone-email', [
                'title' => 'Tambah Nomor Telepon',
                'active' => 'profile',
                'type' => 'Nomor Telepon',
                'act' => 'add',
                'varName' => 'telp_no',
                'inputType' => 'number',
                'route' => 'profile.add.phone.post'
            ]);
        }else{
            return redirect()->route('profile.update.phone')->with(['failed' => 'Terdapat kesalahan silakan masukkan nomor telepon ulang (error: PRVBCKPGERR)']);
        }
    }

    public function addPhonePost(Request $request)
    {
        $validatedData = $request->validate(
            [
                'telp_no' => 'required|unique:users,telp_no|min:12|max:13|regex:/^[0][0-9]*$/'
            ],
            [
                'telp_no.required' => 'Nomor telepon harus diisi',
                'telp_no.unique' => 'Nomor telepon yang kamu masukkan sudah digunakan',
                'telp_no.min' => 'Nomor telepon minimal terdiri dari 12 digit',
                'telp_no.max' => 'Nomor telepon maksimal terdiri dari 13 digit',
                'telp_no.regex' => 'Format nomor telepon tidak valid! No telepon hanya dapat diisi dengan angka dan diawali dengan angka 0',
            ]
        );
        $request->session()->put('telp_no', $validatedData['telp_no']);
        return redirect()->route('profile.add.phone.req.verify.method');
    }

    public function addPhoneReqVerifyMethod(Request $request)
    {
        // dd($request);
        if ($request->session()->has('telp_no')) {

            $telp_no = session()->get('telp_no');
            $verificationCode = random_int(100000, 999999);

            $request->session()->put('verificationCodeTelpNo', $verificationCode);
            // $verificationCode = session()->get('verificationCodeTelpNo');
            // $request->session()->forget('telp_no');

            return view('user.verify-method', [
                'title' => 'Tambah Nomor Telepon',
                'active' => 'profile',
                'type' => 'Nomor Telepon',
                'act' => 'add',
                'varName' => 'telp_no',
                'inputType' => 'number',
                // 'route' => 'profile.add.phone.send.verify.method',
                'route' => 'profile.add.phone.send.verify.method',
                'waRoute' => 'profile.add.phone.verify',
                'telp_no' => $telp_no,
                'verificationCode' => $verificationCode,
                'waVerifMessage' => 'https://wa.me/6285248466297?text=Halo+' . auth()->user()->firstname . '+' . auth()->user()->lastname . '%2C%0D%0ASilakan+masukkan+kode+berikut+untuk+verifikasi+nomor+telepon+yang+kamu+tambahkan%0D%0A%0D%0A%2A' . $verificationCode . '%2A%0D%0A%0D%0AKode+diatas+bersifat+rahasia+dan+jangan+sebarkan+kode+kepada+siapapun.%0D%0A%0D%0APesan+ini+dibuat+otomatis%2C+jika+membutuhkan+bantuan%2C+silakan+hubungi+ADMIN+KLIKSPL+dengan+link+berikut%3A%0D%0Ahttps%3A%2F%2Fwa.me%2F6285248466297'
            ]);
        } else {
            return redirect()->route('profile.add.phone')->with(['failed' => 'Terdapat kesalahan silakan masukkan nomor telepon ulang (error: 0x621f)']);
        }
    }

    public function addPhoneSendVerifyMethod(Request $request)
    {

        // dd(session()->all());
        // dd($request);
        $request->session()->put('id', $request['id']);
        $request->session()->put('username', $request['username']);
        // $request->session()->put('verificationCode', $request['verificationCode']);

        return redirect()->route('profile.add.phone.verify');
        // dd($request->verificationCode);
        // dd(session()->get('verificationCodeTelpNo'));
        // dd($request->verificationCode == session()->get('verificationCodeTelpNo'));
        // if ($request->linkVerification) {
        //     // dd($request->linkVerification);
        //     if ($request->verificationCode == session()->get('verificationCodeTelpNo')) {
        //         dd($request);
        //     } else {
        //         return redirect()->route('profile.add.phone')->with(['failed' => 'Terdapat kesalahan silakan masukkan nomor telepon ulang (error: 0x621f)']);
        //     }
        // } else {
        //     // $request->session()->put();
        //     return redirect()->route('profile.add.phone.verify');

        // }
    }

    public function addPhoneVerify(Request $request)
    {
        // dd($request);
        // dd(session()->all());
        // dd($request->verificationCode);
        // dd(session()->get('verificationCodeTelpNo'));
        // dd($request->verificationCode == session()->get('verificationCodeTelpNo'));
        // dd($request);
        if ($request->session()->has('telp_no')) {

            if ($request->linkVerification) {
                // dd($request->linkVerification);
                if ($request->verificationCode == session()->get('verificationCodeTelpNo')) {
                    dd($request);
                } else {
                    return redirect()->route('profile.add.phone.req.verify.method')->with(['failed' => 'Terdapat kesalahan silakan meminta ulang kode verifikasi (OTP) (error: 0x621f)']);
                }
            } else {
                $request->merge([
                    'id' => session()->get('id'),
                    'username' => session()->get('username'),
                    'telp_no' => session()->get('telp_no'),
                    'verificationCode' => session()->get('verificationCodeTelpNo'),
                ]);
                return view('user.verify-otp', [
                    'title' => 'Tambah Nomor Telepon',
                    'active' => 'profile',
                    'type' => 'Nomor Telepon',
                    'act' => 'add',
                    'varName' => 'telp_no',
                    'inputType' => 'number',
                    // 'route' => 'profile.add.phone.send.verify.method',
                    'route' => 'profile.add.phone.verify.submit',
                    'reqVerifyRoute' => 'profile.add.phone.req.verify.method',
                    'id' => $request->id,
                    'username' => $request->username,
                    'telp_no' => $request->telp_no,
                    'verificationCode' => $request->verificationCode,
                ]);
            }
        } else {
            return redirect()->route('profile.add.phone')->with(['failed' => 'Terdapat kesalahan silakan masukkan nomor telepon ulang (error: 0x621f)']);
        }
    }

    public function addPhoneVerifySubmit(Request $request)
    {
        // dd($request);
        if ($request->verifValue === $request->verifCode) {
            $request->session()->put('is_verified', 1);
            $user = User::where('id', '=', $request->id)->first();
            $user->telp_no = $request->verifAccount;
            $user->save();

            $notifications = [
                'user_id' => $user->id,
                'slug' => 'nomor-telepon-berhasil-diperbarui-'.$user->username.'-'.Carbon::now(),
                'type' => 'Notifikasi',
                'description' => '<p>Nomor Telepon berhasil diperbarui</p></br><p>Nomor Telepon terbaru kamu <strong>'.$user->telp_no.'</strong></p></br><p>Selamat menikmati pengalaman berbelanja di klikspl.com.</p>',
                'excerpt' => 'Nomor Telepon berhasil diperbarui',
                'image' => 'assets\phone.png',
                'is_read' => 0
            ];
            
            $notification = UserNotification::create($notifications);
            return redirect()->route('profile.add.phone.verified');
        } else {
            return back()->with(['verificationFailed' => 'Kode Verifikasi yang anda masukkan tidak sesuai']);
        }
    }

    public function addPhoneVerified(Request $request)
    {
        if ($request->session()->has('is_verified') && session()->get('is_verified') == 1) {
            return view('user.verified-otp', [
                'title' => 'Tambah Nomor Telepon',
                'active' => 'profile',
                'type' => 'Nomor Telepon',
                'act' => 'add',
                'varName' => 'telp_no',
                'route' => 'profile.add.phone.clear.session',
                'routeChange' => 'profile.index',
            ]);
        } else {
            return redirect()->route('profile.add.phone.verify')->with(['verificationFailed' => 'Kode Verifikasi yang anda masukkan tidak sesuai, Pastikan Kode OTP yang dikirimkan dengan yang kamu masukkan sesuai, atau coba lakukan pengiriman ulang kode OTP kembali']);
        }
    }

    public function addPhoneClearSession(Request $request)
    {
        $request->session()->forget('id');
        $request->session()->forget('username');
        $request->session()->forget('telp_no');
        $request->session()->forget('verificationCodeTelpNo');
        $request->session()->forget('is_verified');

        return redirect()->route('profile.index');
    }

    public function updatePhone(Request $request)
    {
        if (isset(auth()->user()->telp_no)) {

            $telp_no = auth()->user()->telp_no;
            $verificationCode = random_int(100000, 999999);

            $request->session()->put('verificationCodeTelpNo', $verificationCode);
            // $verificationCode = session()->get('verificationCodeTelpNo');
            // $request->session()->forget('telp_no');

            return view('user.verify-method', [
                'title' => 'Tambah Nomor Telepon',
                'active' => 'profile',
                'type' => 'Nomor Telepon',
                'act' => 'update',
                'varName' => 'telp_no',
                'inputType' => 'number',
                // 'route' => 'profile.update.phone.send.verify.method',
                'route' => 'profile.update.phone.send.verify.method.first',
                'waRoute' => 'profile.update.phone.verify.first',
                'telp_no' => $telp_no,
                'verificationCode' => $verificationCode,
            ]);
        } else {
            return redirect()->route('profile.update.phone')->with(['failed' => 'Terdapat kesalahan silakan masukkan nomor telepon ulang (error: 0x621f)']);
        }
    }

    public function updatePhoneSendVerifyMethodFirst(Request $request)
    {
        // dd(session()->all());
        // dd($request);
        $request->session()->put('id', $request['id']);
        $request->session()->put('username', $request['username']);
        $request->session()->put('telp_no', $request['telp_no']);
        // $request->session()->put('telp_no', $validatedData['telp_no']);

        return redirect()->route('profile.update.phone.verify.first');
    }

    public function updatePhoneVerifyFirst(Request $request)
    {
        if ($request->session()->has('telp_no')) {

            if ($request->linkVerification) {
                // dd($request->linkVerification);
                if ($request->verificationCode == session()->get('verificationCodeTelpNo')) {
                    // dd($request);
                    return redirect()->route('profile.update.phone.verified.first');
                } else {
                    return redirect()->route('profile.update.phone.req.verify.method')->with(['failed' => 'Terdapat kesalahan silakan meminta ulang kode verifikasi (OTP) (error: 0x621f)']);
                }
            } else {
                $request->merge([
                    'id' => session()->get('id'),
                    'username' => session()->get('username'),
                    'telp_no' => session()->get('telp_no'),
                    'verificationCode' => session()->get('verificationCodeTelpNo'),
                ]);
                return view('user.verify-otp', [
                    'title' => 'Tambah Nomor Telepon',
                    'active' => 'profile',
                    'type' => 'Nomor Telepon',
                    'act' => 'update',
                    'varName' => 'telp_no',
                    'inputType' => 'number',
                    // 'route' => 'profile.update.phone.send.verify.method',
                    'route' => 'profile.update.phone.verify.submit.first',
                    'reqVerifyRoute' => 'profile.update.phone',
                    'id' => $request->id,
                    'username' => $request->username,
                    'telp_no' => $request->telp_no,
                    'verificationCode' => $request->verificationCode,
                ]);
            }
        } else {
            return redirect()->route('profile.update.phone')->with(['failed' => 'Terdapat kesalahan silakan masukkan nomor telepon ulang (error: 0x621f)']);
        }
    }

    public function updatePhoneVerifySubmitFirst(Request $request)
    {
        if ($request->verifValue === $request->verifCode) {
            $request->session()->put('is_verified', 1);
            // dd($request);
            // $user = User::where('id','=',$request->id)->first();
            // $user->telp_no = $request->verifAccount;
            // $user->save();

            return redirect()->route('profile.update.phone.verified.first');
        } else {
            return back()->with(['verificationFailed' => 'Kode Verifikasi yang anda masukkan tidak sesuai']);
        }
    }

    public function updatePhoneVerifiedFirst(Request $request)
    {
        if ($request->session()->has('is_verified') && session()->get('is_verified') == 1) {
            return view('user.verified-otp', [
                'title' => 'Tambah Nomor Telepon',
                'active' => 'profile',
                'type' => 'Nomor Telepon',
                'act' => 'update',
                'varName' => 'telp_no',
                'route' => 'profile.update.phone.fill.new',
                'updateRoute' => 'profile.update.phone.fill.new',
            ]);
        } else {
            return redirect()->route('profile.update.phone.verify')->with(['verificationFailed' => 'Kode Verifikasi yang anda masukkan tidak sesuai, Pastikan Kode OTP yang dikirimkan dengan yang kamu masukkan sesuai, atau coba lakukan pengiriman ulang kode OTP kembali']);
        }
    }

    public function updatePhoneFillNew(Request $request)
    {
        // dd(session()->all());
        if(session()->has('id') && session()->has('username') && session()->has('telp_no') && session()->has('verificationCodeTelpNo') && session()->has('is_verified')){
            return view('user.add-phone-email', [
                'title' => 'Tambah Nomor Telepon',
                'active' => 'profile',
                'type' => 'Nomor Telepon',
                'act' => 'update',
                'varName' => 'telp_no',
                'inputType' => 'number',
                'route' => 'profile.add.phone.post'
            ]);
        }else{
            return redirect()->route('profile.update.phone')->with(['failed' => 'Terdapat kesalahan silakan masukkan nomor telepon ulang (error: 0xUPFNERROR)']);
            
        }
    }
}
