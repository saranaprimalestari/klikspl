@extends('user.layout')
@section('account')
    {{-- @php
    // dd(session()->all());
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
    @endphp --}}
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
                            Ketik ulang kode verifikasi dengan benar atau Kirim ulang kode untuk melakukan
                            verifikasi
                        </p>
                    </div>
                    <div class="modal-footer border-0 d-flex justify-content-center mb-3">
                        <button type="button" class="btn btn-lg btn-secondary btn-block fs-14"
                            data-bs-dismiss="modal">Tutup</button>
                        <a type="button" href="{{ route('profile.add.phone.req.verify.method') }}"
                            class="btn btn-lg btn-danger btn-block fs-14">Kirim ulang</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <h5 class="mb-4">
        {{ $act == 'add' ? 'Tambahkan' : ($act == 'update' ? 'Ubah' : '') }}
        {{ $type }}
    </h5>
    <div class="card mb-3 border-radius-075rem">
        <div class="card-body p-4">
            {{-- <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ url()->previous() }}" class="text-decoration-none link-dark">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div> --}}

            <div class="row">

                {{-- {{ dd(session()->all()) }} --}}
                <div class="col-md-8 mx-auto">
                    <div class="card mb-5 border-radius-075rem box-shadows border-0">
                        <div class="card-body p-5">
                            <div class="header mb-4">
                                <div class="col-12 text-center">
                                    @if (isset($email))
                                        <i class="bi bi-envelope fs-1"></i>
                                    @elseif (isset($telp_no))
                                        <i class="bi bi-chat-left-text fs-1"></i>
                                    @endif
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
                                        {{ $type }}
                                        "{{ isset($email) ? $email : (isset($telp_no) ? $telp_no : '') }}"
                                    </span>
                                </div>
                            </div>
                            {{-- {{ $verificationCode }} --}}
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <input type="hidden" name="username" value="{{ $username }}">
                                <input type="hidden" name="verifAccount"
                                    value="{{ isset($email) ? $email : (isset($telp_no) ? $telp_no : '') }}">
                                <input type="hidden" name="verifValue" value="{{ $verificationCode }}">
                                <input type="number"
                                    class="form-control border-0 border-bottom shadow-none fs-2 text-center border-danger text-danger fw-bold"
                                    name="verifCode" placeholder="" autofocus="autofocus" autocomplete="off" max="999999">
                                <p class="register-act-login mt-2" id="timeLeft"></p>
                                <button type="submit" class="btn btn-danger text-decoration-none w-100 mt-3 verif-button">
                                    Verifikasi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
                        'Tidak menerima kode?<a href="{{ route($reqVerifyRoute) }}" class="text-decoration-none text-danger" id="resend" > kirim ulang</a>';
                } else {
                    element.innerHTML = 'Kirim ulang kode verifikasi dalam ' + timeLeft + ' detik';
                    timeLeft--;
                }
            }

        }
        $(document).ready(function() {
            $('input[type="number"][max]:not([max=""])').on('input', function(e) {
                var $this = $(this);
                var maxlength = $this.attr('max').length;
                var value = $this.val();
                if (value && value.length >= maxlength) {
                    $this.val(value.substr(0, maxlength));
                }
            });
        });
    </script>
@endsection
