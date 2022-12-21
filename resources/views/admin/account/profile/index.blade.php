@extends('admin.layouts.main')
@section('container')
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
            <input type="hidden" name="admin_id" value="{{ auth()->guard('adminMiddle')->user()->id }}">
            <div class="row">
                <div class="col-md-12 order-2">
                    <form action="{{ route('adminprofile.update', $admin) }}" method="POST">
                        @method('put')
                        @csrf
                        <div class="row mb-3 align-items-center">
                            <label for="inputUsername" class="col-sm-2 col-md-2 col-form-label">
                                Username
                            </label>
                            <div class="col-sm-10 col-md-10">
                                <input type="text"
                                    class="form-control user-account-input bg-white border-0 ps-0 shadow-none fw-bold"
                                    id="inputUsername" value="{{ $admin->username }}" disabled readonly name="username">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="inputAdminType" class="col-sm-2 col-md-2 col-form-label">
                                Tipe / Jenis Admin
                            </label>
                            <div class="col-sm-10 col-md-10">
                                <input type="text"
                                    class="form-control user-account-input bg-white border-0 ps-0 shadow-none fw-bold"
                                    id="inputAdminType" value="{{ $admin->admintype->admin_type }}" disabled readonly name="adminType">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="inputCompany" class="col-sm-2 col-md-2 col-form-label">
                                Perusahaan
                            </label>
                            <div class="col-sm-10 col-md-10">
                                <input type="text"
                                    class="form-control user-account-input bg-white border-0 ps-0 shadow-none fw-bold"
                                    id="inputCompany" value="{{ auth()->guard('adminMiddle')->user()->admin_type != 1 ? ($admin->company->name) : 'SUPER ADMIN' }}" disabled readonly name="company">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="inputFirstName" class="col-sm-2 col-md-2 col-form-label">
                                Nama Depan
                            </label>
                            <div class="col-sm-10 col-md-10">
                                <input type="text"
                                    class="form-control user-account-input shadow-none my-1 border-radius-05rem py-2 px-3 @error('firstname') is-invalid @enderror"
                                    id="inputFirstName"
                                    value="{{ !is_null($admin->firstname) ? (!is_null(old('firstname')) ? old('firstname') : $admin->firstname) : (!is_null(old('firstname')) ? old('firstname') : $admin->firstname) }}"
                                    placeholder="Nama depan" name="firstname" required>
                                @error('firstname')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="inputFirstName" class="col-sm-2 col-md-2 col-form-label">
                                Nama Belakang
                            </label>
                            <div class="col-sm-10 col-md-10">
                                <input type="text"
                                    class="form-control user-account-input shadow-none my-1 border-radius-05rem py-2 px-3 @error('lastname') is-invalid @enderror"
                                    id="inputLastName"
                                    value="{{ !is_null($admin->lastname) ? (!is_null(old('lastname')) ? old('lastname') : $admin->lastname) : (!is_null(old('lastname')) ? old('lastname') : $admin->lastname) }}"
                                    placeholder="Nama belakang" name="lastname">
                                @error('lastname')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="inputEmail" class="col-sm-2 col-md-2 col-form-label">
                                Email
                            </label>
                            <div class="col-sm-10 col-md-10">
                                <input type="text"
                                    class="form-control user-account-input shadow-none my-1 border-radius-05rem py-2 px-3 @error('email') is-invalid @enderror"
                                    id="inputEmail"
                                    value="{{ !is_null($admin->email) ? (!is_null(old('email')) ? old('email') : $admin->email) : (!is_null(old('email')) ? old('email') : $admin->email) }}"
                                    placeholder="Email" name="email">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="inputTelpNo" class="col-sm-2 col-md-2 col-form-label">
                                Nomor Telepon
                            </label>
                            <div class="col-sm-10 col-md-10">
                                <input type="text"
                                    class="form-control user-account-input shadow-none my-1 border-radius-05rem py-2 px-3 @error('telp_no') is-invalid @enderror"
                                    id="inputTelpNo"
                                    value="{{ !is_null($admin->telp_no) ? (!is_null(old('telp_no')) ? old('telp_no') : $admin->telp_no) : (!is_null(old('telp_no')) ? old('telp_no') : $admin->telp_no) }}"
                                    placeholder="Nama belakang" name="telp_no">
                                @error('telp_no')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-danger user-account-submit mb-3">Simpan</button>
                        </div>
                    </form>
                </div>
                {{-- <div class="col-md-4 order-1 order-md-2 mb-3">
                    <div class="card profile-image-card">
                        <div class="card-body">
                            @if ($admin->profile_image)
                                <img class="w-100 user-account-profile-img"
                                    src="{{ asset('/storage/' . $admin->profile_image) }}" alt="">
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
                </div> --}}
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
