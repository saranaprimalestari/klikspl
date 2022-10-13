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
                            Kirim ulang kode untuk melakukan verifikasi
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
                    <li class="registration-line on-active">
                        <i class="bi bi-arrow-right fs-2"></i>
                    </li>
                    <li class="registration-step">
                        <div class="registration-item-active">
                            <p>3</p>
                        </div>
                        <p class="registration-text on-active">Buat Username & Password</p>
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
                    <div class="card-body px-5 pt-5 pb-5">
                        <div class="header mb-4">
                            {{-- <div class="col-12 text-center">
                                <i class="{{ $icon }} fs-1"></i>
                            </div> --}}
                            <div class="row">
                                {{-- <div class="col-md-1 col-2">
                                    <a class="text-dark fw-bold" href="{{ route('register.step.one') }}" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Kembali ke tahap sebelumnya">
                                        <strong>
                                            <i class="bi bi-arrow-left"></i>
                                        </strong>
                                    </a>
                                </div> --}}
                                <div class="col-md-12 col-12">
                                    <h5 class="text-center">Buat Username dan Password anda</h5>
                                </div>
                            </div>
                            <div>
                                <span class="d-flex justify-content-center">
                                </span>
                            </div>
                            <div class="text-center">
                                <span class="register-act-login">
                                    username dan password digunakan untuk login
                                </span>
                            </div>
                        </div>
                        <form action="{{ route('register.step.three.post') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label register-username-label m-0">Username</label>
                                <input type="text"
                                    class="form-control shadow-none register-username-field @error('username') is-invalid @enderror"
                                    id="username" aria-describedby="usernameHelp" name="username" required
                                    value="{{ old('username') }}" autocomplete="off">

                                <div id="usernameHelp" class="form-text register-username-help">Contoh: riduan1234
                                </div>

                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label register-password-label m-0">Password</label>
                                <div class="input-group" id="show_hide_password_register">
                                    <input type="password"
                                        class="form-control shadow-none register-password-field @error('password') is-invalid @enderror"
                                        id="password" aria-describedby="passwordHelp" name="password" required value=""
                                        autocomplete="off">
                                    <span class="input-group-text bg-transparent border-left-0" id="showPass"><a href=""
                                            class="text-dark"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </span>

                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- <input type="password"
                                    class="form-control shadow-none register-password-field @error('password') is-invalid @enderror"
                                    id="password" name="password" required value="{{ old('password') }}"
                                    autocomplete="off">
                                    <span class="input-group-text bg-transparent border-left-0" id="showPass"><a href=""
                                            class="text-dark"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </span>

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror --}}
                            </div>
                            <button type="submit"
                                class="btn btn-danger text-decoration-none w-100 mt-3 register-button">Buat Akun</button>
                        </form>
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

            $("#show_hide_password_register a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password_register input').attr("type") == "text") {
                    $('#show_hide_password_register input').attr('type', 'password');
                    $('#show_hide_password_register i').addClass("fa-eye-slash");
                    $('#show_hide_password_register i').removeClass("fa-eye");
                } else if ($('#show_hide_password_register input').attr("type") == "password") {
                    $('#show_hide_password_register input').attr('type', 'text');
                    $('#show_hide_password_register i').removeClass("fa-eye-slash");
                    $('#show_hide_password_register i').addClass("fa-eye");
                }
            });
        });
    </script>
@endsection
