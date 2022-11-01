<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Unique;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    public function index(Request $request)
    {
        if (!is_null($request->session()->get('email')) || !is_null($request->session()->get('telp_no')) || !is_null($request->session()->get('verificationCode')) || !is_null($request->session()->get('is_verified'))) {
            $request->session()->forget('email');
            $request->session()->forget('telp_no');
            $request->session()->forget('verificationCode');
            $request->session()->forget('is_verified');
        }
        return view('register.index', [
            'title' => 'Pendaftaran Membership'
        ]);
    }

    public function StorePost(Request $request)
    {
        // dd($request);
        // dd(session()->all());
        $token = $request->session()->token();
        $token = csrf_token();
        echo $token;
        // print_r($request);
        //  dd($request->emailPhone);
        if (Str::contains($request->emailPhone, '@')) {
            if (User::where('email', '=', $request->emailPhone)->exists()) {
                echo $request->emailPhone;
                $email = $request->emailPhone;
                // echo "user exists";
                // return redirect()->route('send.mail',['id'=>'1','email'=>$email,'title'=>'KLIK SPL: Pendaftaran Membership','message'=>'Silakan memasukkan kode berikut untuk melanjutkan pendaftaran','token'=>Str::random(5)]);
                return back()->with(['registered' => 'Email/No telepon yang anda daftarkan sudah terdaftar sebagai membership', 'value' => $email]);
            } else {
                $email = $request->emailPhone;
                $request->merge(['email' => $email]);
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
                $request->session()->put('email', $email);
                echo $email;
            }
        } else {
            // dd($request);
            if (User::where('telp_no', '=', $request->emailPhone)->exists()) {
                echo $request->emailPhone;
                $telp_no = $request->emailPhone;
                return back()->with(['registered' => 'Email/No telepon yang anda daftarkan sudah terdaftar sebagai membership', 'value' => $telp_no]);
            } else {
                echo $request->emailPhone;
                $telp_no = $request->emailPhone;
                echo strlen($telp_no);
                // dd($telp_no);
                $request->merge(['telp_no' => $telp_no]);
                $validatedData = $request->validate(
                    [
                        'telp_no' => 'required|unique:users|min:10|max:13|regex:/^[0-9]*$/'
                    ],
                    [
                        'telp_no.required' => 'Nomor telepon harus diisi',
                        'telp_no.unique' => 'Nomor telepon yang anda daftarkan sudah terdaftar sebagai membership',
                        'telp_no.min' => 'Nomor telepon minimal terdiri dari 12 digit',
                        'telp_no.max' => 'Nomor telepon maksimal terdiri dari 13 digit',
                        'telp_no.regex' => 'Format nomor telepon tidak valid! No telepon hanya dapat diisi dengan angka',
                    ]
                );
                $request->session()->put('telp_no', $telp_no);
                echo $telp_no;
            }
        }
        return redirect()->route('register.step.one');
        // return view('register.index',[
        //     'title' =>'Register'
        // ]);
    }

    public function createStepOne(Request $request)
    {
        return view('register.create-step-one', [
            'title' => 'Pendaftaran Membership',
            'request' => $request
        ]);
    }
    public function resendMail(Request $request, MailController $mailController, array $array)
    {
        $request = new Request($array);
        $this->mailController = $mailController;
        $this->mailController->sendMail($request);
    }
    public function postStepOne(Request $request, MailController $mailController)
    {
        $verificationCode = random_int(100000, 999999);
        if (Str::contains($request->value, '@')) {
            $details = ['id' => '1', 'email' => $request->value, 'title' => 'KLIK SPL: Pendaftaran Membership', 'message' => 'Silakan masukkan kode berikut untuk melanjutkan pendaftaran membership', 'verifCode' => $verificationCode, 'closing' => 'Kode bersifat rahasia dan jangan sebarkan kode ini kepada siapapun, termasuk pihak KLIKSPL.', 'footer' => ''];
            $detail = new Request($details);
            // dd($details);
            echo gettype($detail);
            $request->session()->put(['verificationCode' => $verificationCode]);
            $request->session()->put(['value' => $request->value]);
            
            $this->mailController = $mailController;
            $this->mailController->sendMail($detail);
        }elseif(preg_match("/^[0][0-9]*$/",$request->value)){
            // dd($request);
            $request->session()->put(['verificationCode' => $verificationCode]);
            $request->session()->put(['value' => $request->value]);
        }

        return redirect()->route('register.step.two');
    }

    public function createStepTwo(Request $request)
    {
        // dd($request);
        return view('register.create-step-two', [
            'title' => 'Register',
            'request' => $request
        ]);
    }

    public function postStepTwo(Request $request)
    {
        if ($request->verifValue === $request->verifCode) {
            $request->session()->put('is_verified', 1);
            return redirect()->route('register.step.three');
        } else {
            return back()->with(['verificationFailed' => 'Kode Verifikasi yang anda masukkan tidak sesuai']);
        }
        // dd($request);
        // $validatedData = $request->validate([
        //     'verifcode' => 'required|unique:users|email:dns'
        // ]);
        // $validatedData = Validator::make($input,$rules,$messages. ['verifValue'=>'verifCode']);
        // if($request->verifCode === $request->verifvalue)
        // $request->merge([])
        // return redirect()->route('register.step.one');
        // return view('register.index',[
        //     'title' =>'Register'
        // ]);
    }

    public function createStepThree(Request $request)
    {
        // dd($request);
        if ($request->session()->get('is_verified')) {
            return view('register.create-step-three', [
                'title' => 'Pendaftaran Membership',
                'request' => $request
            ]);
        } else {
            return back()->with(['verificationFailed' => 'Kode Verifikasi yang anda masukkan tidak valid']);
        }
    }

    public function postStepThree(Request $request, MailController $mailController)
    {
        // dd($request->session()->all());
        // dd($request);
        $validatedData = $request->validate(
            [
                'username' => ['required', 'unique:users', 'alpha_dash', 'min:5', 'max:255', 'string', 'regex:/^[a-z]+[0-9]*$/'],
                'password' => 'required|min:5|max:255',
                'telp_no' => 'nullable|unique:users,telp_no',
                'email' => 'nullable|unique:users,email'
            ],
            [
                'username.unique' => 'username sudah digunakan',
                'username.min' => 'username minimal 5 karakter',
                'username.regex' => 'format username tidak valid! Awali dengan huruf, hindari penggunaan angka ditengah username, jangan gunakan simbol !@#$%^&*()_+|}{":?><',
                'username.required' => 'username harus diisi!',
                'password.min' => 'password minimal 5 karakter',
                'password.required' => 'password harus diisi!',
            ]
        );
        // $random_username = Str::random(10);
        // while (User::where('username', $random_username)->exists()) {
        //     $random_username = Str::random(10);
        // }            
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['email'] = $request->session()->get('email');
        $validatedData['telp_no'] = $request->session()->get('telp_no');
        $validatedData['email_verified_at'] = Carbon::now();
        $user = User::create($validatedData);

        if (Str::contains($request->session()->get('value'), '@')) {
            $details = ['id' => '2', 'email' => $request->session()->get('value'), 'title' => 'KLIK SPL: Pendaftaran Membership Berhasil', 'message' => 'Pendaftaran membership kamu berhasil! Selamat menikmati pengalaman berbelanja di klikspl.com. Untuk masuk dan berbelanja klik tautan berikut:', 'verifCode' => '','url' =>'http://klikspl.test/', 'closing' => '', 'footer' => ''];
            $detail = new Request($details);
            $this->mailController = $mailController;
            $this->mailController->sendMail($detail);    
        }elseif(preg_match("/^[0][0-9]*$/",$request->session()->get('value'))){

        }
        $notifications = [
            'user_id' => $user->id,
            'slug' => 'pendaftaran-membership-berhasil-'.$user->username,
            'type' => 'Notifikasi',
            'description' => '<p>Pendaftaran membership kamu berhasil! Selamat menikmati pengalaman berbelanja di klikspl.com.</p>',
            'excerpt' => 'Pendaftaran membership kamu berhasil',
            'image' => 'assets\footer-logo.png',
            'is_read' => 0
        ];

        $notification = UserNotification::create($notifications);

        return redirect()->route('register.complete');
    }

    public function registerComplete(Request $request)
    {
        return view('register.complete', [
            'title' => 'Pendaftaran Membership Berhasil'
        ]);
    }
}
