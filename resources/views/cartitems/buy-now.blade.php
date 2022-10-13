@extends('layouts.main')
@section('container')
    <script type="text/javascript">
        function disableBack() {
            window.history.forward();
        }
        setTimeout("disableBack()", 0);
        window.onunload = function() {
            null
        };
    </script>
    <div class="container-fluid breadcrumb-products">
        {{ Breadcrumbs::render('buy.now') }}
    </div>
    {{-- {{ print_r(session()->all()) }} --}}
    {{-- {{ dd($userAddress) }} --}}
    {{-- {{ dd($itemBuyNow) }} --}}
    {{-- {{ is_null($itemBuyNow[0]->id) ? 'null' : $itemBuyNow[0]->id }} --}}
    <div class="container mb-5">
        <div class="checkout my-5">

            {{-- <div class="row my-3">
                <div class="col-12">
                    <a href="{{ route('cart.index') }}" class="text-decoration-none link-dark">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div> --}}

            <div class="col-12">
                @if (session()->has('successChangeAddress'))
                    <div class="alert alert-success alert-dismissible fade show alert-success-cart" role="alert">
                        {{ session('successChangeAddress') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session()->has('failedChangeAddress'))
                    <div class="alert alert-danger alert-dismissible fade show alert-success-cart" role="alert">
                        {{ session('failedChangeAddress') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-md-8 col-12">
                    <h5 class="mb-3">Alamat Tujuan Pengiriman</h5>
                    <div class="card checkout-address-card mb-4">
                        <div class="card-body p-4">
                            <div class="row d-flex align-items-center">
                                @if (count(auth()->user()->useraddress) > 0)
                                    <div class="col-md-10">
                                        {{-- <p class="m-0 mb-2 checkout-shipment-address-text">
                                        Alamat Pengiriman
                                    </p> --}}
                                        <div class="checkout-shipment-address">
                                            @foreach ($userAddress as $address)
                                                @if ($address->is_active == 1)
                                                    <p class="m-0 checkout-shipment-address-name">
                                                        {{ $address->name }}
                                                    </p>
                                                    <p class="m-0 checkout-shipment-address-phone">
                                                        {{ $address->telp_no }}
                                                    </p>
                                                    <p class="m-0 checkout-shipment-address-address">
                                                        {{ $address->address }}
                                                    </p>
                                                    <div class="checkout-shipment-address-city">
                                                        <span class="m-0 me-1 ">
                                                            {{ $address->city->name }},
                                                        </span>
                                                        <span class="m-0 checkout-shipment-address-province">
                                                            {{ $address->province->name }}
                                                        </span>
                                                        <span class="m-0 checkout-shipment-address-postalcode">
                                                            {{ !empty($address->postal_code) ? ', ' . $address->postal_code : '' }}
                                                        </span>
                                                    </div>
                                                    <div class="input-data">
                                                        <input class="city-origin" type="hidden" name="cityOrigin"
                                                            value="36">
                                                        <input class="address-id" type="hidden" name="addressId"
                                                            value="{{ $address->id }}">
                                                        <input class="city-destination" type="hidden"
                                                            name="cityDestination" value="{{ $address->city->city_id }}">
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button"
                                            class="btn shadow-none checkout-change-shipment-address p-0 py-3"
                                            data-bs-toggle="modal" data-bs-target="#addressModal">
                                            Ubah Alamat
                                        </button>
                                    </div>
                                @else
                                    <div class="col-md-12">
                                        <div class="product-no-auth-shipment-check">
                                            Kamu belum menambahkan alamat, yuk
                                            <a href="{{ route('useraddress.index') }}"
                                                class="text-decoration-none fw-bold login-link">
                                                Tambahkan Alamat
                                            </a>
                                            untuk melihat biaya ongkir ke lokasimu
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <h5 class="my-3">Produk yang dipesan</h5>
                    <div class="mb-4">
                        @foreach ($itemBuyNow as $item)
                            <div class="card mb-3 checkout-items-card">
                                <div class="card-body p-4">
                                    <div class="row d-flex align-items-center justify-content-center text-center">
                                        <div class="col-md-2 col-4 pe-0">
                                            @if (count($item->product->productimage) > 0)
                                                @if (Storage::exists($item->product->productimage[0]->name))
                                                    <img class="checkout-items-img"
                                                        src="{{ asset('/storage/' . $item->product->productimage[0]->name) }}"
                                                        alt="" width="70">
                                                @else
                                                    <img class="checkout-items-img"
                                                        src="https://source.unsplash.com/400x400?product--{{ $loop->iteration }}"
                                                        alt="" width="70">
                                                @endif
                                            @else
                                                <img class="checkout-items-img"
                                                    src="https://source.unsplash.com/400x400?product--{{ $loop->iteration }}"
                                                    alt="" width="70">
                                            @endif
                                        </div>
                                        <div class="col-md-4 col-8 ps-0">
                                            <div class="checkout-items-product-info text-start">
                                                <p class="text-truncate checkout-items-product-name m-0">
                                                    {{ $item->product->name }}
                                                </p>
                                                <p class="text-truncate checkout-items-product-variant">
                                                    Varian:
                                                    @if (!is_null($item->productVariant))
                                                        {{ $item->productVariant->variant_name }}
                                                    @else
                                                        Tidak ada varian
                                                    @endif
                                                </p>
                                                {{-- <p class="checkout-items-price">
                                                <input type="hidden" name="price-checkout-items-val-{{ $item->id }}"
                                                    class="price-checkout-items-val-{{ $item->id }}"
                                                    value="{{ isset($item->productVariant) ? $item->productVariant->weight : $item->product->weight }}">
                                                @if (isset($item->productVariant))
                                                    {{ $item->productVariant->weight }}
                                                @else
                                                    {{ $item->product->weight }}
                                                @endif
                                                (gr)
                                            </p> --}}
                                                <p class="checkout-items-price text-truncate">
                                                    <input type="hidden"
                                                        name="price-checkout-items-val-{{ $item->id }}"
                                                        class="price-checkout-items-val-{{ $item->id }}"
                                                        value="{{ isset($item->productVariant) ? $item->productVariant->price : $item->product->price }}">
                                                    @if (isset($item->productVariant))
                                                        Rp{{ price_format_rupiah($item->productVariant->price) }}
                                                    @else
                                                        Rp{{ price_format_rupiah($item->product->price) }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-4 my-3">
                                            <p class="m-0 checkout-items-weight-text">
                                                Berat Produk
                                            </p>
                                            <p class="m-0 checkout-items-weight-val">
                                                <input type="hidden" name="price-checkout-items-val-{{ $item->id }}"
                                                    class="price-checkout-items-val-{{ $item->id }}"
                                                    value="{{ isset($item->productVariant) ? $item->productVariant->weight : $item->product->weight }}">
                                                @if (isset($item->productVariant))
                                                    {{ $item->productVariant->weight }}
                                                    @php
                                                        $weight[] = $item->productVariant->weight * $item->quantity;
                                                    @endphp
                                                @else
                                                    {{ $item->product->weight }}
                                                    @php
                                                        $weight[] = $item->product->weight * $item->quantity;
                                                    @endphp
                                                @endif
                                                (gr)
                                            </p>
                                        </div>
                                        <div class="col-md-2 col-4 my-3">
                                            <p class="m-0 checkout-items-qty-text">
                                                Jumlah
                                            </p>
                                            <p class="m-0 checkout-items-qty-val">
                                                {{ $item->quantity }}
                                            </p>
                                        </div>
                                        <div class="col-md-2 col-4 my-3">
                                            <input type="hidden" name="subtotal-cart-items-val-{{ $item->id }}"
                                                class="subtotal-cart-items-val-{{ $item->id }}"
                                                value="{{ price_format_rupiah($item->subtotal) }}">
                                            <input type="hidden"
                                                name="subtotal-cart-items-val-noformat-{{ $item->id }}"
                                                class="subtotal-cart-items-val-noformat-{{ $item->id }}"
                                                value="{{ $item->subtotal }}">
                                            <p class="cart-items-subtotal">
                                                Subtotal
                                            </p>
                                            <p class="subtotal-cart-items-{{ $item->id }} text-danger cart-items-subtotal fw-bold"
                                                id="subtotal-cart-items-single">
                                                Rp{{ price_format_rupiah($item->subtotal) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="input-data-item">
                            <input class="csrf-token" type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                            <input class="total-weight" type="hidden" name="total_weight"
                                value="{{ array_sum($weight) }}">
                            <input class="total-subtotal" type="hidden" name="total_subtotal"
                                value="{{ is_null($itemBuyNow[0]->id) ? $itemBuyNow[0]->subtotal : $itemBuyNow->sum('subtotal') }}">
                            <input class="courier" type="hidden" name="courier" value="all">
                        </div>
                    </div>
                    <h5 class="my-3">Pengiriman</h5>
                    <div class="m-0 sender-address-div mb-2">
                        <div class="header mb-2">
                            <p class="fs-14 fw-500 m-0">Alamat Pengirim</p>
                            <p class="fs-12 text-grey m-0">
                                Pilih darimana produk kamu akan dikirimkan
                            </p>
                        </div>
                        <select class="form-select sender-address form-select-sm shadow-none fs-14 border-0"
                            aria-label="" name="sender_city_id">
                            <option selected="true" value="" disabled="disabled">
                                Pilih alamat pengirim
                            </option>

                            @if (isset($senderAddress))
                                @foreach ($senderAddress as $sender)
                                    @if ($sender->is_active == 1)
                                        <option value="{{ $sender->city_ids }}" id="{{ $sender->id }}">
                                            {{ $sender->city->name == 'Kotawaringin Timur' ? $sender->city->name . ' (Sampit)' : $sender->city->name }}
                                            - ({{ $sender->address }})
                                        </option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <p class="fs-14 fw-500 m-0 mb-2">Kurir</p>
                    <div class="courier-choice" id="courier-choice">
                        <div class="card mb-3 checkout-courier-card">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center courier-choice-text">
                                    @if (count(auth()->user()->useraddress) > 0)
                                        <p class="m-0 checkout-courier-loading-text">
                                            {{-- Memuat data... --}}
                                            Pilih alamat pengirim terlebih dahulu
                                        </p>
                                        {{-- <div class="spinner-border ms-auto checkout-courier-loading" role="status"
                                            aria-hidden="true"></div> --}}
                                    @else
                                        <p class="m-0 checkout-courier-loading-text text-danger">
                                            Tambahkan alamat kamu terlebih dahulu
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="courier-error">
                        <p class="text-danger m-0 courier-error-text"></p>
                    </div>

                    <div class="modal fade" id="courierModal" tabindex="-1" aria-labelledby="courierModalLabel"
                        aria-text="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content checkout-courier-modal">
                                <div class="modal-header border-0 p-4">
                                    <h5 class="modal-title m-0" id="courierModalLabel">Pilihan Kurir Pengirim</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4 courier-modal-body">

                                </div>
                                <div class="modal-footer border-0 p-4">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel"
                        aria-text="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content checkout-address-modal">
                                <div class="modal-header border-0 p-4">
                                    <h5 class="modal-title m-0" id="addressModalLabel">Pilih Alamat</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="col-12 mb-3">
                                        <a href="{{ route('useraddress.create') }}" target="_blank"
                                            class="btn btn-danger profile-address-change-btn py-2 px-3">
                                            <p>
                                                <i class="bi bi-plus-lg"></i> Tambah Alamat
                                            </p>
                                        </a>
                                    </div>
                                    @foreach ($userAddress as $address)
                                        <form action="{{ route('useraddress.change.active') }}" method="post">
                                            @csrf
                                            <div
                                                class="card mb-4 checkout-address-card-change  {{ $address->is_active == 1 ? 'border border-danger' : '' }}">
                                                <div class="card-body p-0 p-4">
                                                    <div class="row">
                                                        <div class="col-md-10 checkout-shipment-address">
                                                            <p class="m-0 checkout-shipment-address-name">
                                                                {{ $address->name }}
                                                            </p>
                                                            <p class="m-0 checkout-shipment-address-phone">
                                                                {{ $address->telp_no }}
                                                            </p>
                                                            <p class="m-0 checkout-shipment-address-address">
                                                                {{ $address->address }}
                                                            </p>
                                                            <div class="checkout-shipment-address-city">
                                                                <span class="m-0 me-1 ">
                                                                    {{ $address->city->name }},
                                                                </span>
                                                                <span class="m-0 checkout-shipment-address-province me-1">
                                                                    {{ $address->province->name }},
                                                                </span>
                                                                <span class="m-0 checkout-shipment-address-postalcode">
                                                                    {{ $address->city->postal_code }}
                                                                </span>
                                                            </div>
                                                            <div class="input-data">
                                                                <input class="address-id" type="hidden" name="addressId"
                                                                    value="{{ $address->id }}">
                                                                <input class="user-id" type="hidden" name="userId"
                                                                    value="{{ auth()->user()->id }}">
                                                                <input class="city-origin" type="hidden"
                                                                    name="cityOrigin" value="36">
                                                                <input class="city-destination" type="hidden"
                                                                    name="cityDestination"
                                                                    value="{{ $address->city->city_id }}">
                                                                <input type="hidden" name="index"
                                                                    value="{{ $loop->index }}">
                                                            </div>
                                                            <div class=" mt-2 d-flex align-items-center">
                                                                @if ($address->is_active != 1)
                                                                    <button type="submit"
                                                                        class="btn m-0 p-0 text-decoration-none text-danger checkout-shipment-address-change-link shadow-none"
                                                                        data-bs-toggle="modal" role="button">
                                                                        Pilih Alamat
                                                                    </button>
                                                                    <span class="text-secondary mx-1"> | </span>
                                                                @endif
                                                                <a href="{{ route('useraddress.edit', $address) }}"
                                                                    target="_blank"
                                                                    class="ubahAlamat text-decoration-none text-danger checkout-shipment-address-change-link">Edit
                                                                    Alamat</a>
                                                            </div>
                                                        </div>
                                                        @if ($address->is_active == 1)
                                                            <div
                                                                class="col-md-2 d-flex align-items-center text-danger checkout-shipment-address-active">
                                                                <p class="m-0 my-2 fw-bold">digunakan</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    {{-- </label> --}}
                                                </div>
                                            </div>
                                        </form>
                                    @endforeach
                                </div>
                                <div class="modal-footer border-0 p-4">
                                    {{-- <button type="submit" class="btn btn-secondary checkout-shipment-address-cancel-btn p-2"
                                        data-bs-dismiss="modal">
                                        <p>
                                            Batal
                                        </p>
                                    </button>
                                    <button type="submit" class="btn btn-danger checkout-shipment-address-change-btn p-2">
                                        <p>
                                            Pilih Alamat
                                        </p>
                                    </button> --}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="paymentModal" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="paymentModalLabel" aria-text="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                        <div class="modal-content payment-method-modal">
                            <form class="payment-form" action="{{ route('order.store') }}" method="POST"
                                onSubmit="return confirm('Apakah anda yakin Data Pemesanan anda sudah benar (Alamat Pengiriman, Produk Pesanan, dan Kurir Pengiriman)?');">
                                @csrf

                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="product_id" value="{{ $itemBuyNow[0]->product_id }}">
                                <input type="hidden" name="product_variant_id"
                                    value="{{ $itemBuyNow[0]->product_variant_id }}">
                                <input type="hidden" name="quantity" value="{{ $itemBuyNow[0]->quantity }}">
                                <input type="hidden" name="subtotal" value="{{ $itemBuyNow[0]->subtotal }}">

                                <input type="hidden" class="courier" name="courier" value="">
                                <input type="hidden" class="courier_package_type" name="courier_package_type"
                                    value="">
                                <input type="hidden" class="estimation" name="estimation" value="">
                                <input type="hidden" class="courier_price" name="courier_price" value="">
                                <input type="hidden" class="sender_address_id" name="sender_address_id" value="">
                                {{-- {{ dd($itemBuyNow) }} --}}
                                @foreach ($itemBuyNow as $item)
                                    {{-- <input type="hidden" name="cart_ids[{{ $carts->id }}]" value=""> --}}
                                    <input type="hidden" name="cart_ids[{{ $item->id }}]"
                                        value="{{ $item->id }}">
                                    <input type="hidden" name="product_ids[{{ $item->product->id }}]"
                                        value="{{ $item->product->id }}">
                                    {{-- <input type="hidden" name="ids[]" value="{{ $carts->id }}"> --}}
                                @endforeach

                                <div class="modal-header p-4 border-0">
                                    <h5 class="modal-title m-0" id="addressModalLabel">Pilih Metode Pembayaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-5">
                                            <div class="d-flex mb-2">
                                                <p class="m-0 fw-bold">Metode pembayaran yang tersedia</p>
                                                {{-- <a href="#"
                                                class="text-decoration-none text-danger fw-bold ms-auto text-end">Lihat
                                                Semua</a> --}}
                                            </div>
                                            @foreach ($paymentMethods as $paymentMethod)
                                                <div class="form-check py-1">
                                                    <input class="form-check-input paymentMethods shadow-none"
                                                        type="radio" name="payment_method_id"
                                                        id="paymentMethods-tf-{{ $paymentMethod->type }}-{{ $paymentMethod->name }}"
                                                        value="{{ $paymentMethod->id }}" required>
                                                    <label class="form-check-label"
                                                        for="paymentMethods-tf-{{ $paymentMethod->type }}-{{ $paymentMethod->name }}">
                                                        <div class="row align-items-center">
                                                            @if (!empty($paymentMethod->logo))
                                                                <div class="col-2 pe-0">
                                                                    <img class="w-100"
                                                                        src=" {{ asset($paymentMethod->logo) }}"
                                                                        alt="">
                                                                </div>
                                                                <div class="col-10">
                                                                    {{ $paymentMethod->type }}
                                                                    {{ $paymentMethod->name }}
                                                                </div>
                                                            @else
                                                                <div class="col-12">
                                                                    {{ $paymentMethod->type }}
                                                                    {{ $paymentMethod->name }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-6 col-12 mb-5">
                                            <div class="mb-2">
                                                <p class="m-0 fw-bold">Ringkasan Pembayaran</p>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="checkout-payment-total-price-text m-0">
                                                        Total Harga ({{ count($itemBuyNow) }}) Produk</p>
                                                </div>
                                                {{-- <div
                                                class="col-6 checkout-total-all-val checkout-total-all-val text-end">
                                            </div> --}}
                                                <div class="col-6 text-end checkout-payment-total-price-val">
                                                    Rp{{ price_format_rupiah(is_null($itemBuyNow[0]->id) ? $itemBuyNow[0]->subtotal : $itemBuyNow->sum('subtotal')) }}
                                                    {{-- Rp{{ price_format_rupiah($itemBuyNow['subtotal']) }} --}}
                                                </div>
                                                <input type="hidden" name="checkout_total_prices"
                                                    value="{{ is_null($itemBuyNow[0]->id) ? $itemBuyNow[0]->subtotal : $itemBuyNow->sum('subtotal') }}">
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-7 checkout-payment-weight-text">
                                                    Berat total: <span class="total-weight-checkout"></span>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-7 checkout-payment-shipment-text pe-0">
                                                </div>
                                                <div class="col-5 checkout-payment-shipment-val text-end">
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-7 checkout-payment-courier-text">
                                                </div>
                                            </div>

                                            {{-- <div class="row mb-2">
                                                <div class="col-6">
                                                    <p class="checkout-payment-unique-code-text m-0">
                                                        Kode Unik
                                                    </p>
                                                </div>
                                                <div class="col-6 checkout-payment-unique-code-val text-end">
                                                    Rp{{ $unique_code }}
                                                </div>
                                                <input type="hidden" name="checkout_unique_code"
                                                    value="{{ $unique_code }}">
                                            </div> --}}

                                            <div class="my-3 border border-1 border-bottom checkout-checkout-divider">
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="checkout-total-all-text checkout-payment-total-all-text m-0">
                                                        Total Harga</p>
                                                </div>
                                                <div class="col-6 checkout-payment-total-all-val text-end fw-bold">
                                                </div>
                                                <input type="hidden" name="checkout_payment_total_price" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 p-4">
                                    <button type="button" class="btn btn-secondary show-payment-modal-button"
                                        data-bs-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn btn-danger show-payment-modal-button">Lanjutkan
                                        Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- checkout card only on tab and desktop --}}
                <div class="col-md-4 col-12 mt-4 checkout-total-div d-none d-sm-block">
                    <div class="card mt-3 checkout-total-card sticky-md-top">
                        <div class="card-body">
                            <form action="{{ route('checkout.payment') }}" onsubmit="return validateCheckout()"
                                method="POST">
                                @csrf

                                @foreach ($itemBuyNow as $item)
                                    <input type="hidden" name="product-id[]" value="{{ $item->id }}">
                                    {{-- <input type="hidden" name="product-qty[]" value="{{ $item->quantity }}">
                                    <input type="hidden" name="product-subtotal[]" value="{{ $item->subtotal }}"> --}}
                                @endforeach

                                @foreach ($weight as $weightItem)
                                    <input type="hidden" name="product-weight[]" value="{{ $weightItem }}">
                                @endforeach

                                <input type="hidden" name="user-id" value="{{ auth()->user()->id }}">

                                <div class="input-data-shipment">

                                    @foreach ($userAddress as $address)
                                        @if ($address->is_active == 1)
                                            <input class="address-id" type="hidden" name="addressId"
                                                value="{{ $address->id }}">
                                            <input class="city-origin" type="hidden" name="cityOrigin" value="36">
                                            <input class="city-destination" type="hidden" name="cityDestination"
                                                value="{{ $address->city->city_id }}">
                                        @endif
                                    @endforeach

                                    <input type="hidden" class="courier-name-choosen" name="courier-name-choosen"
                                        value="">
                                    <input type="hidden" class="courier-service-choosen" name="courier-service-choosen"
                                        value="">
                                    <input type="hidden" class="courier-etd-choosen" name="courier-etd-choosen"
                                        value="">
                                    <input type="hidden" class="courier-price-choosen" name="courier-price-choosen"
                                        value="">
                                </div>

                                <div class="input-data-item-detail">
                                    <input class="csrf-token" type="hidden" name="csrf_token"
                                        value="{{ csrf_token() }}">
                                    <input class="total-weight" type="hidden" name="total_weight"
                                        value="{{ array_sum($weight) }}">
                                    <input class="total-subtotal" type="hidden" name="total_subtotal"
                                        value="{{ is_null($itemBuyNow[0]->id) ? $itemBuyNow[0]->subtotal : $itemBuyNow->sum('subtotal') }}">
                                    <input class="courier" type="hidden" name="courier" value="all">
                                </div>

                                <h5 class="cart-items-checkout-header cart-items-checkout-header mt-1 mb-4">
                                    Ringkasan Pesanan
                                </h5>
                                <div class="row">
                                    <div class="col-7 checkout-items-total-text cart-items-total-text pe-0">
                                        Total Harga ({{ count($itemBuyNow) }}) Produk
                                    </div>
                                    <div class="col-5 cart-items-total-val text-end">
                                        Rp{{ price_format_rupiah(is_null($itemBuyNow[0]->id) ? $itemBuyNow[0]->subtotal : $itemBuyNow->sum('subtotal')) }}
                                        {{-- Rp{{ price_format_rupiah($itemBuyNow['subtotal']) }} --}}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div
                                        class="col-7 checkout-items-text cart-items-total-text pe-0 total-weight-checkout-text">
                                        Berat total: <span class="total-weight-checkout"></span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-7 checkout-shipment-total-text cart-items-total-text pe-0">
                                    </div>
                                    <div class="col-5 checkout-shipment-total-val cart-items-total-val text-end">
                                    </div>
                                </div>
                                <div class="my-4 border border-1 border-bottom cart-items-checkout-divider">
                                </div>
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <p class="checkout-total-all-text cart-items-checkout-total-all-text m-0">
                                            Total Harga</p>
                                    </div>
                                    <div class="col-6 checkout-total-all-val cart-items-total-all-val text-end fw-bold">
                                    </div>
                                    <input type="hidden" name="checkout_total_price" value="">
                                </div>
                                <div class="d-grid">
                                    {{-- <button type="button"
                                        class="btn btn-block checkout-button show-payment-modal-button shadow-none">
                                        Pilih Metode Pembayaran
                                    </button> --}}
                                    <button type="button"
                                        class="btn btn-block checkout-button show-payment-modal-button shadow-none"
                                        data-bs-toggle="modal" data-bs-target="#paymentModal">
                                        Pilih Metode Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- checkout card only on small device / smartphone --}}
                <div class="fixed-bottom col-12 mb-5 p-0 checkout-total-div d-block d-sm-none">
                    <div class="card my-2 checkout-total-card sticky-md-top">
                        <div class="card-body">
                            <a href="#" class="btn active d-block pt-0 expand-checkout-bill shadow-none"
                                role="button" data-bs-toggle="button" aria-pressed="true">
                                Detail <i class="bi bi-chevron-up mx-2 expand-checkout-bill-chevron"></i>
                            </a>
                            <form class="checkout-bill-form d-none" action="{{ route('checkout.payment') }}"
                                onsubmit="return validateCheckout()" method="POST">
                                @csrf
                                @foreach ($itemBuyNow as $item)
                                    <input type="hidden" name="product-id[]" value="{{ $item->id }}">
                                    {{-- <input type="hidden" name="product-qty[]" value="{{ $item->quantity }}">
                                    <input type="hidden" name="product-subtotal[]" value="{{ $item->subtotal }}"> --}}
                                @endforeach

                                @foreach ($weight as $weightItem)
                                    <input type="hidden" name="product-weight[]" value="{{ $weightItem }}">
                                @endforeach

                                <input type="hidden" name="user-id" value="{{ auth()->user()->id }}">

                                <div class="input-data-shipment">

                                    @foreach ($userAddress as $address)
                                        @if ($address->is_active == 1)
                                            <input class="address-id" type="hidden" name="addressId"
                                                value="{{ $address->id }}">
                                            <input class="city-origin" type="hidden" name="cityOrigin" value="36">
                                            <input class="city-destination" type="hidden" name="cityDestination"
                                                value="{{ $address->city->city_id }}">
                                        @endif
                                    @endforeach

                                    <input type="hidden" class="courier-name-choosen" name="courier-name-choosen"
                                        value="">
                                    <input type="hidden" class="courier-service-choosen" name="courier-service-choosen"
                                        value="">
                                    <input type="hidden" class="courier-etd-choosen" name="courier-etd-choosen"
                                        value="">
                                    <input type="hidden" class="courier-price-choosen" name="courier-price-choosen"
                                        value="">
                                </div>

                                <div class="input-data-item-detail">
                                    <input class="csrf-token" type="hidden" name="csrf_token"
                                        value="{{ csrf_token() }}">
                                    <input class="total-weight" type="hidden" name="total_weight"
                                        value="{{ array_sum($weight) }}">
                                    <input class="total-subtotal" type="hidden" name="total_subtotal"
                                        value="{{ is_null($itemBuyNow[0]->id) ? $itemBuyNow[0]->subtotal : $itemBuyNow->sum('subtotal') }}">
                                    <input class="courier" type="hidden" name="courier" value="all">
                                </div>

                                <h5 class="cart-items-checkout-header cart-items-checkout-header mt-1 mb-4">Ringkasan
                                    Pesanan</h5>
                                <div class="row">
                                    <div class="col-7 checkout-items-total-text cart-items-total-text pe-0">
                                        Total Harga ({{ count($itemBuyNow) }}) Produk
                                    </div>
                                    <div class="col-5 cart-items-total-val text-end">
                                        Rp{{ price_format_rupiah(is_null($itemBuyNow[0]->id) ? $itemBuyNow[0]->subtotal : $itemBuyNow->sum('subtotal')) }}
                                        {{-- Rp{{ price_format_rupiah($itemBuyNow['subtotal']) }} --}}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div
                                        class="col-7 checkout-items-text cart-items-total-text pe-0 total-weight-checkout">
                                        Berat total: <span class="total-weight-checkout"></span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-7 checkout-shipment-total-text cart-items-total-text pe-0">
                                    </div>
                                    <div class="col-5 checkout-shipment-total-val cart-items-total-val text-end">
                                    </div>
                                </div>
                                <div class="my-4 border border-1 border-bottom cart-items-checkout-divider">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="checkout-total-all-text cart-items-checkout-total-all-text mt-1 mb-4">
                                            Total harga</p>
                                    </div>
                                    <div class="col-6 checkout-total-all-val cart-items-total-all-val text-end fw-bold">
                                    </div>
                                    <input type="hidden" name="checkout_total_price" value="">
                                </div>
                                <div class="d-grid">
                                    {{-- <button type="button"
                                        class="btn btn-block checkout-button show-payment-modal-button shadow-none">
                                        Pilih Metode Pembayaran
                                    </button> --}}
                                    <button type="button"
                                        class="btn btn-block checkout-button show-payment-modal-button shadow-none"
                                        data-bs-toggle="modal" data-bs-target="#paymentModal">
                                        Pilih Metode Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        // $(window).focus(function() {
        //     window.location.reload();
        // });

        function validateCheckout() {

            if (courierName == '' || courierService == '' || courierETD == '' || courierPrice == '') {
                $('.courier-error-text').text('Pilih kurir pengirim terlebih dahulu');
                alert('Pilih kurir pengirim terlebih dahulu');
                return false;
            }
        }

        $(window).on('load', function() {
            var token = $('.csrf-token').val();
            var city_origin = $('.city-origin').val();
            var city_destination = $('.city-destination').val();
            var weight = $('.total-weight').val();
            console.log(weight + ' g');
            if (weight < 1000) {
                weight = 1000;
            }
            $('.total-weight-checkout').text(Math.round(parseInt(weight) / 1000) + ' kg');
            // $('.total-weight-checkout').text((parseInt(weight)/1000) +' kg');
            var courier = $('.courier').val();

            console.log(token);
            console.log(city_origin);
            console.log(city_destination);
            console.log(courier);
            console.log(weight);

            // $.fn.shipment_cost_checkout(token, city_origin, city_destination, courier, weight);
        });

        $(document).ready(function() {
            $('body').on('change', 'select[name="sender_city_id"]', function(e) {
                console.log(e.currentTarget);
                var sender_city_id = ($("select[name='sender_city_id']").val());
                var sender_id = ($("select[name='sender_city_id']").find(':selected').attr('id'));
                console.log(sender_city_id);
                console.log(sender_id);
                $('input[name="sender_address_id"]').val(sender_id);

                var courier = $('.courier').val('all');
                $('input[name="courier-name-choosen"]').val('');
                $('input[name="courier-service-choosen"]').val('');
                $('input[name="courier-etd-choosen"]').val('');
                $('input[name="courier_package_type"]').val('');
                $('input[name="estimation"]').val('');
                $('input[name="courier_price"]').val('');

                $('.checkout-shipment-total-text').empty();
                $('.checkout-payment-shipment-text').empty();
                $('input[name="checkout_total_price"]').val('');
                $('.checkout-shipment-total-val').empty();
                $('.checkout-payment-shipment-val').empty();
                $('.checkout-total-all-val').empty();
                $('.checkout-payment-total-all-val').empty();
                $('input[name="checkout_payment_total_price"]').val('');
                $('.courier-error-text').empty();
                $('.checkout-payment-courier-text').empty();
                $('.courier-choice-text').empty();
                $('.courier-choice-text').html(
                    '<p class="m-0 checkout-courier-loading-text">Memuat data...</p><div class="spinner-border ms-auto checkout-courier-loading" role="status" aria-hidden="true"></div>'
                );
                $('input[name="sender_city"]').val(sender_city_id);
                var token = $('.csrf-token').val();
                var city_destination = $('.city-destination').val();
                var weight = $('.total-weight').val();
                console.log(weight + ' g');
                if (weight < 1000) {
                    weight = 1000;
                }
                $('.total-weight-checkout').text(Math.round(parseInt(weight) / 1000) + ' kg');
                // $('.total-weight-checkout').text((parseInt(weight)/1000) +' kg');
                var courier = $('.courier').val();

                console.log(token);
                console.log(sender_city_id);
                console.log(city_destination);
                console.log(courier);
                console.log(weight);

                $.fn.shipment_cost_checkout(token, sender_city_id, city_destination, courier, weight);
            });
            $('body').on('change', 'input:radio[name="checkout-courier-input"]', function() {
                var cart_id = [];
                $.each($('input:radio[name="checkout-courier-input"]:checked'), function() {

                    var courier = $('input[name="courier-name-' + $(this).val() + '"]').val();
                    var service = $('input[name="courier-service-' + $(this).val() + '"]').val();
                    var etd = $('input[name="courier-etd-' + $(this).val() + '"]').val();
                    var price = $('input[name="courier-price-' + $(this).val() + '"]').val();

                    $('.courier-choice').empty();

                    $('.courier-choice').append(
                        '<button class="btn mb-3 checkout-courier-button w-100 p-4 " data-bs-toggle="modal"data-bs-target="#courierModal"><div class="row d-flex align-items-center"><div class="col-md-10 col-12 text-start"><div class="checkout-courier-label m-0"> <p class="m-0 d-inline-block modal-courier-type pe-1 fw-bold">' +
                        courier.toUpperCase() +
                        '</p><p class="m-0 d-inline-block modal-courier-package fw-bold">' +
                        service +
                        '</p><p class="m-0">Akan tiba dalam ' + etd.replace(' HARI', '') +
                        ' hari dari pengiriman</p></div></div><div class="col-md-2 col-12"><p class="m-0 text-danger checkout-courier-cost text-start my-2 fw-bold"><span class="checkout-courier-cost">' +
                        formatRupiah(price, "Rp") +
                        '</span></p></div></div><input type="hidden" name="courier-name" value="' +
                        courier.toUpperCase() +
                        '"><input type="hidden" name="courier-service" value="' + service +
                        '"><input type="hidden" name="courier-etd" value="' + etd +
                        '"><input type="hidden" name="courier-price" value="' + price +
                        '"></div></button>'
                    );

                    $('input[name="courier-name-choosen"]').val(courier);
                    $('input[name="courier-service-choosen"]').val(service);
                    etd = etd.replace(' HARI', '');
                    $('input[name="courier-etd-choosen"]').val(etd);

                    $('input[name="courier"]').val(courier);
                    $('input[name="courier_package_type"]').val(service);
                    $('input[name="estimation"]').val(etd);
                    $('input[name="courier_price"]').val(price);
                    console.log($('input[name="courier"]').val());
                    console.log($('input[name="courier_package_type"]').val());
                    console.log($('input[name="estimation"]').val());
                    console.log($('input[name="courier_price"]').val());

                    $('.checkout-shipment-total-text').text('Total Ongkos Kirim');
                    $('.checkout-payment-shipment-text').text('Total Ongkos Kirim');
                    $('input[name="checkout_total_price"]').val(parseInt($(
                        'input[name="total_subtotal"]').val()) + parseInt(price));
                    $('.checkout-shipment-total-val').text(formatRupiah(price, "Rp"));
                    $('.checkout-payment-shipment-val').text(formatRupiah(price, "Rp"));
                    $('.checkout-total-all-val').text(formatRupiah(parseInt($(
                        'input[name="total_subtotal"]').val()) + parseInt(price), "Rp"));
                    $('.checkout-payment-total-all-val').text(formatRupiah(parseInt($(
                        'input[name="total_subtotal"]').val()) + parseInt(price), "Rp"));
                    $('#courierModal').modal('toggle');
                    $('input[name="checkout_payment_total_price"]').val(parseInt($(
                        'input[name="total_subtotal"]').val()) + parseInt(price));
                    $('.courier-error-text').empty();
                    $('.checkout-payment-courier-text').text(courier + ' ' + service + ' ' + etd +
                        ' hari');

                });
            });
            $('#paymentModal').on('show.bs.modal', function(e) {
                let courierName = $('input[name="courier"]').val();
                let courierService = $('input[name="courier_package_type"]').val();
                let courierETD = $('input[name="estimation"]').val();
                let courierPrice = $('input[name="courier_price"]').val();
                var button = e.relatedTarget;
                if ($(button).hasClass('show-payment-modal-button')) {
                    if (courierName == '' || courierService == '' || courierETD == '' || courierPrice ==
                        '') {
                        console.log($('input[name="courier-name-choosen"]').val());
                        e.preventDefault();
                        $('.courier-error-text').text('Pilih kurir pengirim terlebih dahulu');
                        alert('Pilih kurir pengirim terlebih dahulu');
                        expand();
                    }
                }
            });

            function expand() {
                console.log($('.checkout-bill-form'));
                if ($('.checkout-bill-form').hasClass("d-none")) {
                    $('.checkout-bill-form').removeClass("d-none");
                } else {
                    $('.checkout-bill-form').addClass('d-none');
                }
                if ($('.expand-checkout-bill-chevron').hasClass("bi-chevron-up")) {
                    $('.expand-checkout-bill-chevron').removeClass("bi-chevron-up");
                    $('.expand-checkout-bill-chevron').addClass("bi-chevron-down");
                    console.log($('.expand-checkout-bill-chevron'));
                } else if ($('.expand-checkout-bill-chevron').hasClass("bi-chevron-down")) {
                    $('.expand-checkout-bill-chevron').removeClass("bi-chevron-down");
                    $('.expand-checkout-bill-chevron').addClass("bi-chevron-up");
                    console.log($('.expand-checkout-bill-chevron'));
                }
            }

            $('.expand-checkout-bill').click(function() {
                expand();
            })
        });
    </script>
@endsection
