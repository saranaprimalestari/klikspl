@extends('user.layout')
@section('account')
    <div class="card mb-3 profile-card">
        <div class="card-body p-4">
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('profile.index') }}" class="text-decoration-none link-dark">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>  
            </div>
            <h5 class="mb-4">Ubah Email</h5>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card mb-5 border-radius-075rem box-shadows border-0">
                        <div class="card-body p-5">
                            <div class="header mb-4">
                                <div class="col-12 text-center">
                                    <i class="bi bi-envelope fs-1"></i>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h5 class="">Masukkan Kode Verifikasi</h5>
                                    </div>
                                </div>
                                <div>
                                    <span class="d-flex justify-content-center">
                                    </span>
                                </div>
                                <div class="text-center">
                                    <span class="register-act-login">
                                        Kode verifikasi dikirim melalui
                                    </span>
                                </div>
                            </div>
                            <form action="{{ route('register.step.two.post') }}" method="POST">
                                @csrf
                                <input type="hidden" name="verifAccount" value="">
                                <input type="hidden" name="verifValue" value="">
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
        </div>
    </div>
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
