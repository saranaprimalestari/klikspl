<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        // if (!is_null($request->session()->get('email')) || !is_null($request->session()->get('telp_no')) || !is_null($request->session()->get('verificationCode')) || !is_null($request->session()->get('is_verified')) || !is_null($request->session()->get('data')) || !is_null($request->session()->get('user_id'))) {
        //     $request->session()->forget('email');
        //     $request->session()->forget('telp_no');
        //     $request->session()->forget('verificationCode');
        //     $request->session()->forget('is_verified');
        //     $request->session()->forget('user_id');
        // }
        return view('user.change-password', [
            'title' => 'Ubah Password',
            'active' => 'changePassword',
        ]);
    }

    public function changePasswordPost(Request $request)
    {
        // mengambil data user dari database
        $user = User::findorfail($request->user_id);
        // dd($user);
        if (!(Hash::check($request->oldPassword, $user->password))) {
            return back()->with('failed', 'Password saat ini yang anda masukkan tidak benar!');
        }
        //checking password yang dimasukkan apakah sama dengan password sebelumnya yang ada di database
        if (Hash::check($request->newPassword, $user->password)) {
            return back()->with('failed', 'Password tidak boleh sama dengan password sebelumnya');
        } else {

            // $request->merge(['passwordRetype' => $request->passwordRetype]);
            $validatedData = $request->validate(
                [
                    'newPassword' => ['required','min:5','max:255',Password::min(5)
                    ->letters()
                    ->numbers()],
                    'confirmPassword' => 'same:newPassword'
                ],
                [
                    'newPassword.min' => 'password minimal 5 karakter',
                    'newPassword.required' => 'password harus diisi!',
                    'newPassword.letters' => 'password baru setidaknya memiliki satu karakter huruf besar dan huruf kecil',
                    'confirmPassword.same' => 'Password yang diketikkan tidak cocok, pastikan kembali password yang diketikkan sama'
                ]
            );
            $validatedData['newPassword'] = Hash::make($validatedData['newPassword']);
            
            // $new_pass = ['password' => $validatedData['newPassword']];
            if ($user->update(['password' => $validatedData['newPassword']])) {
                return  redirect()->back()->with('success','Berhasil mengganti password');
            }
        }

        if (Str::contains($request->user, '@')) {
            if (User::where('email', '=', $request->user)->exists()) {
                $user = User::where('email', '=', $request->user)->first();
                $email = $request->user;
                $request->merge(['email' => $email]);
                $request->session()->put('email', $email);
                $request->session()->put('user_id', $user->id);
                $request->session()->put('password', $user->password);
                $validatedData = $request->validate(
                    [
                        'email' => ['required', 'email', 'regex:/.*\.(com|co.id)$/']
                    ],
                    [
                        'email.required' => 'Email harus diisi',
                        'email.email' => 'Format email tidak valid! Pastikan mengisi email dengan benar',
                        'email.regex' => 'Domain email yang dapat digunakan .com dan .co.id',
                    ]
                );
            } else {
                $email = $request->user;
                return back()->with(['failed' => 'Email/No telepon yang anda belum terdaftar sebagai membership', 'value' => $email]);
            }
        } else {
            if (User::where('telp_no', '=', $request->user)->exists()) {
                $user = User::where('email', '=', $request->user)->first();
                $telp_no = $request->user;
                $request->merge(['telp_no' => $telp_no]);
                $request->session()->put('user_id', $user->id);
                $request->session()->put('password', $user->password);
                $validatedData = $request->validate(
                    [
                        'telp_no' => 'required|min:12|max:13|regex:/^[0-9]*$/'
                    ],
                    [
                        'telp_no.required' => 'Nomor telepon harus diisi',
                        'telp_no.min' => 'Nomor telepon minimal terdiri dari 12 digit',
                        'telp_no.max' => 'Nomor telepon maksimal terdiri dari 13 digit',
                        'telp_no.regex' => 'Format nomor telepon tidak valid! No telepon hanya dapat diisi dengan angka',
                    ]
                );
                $request->session()->put('telp_no', $telp_no);
            } else {
                $telp_no = $request->user;
                return back()->with(['failed' => 'Email/No telepon yang anda daftarkan sudah terdaftar sebagai membership', 'value' => $telp_no]);
            }
        }

        return redirect()->route('forgot.password.send.code');
    }

    public function resetPasswordSendCode(Request $request)
    {
        if (!is_null($request->session()->get('email')) || !is_null($request->session()->get('telp_no')) || !is_null($request->session()->get('verificationCode')) || !is_null($request->session()->get('is_verified')) || !is_null($request->session()->get('data')) || !is_null($request->session()->get('user_id'))) {
            return view('login.forgot-password-sendcode', [
                'title' => 'Lupa Password',
                'data' => $request
            ]);
        } else {
            return redirect()->route('forgot.password');
        }
    }

    public function resetPasswordGetCode(Request $request, MailController $mailController)
    {
        if (!is_null($request->session()->get('email')) || !is_null($request->session()->get('telp_no')) || !is_null($request->session()->get('verificationCode')) || !is_null($request->session()->get('is_verified')) || !is_null($request->session()->get('data')) || !is_null($request->session()->get('user_id'))) {

            $verificationCode = random_int(100000, 999999);
            $details = ['id' => '1', 'email' => $request->value, 'title' => 'KLIK SPL: Reset Password', 'message' => 'Silakan masukkan kode berikut untuk mengganti password akun anda', 'verifCode' => $verificationCode, 'closing' => 'Kode bersifat rahasia dan jangan sebarkan kode ini kepada siapapun, termasuk pihak KLIKSPL.', 'footer' => ''];
            $detail = new Request($details);
            
            $request->session()->put(['verificationCode' => $verificationCode]);

            // $this->mailController = $mailController;
            // $this->mailController->sendMail($detail);
            $sendMailController = $mailController;
            $sendMailController->sendMail($detail);

            return redirect()->route('forgot.password.verif.code');
        } else {

            return redirect()->route('forgot.password');
        }
    }

    public function resetPasswordVerification(Request $request)
    {

        if (!is_null($request->session()->get('email')) || !is_null($request->session()->get('telp_no')) || !is_null($request->session()->get('verificationCode')) || !is_null($request->session()->get('is_verified')) || !is_null($request->session()->get('data')) || !is_null($request->session()->get('user_id'))) {
            return view('login.forgot-password-verificationcode', [
                'title' => 'Lupa Password',
                'data' => $request
            ]);
        } else {
            return redirect()->route('forgot.password');
        }
    }

    public function resetPasswordVerificationPost(Request $request)
    {
        if (!is_null($request->session()->get('email')) || !is_null($request->session()->get('telp_no')) || !is_null($request->session()->get('verificationCode')) || !is_null($request->session()->get('is_verified')) || !is_null($request->session()->get('data')) || !is_null($request->session()->get('user_id'))) {
            if ($request->verifValue === $request->verifCode) {
                $request->session()->put('is_verified', 1);
                return redirect()->route('forgot.password.reset');
            } else {
                return back()->with(['verificationFailed' => 'Kode Verifikasi yang anda masukkan tidak sesuai']);
            }
        } else {
            return redirect()->route('forgot.password');
        }
    }

    public function resetPasswordReset(Request $request)
    {
        if (!is_null($request->session()->get('email')) || !is_null($request->session()->get('telp_no')) || !is_null($request->session()->get('verificationCode')) || !is_null($request->session()->get('is_verified')) || !is_null($request->session()->get('data')) || !is_null($request->session()->get('user_id'))) {
            if ($request->session()->get('is_verified')) {
                return view('login.forgot-password-reset', [
                    'title' => 'Pendaftaran Membership',
                    'request' => $request
                ]);
            } else {
                return back()->with(['verificationFailed' => 'Kode Verifikasi yang anda masukkan tidak valid']);
            }
        } else {
            return redirect()->route('forgot.password');
        }
    }

    public function resetPasswordResetPost(Request $request)
    {
        // mengambil data user dari database
        $user = User::find(session()->get('user_id'));

        //checking password yang dimasukkan apakah sama dengan password sebelumnya yang ada di database
        if (Hash::check($request->password, $user->password)) {
            return back()->with('resetFailed', 'Password tidak boleh sama dengan password sebelumnya');
        } else {
            $request->merge(['passwordRetype' => $request->passwordRetype]);
            $validatedData = $request->validate(
                [
                    'password' => 'required|min:5|max:255',
                    'passwordRetype' => 'same:password'
                ],
                [
                    'password.min' => 'password minimal 5 karakter',
                    'password.required' => 'password harus diisi!',
                    'passwordRetype.same' => 'Password yang diketikkan tidak cocok, pastikan kembali password yang diketikkan sama'
                ]
            );
            $validatedData['password'] = Hash::make($validatedData['password']);
            $new_pass = ['password' => $validatedData['password']];
            if ($user->update(['password' => $validatedData['password']])) {
                return  redirect()->route('forgot.password.reset.complete');
            }
        }
    }

    public function resetPasswordResetComplete(Request $request)
    {
        return view('login.reset-password-success', [
            'title' => 'Reset Password Sukses',
        ]);
    }
}
