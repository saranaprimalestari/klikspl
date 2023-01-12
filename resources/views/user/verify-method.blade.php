@extends('user.layout')
@section('account')
    <div class="row">
        <div class="col-12">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show alert-success-cart mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('failed'))
                <div class="alert alert-danger alert-dismissible fade show alert-success-cart mb-4" role="alert">
                    {{ session('failed') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
    {{-- {{ dd(session()->all()) }} --}}
    {{-- {{ $verificationCode }} --}}
    <h5 class="mb-4">
        {{ $act == 'add' ? 'Tambahkan' : ($act == 'update' ? 'Ubah' : '') }}
        {{ $type }}
    </h5>
    <div class="card mb-3 border-radius-075rem fs-14">
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
                                        Kode OTP digunakan untuk verifikasi
                                        {{ isset($email) ? 'Email' : (isset($telp_no) ? 'No.Telepon' : '') }}
                                        anda.
                                    </span>
                                </div>
                            </div>
                            @if (isset($email))
                                <form action="{{ route($route) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="username" value="{{ auth()->user()->username }}">
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <input type="hidden" name="verificationCode" value="{{ $verificationCode }}">
                                    <button type="submit"
                                        class="text-decoration-none text-dark border-0 bg-transparent w-100 px-0">
                                        <div class="card border-radius-075rem">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-md-9 col-9 text-start">
                                                        <p class="m-0">
                                                            <strong>
                                                                kirim Email ke:
                                                            </strong>
                                                        </p>
                                                        <p class="m-0">
                                                            {{ $email }}
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="col-md-3 col-3 d-flex align-items-center justify-content-center pe-4">
                                                        <i class="bi bi-envelope fs-1"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                            @elseif (isset($telp_no))
                                {{-- <form action="{{ route($route) }}" method="POST" class="">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="username" value="{{ auth()->user()->username }}">
                                    <input type="hidden" name="telp_no" value="{{ $telp_no }}">
                                    <input type="hidden" name="verificationCode" value="{{ $verificationCode }}">
                                    <button type="submit"
                                        class="text-decoration-none text-dark border-0 bg-transparent w-100 px-0">
                                        <div class="card border-radius-075rem mb-3 box-shadow">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-md-9 col-9 text-start">
                                                        <p class="m-0">
                                                            <strong>
                                                                Kirim SMS ke
                                                            </strong>
                                                        </p>
                                                        <p class="m-0">
                                                            {{ $telp_no }}
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="col-md-3 col-3 d-flex align-items-center justify-content-center pe-4">
                                                        <i class="bi bi-chat-left-text fs-1"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </form> --}}
                                <form action="{{ route($route) }}" method="POST" class="phone-verify-method-form">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="username" value="{{ auth()->user()->username }}">
                                    <input type="hidden" name="telp_no" value="{{ $telp_no }}">
                                    <input type="hidden" name="verificationCode" value="{{ $verificationCode }}">
                                    <a href="https://wa.me/628115102888?text=Halo+{{ auth()->user()->firstname }}+{{ auth()->user()->lastname }}%2C%0D%0ASilakan+masukkan+kode+berikut+untuk+verifikasi+nomor+telepon+yang+kamu+tambahkan%0D%0A%0D%0A%2A{{ $verificationCode }}%2A%0D%0A%0D%0AKode+diatas+bersifat+rahasia+dan+jangan+sebarkan+kode+kepada+siapapun.%0D%0A%0D%0Aatau+kamu+dapat+klik+link+berikut+untuk+melanjutkan+verifikasi.%0D%0A%0D%0A{{ urlencode(route($waRoute)) }}%3F_token%3D{{ csrf_token() }}%26id%3D{{ auth()->user()->id }}%26username%3D{{ auth()->user()->username }}%26telp_no%3D{{ $telp_no }}%26verificationCode%3D{{ $verificationCode }}%26linkVerification%3D1%0D%0A%0D%0APesan+ini+dibuat+otomatis%2C+jika+membutuhkan+bantuan%2C+silakan+hubungi+ADMIN+KLIKSPL+dengan+link+berikut%3A%0D%0Ahttps%3A%2F%2Fwa.me%2F628115102888"
                                        target="_blank" class="text-decoration-none link-dark send-wa-otp">
                                        <div class="card border-radius-075rem box-shadow">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-md-9 col-9 text-start">
                                                        <p class="m-0">
                                                            <strong>
                                                                kirim Pesan Whatsapp ke
                                                            </strong>
                                                        </p>
                                                        <p class="m-0">
                                                            {{ $telp_no }}
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="col-md-3 col-3 d-flex align-items-center justify-content-center pe-4">
                                                        <i class="bi bi-whatsapp fs-1"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </form>
                            @endif
                            {{-- </button> --}}
                            {{-- </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.send-wa-otp').click(function() {
                $('.phone-verify-method-form').submit();
            })
        })
    </script>
@endsection
