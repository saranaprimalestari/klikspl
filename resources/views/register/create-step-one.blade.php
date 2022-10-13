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
                                                            SMS
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
                                                    <i class="bi bi-chat-left-text fs-1"></i>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            {{-- </a> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="login-footer text-center">
            &copy; 2022, CV Sarana Prima Lestari
        </div>
    </div>
@endsection
