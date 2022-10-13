@extends('layouts.library')

@section('container')
    <div class="login-container">

        <div class="col-12 d-flex justify-content-center mt-5">
            <img class="" src="/assets/footer-logo.svg" width="180" alt="">
        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-md-5 mt-2 mx-auto">
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
                                <div class="col-12">
                                    <h5 class="text-center">Atur Ulang Password Berhasil</h5>
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
