@extends('layouts.library')

@section('container')
    @php
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
        {{-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
         {{ session('registered') }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div> --}}
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
    <div class="register-container mt-3">
        <div class="col-12 d-flex justify-content-center">
            <img class="" src="/assets/footer-logo.svg" width="180" alt="">
        </div>
        <div class="col-12 text-center mt-5">
            <h5 class="mb-4">Daftar Membership</h5>
            <div class="d-none d-sm-block">
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
                    <li class="registration-line">
                        <i class="bi bi-arrow-right fs-2"></i>
                    </li>
                    <li class="registration-step">
                        <div class="registration-item">
                            <p>3</p>
                        </div>
                        <p class="registration-text">Buat Username & Password</p>
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
            <div class="col-md-5 mt-1">
                <div class="card login-card border-0 mt-3">
                    <div class="card-body px-5 pt-3 pb-5">
                        <div class="header mb-4">
                            <div class="col-12 text-center">
                                <i class="{{ $icon }} fs-1"></i>
                            </div>
                            <div class="row">
                                <div class="col-md-1 col-2">
                                    <a class="text-dark fw-bold" href="{{ route('register.step.one') }}"
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
                                    Kode verifikasi dikirim melalui {{ $type }} ke {{ $data }} {{ session()->get('verificationCode') }}
                                </span>
                            </div>
                        </div>
                        {{-- {{ $data }} --}}
                        <form action="{{ route('register.step.two.post') }}" method="POST">
                            @csrf
                            <input type="hidden" name="verifAccount" value="{{ $data }}">
                            <input type="hidden" name="verifValue" value="{{ $verifCode }}">
                            <input type="text"
                                class="form-control border-0 border-bottom shadow-none fs-2 text-center border-danger text-danger fw-bold"
                                name="verifCode" placeholder="" autofocus="autofocus" autocomplete="off">
                            <p class="register-act-login mt-2" id="timeLeft"></p>
                            <button type="submit"
                                class="btn btn-danger text-decoration-none w-100 mt-3 verif-button">Verifikasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="login-footer text-center">
            &copy; 2022, CV Sarana Prima Lestari
        </div>
    </div>
    {{-- {{ dd($request) }} --}}
    <script>
        window.onload = function() {
            var timeLeft = 30;
            var element = document.getElementById('timeLeft');
            var detail = document.getElementById('detail');
            var timer = setInterval(countdown, 1000);

            function countdown() {
                if (timeLeft == -1) {
                    element.innerHTML =
                        'Tidak menerima kode?<a href="{{ url()->previous() }}" class="text-decoration-none text-danger" id="resend" > kirim ulang</a>';
                } else {
                    element.innerHTML = 'Kirim ulang kode verifikasi dalam ' + timeLeft + ' detik';
                    timeLeft--;
                }
            }
        }
    </script>
@endsection
