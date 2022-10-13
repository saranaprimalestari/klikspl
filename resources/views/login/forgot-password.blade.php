@extends('layouts.library')

@section('container')
    {{-- {{ print_r(session()->all()) }} --}}
    <div class="login-container">

        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                @if (session()->has('failed'))
                    <script>
                        $(window).on('load', function() {
                            setTimeout(function() {
                                $('#forgotPassword').modal('show')
                            }, 10);
                        })
                    </script>
                    {{-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('registered') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div> --}}
                    <div class="modal fade mt-5" id="forgotPassword" tabindex="-1" aria-labelledby="returnForgotPassModal"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content text-center modalConfirm">
                                <div class="modal-header border-0 pt-4 px-4 pb-0">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-5">
                                    <h5 class="modal-title mb-3" id="returnForgotPassModal">Email Tidak Terdaftar</h5>
                                    <p class="register-modal-p mb-0">
                                        Email atau No Telepon yang ada masukkan
                                        <strong>{{ session('value') }}</strong>
                                        tidak terdaftar sebagai member. Pastikan kembali apakah email atau No Telepon sudah benar
                                    </p>
                                </div>
                                <div class="modal-footer border-0 d-flex justify-content-center mb-3">
                                    {{-- <a type="button" href="{{ route('login') }}"
                                        class="btn btn-lg btn-danger btn-block register-modal-submit">Masuk</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

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
                                <div class="col-md-1 col-2">
                                    <a class="text-dark fw-bold" href="{{ route('login') }}" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Kembali ke tahap sebelumnya">
                                        <strong>
                                            <i class="bi bi-arrow-left"></i>
                                        </strong>
                                    </a>
                                </div>
                                <div class="col-md-11 col-10">
                                    <h5 class="">Reset Password</h5>
                                </div>
                            </div>
                            <div>
                                <span class="d-flex justify-content-center">
                                </span>
                            </div>
                            <div class="text-start">
                                <span class="register-act-login">
                                    Masukkan email atau nomor telepon yang terdaftarkan. Kode verifikasi akan dikirimkan
                                    untuk reset password
                                </span>
                            </div>
                        </div>
                        <form class="mt-1" method="POST" action="{{ route(' m.password.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="forgot-password-email-telpno"
                                    class="form-label login-user-label m-0 @error('email') is-invalid @enderror @error('telp_no') is-invalid @enderror">Alamat
                                    Email atau No Telepon</label>
                                <input type="text" class="form-control shadow-none login-user-field"
                                    id="forgot-password-email-telpno" aria-describedby="loginHelp" name="user" required
                                    value="{{ old('email') }}{{ old('telp_no') }}">
                                <div id="loginHelp" class="form-text login-user-help">
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                @error('telp_no')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="d-grid mt-4 mb-3">
                                <button type="submit" class="btn btn-danger login-button">
                                    Selanjutnya
                                </button>
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
@endsection
