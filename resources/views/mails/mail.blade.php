{{-- <!DOCTYPE html>
<html>

<head>
    <title>KLIK SPL MAIL</title>
</head> --}}
@extends('layouts.library')
@section('container')
    <style>
        @media (min-width: 768px) {
            .wrapper {
                background-color: #4d4d4d;
                padding: 100px 100px 100px 100px;
            }
            .main-email {
                background-color: #ffffff;
                padding: 50px 50px 50px 50px;
                width: 67%;
                margin-right: auto !important;
                margin-left: auto !important;
                margin-top: 10%;
                margin-bottom: 10%;
            }
        }

    </style>
    <div class="row bg-light wrapper">
        <div class="col-8 bg-white mx-auto m-4 py-4 px-5 rounded main-email">
            <div class="col-12 text-center pb-3">
                <img src="{{ asset('/assets/footer-logo.svg') }}" class="text-center" alt="" width="200">
            </div>
            <div>
                <h4>{{ $details['title'] }}</h4>
                {{-- <h4>KLIK SPL: Pendaftaran Membership</h4> --}}
                <p class="m-0">Halo,</p>
                <p>{{ $details['body'] }}</p>
                {{-- <p>Pendaftaran membership kamu berhasil! Selamat menikmati pengalaman berbelanja di klikspl.com. Untuk masuk dan berbelanja klik tautan berikut:</p> --}}
                <h1 style="text-align: center">{{ $details['verification'] }}</h1>
                <div style="text-align: center; margin: 50px;">
                    @if ($details['url'])
                        {{-- @component('mail::button', ['url' => $details['url'], 'color' => '#db162f']) Masuk @endcomponent --}}
                        <a href="{{ $details['url'] }}"
                            style="color: #ffffff; font-weight: 500; text-decoration: none; background-color: #db162f; padding: 10px 30px 10px 30px; border-radius: 10px; ">
                            Kunjungi Link
                        </a>
                    @endif
                </div>
                <p>{{ $details['closing'] }}</p>
                {{-- <p>Closing section</p> --}}

                <p>{{ $details['footer'] }}</p>
                {{-- <p>footer section</p> --}}
                <p>Email ini dibuat otomatis mohon untuk tidak membalas, jika membutuhkan bantuan, silakan hubungi <a
                        href="wa.me/625113269593" style="color:#db162f;text-decoration: none">ADMIN KLIKSPL</a></p>
            </div>
            {{-- <div class="footer col-12 text-center">
                <p class="fw-bold m-0">
                    Ikuti Kami
                </p>
                <span>
                    <a href="#" class="text-decoration-none text-dark">
                        <i class="bi bi-instagram"></i>
                    </a>
                </span>
                <span>
                    <a href="#" class="text-decoration-none text-dark">
                        <i class="bi bi-facebook"></i>
                    </a>
                </span>
                <span>
                    <a href="#" class="text-decoration-none text-dark">
                        <i class="bi bi-globe2"></i>
                    </a>
                </span>
            </div> --}}
        </div>
    </div>
@endsection
{{-- <body>
    
</body>

</html> --}}
