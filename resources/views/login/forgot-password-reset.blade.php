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
    @if (session()->has('resetFailed') || session()->has("error['new_password']"))
        <script>
            $(window).on('load', function() {
                setTimeout(function() {
                    $('#resetPass').modal('show')
                }, 10);
            })
        </script>
        <div class="modal fade mt-5" id="resetPass" tabindex="-1" aria-labelledby="returnLoginModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content text-center modalConfirm">
                    <div class="modal-header border-0 pt-4 px-4 pb-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5">
                        <h5 class="modal-title mb-3" id="returnLoginModal">Reset Password Gagal!</h5>
                        <p class="register-modal-p mb-0">
                            {{ session('resetFailed') }}
                            {{ session('new_password') }}
                        </p>
                    </div>
                    <div class="modal-footer border-0 d-flex justify-content-center mb-3">
                        <a type="button" class="btn btn-lg btn-danger btn-block register-modal-submit" data-bs-dismiss="modal" aria-label="Close">Oke</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="login-container">

        <div class="col-12 d-flex justify-content-center mt-5">
            <a href="{{ route('login') }}">
                <img class="" src="/assets/footer-logo.svg" width="180" alt="">
            </a>
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
                                    <h5 class="text-center">Masukkan password baru anda</h5>
                                </div>
                            </div>
                            <div>
                                <span class="d-flex justify-content-center">
                                </span>
                            </div>
                            <div class="text-center">
                                <span class="register-act-login">
                                    Password baru digunakan untuk masuk dan berbelanja
                                </span>
                            </div>
                        </div>
                        <form action="{{ route('forgot.password.reset.post') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="user_id" value="{{ session()->get('user_id') }}">
                            <div class="mb-3">
                                <label for="password" class="form-label forgot-password-label m-0">Password Baru</label>
                                <div class="input-group" id="show_hide_password">
                                    <input type="password"
                                        class="form-control forgot-pass shadow-none border border-right-0 forgot-password-field @error('password') is-invalid @enderror"
                                        id="password" aria-describedby="passwordHelp" name="password" required
                                        value="" autocomplete="off">
                                    <span class="input-group-text bg-transparent border-left-0" id="showPass"><a href=""
                                            class="text-dark"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </span>

                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div id="passwordHelp" class="form-text forgot-password-help">Minimum 5 karakter
                                </div>

                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label forgot-password-label m-0">Ketik Ulang Password
                                    Baru</label>
                                <div class="input-group" id="show_hide_password_retype">
                                    <input type="password"
                                        class="form-control forgot-pass shadow-none border border-right-0 forgot-password-field @error('passwordRetype') is-invalid @enderror"
                                        id="passwordRetype" aria-describedby="passwordHelp" name="passwordRetype" required
                                        value="" autocomplete="off">
                                    <span class="input-group-text bg-transparent border-left-0" id="showPass"><a href=""
                                            class="text-dark"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </span>

                                    @error('passwordRetype')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mt-2">
                                    <p class="fw-bold checking forgot-password-label"></p>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-danger text-decoration-none w-100 mt-3 forgot-button">Reset
                                Password</button>
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
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
            $("#show_hide_password_retype a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password_retype input').attr("type") == "text") {
                    $('#show_hide_password_retype input').attr('type', 'password');
                    $('#show_hide_password_retype i').addClass("fa-eye-slash");
                    $('#show_hide_password_retype i').removeClass("fa-eye");
                } else if ($('#show_hide_password_retype input').attr("type") == "password") {
                    $('#show_hide_password_retype input').attr('type', 'text');
                    $('#show_hide_password_retype i').removeClass("fa-eye-slash");
                    $('#show_hide_password_retype i').addClass("fa-eye");
                }
            });
        });

        $('input').keyup(function() {
            console.log('pass: '+$('input[name=password]').val());
            var password = $('input[name=password]').val();
            var passwordRetype = $('input[name=passwordRetype]').val();
            if (($('input[name=password]').val().length == 0) || ($('input[name=passwordRetype]').val().length == 0)) {
                // $('#password').addClass('has-error');
                $('.checking').html('<p style="color: #db162f;">Password tidak cocok </p>');
                
            } else if (password != passwordRetype) {
                $('.checking').html('<p style="color: #db162f;">Password tidak cocok </p>');
                // $('#password').addClass('has-error');
                // $('#passwordRetype').addClass('has-error');
            } else {
                $('.checking').html('<p style="color: #5cb85c;">Password cocok </p>');
                // $('#password').removeClass().addClass('has-success');
                // $('#passwordRetype').removeClass().addClass('has-success');
            }
        });
    </script>
@endsection
