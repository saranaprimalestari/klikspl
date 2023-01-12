@extends('user.layout')
{{-- @section('container') --}}
@section('account')
    <div class="col-12">
        @if (session()->has('successChangeAddress') or session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show alert-success-cart" role="alert">
                {{ session('successChangeAddress') }}
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('failedChangeAddress') or session()->has('failed'))
            <div class="alert alert-danger alert-dismissible fade show alert-success-cart" role="alert">
                {{ session('failedChangeAddress') }}
                {{ session('failed') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h5 class="m-0">Alamat Saya</h5>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('useraddress.create') }}" class="btn btn-danger profile-address-change-btn py-2 px-3">
                <p>
                    <i class="bi bi-plus-lg"></i> Tambah Alamat
                </p>
            </a>
        </div>
    </div>
    <div class="card mb-3 profile-card">
        <div class="card-body p-4">
            @if (auth()->user()->useraddress->count() > 0)
                @foreach (auth()->user()->useraddress()->orderBy('is_active', 'desc')->get() as $address)
                    <div
                        class="card mb-4 profile-address-card user-address-{{ $address->id }} {{ $address->is_active == 1 ? 'border border-danger' : '' }}">
                        <div class="card-body p-0 p-4">
                            <div class="row">
                                <div class="col-md-10 profile-address">
                                    <p class="m-0 profile-address-name">
                                        {{ $address->name }}
                                    </p>
                                    <p class="m-0 profile-address-phone">
                                        {{ $address->telp_no }}
                                    </p>
                                    <p class="m-0 profile-address-address">
                                        {{ $address->address }}
                                    </p>
                                    <div class="profile-address-city">
                                        <span class="m-0 me-1 ">
                                            {{ $address->city->name }},
                                        </span>
                                        <span class="m-0 profile-address-province me-1">
                                            {{ $address->province->name }}
                                        </span>
                                        {{-- <span class="m-0 profile-address-postalcode">
                                            {{ $address->city->postal_code }}
                                        </span> --}}
                                    </div>
                                    <div class="input-data">
                                        <input class="city-origin" type="hidden" name="cityOrigin" value="35">
                                        <input class="city-destination" type="hidden" name="cityDestination"
                                            value="{{ $address->city->city_id }}">
                                    </div>
                                    <div class=" mt-2 d-flex align-items-center">
                                        @if ($address->is_active != 1)
                                            {{-- <button type="submit"
                                                    class="btn btn-danger profile-address-change-btn py-2 px-3 me-3">
                                                    <p>
                                                        Pilih Alamat
                                                    </p>
                                                </button> --}}
                                            <form action="{{ route('useraddress.change.active') }}" method="post" class="me-2">
                                                @csrf
                                                <input class="address-id" type="hidden" name="addressId"
                                                    value="{{ $address->id }}">
                                                <input class="user-id" type="hidden" name="userId"
                                                    value="{{ auth()->user()->id }}">
                                                <button type="submit"
                                                    class="btn m-0 p-0 text-decoration-none text-danger profile-address-change-link shadow-none"
                                                    href="#editAddressModal" data-bs-toggle="modal" role="button">
                                                    Pilih Alamat
                                                </button>
                                            </form>
                                            {{-- <span class="text-secondary mx-1"> | </span> --}}
                                        @endif
                                        <a class="text-decoration-none text-danger profile-address-change-link me-2"
                                            href="{{ route('useraddress.edit', $address) }}" role="button">
                                            Edit Alamat
                                        </a>
                                        @if ($address->is_active != 1)
                                            {{-- <span class="text-secondary mx-1"> | </span> --}}
                                            <form class="me-2" action="{{ route('useraddress.destroy', $address) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit"
                                                    class="btn m-0 p-0 text-decoration-none shadow-none text-danger profile-address-change-link"
                                                    href="#editAddressModal" data-bs-toggle="modal" role="button">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                @if ($address->is_active == 1)
                                    <div
                                        class="col-md-2 d-flex align-items-center justify-content-end text-danger profile-address-active">
                                        <p class="m-0 my-2 fw-bold">digunakan</p>
                                        {{-- <p class="m-0 my-2 fs-3">
                                                <i class="bi bi-check-lg"></i>
                                            </p> --}}
                                    </div>
                                @endif
                            </div>
                            {{-- </label> --}}
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center notification-empty">
                    <img class="my-4 cart-items-logo" src="/assets/footer-logo.png" width="300" alt="">
                    <p>
                        anda belum menambahkan alamat, yuk
                        <a href="{{ route('useraddress.index') }}" class="text-decoration-none fw-bold login-link">
                            Tambahkan Alamat
                        </a>
                        untuk melihat perkiraan biaya ongkir ke lokasimu
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection
