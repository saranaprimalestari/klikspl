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
                                <div class="row">
                                    <div class="col-md-12 col-12 text-center">
                                        <h5 class="">Kirim Kode OTP</h5>
                                    </div>
                                </div>
                                <div>
                                    <span class="d-flex justify-content-center">
                                    </span>
                                </div>
                                <div class="text-center">
                                    <span class="register-act-login">
                                        Kode OTP digunakan demi keamanan akun anda.
                                    </span>
                                </div>
                            </div>
                            <form action="{{ route('profile.change.email.post') }}" method="POST">
                                @csrf
                                <input type="hidden" name="value" value="{{ auth()->user()->email }}">
                                <button type="submit" class="text-decoration-none text-dark border-0 bg-transparent w-100">
                                    <div class="card login-card register-act-login shadow-none">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-9 text-start">
                                                    <p>
                                                        <strong>
                                                            kirim Kode OTP
                                                        </strong>
                                                    </p>
                                                    <p>
                                                        {{ auth()->user()->email }}
                                                    </p>
                                                </div>
                                                <div class="col-md-3 d-flex align-items-center">
                                                        <i class="bi bi-envelope fs-1"></i>
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
        </div>
    </div>
@endsection
