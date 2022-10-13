@extends('user.layout')
{{-- @section('container') --}}
@section('account')
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
    <div class="card mb-3 profile-card">
        <div class="card-body p-4">
            <h5 class="mb-4">
                <a href="{{ route('useraddress.index') }}" class="text-decoration-none link-dark">
                    <i class="bi bi-arrow-left"></i>
                </a>
                Ubah Alamat
            </h5>
            <form class="row g-3" action="{{ route('useraddress.update', $address) }}" method="post">
                @csrf
                @method('put')
                <input type="hidden" class="form-control user-account-input shadow-none" id="user_id"
                    value="{{ auth()->user()->id }}" name="user_id" required>
                <input type="hidden" class="form-control user-account-input shadow-none" id="user_id"
                    value="{{ $address->province_ids }}" name="province_id_edit" required>
                <input type="hidden" class="form-control user-account-input shadow-none" id="user_id"
                    value="{{ $address->city_ids }}" name="city_id_edit" required>
                <input type="hidden" class="form-control user-account-input shadow-none" id="user_id"
                    value="{{ $address->postal_code }}" name="postal_code_edit" required>
                <div class="col-md-6">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text"
                        class="form-control user-account-input shadow-none @error('name') is-invalid @enderror" id="name"
                        placeholder="Nama pemilik alamat" name="name" value="{{ $address->name }}" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="telp_no" class="form-label">No Telepon</label>
                    <input type="telp_no"
                        class="form-control user-account-input shadow-none @error('telp_no') is-invalid @enderror"
                        id="telp_no" placeholder="No Telepon" name="telp_no" value="{{ $address->telp_no }}" required>
                    @error('telp_no')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="province_ids" class="form-label">Provinsi</label>
                    <div class="form-group mb-2">
                        {{-- <label class="font-weight-bold">PROVINSI TUJUAN</label> --}}
                        <select
                            class="form-control user-account-input shadow-none address-province-edit form-select shadow-none @error('province_ids') is-invalid @enderror"
                            name="province_ids" id="address-province-edit" required>
                            <option value="0">Pilih Provinsi
                            </option>
                            @foreach ($provinces as $provinceId => $value)
                                {{ $provinceId }} {{ $address->province_ids }}
                                <option value="{{ $provinceId }}">
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                        @error('province_ids')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="city_ids" class="form-label">Kabupaten/Kota</label>
                    <select
                        class="form-control user-account-input shadow-none address-city-edit form-select text-truncate @error('city_ids') is-invalid @enderror"
                        name="city_ids" required>
                        <option value="">Pilih kota</option>
                    </select>
                    @error('city_ids')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="district" class="form-label">Kecamatan</label>
                    <input type="text"
                        class="form-control user-account-input shadow-none @error('district') is-invalid @enderror"
                        id="district" placeholder="Kecamatan..." name="district" value="{{ $address->district }}"
                        required>
                    @error('district')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="postal_code" class="form-label">Kode Pos</label>
                    <select
                        class="form-control user-account-input shadow-none postal-code-edit form-select text-truncate @error('postal_code') is-invalid @enderror"
                        name="postal_code">
                        <option value="">Kode Pos</option>
                    </select>
                    @error('postal_code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control user-account-input shadow-none @error('address') is-invalid @enderror"
                        placeholder="Alamat" id="address" name="address" required>{{ $address->address }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 my-4">
                    <button type="submit" class="btn btn-danger profile-address-save-btn">Simpan Alamat</button>
                </div>
            </form>
        </div>
    </div>
@endsection
