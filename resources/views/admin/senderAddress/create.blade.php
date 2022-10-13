@extends('admin.layouts.main')
@section('container')
    <div class="col-12">
        <h5 class="mb-4">
            <a href="{{ route('senderaddress.index') }}" class="text-decoration-none link-dark">
                <i class="bi bi-arrow-left"></i>
            </a>
            Tambahkan Alamat Pengiriman Baru
        </h5>
        <div class="card mb-3 border-0 border-radius-1-5rem fs-14">
            <div class="card-body p-4">
                <form class="row g-3" action="{{ route('senderaddress.store') }}" method="post">
                    @csrf
                    {{-- <input type="hidden" class="form-control user-account-input shadow-none" id="user_id" value="{{ auth()->user()->id }}" name="user_id" required> --}}
                    <input type="hidden" class="form-control user-account-input shadow-none" id="is_active" value="1"
                        name="is_active" required>
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama Pengirim</label>
                        <input type="text"
                            class="form-control user-account-input shadow-none @error('name') is-invalid @enderror"
                            id="name" placeholder="Nama pemilik alamat" name="name" required>
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
                            id="telp_no" placeholder="No Telepon" name="telp_no" required>
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
                                class="form-control user-account-input shadow-none address-province form-select shadow-none @error('province_ids') is-invalid @enderror"
                                name="province_ids" required>
                                <option value="0">Pilih Provinsi
                                </option>
                                @foreach ($provinces as $provinceId => $value)
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
                            class="form-control user-account-input shadow-none address-city form-select text-truncate @error('city_ids') is-invalid @enderror"
                            name="city_ids" required>
                            <option value="">Pilih provinsi terlebih dahulu</option>
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
                            id="district" placeholder="Kecamatan..." name="district" required>
                        @error('district')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="postal_code" class="form-label">Kode Pos</label>
                        <select
                            class="form-control user-account-input shadow-none postal-code form-select text-truncate @error('postal_code') is-invalid @enderror"
                            name="postal_code">
                            <option value="">Pilih provinsi dan kota terlebih dahulu</option>
                        </select>
                        @error('postal_code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="address" class="form-label">Alamat Lengkap Pengirim</label>
                        <textarea class="form-control user-account-input shadow-none @error('address') is-invalid @enderror"
                            placeholder="Tuliskan alamat lengkap disertai nomor rumah, gang/blok, RT dan RW untuk memudahakan kurir pengirim menemukan alamat kamu"
                            id="address" name="address" rows="3" required></textarea>
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 mt-4 mb-2">
                        <button type="submit" class="btn btn-danger profile-address-save-btn">Simpan Alamat</button>
                    </div>
                </form>
                </form>
            </div>
        </div>
    @endsection
