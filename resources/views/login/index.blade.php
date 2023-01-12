@extends('layouts.library')

@section('container')
    {{-- {{ print_r(session()->all()) }} --}}
    <div class="login-container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 col-lg-6 d-flex login-left-col mt-4 mt-lg-0 mt-xl-0 px-5 px-lg-0 px-xl-0">
                <img class="footer-logo w-100" src="/assets/footer-logo.svg" alt="">
                {{-- <img class="" src="https://source.unsplash.com/500x500?market"> --}}
            </div>
            <div class="col-md-8 col-lg-5 mt-5 ms-lg-5">
                @if (session()->has('loginError'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('loginError') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card login-card border-0 mt-3">
                    <div class="card-body p-5">
                        {{-- <div class="d-flex justify-content-center mb-3">
                            <img class="footer-logo w-50" src="/assets/footer-logo.svg" alt="">
                        </div>
                        <div class="header d-flex justify-content-center">
                            <h5>Masuk</h5>
                        </div> --}}
                        <div class="header d-flex mb-4">
                            <div>
                                <h5>Masuk</h5>
                            </div>
                            <div class="ms-auto">
                                {{-- <a class="text-decoration-none text-danger login-register-link" href="/register">Daftar Membership</a> --}}
                            </div>
                        </div>
                        <form class="mt-1 user-login-form" method="POST" action="/login">
                            @csrf
                            <div class="mb-3">
                                <label for="login-user" class="form-label login-user-label m-0">Alamat Email/ Username</label>
                                <input type="text" class="form-control shadow-none login-user-field" id="login-user"
                                    aria-describedby="loginHelp" name="user">
                                <div id="loginHelp" class="form-text login-user-help">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label login-password-label m-0">Password</label>
                                {{-- <input type="password" class="form-control shadow-none login-password-field" id="password" name="password"> --}}
                                <div class="input-group" id="show_hide_password">
                                    <input type="password"
                                        class="form-control shadow-none login-password-field @error('password') is-invalid @enderror border-end-0"
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
                            </div>
                            <div class="d-grid mt-4 mb-2">
                                <div class="d-flex mb-3">
                                    <div class="me-auto">
                                        <div class="form-check fs-13">
                                            <input type="checkbox" class="form-check-input rememberMe-checkbox shadow-none" id="rememberMe" name="remember" value="1">
                                            <label class="form-check-label" for="rememberMe">Ingat saya</label>
                                        </div>
                                    </div>
                                    <div class="">
                                        <a class="text-decoration-none text-danger login-forgot-password"
                                            href="{{ route('forgot.password') }}">Lupa
                                            password?</a>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-danger login-button submit-button">
                                    Masuk
                                </button>
                            </div>
                            <div class="footer">
                                <p class="text-center login-register-bottom fs-12">
                                    ingin menjadi member?
                                    <a class="text-decoration-none text-danger fw-bold" href="/register">Daftar sekarang!</a>
                                    Apa saja kelebihan menjadi member?
                                    <a class="text-decoration-none text-danger fw-bold" href="">lihat disini</a>
                                </p>
                            </div>
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
            $('.user-login-form').submit(function(e){
                console.log(e);
                $('.login-button').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                $('.login-button').attr('disabled', true);
            })
        });
    </script>
@endsection
