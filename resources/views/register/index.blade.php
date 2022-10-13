@extends('layouts.library')

@section('container')
    {{-- {{ print_r(session()->all()) }} --}}
    <div class="register-container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                @if (session()->has('registered'))
                    <script>
                        $(window).on('load', function() {
                            setTimeout(function() {
                                $('#returnLogin').modal('show')
                            }, 10);
                        })
                    </script>
                    {{-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('registered') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div> --}}
                    <div class="modal fade mt-5" id="returnLogin" tabindex="-1" aria-labelledby="returnLoginModal"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content text-center modalConfirm">
                                <div class="modal-header border-0 pt-4 px-4 pb-0">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-5">
                                    <h5 class="modal-title mb-3" id="returnLoginModal">Gagal Mendaftar sebagai Member</h5>
                                    <p class="register-modal-p mb-0">
                                        Email/No Telepon yang ada masukkan
                                        <strong>{{ session('value') }}</strong>
                                        sudah terdaftar sebagai member. Masuk untuk lanjut berbelanja?
                                    </p>
                                </div>
                                <div class="modal-footer border-0 d-flex justify-content-center mb-3">
                                    <a type="button" href="{{ route('login') }}"
                                        class="btn btn-lg btn-danger btn-block register-modal-submit">Masuk</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col-md-6 d-flex login-left-col">
                <img class="footer-logo w-100" src="/assets/footer-logo.svg" alt="">
                {{-- <img class="" src="https://source.unsplash.com/500x500?market"> --}}
            </div>
            <div class="col-md-5 mt-5 col-12">
                <div class="card register-card border-0 mt-3">
                    <div class="card-body p-5">
                        {{-- <div class="d-flex justify-content-center mb-3">
                            <img class="footer-logo w-50" src="/assets/footer-logo.svg" alt="">
                        </div>
                        <div class="header d-flex justify-content-center">
                            <h5>Masuk</h5>
                        </div> --}}
                        <div class="header text-center mb-4">
                            <div>
                                <h5>Daftar Membership Sekarang</h5>
                            </div>
                            <div class="mx-auto">
                                <span class="register-act-login">
                                    Sudah menjadi member?
                                    <a class="text-decoration-none text-danger login-register-link" href="/login">Masuk</a>
                                </span>
                            </div>
                        </div>
                        <form action="{{ route('register.post') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="emailAddr" class="form-label login-email-label m-0 register-modal-p login-user-label">Email / No
                                    Telepon</label>
                                @if (is_null('email'))
                                    {{ $taskError = 'email' }}
                                @else
                                @endif
                                <input type="text"
                                    class="form-control shadow-none login-email-field @error('email') is-invalid @enderror @error('telp_no') is-invalid @enderror"
                                    id="emailPhone" aria-describedby="emailHelp" name="emailPhone" required
                                    value="{{ old('email') }}{{ old('telp_no') }}">

                                <div id="emailHelp" class="form-text login-email-help">Contoh: email@klikspl.com /
                                    081234567890
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
                            <div class="d-grid mt-4 mb-2">
                                <button type="button" class="btn btn-danger login-button" data-bs-toggle="modal"
                                    data-bs-target="#confirmModal" id="sendToConfirm">
                                    Daftar
                                </button>
                            </div>
                            <div class="footer">
                                <p class="text-center register-agreement-bottom">
                                    Dengan mendaftar membership, saya menyetujui
                                    <a class="text-decoration-none text-danger fw-bold" href="">Syarat dan Ketentuan</a>,
                                    serta
                                    <a class="text-decoration-none text-danger fw-bold" href="">Kebijakan Privasi</a>
                                </p>
                            </div>
                            <div class="modal fade mt-5" id="confirmModal" tabindex="-1" aria-labelledby="registerModal"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content text-center modalConfirm">
                                        <div class="modal-header border-0 pt-4 px-4 pb-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body px-5">
                                            <h5 class="modal-title mb-3" id="registerModal">Apakah email / no telepon yang
                                                anda masukkan sudah benar? </h5>
                                            <p class="register-modal-p">
                                                Kami akan mengirimkan kode verifikasi ke email / no telepon berikut
                                            </p>
                                            <input type="text"
                                                class="form-control shadow-none login-email-field border-0 text-center"
                                                id="emailPhoneConfirm" aria-describedby="emailHelp" name="emailphoneConfirm"
                                                readonly>
                                        </div>
                                        <div class="modal-footer border-0 d-flex justify-content-center mb-3">
                                            <button type="button"
                                                class="btn btn-lg btn-secondary btn-block register-modal-change"
                                                data-bs-dismiss="modal">Ubah</button>
                                            <button type="submit"
                                                class="btn btn-lg btn-danger btn-block register-modal-submit">Benar</button>
                                        </div>
                                    </div>
                                </div>
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
        $(function() {
            var $src = $('#emailPhone'),
                $dest = $('#emailPhoneConfirm'),
                $readyToConfirm = $('#sendToConfirm');
            $readyToConfirm.on('click', function() {
                $dest.val($src.val());
            });
        });
    </script>
@endsection
