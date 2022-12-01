<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\user;
use Illuminate\Http\Request;
use App\Models\UserNotification;
use App\Http\Controllers\MailController;

class UserEmailController extends Controller
{
    
    public function addEmail(Request $request)
    {
        if(is_null(auth()->user()->email)){
            return view('user.add-phone-email', [
                'title' => 'Tambah Email',
                'active' => 'profile',
                'type' => 'Email',
                'act' => 'add',
                'varName' => 'email',
                'inputType' => 'email',
                'route' => 'profile.add.email.post'
            ]);
        }else{
            return redirect()->route('profile.update.email')->with(['failed' => 'Terdapat kesalahan silakan masukkan nomor telepon ulang (error: PRVBCKPGERR)']);
        }
    }

    public function addEmailPost(Request $request)
    {
        $validatedData = $request->validate(
            [
                'email' => ['required', 'unique:users', 'email', 'regex:/.*\.(com|co.id)$/']
            ],
            [
                'email.required' => 'Email harus diisi',
                'email.unique' => 'Email sudah tedaftar',
                'email.email' => 'Format email tidak valid! Pastikan mengisi email dengan benar',
                'email.regex' => 'Domain email yang dapat digunakan .com dan .co.id',
            ]
        );
        $request->session()->put('email', $validatedData['email']);
        return redirect()->route('profile.add.email.req.verify.method');
    }

    public function addEmailReqVerifyMethod(Request $request)
    {
        // dd($request);
        if ($request->session()->has('email')) {

            $email = session()->get('email');
            $verificationCode = random_int(100000, 999999);

            $request->session()->put('verificationCodeEmail', $verificationCode);
            // $verificationCode = session()->get('verificationCodeEmail');
            // $request->session()->forget('email');

            return view('user.verify-method', [
                'title' => 'Tambah Email',
                'active' => 'profile',
                'type' => 'Email',
                'act' => 'add',
                'varName' => 'email',
                'inputType' => 'number',
                // 'route' => 'profile.add.email.send.verify.method',
                'route' => 'profile.add.email.send.verify.method',
                'waRoute' => 'profile.add.email.verify',
                'email' => $email,
                'verificationCode' => $verificationCode,
                'waVerifMessage' => 'https://wa.me/6285248466297?text=Halo+' . auth()->user()->firstname . '+' . auth()->user()->lastname . '%2C%0D%0ASilakan+masukkan+kode+berikut+untuk+verifikasi+nomor+telepon+yang+kamu+tambahkan%0D%0A%0D%0A%2A' . $verificationCode . '%2A%0D%0A%0D%0AKode+diatas+bersifat+rahasia+dan+jangan+sebarkan+kode+kepada+siapapun.%0D%0A%0D%0APesan+ini+dibuat+otomatis%2C+jika+membutuhkan+bantuan%2C+silakan+hubungi+ADMIN+KLIKSPL+dengan+link+berikut%3A%0D%0Ahttps%3A%2F%2Fwa.me%2F6285248466297'
            ]);
        } else {
            return redirect()->route('profile.add.email')->with(['failed' => 'Terdapat kesalahan silakan masukkan nomor telepon ulang (error: 0x621f)']);
        }
    }

    public function addEmailSendVerifyMethod(Request $request, MailController $mailController)
    {

        // dd(session()->all());
        // dd($request);
        $request->session()->put('id', $request['id']);
        $request->session()->put('username', $request['username']);
        // $request->session()->put('verificationCode', $request['verificationCode']);
        $details = ['id' => '1', 'email' => session()->get('email'), 'title' => 'KLIK SPL: Menambahkan Email', 'message' => 'Silakan masukkan kode berikut untuk melanjutkan proses penambahan email', 'verifCode' => session()->get('verificationCodeEmail'), 'closing' => 'Kode bersifat rahasia dan jangan sebarkan kode ini kepada siapapun, termasuk pihak KLIKSPL.', 'footer' => ''];

            $detail = new Request($details);
            $this->mailController = $mailController;
            $this->mailController->sendMail($detail);
               
        // dd(session()->all());
        return redirect()->route('profile.add.email.verify');
        // dd($request->verificationCode);
        // dd(session()->get('verificationCodeEmail'));
        // dd($request->verificationCode == session()->get('verificationCodeEmail'));
        // if ($request->linkVerification) {
        //     // dd($request->linkVerification);
        //     if ($request->verificationCode == session()->get('verificationCodeEmail')) {
        //         dd($request);
        //     } else {
        //         return redirect()->route('profile.add.email')->with(['failed' => 'Terdapat kesalahan silakan masukkan nomor telepon ulang (error: 0x621f)']);
        //     }
        // } else {
        //     // $request->session()->put();
        //     return redirect()->route('profile.add.email.verify');

        // }
    }

    public function addEmailVerify(Request $request)
    {
        // dd($request);
        // dd(session()->all());
        // dd($request->verificationCode);
        // dd(session()->get('verificationCodeEmail'));
        // dd($request->verificationCode == session()->get('verificationCodeEmail'));
        // dd($request);
        if ($request->session()->has('email')) {
        
            if ($request->linkVerification) {
                // dd($request->linkVerification);
                if ($request->verificationCode == session()->get('verificationCodeEmail')) {
                    dd($request);
                } else {
                    return redirect()->route('profile.add.email.req.verify.method')->with(['failed' => 'Terdapat kesalahan silakan meminta ulang kode verifikasi (OTP) (error: 0x621f)']);
                }
            } else {
                $request->merge([
                    'id' => session()->get('id'),
                    'username' => session()->get('username'),
                    'email' => session()->get('email'),
                    'verificationCode' => session()->get('verificationCodeEmail'),
                ]);
                return view('user.verify-otp', [
                    'title' => 'Tambah Email',
                    'active' => 'profile',
                    'type' => 'Email',
                    'act' => 'add',
                    'varName' => 'email',
                    'inputType' => 'number',
                    // 'route' => 'profile.add.email.send.verify.method',
                    'route' => 'profile.add.email.verify.submit',
                    'reqVerifyRoute' => 'profile.add.email.req.verify.method',
                    'id' => $request->id,
                    'username' => $request->username,
                    'email' => $request->email,
                    'verificationCode' => $request->verificationCode,
                ]);
            }
        } else {
            return redirect()->route('profile.add.email')->with(['failed' => 'Terdapat kesalahan silakan masukkan nomor telepon ulang (error: 0x621f)']);
        }
    }

    public function addEmailVerifySubmit(Request $request)
    {
        // dd($request);
        if ($request->verifValue === $request->verifCode) {
            $request->session()->put('is_verified', 1);
            $user = User::where('id', '=', $request->id)->first();
            $user->email = $request->verifAccount;
            $user->save();
            
            $notifications = [
                'user_id' => $user->id,
                'slug' => 'email-berhasil-diperbarui-'.$user->username.'-'.Carbon::now(),
                'type' => 'Notifikasi',
                'description' => '<p class="m-0">Email berhasil diperbarui</p></br><p class="m-0">Email terbaru kamu <strong>'.$user->email.'</strong></p></br><p class="m-0">Selamat menikmati pengalaman berbelanja di klikspl.com.</p>',
                'excerpt' => 'Email berhasil diperbarui',
                'image' => 'assets\email.png',
                'is_read' => 0
            ];
            
            $notification = UserNotification::create($notifications);

            return redirect()->route('profile.add.email.verified');
        } else {
            return back()->with(['verificationFailed' => 'Kode Verifikasi yang anda masukkan tidak sesuai']);
        }
    }

    public function addEmailVerified(Request $request)
    {
        if ($request->session()->has('is_verified') && session()->get('is_verified') == 1) {
            return view('user.verified-otp', [
                'title' => 'Tambah Email',
                'active' => 'profile',
                'type' => 'Email',
                'act' => 'add',
                'varName' => 'email',
                'route' => 'profile.add.email.clear.session',
                'routeChange' => 'profile.index',
            ]);
        } else {
            return redirect()->route('profile.add.email.verify')->with(['verificationFailed' => 'Kode Verifikasi yang anda masukkan tidak sesuai, Pastikan Kode OTP yang dikirimkan dengan yang kamu masukkan sesuai, atau coba lakukan pengiriman ulang kode OTP kembali']);
        }
    }

    public function addEmailClearSession(Request $request)
    {
        $request->session()->forget('id');
        $request->session()->forget('username');
        $request->session()->forget('email');
        $request->session()->forget('verificationCodeEmail');
        $request->session()->forget('is_verified');

        return redirect()->route('profile.index');
    }

    public function updateEmail(Request $request)
    {
        if (isset(auth()->user()->email)) {

            $email = auth()->user()->email;
            $verificationCode = random_int(100000, 999999);

            $request->session()->put('verificationCodeEmail', $verificationCode);
            // $verificationCode = session()->get('verificationCodeEmail');
            // $request->session()->forget('email');

            return view('user.verify-method', [
                'title' => 'Ubah Email',
                'active' => 'profile',
                'type' => 'Email',
                'act' => 'update',
                'varName' => 'email',
                'inputType' => 'number',
                // 'route' => 'profile.update.email.send.verify.method',
                'route' => 'profile.update.email.send.verify.method.first',
                'waRoute' => 'profile.update.email.verify.first',
                'email' => $email,
                'verificationCode' => $verificationCode,
            ]);
        } else {
            return redirect()->route('profile.update.email')->with(['failed' => 'Terdapat kesalahan silakan masukkan nomor telepon ulang (error: 0x621f)']);
        }
    }

    public function updateEmailSendVerifyMethodFirst(Request $request, MailController $mailController)
    {
        // dd(session()->all());
        // dd($request);
        $request->session()->put('id', $request['id']);
        $request->session()->put('username', $request['username']);
        $request->session()->put('email', $request['email']);
        // $request->session()->put('email', $validatedData['email']);
        $details = ['id' => '1', 'email' => session()->get('email'), 'title' => 'KLIK SPL: Menambahkan Email', 'message' => 'Silakan masukkan kode berikut untuk melanjutkan proses penambahan email', 'verifCode' => session()->get('verificationCodeEmail'), 'closing' => 'Kode bersifat rahasia dan jangan sebarkan kode ini kepada siapapun, termasuk pihak KLIKSPL.', 'footer' => ''];

        $detail = new Request($details);
        $this->mailController = $mailController;
        $this->mailController->sendMail($detail);

        return redirect()->route('profile.update.email.verify.first');
    }

    public function updateEmailVerifyFirst(Request $request)
    {
        if ($request->session()->has('email')) {

            if ($request->linkVerification) {
                // dd($request->linkVerification);
                if ($request->verificationCode == session()->get('verificationCodeEmail')) {
                    // dd($request);
                    return redirect()->route('profile.update.email.verified.first');
                } else {
                    return redirect()->route('profile.update.email.req.verify.method')->with(['failed' => 'Terdapat kesalahan silakan meminta ulang kode verifikasi (OTP) (error: 0x621f)']);
                }
            } else {
                $request->merge([
                    'id' => session()->get('id'),
                    'username' => session()->get('username'),
                    'email' => session()->get('email'),
                    'verificationCode' => session()->get('verificationCodeEmail'),
                ]);
                return view('user.verify-otp', [
                    'title' => 'Ubah Email',
                    'active' => 'profile',
                    'type' => 'Email',
                    'act' => 'update',
                    'varName' => 'email',
                    'inputType' => 'number',
                    // 'route' => 'profile.update.email.send.verify.method',
                    'route' => 'profile.update.email.verify.submit.first',
                    'reqVerifyRoute' => 'profile.update.email',
                    'id' => $request->id,
                    'username' => $request->username,
                    'email' => $request->email,
                    'verificationCode' => $request->verificationCode,
                ]);
            }
        } else {
            return redirect()->route('profile.update.email')->with(['failed' => 'Terdapat kesalahan silakan masukkan nomor telepon ulang (error: 0x621f)']);
        }
    }

    public function updateEmailVerifySubmitFirst(Request $request)
    {
        if ($request->verifValue === $request->verifCode) {
            $request->session()->put('is_verified', 1);
            // dd($request);
            // $user = User::where('id','=',$request->id)->first();
            // $user->email = $request->verifAccount;
            // $user->save();

            return redirect()->route('profile.update.email.verified.first');
        } else {
            return back()->with(['verificationFailed' => 'Kode Verifikasi yang anda masukkan tidak sesuai']);
        }
    }

    public function updateEmailVerifiedFirst(Request $request)
    {
        if ($request->session()->has('is_verified') && session()->get('is_verified') == 1) {
            return view('user.verified-otp', [
                'title' => 'Ubah Email',
                'active' => 'profile',
                'type' => 'Email',
                'act' => 'update',
                'varName' => 'email',
                'route' => 'profile.update.email.fill.new',
                'updateRoute' => 'profile.update.email.fill.new',
            ]);
        } else {
            return redirect()->route('profile.update.email.verify')->with(['verificationFailed' => 'Kode Verifikasi yang anda masukkan tidak sesuai, Pastikan Kode OTP yang dikirimkan dengan yang kamu masukkan sesuai, atau coba lakukan pengiriman ulang kode OTP kembali']);
        }
    }

    public function updateEmailFillNew(Request $request)
    {
        // dd(session()->all());
        if(session()->has('id') && session()->has('username') && session()->has('email') && session()->has('verificationCodeEmail') && session()->has('is_verified')){
            return view('user.add-phone-email', [
                'title' => 'Ubah Email',
                'active' => 'profile',
                'type' => 'Email',
                'act' => 'update',
                'varName' => 'email',
                'inputType' => 'email',
                'route' => 'profile.add.email.post'
            ]);
        }else{
            return redirect()->route('profile.update.email')->with(['failed' => 'Terdapat kesalahan silakan masukkan ulang email (error: 0xEMUPERROR)']);
            
        }
    }
}
