@extends('admin.layouts.main')
@section('container')
    {{-- {{ dd($admin) }} --}}
    {{-- {{ print_r(session()->all()) }} --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show alert-notification" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session()->has('failed'))
        <div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">
            {{ session('failed') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        {!! implode(
            '',
            $errors->all(
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">:message<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
            ),
        ) !!}
    @endif
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-md-3 pt-5 mb-1">
        <h4 class="m-0">
            <a href="{{ route('management.index') }}" class="text-decoration-none link-dark">
                <i class="bi bi-arrow-left"></i>
            </a>
            Edit Data Admin
        </h4>
    </div>
    <form action="{{ route('management.update', $admin) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="container p-0 mb-4">
            <div class="card product-info-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Informasi Admin</h5>
                        <p class="text-grey fs-13 m-0">Isikan username, nama depan, nama belakang, tipe, perusahaan, no
                            telepon, dan email</p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-3 row">
                        <label for="username" class="col-sm-3 col-form-label fw-600">
                            Username <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input required type="text"
                                class="form-control fs-14 @error('username') is-invalid @enderror" id="username"
                                name="username" placeholder="Ketikkan username" value="{{ $admin->username }}{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="productCode" class="col-sm-3 col-form-label">
                            <p class="fw-600 m-0">
                                Nama depan / belakang
                            </p>
                            <p class="text-grey fs-12 m-0">nama depan dan belakang boleh dikosongkan</p>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control fs-14 @error('firstname') is-invalid @enderror"
                                id="firstName" name="firstname" placeholder="Ketikkan nama depan"
                                value="{{ $admin->firstname }}{{ old('firstname') }}">
                            @error('firstname')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-1 text-center mt-2">
                            <i class="bi bi-slash-lg"></i>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control fs-14 @error('lastname') is-invalid @enderror"
                                id="lastName" name="lastname" placeholder="Ketikkan nama belakang"
                                value="{{ $admin->lastname }}{{ old('lastname') }}">
                            @error('lastname')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="adminType" class="col-sm-3 col-form-label fw-600">
                            Tipe Admin <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select required
                                class="form-control shadow-none admin-product-category form-select shadow-none fs-14 @error('admin_type') is-invalid @enderror"
                                id="adminType" name="admin_type">
                                <option value="" class="fs-14">Tipe Admin
                                </option>
                                @foreach ($adminTypes as $adminType)
                                    <option class="fs-14" value="{{ $adminType->id }}" {{ ($admin->admin_type == $adminType->id) ? 'selected' : '' }}>
                                        {{ $adminType->admin_type }}</option>
                                @endforeach
                            </select>
                            @error('admin_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="company" class="col-sm-3 col-form-label fw-600">
                            Perusahaan <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control shadow-none admin-product-merk form-select shadow-none fs-14 @error('company_id') is-invalid @enderror"
                                name="company_id">
                                <option value="" class="fs-14">Perusahaan
                                </option>
                                @foreach ($companies as $company)
                                    <option class="fs-14" value="{{ $company->id }}" {{ ($admin->company_id == $company->id) ? 'selected' : '' }}>
                                        {{ $company->name }}</option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="telp_no" class="col-sm-3 col-form-label fw-600">
                            Nomor Telepon
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control fs-14 @error('telp_no') is-invalid @enderror"
                                id="telp_no" name="telp_no" placeholder="Contoh: 081234567890"
                                value="{{ $admin->telp_no }}{{ old('telp_no') }}">
                            @error('telp_no')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-3 col-form-label fw-600">
                            Email <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input required type="text" class="form-control fs-14 @error('email') is-invalid @enderror"
                                id="email" name="email" placeholder="contoh: email@klikspl.com"
                                value="{{ $admin->email }}{{ !is_null(old('email')) ? '' : old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-sm-3 col-form-label fw-600">
                            Password
                        </label>
                        <div class="col-sm-9">
                            <div class="input-group" id="show_hide_password">
                                <input type="password"
                                    class="form-control fs-14 @error('password') is-invalid @enderror" id="password"
                                    name="password" placeholder="Ketikkan password" value="{{ old('password') }}">
                                <span class="input-group-text bg-transparent border-left-0" id=""><a
                                        href="" class="text-dark"><i class="fa fa-eye-slash"
                                            aria-hidden="true"></i></a>
                                </span>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container product-shipment-origin-container p-0 mb-4">
            <div class="card product-shipment-origin-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Lokasi Pengiriman</h5>
                        <p class="text-grey fs-13 m-0">Pilih lokasi pengiriman untuk melihat dan mengelola pesanan yang masuk</p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="chk_option_error text-danger fs-14 fw-600 mb-2">
                        Pilih setidaknya satu alamat pengiriman!
                    </div>
                    @foreach ($senderAddresses as $sender)
                        {{-- {{ $loop->index }} --}}
                        <div class="mb-3 form-check">
                            {{-- <input type="hidden" name="sender_address[{{ $loop->index }}]"
                                value="{{ $sender->city_ids }}"> --}}
                            <input type="checkbox" class="form-check-input @error('sender') is-invalid @enderror"
                                id="{{ $sender->id }}" name="sender_address_id[{{ $loop->index }}]"
                                value="{{ $sender->id }}" 
                                @foreach ($admin->adminsenderaddress as $senderAddress)
                                    {{ ($senderAddress->sender_address_id == $sender->id) ? 'checked' : '' }}    
                                @endforeach>
                            <label class="form-check-label" for="{{ $sender->id }}">
                                <p class="fw-600 m-0">{{ $sender->name }}</p>
                                <p class="m-0">{{ $sender->address }}</p>
                                <div class="d-flex">
                                    <p class="m-0">
                                        {{ $sender->city->name }},
                                    </p>
                                    <p class="m-0">
                                        {{ $sender->province->name }},
                                    </p>
                                    <p class="m-0">
                                        {{ $sender->postal_code }}
                                    </p>
                                </div>
                                <p class="m-0">{{ $sender->telp_no }}</p>
                            </label>
                        </div>
                    @endforeach
                    <div>
                        @if ($errors->has('sender_address_id'))
                            <div class="error text-danger fw-600">
                                {{ $errors->first('sender') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="container p-0 mb-5 pb-5">
            <div class="row">
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-danger fs-14  ">
                        <i class="far fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </form>
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
        });
    </script>
@endsection
