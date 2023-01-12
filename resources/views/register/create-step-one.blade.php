@extends('layouts.library')

@section('container')
    @php
        // print_r(session()->all());
        if (Session::get('email') != '') {
            $data = Session::get('email');
        } else {
            $data = Session::get('telp_no');
        }
    @endphp
    <div class="register-container mt-3">
        <div class="col-12 d-flex justify-content-center">
            <img class="" src="/assets/footer-logo.svg" width="180" alt="">
        </div>
        <div class="col-12 text-center mt-5">
            <h5 class="mb-4">Daftar Membership</h5>
            <div class="d-none d-sm-block">
                <ul id="registration-progress" class="list-unstyled d-flex justify-content-center ">
                    <li class="registration-step">
                        <div class="registration-item-active">
                            <p class="">1</p>
                        </div>
                        <p class="registration-text on-active">Metode Verifikasi</p>
                    </li>
                    <li class="registration-line">
                        <i class="bi bi-arrow-right fs-2"></i>
                    </li>
                    <li class="registration-step">
                        <div class="registration-item">
                            <p class="">2</p>
                        </div>
                        <p class="registration-text">Verifikasi</p>
                    </li>
                    <li class="registration-line">
                        <i class="bi bi-arrow-right fs-2"></i>
                    </li>
                    <li class="registration-step">
                        <div class="registration-item">
                            <p>3</p>
                        </div>
                        <p class="registration-text">Buat Password</p>
                    </li>
                    <li class="registration-line">
                        <i class="bi bi-arrow-right fs-2"></i>
                    </li>
                    <li class="registration-step">
                        <div class="registration-item">
                            <p><i class="bi bi-check-lg"></i></p>
                        </div>
                        <p class="registration-text">Selesai</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col-md-5 mt-1 col-12">
                <div class="card login-card border-0 mt-3">
                    <div class="card-body p-5">
                        <div class="header mb-4">
                            <div class="row">
                                <div class="col-md-1 col-2">
                                    <a class="text-dark fw-bold" href="{{ route('register') }}" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Kembali ke tahap sebelumnya">
                                        <strong>
                                            <i class="bi bi-arrow-left"></i>
                                        </strong>
                                    </a>
                                </div>
                                <div class="col-md-11 col-10">
                                    <h5 class="ms-4 ps-2">Pilih Metode Verifikasi</h5>
                                </div>
                            </div>
                            <div>
                                <span class="d-flex justify-content-center">
                                </span>
                            </div>
                            <div class="text-center">
                                <span class="register-act-login">
                                    Pilihan yang tersedia saat ini untuk
                                    mengirimkan kode verifikasi.
                                </span>
                            </div>
                        </div>
                        @if (Session::get('email') != '')
                            <form action="{{ route('register.step.one.post') }}" method="POST">
                                @csrf
                                <input type="hidden" name="value" value="{{ $data }}">
                                <button type="submit" class="text-decoration-none text-dark border-0 bg-transparent w-100">
                                    <div class="card login-card register-act-login shadow-none">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-9 text-start">
                                                    <p>
                                                        <strong>
                                                            kirim
                                                            @if (Session::get('email') != '')
                                                                Email
                                                            @else
                                                                Pesan Whatsapp
                                                            @endif
                                                            ke
                                                        </strong>
                                                    </p>
                                                    <p>
                                                        {{ $data }}
                                                    </p>
                                                </div>
                                                <div class="col-md-3 d-flex align-items-center">
                                                    @if (Session::get('email') != '')
                                                        <i class="bi bi-envelope fs-1"></i>
                                                    @else
                                                        <i class="bi bi-whatsapp fs-1"></i>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        @elseif (Session::get('telp_no') != '')
                        <form action="{{ route('register.step.one.post') }}" method="POST" class="phone-verify-method-form-register">
                            @csrf
                            <input type="hidden" name="value" value="{{ $data }}">
                            <a href="https://wa.me/628115102888?text=Halo%2C%0D%0ASilakan+masukkan+kode+berikut+untuk+verifikasi+nomor+telepon+yang+kamu+gunakan+untuk+pendaftaran+akun+membership+di+KLIKSPL%0D%0A%0D%0A%2A{{ $verificationCode }}%2A%0D%0A%0D%0AKode+diatas+bersifat+rahasia+dan+jangan+sebarkan+kode+kepada+siapapun.%0D%0A%0D%0APesan+ini+dibuat+otomatis%2C+jika+membutuhkan+bantuan%2C+silakan+hubungi+ADMIN+KLIKSPL+dengan+link+berikut%3A%0D%0Ahttps%3A%2F%2Fwa.me%2F628115102888"
                                target="_blank" class="text-decoration-none link-dark send-wa-otp-register fs-14">
                                <div class="card border-radius-075rem box-shadow">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-9 col-9 text-start">
                                                <p class="">
                                                    <strong>
                                                        kirim Pesan Whatsapp ke
                                                    </strong>
                                                </p>
                                                <p class="">
                                                    {{ $data }}
                                                </p>
                                            </div>
                                            <div class="col-md-3 col-3 d-flex align-items-center justify-content-center pe-4">
                                                <i class="bi bi-whatsapp fs-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="login-footer text-center">
            &copy; 2022, CV Sarana Prima Lestari
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.send-wa-otp-register').click(function() {
                $('.phone-verify-method-form-register').submit();
            })
        })
    </script>
@endsection
