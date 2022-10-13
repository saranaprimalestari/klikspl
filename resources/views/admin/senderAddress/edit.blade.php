@extends('admin.layouts.main')
@section('container')
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
    <h5 class="mb-4">
        <a href="{{ route('senderaddress.index') }}" class="text-decoration-none link-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        Ubah Alamat
    </h5>
    <div class="card mb-3 border-radius-1-5rem border-0 fs-14">
        <div class="card-body p-4">
            <form class="row g-3" action="{{ route('senderaddress.update', $address) }}" method="post">
                @csrf
                @method('put')
                <input type="hidden" class="form-control user-account-input shadow-none" id="user_id"
                    value="{{ $address->province_ids }}" name="province_id_edit" required>
                <input type="hidden" class="form-control user-account-input shadow-none" id="user_id"
                    value="{{ $address->city_ids }}" name="city_id_edit" required>
                <input type="hidden" class="form-control user-account-input shadow-none" id="user_id"
                    value="{{ $address->postal_code }}" name="postal_code_edit" required>
                <div class="col-md-6">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text"
                        class="form-control user-account-input shadow-none @error('name') is-invalid @enderror"
                        id="name" placeholder="Nama pemilik alamat" name="name" value="{{ $address->name }}"
                        required>
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
                                {{-- {{ $provinceId }} {{ $address->province_ids }} --}}
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
                    <input type="text"
                        class="form-control user-account-input shadow-none @error('postal_code') is-invalid @enderror"
                        id="postal_code" placeholder="Kode Pos..." name="postal_code" value="{{ $address->postal_code }}"
                        required>
                    @error('postal_code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="address" class="form-label">Alamat Lengkap Pengirim</label>
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
    <script>
        $(window).on('load', function() {
            if ($('input[name="province_id_edit"]').val() != null || $('input[name="city_id_edit"]').val() !=
                null || $('input[name="postal_code_edit"]').val() != null) {

                let province_id_edit = $('input[name="province_id_edit"]').val();
                let city_id_edit = $('input[name="city_id_edit"]').val();
                let postal_code_edit = $('input[name="postal_code_edit"]').val();
                console.log($('input[name="province_id_edit"]').val());
                console.log(city_id_edit);
                jQuery.ajax({
                    url: '/cities/' + province_id_edit,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        $('select[name="city_ids"]').empty();
                        $('select[name="city_ids"]').append(
                            '<option value="">Pilih kota</option>');
                        $.each(response, function(key, value) {
                            $('select[name="city_ids"]').append(
                                '<option class="destination-city-option" value="' +
                                value.city_id + '">' + value.type + ' ' + value
                                .name + '</option>');
                            if (city_id_edit == value.city_id) {
                                $('select[name="postal_code"]').empty();
                                $('select[name="postal_code"]').append(
                                    '<option value="">Pilih Kode Pos, Jika tidak ada yang sesuai silakan lewati kolom ini</option>'
                                );
                                $('select[name="postal_code"]').append(
                                    '<option class="destination-city-option" value="' +
                                    value.postal_code + '">' + value
                                    .postal_code + '</option>');
                                $('[name="postal_code"]').val($(
                                    'input[name="postal_code_edit"]').val());
                            }
                        });
                        $('[name="city_ids"]').val($('input[name="city_id_edit"]').val());
                        // $('[name="postal_code"]').val($('input[name="postal_code_edit"]').val());
                    },
                });
                $('[name="province_ids"]').val($('input[name="province_id_edit"]').val());
                // console.log($('[name="province_ids"]').val($('input[name="province_id_edit"]').val()));
                $('[name="city_ids"]').val($('input[name="city_id_edit"]').val());
                $('[name="postal_code"]').val($('input[name="postal_code_edit"]').val());
            }
        });
    </script>
@endsection
