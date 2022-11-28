@extends('user.layout')
@section('account')
    {{-- {{ print_r(session()->all()) }} --}}
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
    <h5 class="mb-4">Profil Saya</h5>
    <div class="card mb-3 profile-card">
        <div class="card-body p-4">
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <div class="row">
                <div class="col-md-8 order-2">
                    <form action="{{ route('profile.update', $user->username) }}" method="POST">
                        @method('put')
                        @csrf
                        <div class="row mb-3 align-items-center">
                            <label for="inputUsername" class="col-sm-2 col-md-3 col-form-label">Username</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text"
                                    class="form-control user-account-input bg-white border-0 ps-0 shadow-none fw-bold"
                                    id="inputUsername" value="{{ $user->username }}" disabled readonly name="username">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="inputFirstName" class="col-sm-2 col-md-3 col-form-label">Nama Depan</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text"
                                    class="form-control user-account-input shadow-none my-1 border-radius-05rem py-2 px-3 @error('firstname') is-invalid @enderror"
                                    id="inputFirstName"
                                    value="{{ !is_null($user->firstname) ? (!is_null(old('firstname')) ? old('firstname') : $user->firstname) : (!is_null(old('firstname')) ? old('firstname') : $user->firstname) }}"
                                    placeholder="Nama depan" name="firstname" required>
                                @error('firstname')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="inputFirstName" class="col-sm-2 col-md-3 col-form-label">Nama Belakang</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text"
                                    class="form-control user-account-input shadow-none my-1 border-radius-05rem py-2 px-3 @error('lastname') is-invalid @enderror"
                                    id="inputLastName"
                                    value="{{ !is_null($user->lastname) ? (!is_null(old('lastname')) ? old('lastname') : $user->lastname) : (!is_null(old('lastname')) ? old('lastname') : $user->lastname) }}"
                                    placeholder="Nama belakang" name="lastname">
                                @error('lastname')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="inputEmail" class="col-sm-2 col-md-3 col-form-label">Email</label>
                            @if (isset($user->email))
                                <input type="hidden"
                                    class="form-control user-account-input bg-white border-0 ps-0 shadow-none"
                                    id="inputEmail" value="{{ $user->email }}" placeholder="example@klikspl.com"
                                    name="email" disabled readonly>
                                <div class="col-sm-10 col-md-9">
                                    <p class="d-inline-block m-0">
                                        {{ $user->email }}
                                    </p>
                                    @if (isset($user->email))
                                        <a href="{{ route('profile.update.email') }}"
                                            class="d-inline-block text-decoration-none link-dark fw-bold text-red-klikspl">
                                            Ubah
                                        </a>
                                    @else
                                        <a href="{{ route('profile.add.email') }}"
                                            class="d-inline-block text-decoration-none link-dark fw-bold text-red-klikspl">
                                            Tambah
                                        </a>
                                    @endif
                                </div>
                            @else
                                <div class="col-sm-10 col-md-5">
                                    <a href="{{ route('profile.add.email') }}" class="text-decoration-none link-dark fw-bold add-email">Tambah</a>
                                </div>
                            @endif
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="inputNoTelepon" class="col-sm-2 col-md-3 col-form-label">Nomor Telepon</label>
                            @if (isset($user->telp_no))
                                <input type="hidden"
                                    class="form-control user-account-input bg-white border-0 ps-0 shadow-none"
                                    id="inputNoTelepon" value="{{ $user->telp_no }}" placeholder="081234567890"
                                    name="telp_no" disabled readonly>
                                <div class="col-sm-10 col-md-4">
                                    <p class="d-inline-block m-0">
                                        {{ $user->telp_no }}
                                    </p>
                                    <a href="{{ route('profile.update.phone') }}" class="d-inline-block text-decoration-none link-dark fw-bold text-red-klikspl">
                                        Ubah
                                    </a>
                                </div>
                            @else
                                <div class="col-sm-10 col-md-5">
                                    <a href="{{ route('profile.add.phone') }}" class="text-decoration-none link-dark fw-bold text-red-klikspl">Tambah</a>
                                </div>
                            @endif
                        </div>
                        <fieldset class="row mb-3 align-items-center">
                            <legend class="col-form-label col-sm-2 col-md-3 pt-0">Jenis Kelamin</legend>
                            <div class="col-sm-10 col-md-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input form-gender shadow-none" type="radio" name="gender"
                                        id="genderM" value="M" {{ $user->gender == 'M' ? 'checked' : '' }}
                                        {{ !is_null($user->gender) && $user->gender == 'M' ? (!is_null(old('gender')) && old('gender') == 'M' ? 'checked' : 'checked') : (!is_null(old('gender')) && old('gender') == 'M' ? 'checked' : '') }}
                                        required>
                                    <label class="form-check-label" for="genderM">
                                        Pria
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input form-gender shadow-none" type="radio" name="gender"
                                        id="genderF" value="F" {{ $user->gender == 'F' ? 'checked' : '' }}
                                        {{ !is_null($user->gender) && $user->gender == 'F' ? (!is_null(old('gender')) && old('gender') == 'F' ? 'checked' : 'checked') : (!is_null(old('gender')) && old('gender') == 'F' ? 'checked' : '') }}>
                                    <label class="form-check-label" for="genderF">
                                        Wanita
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <div class="row mb-3 align-items-center">
                            <label for="inputBirthDate" class="col-sm-2 col-md-3 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="date"
                                    class="form-control user-account-input shadow-none border-radius-05rem py-2 px-3"
                                    id="inputBirthDate"
                                    value="{{ !is_null($user->birthdate) ? (!is_null(old('birthdate')) ? old('birthdate') : $user->birthdate) : (!is_null(old('birthdate')) ? old('birthdate') : $user->birthdate) }}"
                                    name="birthdate" required>
                            </div>
                            {{-- {{ date("d/m/Y", strtotime($user->birthdate)) }}
                            {{ date("d/m/Y", strtotime(old('birthdate'))) }} --}}
                        </div>
                        <div class="row text-end">
                            <div class="col-12">
                                <button type="submit" class="btn btn-danger user-account-submit mb-3">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 order-1 order-md-2 mb-3">
                    <div class="card profile-image-card">
                        <div class="card-body">
                            @if ($user->profile_image)
                                <img class="w-100 user-account-profile-img"
                                    src="{{ asset('/storage/' . $user->profile_image) }}" alt="">
                            @else
                                <img class="w-100 user-account-profile-img" src="{{ asset('/assets/avatars.svg') }}"
                                    alt="">
                            @endif
                            <div class="col-12 d-grid my-2">
                                <div class="btn user-account-profile-img-btn btn-secondary">
                                    Pilih Foto
                                    <input class="user-account-profile-img-file" type="file" name="profileImage"
                                        id="profileImage">
                                </div>
                            </div>
                            @if (auth()->user()->profile_image)
                                <div class="col-12 my-2">
                                    <form action="{{ route('profile.image.delete') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-danger user-account-profile-img-btn">Hapus
                                                Foto Profil</button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            <div class="show-before-upload d-grid">
                            </div>
                            <span>
                                Ukuran gambar maks: 2MB
                            </span>
                            <span>
                                Format file: .JPG .JPEG .PNG
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="upload-img-user-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="previewImgUserModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewImgUserModal">Unggah Foto Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <!--  default image where we will set the src via jquery-->
                                <img id="image-user" class="img-user">
                            </div>
                            <div class="col-md-4">
                                <div class="preview-img-user"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary fs-14" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger fs-14" id="upload-profile-img">Upload</button>
                </div>
            </div>
        </div>
    </div>
    {{-- <a href="https://google.com/" style="color: #ffffff; font-weight: 500; text-decoration: none; background-color: #db162f; padding: 10px 30px 10px 30px; border-radius: 10px; ,margin: 100px">Masuk</a> --}}
    <script>
        inputBirthDate.max = new Date().toISOString().split("T")[0];
    </script>
@endsection
