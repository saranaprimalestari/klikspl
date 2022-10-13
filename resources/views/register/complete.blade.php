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
            <ul id="registration-progress" class="list-unstyled d-flex justify-content-center">
                <li class="registration-step">
                    <div class="registration-item-active">
                        <p class="">1</p>
                    </div>
                    <p class="registration-text on-active">Metode Verifikasi</p>
                </li>
                <li class="registration-line on-active">
                    <i class="bi bi-arrow-right fs-2"></i>
                </li>
                <li class="registration-step">
                    <div class="registration-item-active">
                        <p class="">2</p>
                    </div>
                    <p class="registration-text on-active">Verifikasi</p>
                </li>
                <li class="registration-line on-active">
                    <i class="bi bi-arrow-right fs-2"></i>
                </li>
                <li class="registration-step">
                    <div class="registration-item-active">
                        <p>3</p>
                    </div>
                    <p class="registration-text on-active">Buat Password</p>
                </li>
                <li class="registration-line on-active">
                    <i class="bi bi-arrow-right fs-2"></i>
                </li>
                <li class="registration-step">
                    <div class="registration-item-active">
                        <p><i class="bi bi-check-lg"></i></p>
                    </div>
                    <p class="registration-text on-active">Selesai</p>
                </li>
            </ul>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col-md-5 mt-1">
                <div class="card login-card border-0 mt-3">
                    <div class="card-body p-5">
                        <div class="header mb-4">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="text-center">Pendaftaran Membership Berhasil</h5>
                                </div>
                            </div>
                            <div>
                                <span class="d-flex justify-content-center">
                                </span>
                            </div>
                            <div class="text-center">
                                <span class="register-act-login">
                                    silakan masuk untuk melanjutkan berbelanja
                                </span>
                            </div>
                            <a href="{{ route('login') }}" class="btn btn-danger text-decoration-none w-100 mt-3 register-button">Masuk</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="login-footer text-center">
            &copy; 2022, CV Sarana Prima Lestari
        </div>
    </div>
@endsection
