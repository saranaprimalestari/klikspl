@extends('layouts.library')

@section('container')
    @php
    // print_r(session()->all());
    if (Session::get('email') != '') {
        $data = Session::get('email');
        $type = 'email';
        $icon = 'bi bi-envelope';
    } else {
        $data = Session::get('telp_no');
        $type = 'Nomor Telepon';
        $icon = 'bi bi-chat-left-text';
    }
    $verifCode = Session::get('verificationCode');
    @endphp
    @if (session()->has('verificationFailed'))
        <script>
            $(window).on('load', function() {
                setTimeout(function() {
                    $('#verifFailed').modal('show')
                }, 10);
            })
        </script>
        <div class="modal fade mt-5" id="verifFailed" tabindex="-1" aria-labelledby="returnLoginModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content text-center modalConfirm">
                    <div class="modal-header border-0 pt-4 px-4 pb-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5">
                        <h5 class="modal-title mb-3" id="returnLoginModal">Kode verifikasi tidak sesuai!</h5>
                        <p class="register-modal-p mb-0">
                            {{ session('verificationFailed') }}!
                            Ketik ulang kode verifikasi dengan benar atau Kirim ulang kode untuk melakukan verifikasi
                        </p>
                    </div>
                    <div class="modal-footer border-0 d-flex justify-content-center mb-3">
                        <a type="button" href="{{ route('register.step.one') }}"
                            class="btn btn-lg btn-danger btn-block register-modal-submit">Kirim ulang</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
                            <div class="col-12 text-center">
                                <i class="{{ $icon }} fs-1"></i>
                            </div>
                            <div class="row">
                                <div class="col-md-1 col-2">
                                    <a class="text-dark fw-bold" href="{{ route('forgot.password.get.code') }}"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        title="Kembali ke tahap sebelumnya">
                                        <strong>
                                            <i class="bi bi-arrow-left"></i>
                                        </strong>
                                    </a>
                                </div>
                                <div class="col-md-11 col-10">
                                    <h5 class="ms-4 ps-2">Masukkan Kode Verifikasi</h5>
                                </div>
                            </div>
                            <div>
                                <span class="d-flex justify-content-center">
                                </span>
                            </div>
                            <div class="text-center">
                                <span class="register-act-login">
                                    Kode verifikasi dikirim melalui {{ $type }} ke {{ $data }}
                                </span>
                            </div>
                        </div>
                        <form action="{{ route('forgot.password.verif.post') }}" method="POST">
                            @csrf
                            <input type="hidden" name="verifAccount" value="{{ $data }}">
                            <input type="hidden" name="verifValue" value="{{ $verifCode }}">
                            <input type="text"
                                class="form-control border-0 border-bottom shadow-none fs-2 text-center border-danger text-danger fw-bold"
                                name="verifCode" placeholder="" autofocus="autofocus" autocomplete="off">
                            <p class="register-act-login mt-2" id="timeLeft"></p>
                            <button type="submit" class="btn btn-danger text-decoration-none w-100 mt-3">Verifikasi</button>
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
