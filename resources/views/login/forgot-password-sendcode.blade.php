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
    {{-- {{ print_r(session()->all()) }} --}}
    <div class="login-container">

        <div class="col-12 d-flex justify-content-center mt-5">
            <img class="" src="/assets/footer-logo.svg" width="180" alt="">
        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-12 col-md-8 col-lg-5 mt-2 mx-auto">
                @if (session()->has('loginError'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('loginError') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card login-card border-0 mt-3">
                    <div class="card-body p-5">
                        <div class="header mb-4">
                            <div class="row">
                                <div class="col-md-1 col-2">
                                    <a class="text-dark fw-bold" href="{{ route('forgot.password') }}"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        title="Kembali ke tahap sebelumnya">
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
                        <form action="{{ route('forgot.password.get.code') }}" method="POST">
                            @csrf
                            <input type="hidden" name="value" value="{{ $data }}">
                            <button type="submit" class="text-decoration-none text-dark border-0 bg-transparent w-100">
                                <div class="card login-card register-act-login shadow-none">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-9 col-9 text-start">
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
                                            <div class="col-md-3 col-3 d-flex align-items-center">
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
