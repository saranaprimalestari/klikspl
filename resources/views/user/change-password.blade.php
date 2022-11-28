@extends('user.layout')
@section('account')
    <div class="mb-4">
        <div class="col-12">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show alert-success-cart" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('failed'))
                <div class="alert alert-danger alert-dismissible fade show alert-success-cart" role="alert">
                    {{ session('failed') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
    <h5>Ubah Password</h5>
    <p class="fs-12 text-grey">Demi keamanan akun anda disarankan untuk mengganti password secara berkala, dan
        jangan beritahukan password kepada siapapun!</p>
    <div class="card mb-3 profile-card">
        <div class="card-body p-4">
            <form action="{{ route('change.password.post') }}" class="" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <div class="row mb-3 align-items-center">
                    <label for="oldPassword" class="col-sm-2 col-md-3 col-form-label">Password Saat ini</label>
                    <div class="col-sm-10 col-md-9">
                        <div class="input-group" id="show_hide_password">
                            <input type="password"
                                class="form-control user-account-input shadow-none border-radius-05rem py-2 px-3 @error('oldPassword') is-invalid @enderror"
                                id="oldPassword" name="oldPassword" required value="" autocomplete="off">
                            <span class="input-group-text bg-transparent border-left-0" id="showPass"><a href=""
                                    class="text-dark"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </span>
                            @error('oldPassword')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <label for="newPassword" class="col-sm-2 col-md-3 col-form-label">Password Baru</label>
                    <div class="col-sm-10 col-md-9">
                        <div class="input-group" id="show_hide_password_new">
                            <input type="password"
                                class="form-control user-account-input shadow-none border-radius-05rem py-2 px-3 @error('newPassword') is-invalid @enderror"
                                id="newPassword" name="newPassword" required value="" autocomplete="off">
                            <span class="input-group-text bg-transparent border-left-0" id="showPass"><a href=""
                                    class="text-dark"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </span>
                            @error('newPassword')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <label for="confirmPassword" class="col-sm-2 col-md-3 col-form-label">Konfirmasi Password</label>
                    <div class="col-sm-10 col-md-9">
                        <div class="input-group" id="show_hide_password_retype">
                            <input type="password"
                                class="form-control user-account-input shadow-none border-radius-05rem py-2 px-3 @error('confirmPassword') is-invalid @enderror"
                                id="confirmPassword" name="confirmPassword" required value="" autocomplete="off">
                            <span class="input-group-text bg-transparent border-left-0" id="showPass"><a href=""
                                    class="text-dark"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </span>
                            @error('confirmPassword')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-1 align-items-center">
                    <div class="col-md-3"></div>
                    <div class="col-12 col-md-9 mb-2">
                        <div class="mt-2">
                            <p class="fw-bold checking forgot-password-label m-0"></p>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <a href="" class="btn btn-outline-secondary reset-password-button my-2 fs-14">
                        Lupa Password
                    </a>
                    <button id="reset-button" type="submit"
                        class="btn btn-danger reset-password-button my-2 fs-14">Simpan</button>
                </div>
            </form>
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
            $("#show_hide_password_new a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password_new input').attr("type") == "text") {
                    $('#show_hide_password_new input').attr('type', 'password');
                    $('#show_hide_password_new i').addClass("fa-eye-slash");
                    $('#show_hide_password_new i').removeClass("fa-eye");
                } else if ($('#show_hide_password_new input').attr("type") == "password") {
                    $('#show_hide_password_new input').attr('type', 'text');
                    $('#show_hide_password_new i').removeClass("fa-eye-slash");
                    $('#show_hide_password_new i').addClass("fa-eye");
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

        $('input[name=newPassword]').add('input[name=oldPassword]').add('input[name=confirmPassword]').keyup(function() {
            console.log('pass: ' + $('input[name=newPassword]').val());
            console.log('pass: ' + $('input[name=confirmPassword]').val());
            var password = $('input[name=newPassword]').val();
            var confirmPassword = $('input[name=confirmPassword]').val();
            if (($('input[name=newPassword]').val().length == 0) || ($('input[name=confirmPassword]').val()
                    .length == 0)) {
                // $('#password').addClass('has-error');
                $('.checking').html('<p class="m-0" style="color: #db162f;">Password tidak cocok </p>');
                document.getElementById("reset-button").disabled = true;

            } else if (password != confirmPassword) {
                $('.checking').html('<p class="m-0" style="color: #db162f;">Password tidak cocok </p>');
                // $('#password').addClass('has-error');
                // $('#confirmPassword').addClass('has-error');
                document.getElementById("reset-button").disabled = true;

            } else {
                $('.checking').html('<p class="m-0" style="color: #5cb85c;">Password cocok </p>');
                // $('#password').removeClass().addClass('has-success');
                // $('#confirmPassword').removeClass().addClass('has-success');
                document.getElementById("reset-button").disabled = false;
            }

            if (($('input[name=oldPassword]').val()) == ($('input[name=newPassword]').val())) {
                // $('#password').addClass('has-error');
                $('.checking').html(
                    '<p class="m-0" style="color: #db162f;">PASSWORD baru tidak boleh sama dengan PASSWORD saat ini! </p>'
                );
                document.getElementById("reset-button").disabled = true;
            }
        });
    </script>
@endsection
