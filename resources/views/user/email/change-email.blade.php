
@extends('user.layout')
@section('account')
    <div class="card mb-3 profile-card">
        <div class="card-body p-4">
            {{-- <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ url()->previous() }}" class="text-decoration-none link-dark">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div> --}}
            <h5>
                {{ $act == 'add' ? 'Tambahkan' : ($act == 'change' ? 'Ubah' : '') }}
                {{ isset($email) ? 'Email' : (isset($telp_no) ? 'No.Telepon' : '') }}
            </h5>
            <form action="{{ route('profile.change.email.new.prepost') }}" class="" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <div class="row my-4 align-items-center">
                    <label for="email" class="col-sm-2 col-md-3 col-form-label">Email</label>
                    <div class="col-sm-10 col-md-9">
                        <div class="input-group" id="show_hide_password">
                            <input type="email" class="form-control user-account-input shadow-none border-radius-05rem py-2 px-3 @error('email') is-invalid @enderror" id="email" name="email" required value="" autocomplete="off" placeholder="contoh: klikspl@example.com">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button id="add-phone-btn" type="submit"
                    class="btn btn-danger add-phone-button fs-14">Selanjutnya</button>
            </form>
        </div>
    </div>
@endsection
