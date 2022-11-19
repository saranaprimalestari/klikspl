@extends('layouts.main')

@section('container')
    <div class="container-fluid breadcrumb-products fs-14 text-truncate">
        {{ Breadcrumbs::render('product.show', $product) }}
    </div>
    {{-- {{ "Now is " . date("Y-m-d h:i:s" , strtotime('+5 hours')); }}
    {{ "Now is " . date("Y-m-d h:i:s"); }} --}}
    {{-- {{ $product }} --}}
    {{-- {{ $product->productvariant }} --}}
    {{-- {{ print_r(session()->all()) }} --}}
    {{-- {{ $product->productImage }} --}}

    <div class="container my-md-5 my-2 p-0">
        {{-- <div class="container p-0"> --}}

        {{-- <div class="row my-3">
                <div class="col-12">
                    <a href="{{ url()->previous() }}" class="text-decoration-none link-dark">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div> --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show alert-success-cart" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session()->has('failed'))
            <div class="alert alert-danger alert-dismissible fade show alert-success-cart" role="alert">
                {{ session('failed') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row d-flex">
            <div class="col-md-5 col-12">
                @if (count($product->productImage) > 0)
                    <div class="product-main-img mb-3">
                        @if (count($product->productimage) > 0)
                            @if (Storage::exists($product->productimage[0]->name))
                                <img id="main-image" src="{{ asset('/storage/' . $product->productimage[0]->name) }}"
                                    class="product-detail-img" alt="Foto Produk" width="100%">
                            @else
                                <img id="main-image" src="https://source.unsplash.com/400x400?product-1"
                                    class="product-detail-img" alt="Foto Produk" width="100%">
                            @endif
                        @else
                            <img id="main-image" src="https://source.unsplash.com/400x400?product-1"
                                class="product-detail-img" alt="Foto Produk" width="100%">
                        @endif
                    </div>
                    <div class="thumbnail">
                        @foreach ($product->productImage as $productImg)
                            @if (Storage::exists($productImg->name))
                                <img role="button" class="product-detail-img me-1 mb-2"
                                    id="thumbnail-img-{{ $loop->iteration }}"
                                    src="{{ asset('/storage/' . $productImg->name) }}" width="60"
                                    onclick="change_image(this,{{ $loop->iteration }},{{ $loop->count }})">
                            @else
                                <img role="button" class="product-detail-img me-1 mb-2"
                                    id="thumbnail-img-{{ $loop->iteration }}"
                                    src="https://source.unsplash.com/400x400?product-{{ $loop->iteration }}" width="60"
                                    onclick="change_image(this,{{ $loop->iteration }},{{ $loop->count }})">
                            @endif
                        @endforeach
                    </div>

                    <div class="share mt-3 mb-3">
                        <h6>Bagikan &nbsp;
                            <a target="_blank"
                                href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&amp;src=sdkpreparse"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Bagikan ke Facebook"><i
                                    class="bi bi-facebook me-1"></i></a>
                            {{-- <a  href="whatsapp://send?text=The text to share!" data-action="share/whatsapp/share" target="_blank"><i class="bi bi-whatsapp me-1"></i></a> --}}
                            <a type="button" class="pe-auto" onclick="Copy('{{ url()->current() }}')"><i
                                    class="bi bi-clipboard me-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Salin URL"></i></a>
                        </h6>
                    </div>
                @else
                    <div class="product-main-img mb-3">
                        {{-- {{ $product->productImage[0] }} --}}
                        <img id="main-image" class="product-detail-img" src="https://source.unsplash.com/400x400?product-1"
                            class="img-fluid" alt="..." width="100%">
                    </div>
                    <div class="share mt-3">
                        <h6>Bagikan &nbsp;
                            <a target="_blank"
                                href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&amp;src=sdkpreparse"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Bagikan ke Facebook"><i
                                    class="bi bi-facebook me-1"></i></a>
                            {{-- <a  href="whatsapp://send?text=The text to share!" data-action="share/whatsapp/share" target="_blank"><i class="bi bi-whatsapp me-1"></i></a> --}}
                            <a href="" class="pe-auto" onclick="Copy('{{ url()->current() }}')"><i
                                    class="bi bi-clipboard me-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Salin URL"></i></a>
                        </h6>
                    </div>
                @endif
                <div class="modal fade" id="imagemodal" tabindex="-1" aria-labelledby="imagePreviewModal"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content imagePreviewModal">
                            <div class="modal-header border-bottom-0">
                                <p class="modal-title" id="imagePreviewModal">{{ $product->name }}</p>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-7 col-12">
                                        <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                                            <a id="imagePreviewLink" class="imagepreviewLink w-100">
                                                <img id="imagePreview" src="" class="imagepreview w-100">
                                            </a>
                                            {{-- <div class="easyzoom easyzoom--overlay"> <a href="https://i.imgur.com/jnxzAN2.jpg"> <img class="mainimage" src="https://i.imgur.com/jnxzAN2.jpg" height="460" /> </a> </div> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-12">
                                        {{-- <div id="imagepreviewZoom" class="img-zoom-result"></div> --}}
                                        <div class="thumbnail my-2 thumbnails-modal">
                                            @foreach ($product->productImage as $productImg)
                                                @if (Storage::exists($productImg->name))
                                                    <a href="{{ asset('/storage/' . $productImg->name) }}"
                                                        data-standard="{{ asset('/storage/' . $productImg->name) }}">
                                                        <img role="button" class="product-detail-img me-1 mb-2"
                                                            id="thumbnail-img-modal-{{ $loop->iteration }}"
                                                            src="{{ asset('/storage/' . $productImg->name) }}"
                                                            width="60"
                                                            onclick="change_image_modal(this,{{ $loop->iteration }},{{ $loop->count }})">
                                                    </a>
                                                @else
                                                    <img role="button" class="product-detail-img me-1 mb-2"
                                                        id="thumbnail-img-modal-{{ $loop->iteration }}"
                                                        src="https://source.unsplash.com/400x400?product-{{ $loop->iteration }}"
                                                        width="60"
                                                        onclick="change_image_modal(this,{{ $loop->iteration }},{{ $loop->count }})">
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                        <div class="col-md-6">
                                            <img src="" id="imagepreview" class="imagepreview" style="width: 100%;">

                                        </div>
                                        <div class="col-md-6">
                                            <img src="" id="imagepreviewZoom" class="imagepreviewZoom"
                                                style="width: 100%;">
                                                <div id="myresult2" class="img-zoom-result2"></div>

                                        </div>
                                    </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="commentImageModal" tabindex="-1" aria-labelledby="commentImageModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-transparent border-0">
                            <div class="modal-header border-0">
                                <h5 class="modal-title" id="commentImageModalLabel"></h5>
                                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img id="commentImagePreview" src="" class="commentImagePreview w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-12">
                {{-- <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data"
                            id="add-to-cart-form">
                            @csrf
                            @auth
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="subtotal" value="{{ $product->price }}">
                            @endauth
                            <input type="hidden" name="product_id" value="{{ $product->id }}"> --}}
                <div class="product-info">
                    <h5 class="fs-6">{{ $product->name }}</h5>
                    <div class="d-flex">
                        <p class="m-0">
                            <strong>{{ count($product->productvariant) > 0 ? $product->productvariant->sum('sold') : $product->sold }}</strong>
                            Terjual
                            <span class="mx-1">&#149;</span>
                            <a type="button" onclick="goToByScroll('rating-section')">
                                <i class="bi bi-star-fill text-warning"></i>
                                {{ round($star, 1) }}
                            </a>
                            <span class="mx-1">&#149;</span>
                            {{ $product->view }} orang melihat produk ini
                        </p>
                    </div>
                </div>

                <div class="product-price my-4">
                    <h4 class="product-price-text">
                        Rp
                        <span class="price-span" id="price-span">
                            @if (count($product->productvariant) == 1)
                                {{ price_format_rupiah($product->productvariant->sortBy('price')->first()->price) }}
                            @elseif (count($product->productvariant) > 1)
                                @if ($product->productvariant->sortBy('price')->first()->price ==
                                    $product->productvariant->sortBy('price')->last()->price)
                                    {{ price_format_rupiah($product->productvariant->sortBy('price')->first()->price) }}
                                @else
                                    {{ price_format_rupiah($product->productvariant->sortBy('price')->first()->price) }}
                                    -
                                    {{ price_format_rupiah($product->productvariant->sortBy('price')->last()->price) }}
                                @endif
                            @else
                                {{ price_format_rupiah($product->price) }}
                            @endif
                        </span>
                    </h4>
                </div>

                @if (count($product->productvariant) == 0)
                    <input type="hidden" class="none-variant" name="product_variant_ids" value="0">
                    <input type="hidden" class="none-variant" name="product_price" value="{{ $product->price }}">
                    {{-- <input type="hidden" class="none-variant" name="" value="{{  }}"> --}}
                @endif
                @if (count($product->productvariant) > 0)
                    <div class="variant mt-3">
                        <p class="fw-bold m-0 mb-2">Varian</p>
                        {{-- <div class="btn-group" role="group" aria-label="Basic radio toggle button group"> --}}
                        @foreach ($product->productvariant as $variant)
                            {{-- <input type="hidden" name="variantId[]" value="{{ $variant->id }}"> --}}
                            @php
                                $variant_id = $variant->id;
                            @endphp
                            <input type="hidden" class="btn-check" name="variantSlug-{{ $variant->id }}"
                                id="btn-radio-{{ $variant->variant_slug }}" autocomplete="off"
                                value="{{ $variant->variant_slug }}">

                            <input type="hidden" class="btn-check" name="variantWeight-{{ $variant->id }}"
                                id="btn-radio-{{ $variant->weight_used }}" autocomplete="off"
                                value="{{ $variant->weight_used }}">

                            <input type="hidden" class="btn-check" name="variantStock-{{ $variant->id }}"
                                id="btn-radio-{{ $variant->stock }}" autocomplete="off" value="{{ $variant->stock }}">

                            <input type="hidden" class="btn-check" name="variantPrice-{{ $variant->id }}"
                                id="btn-radio-{{ $variant->price }}" autocomplete="off"
                                value="{{ price_format_rupiah($variant->price) }}">

                            <input type="hidden" class="btn-check" name="variantPriceNoFormat-{{ $variant->id }}"
                                id="btn-radio-{{ $variant->price }}" autocomplete="off" value="{{ $variant->price }}">
                            @foreach ($variant->productorigin as $origin)
                                <input type="hidden" class="btn-check" name="senderAddressId-{{ $variant->id }}[]"
                                    id="btn-radio-{{ $variant->price }}" autocomplete="off"
                                    value="{{ $origin->senderaddress->id }}">
                                <input type="hidden" class="btn-check" name="senderAddressName-{{ $variant->id }}[]"
                                    id="btn-radio-{{ $variant->price }}" autocomplete="off"
                                    value="{{ $origin->senderaddress->name }}">
                                <input type="hidden" class="btn-check" name="senderAddresses-{{ $variant->id }}[]"
                                    id="btn-radio-{{ $variant->price }}" autocomplete="off"
                                    value="{{ $origin->senderaddress->address }}">
                                <input type="hidden" class="btn-check" name="senderAddressCity-{{ $variant->id }}[]"
                                    id="btn-radio-{{ $variant->price }}" autocomplete="off"
                                    value="{{ $origin->senderaddress->city->name }}">
                                <input type="hidden" class="btn-check" name="senderAddressCityId-{{ $variant->id }}[]"
                                    id="btn-radio-{{ $variant->price }}" autocomplete="off"
                                    value="{{ $origin->senderaddress->city_ids }}">
                            @endforeach
                            {{-- [{{  }}
                                    @foreach ($variant->productorigin as $origin)
                                        {{ $origin->id }},
                                    @endforeach
                                    ] --}}
                            <input type="radio" class="btn-check @error('product_variant_id') is-invalid @enderror"
                                name="product_variant_ids" id="btn-radio-{{ $variant->id }}" autocomplete="off"
                                value="{{ $variant->id }}">

                            <label
                                class="btn btn-variant btn-outline-danger me-1 my-1 shadow-none {{ $variant->stock <= 0 ? 'disabled' : '' }}"
                                id="btn variant"
                                for="btn-radio-{{ $variant->id }}">{{ $variant->variant_name }}</label>
                            {{-- <div>
                                        Tersedia di : 
                                        @foreach ($variant->productorigin as $origin)
                                            <p>{{ $origin->senderaddress->city->name }}</p>
                                        @endforeach
                                    </div> --}}
                        @endforeach
                        {{-- @error('quantity')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @error('subtotal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror --}}
                        @error('product_variant_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="product_variant_ids_error"></div>
                    </div>
                    <input type="hidden" name="subtotal" value="">
                @endif

                <div class="shipping mt-3">
                    <p class="fw-bold m-0 mb-2">Pengiriman
                        {{-- <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                  </div> --}}
                    </p>
                    <div class="row">
                        <div class="col-md-3 col-4">
                            <p class="m-0 shipping-text">
                                Dikirim dari
                            </p>
                        </div>
                        {{-- {{ dd($product->productorigin) }} --}}

                        <div class="col-md-5 col-8 ps-0 shipping-from ps-2">
                            <select class="form-select sender-address form-select-sm shadow-none" aria-label=""
                                name="city_origin" required>
                                <option selected="true" value="" disabled="disabled">Pilih alamat pengirim
                                </option>
                                @foreach ($product->productorigin as $origin)
                                    @if ($origin->senderaddress->is_active == 1)
                                        @if (isset($origin->productvariant))
                                            {{-- {{ $origin->productvariant->variant_name }}
                                                    {{ $origin->senderaddress->name }} -
                                                    {{ $origin->city->name == 'Kotawaringin Timur' ? $origin->city->name . ' (Sampit)' : $origin->city->name }}
                                                    <input type="hidden" class="variant" id="{{  $origin->productvariant->id }}" value="{{ $origin->city_ids }}"> --}}
                                        @else
                                            <option value="{{ $origin->senderaddress->id }}">
                                                {{ $origin->city->name == 'Kotawaringin Timur' ? $origin->city->name . ' (Sampit)' : $origin->city->name }}
                                                -
                                                ({{ $origin->senderaddress->address }})
                                            </option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                            {{-- <select
                                    class="form-control city-origin-select form-select form-select-sm shadow-none ps-0" name="city_origin">
                                    <option selected="true" value="" disabled="disabled">
                                        Pilih kota pengirim
                                    </option>
                                    @foreach ($product->productorigin as $origin)
                                        <option value="{{ $origin->city_ids }}">
                                            {{ ($origin->city->name == 'Kotawaringin Timur') ? $origin->city->name . ' (Sampit)' : $origin->city->name }}
                                        </option>
                                    @endforeach
                                </select> --}}
                            {{-- @foreach ($product->productorigin as $origin)
                                    <input type="radio"
                                        class="btn-check @error('product_origin') is-invalid @enderror"
                                        name="product_origins" id="btn-radio-{{ $origin->city_ids }}"
                                        autocomplete="off" value="{{ $origin->city_ids }}">
                                    <label
                                        class="btn btn-variant btn-outline-danger me-1 my-1 shadow-none"
                                        id="btn variant"
                                        for="btn-radio-{{ $origin->city_ids }}">{{  $origin->city->name }}</label>
                                @endforeach --}}
                            {{-- {{ $from_city->name }} --}}
                            <div class="sender_address_id_error fs-14"></div>
                        </div>
                    </div>
                    @error('sender_address_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    {{-- <div class="row">
                                    <div class="col-md-3">
                                        <p class="shipping-text m-0">
                                            Berat (gram)
                                        </p>
                                    </div>
                                    <div class="col-md-6 ps-0">
                                    </div>
                                </div> --}}
                    {{-- <input type="hidden" class="form-control py-0 ps-2 product-weight" name="weight" id="weight"
                            placeholder="Masukkan Berat (gram)" value="{{ $product->weight }}" readonly> --}}
                    <input type="hidden" class="form-control py-0 ps-2 product-weight" name="weight" id="weight"
                        placeholder="Masukkan Berat (gram)" value="1000" readonly>

                    <div class="row my-1">
                        <div class="col-md-3 col-4">
                            <p class="m-0 shipping-courier-text">
                                Ongkos Kirim
                            </p>
                        </div>
                        <div class="col-md-7 col-8 ps-0 shipping-courier-option ps-2">
                            <button type="button"
                                class="btn border-0 shadow-none text-start p-0 shipping shipping-courier-option-btn text-danger ps-2"
                                data-bs-toggle="modal" data-bs-target="#shipmentCourierModal">
                                Lihat pilihan kurir
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="shipmentCourierModal" tabindex="-1"
                                aria-labelledby="shipmentCourierModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                    <div class="modal-content shipment-cost-modal">
                                        <div class="modal-header p-4 border-0">
                                            <h5 class="modal-title" id="shipmentCourierModalLabel">Pilihan
                                                Kurir dan Ongkos Kirim</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row">
                                                <div class="col-md-4 col-12">
                                                    <div class="card shipment-cost-modal-card mb-4">
                                                        <div class="card-body p-3">
                                                            <div class="send-from">
                                                                Dikirim dari
                                                            </div>
                                                            <div class="send-from-city fw-bold">

                                                            </div>
                                                            <div class="divide">
                                                                <i class="bi bi-three-dots-vertical"></i>
                                                            </div>
                                                            <div class="send-to">
                                                                Tujuan
                                                            </div>
                                                            <div class="send-to-address text-truncate">
                                                                @auth
                                                                    @if (count(auth()->user()->useraddress) > 0)
                                                                        @foreach (auth()->user()->useraddress as $address)
                                                                            @if ($address->is_active == 1)
                                                                                <a class="btn send-to-address text-truncate text-decoration-none shadow-none text-dark fw-bold m-0 p-0"
                                                                                    data-bs-target="#addressModal"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-placement="bottom"
                                                                                    title="{{ $address->address }}, {{ $address->city->name }}, {{ $address->province->name }}, {{ $address->city->postal_code }}">
                                                                                    {{ $address->name }}
                                                                                </a>
                                                                                <input type="hidden" name="city_destinations"
                                                                                    value="{{ $address->city->city_id }}">
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <a href="{{ route('useraddress.index') }}"
                                                                            class="text-decoration-none fw-bold login-link">
                                                                            Tambahkan Alamat
                                                                        </a>
                                                                    @endif
                                                                @else
                                                                    {{-- <a href="/login"
                                                                            class="p-0 px-3 py-2 navbar-action login-btn login btn"
                                                                            role="button">
                                                                            Masuk
                                                                        </a> --}}
                                                                    {{-- <a class="btn px-3 py-2 navbar-action login btn" href="#" role="button">Masuk</a> --}}
                                                                    <a href="/login"
                                                                        class="text-decoration-none fw-bold login-link">
                                                                        Masuk
                                                                    </a>
                                                                @endauth
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card shipment-cost-modal-card mb-5">
                                                        <div class="card-body p-3">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <p class="m-0 shipping-text pt-1 fw-bold mb-3">
                                                                        Simulasi Ongkir (per Kg)
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <p class="m-0 shipping-text pt-1 fw-bold">
                                                                        Provinsi Asal
                                                                    </p>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group mb-2">
                                                                        {{-- <label class="font-weight-bold">PROVINSI TUJUAN</label> --}}
                                                                        <select
                                                                            class="form-control origin-province form-select form-select-sm shadow-none ps-0"
                                                                            name="province_origin">
                                                                            <option value="0">Pilih provinsi
                                                                                Asal
                                                                            </option>
                                                                            @foreach ($provinces as $provinceId => $value)
                                                                                <option value="{{ $provinceId }}">
                                                                                    {{ $value }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <p class="m-0 shipping-text pt-1 fw-bold">
                                                                        Kota Asal
                                                                    </p>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group mb-2">
                                                                        {{-- <label class="font-weight-bold">KOTA / KABUPATEN TUJUAN</label> --}}
                                                                        <select
                                                                            class="form-control origin-city form-select form-select-sm text-truncate"
                                                                            name="city_origin_on_modal">
                                                                            <option value="">Pilih kota asal
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <p class="m-0 shipping-text pt-1 fw-bold">
                                                                        Provinsi Tujuan
                                                                    </p>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group mb-2">
                                                                        {{-- <label class="font-weight-bold">PROVINSI TUJUAN</label> --}}
                                                                        <select
                                                                            class="form-control destination-province form-select form-select-sm shadow-none ps-0"
                                                                            name="province_destination">
                                                                            <option value="0">Pilih provinsi
                                                                                tujuan
                                                                            </option>
                                                                            @foreach ($provinces as $provinceId => $value)
                                                                                <option value="{{ $provinceId }}">
                                                                                    {{ $value }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <p class="m-0 shipping-text pt-1 fw-bold">
                                                                        Kota Tujuan
                                                                    </p>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group mb-2">
                                                                        {{-- <label class="font-weight-bold">KOTA / KABUPATEN TUJUAN</label> --}}
                                                                        <select
                                                                            class="form-control destination-city form-select form-select-sm text-truncate"
                                                                            name="city_destination">
                                                                            <option value="">Pilih kota tujuan
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <p class="shipping-text m-0 fw-bold">
                                                                        Ongkos Kirim
                                                                    </p>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group mb-2">
                                                                        {{-- <label class="font-weight-bold">PROVINSI TUJUAN</label> --}}
                                                                        <select
                                                                            class="form-control courier-choices form-select form-select-sm shadow-none text-truncate"
                                                                            name="courier">
                                                                            <option value="0">Pilihan Kurir
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-12">
                                                    <h5>Perkiraan Ongkos Kirim</h5>
                                                    @auth
                                                        @if (count(auth()->user()->useraddress) > 0)
                                                            <div class="accordion accordion-flush" id="accordionShipment">
                                                                @if (count($product->productvariant) > 0)
                                                                    @foreach ($product->productvariant as $variant)
                                                                        <div class="accordion-item">
                                                                            <h2 class="accordion-header"
                                                                                id="flush-headingOne">
                                                                                <button
                                                                                    class="accordion-button accordionShipmentButton accordion-shipment-{{ $variant->id }} collapsed shadow-none "
                                                                                    type="button" data-bs-toggle="collapse"
                                                                                    data-bs-target="#shipment-courier-{{ $variant->id }}"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="shipment-courier-{{ $variant->id }}">
                                                                                    Varian
                                                                                    {{ $variant->variant_name }}
                                                                                    ({{ round($variant->weight_used / 1000, 2) }}kg)
                                                                                </button>
                                                                            </h2>
                                                                            <div id="shipment-courier-{{ $variant->id }}"
                                                                                class="accordion-collapse collapse"
                                                                                aria-labelledby="flush-headingOne"
                                                                                data-bs-parent="#accordionShipment">
                                                                                <div
                                                                                    class="accordion-body product-modal-shipment shipment-{{ $variant->id }}">
                                                                                    <div
                                                                                        class="modal-ongkir row d-flex align-items-center mb-3">
                                                                                        <div class="col-11">
                                                                                            Memuat data...
                                                                                        </div>
                                                                                        <div class="col-1">
                                                                                            <div class="spinner-border spinner-border-sm"
                                                                                                role="status">
                                                                                                <span
                                                                                                    class="visually-hidden">Loading...</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="flush-headingOne">
                                                                            <button
                                                                                class="accordion-button accordionShipmentButton collapsed shadow-none accordion-shipment-{{ $product->id }}"
                                                                                type="button" data-bs-toggle="collapse"
                                                                                data-bs-target="#flush-collapseOne"
                                                                                aria-expanded="false"
                                                                                aria-controls="flush-collapseOne">
                                                                                Biaya Ongkos Kirim :
                                                                                {{ $product->name }}
                                                                            </button>
                                                                        </h2>
                                                                        <div id="flush-collapseOne"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="flush-headingOne"
                                                                            data-bs-parent="#accordionShipment">
                                                                            <div
                                                                                class="accordion-body shipment-{{ $product->id }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div class="product-no-auth-shipment-check">
                                                                Kamu belum menambahkan alamat, yuk
                                                                <a href="{{ route('useraddress.index') }}"
                                                                    class="text-decoration-none fw-bold login-link">
                                                                    Tambahkan Alamat
                                                                </a>
                                                                untuk melihat perkiraan biaya ongkir ke lokasimu
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="product-no-auth-shipment-check">
                                                            Kamu belum masuk, yuk
                                                            <a href="/login" class="text-decoration-none fw-bold login-link">
                                                                Masuk
                                                            </a>
                                                            untuk melihat perkiraan biaya ongkir ke lokasimu
                                                        </div>
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content border-radius-075rem">
                                        <div class="modal-header border-0 p-4">
                                            <h5 class="modal-title m-0" id="addressModalLabel">Pilih Alamat
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            @auth
                                                @foreach (auth()->user()->useraddress as $address)
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
                                                                            <span
                                                                                class="m-0 checkout-shipment-address-province me-1">
                                                                                {{ $address->province->name }},
                                                                            </span>
                                                                            <span
                                                                                class="m-0 checkout-shipment-address-postalcode">
                                                                                {{ $address->city->postal_code }}
                                                                            </span>
                                                                        </div>
                                                                        <div class="input-data">
                                                                            <input class="address-id" type="hidden"
                                                                                name="addressId"
                                                                                value="{{ $address->id }}">
                                                                            <input class="user-id" type="hidden"
                                                                                name="userId"
                                                                                value="{{ auth()->user()->id }}">
                                                                            <input class="city-origin" type="hidden"
                                                                                name="cityOrigin" value="35">
                                                                            <input class="city-destination" type="hidden"
                                                                                name="cityDestination"
                                                                                value="{{ $address->city->city_id }}">
                                                                        </div>
                                                                        <div class=" mt-2 d-flex align-items-center">
                                                                            @if ($address->is_active != 1)
                                                                                <button type="submit"
                                                                                    class="btn m-0 p-0 text-decoration-none text-danger checkout-shipment-address-change-link shadow-none"
                                                                                    href="#editAddressModal"
                                                                                    data-bs-toggle="modal" role="button">
                                                                                    Pilih Alamat
                                                                                </button>
                                                                                <span class="text-secondary mx-1"> |
                                                                                </span>
                                                                            @endif
                                                                            <a class="text-decoration-none text-danger checkout-shipment-address-change-link"
                                                                                href="#editAddressModal"
                                                                                data-bs-toggle="modal" role="button">
                                                                                Edit Alamat
                                                                            </a>
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
                                            @else
                                            @endauth
                                        </div>
                                        <div class="modal-footer border-0 p-4">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
                        </div>
                    </div>
                </div>

                <div class="order mt-3">
                    <p class="fw-bold m-0 mb-2">Jumlah Pemesanan</p>
                    <div class="col-md-6 col-12 d-flex align-items-center">
                        <div class="input-group inline-group inline-group-qty-product-detail">
                            <div class="input-group-prepend">
                                <button type="button"
                                    class="btn btn-minus-qty-product-detail shadow-none {{ count($product->productvariant) == 0 ? ($product->stock <= 0 ? 'disabled' : '') : '' }}">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                            </div>
                            <input class="form-control qty-product-detail shadow-none" min="0"
                                name="quantity_product" value="1" type="number" min="1"
                                max="{{ count($product->productvariant) > 0 ? $product->productvariant->sum('stock') : $product->stock }}"
                                onkeydown="return false"
                                {{ count($product->productvariant) == 0 ? ($product->stock <= 0 ? 'disabled' : '') : '' }}>
                            <div class="input-group-append">
                                <button type="button"
                                    class="btn btn-plus-qty-product-detail shadow-none {{ count($product->productvariant) == 0 ? ($product->stock <= 0 ? 'disabled' : '') : '' }}">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="order-qty ms-2">
                            stok tersedia
                            <p class="fw-bold d-inline order-qty-stock">
                                {{ $stock }}
                            </p>
                            unit
                        </div>
                    </div>
                    {{-- @if (count($product->productvariant) > 0)
                                {{ ($product->productvariant->stock) }}
                                @if (empty($product->productvariant->stock))
                                    <p class="text-danger fs-12 text-start ps-md-5 ms-md-5 pt-md-2 mb-0">
                                        Saat ini stock produk sedang kosong, kamu bisa memesan jika stock kembali ada.
                                    </p>
                                @endif
                            @else
                                @if (empty($product->stock))
                                    <p class="text-danger fs-12 text-start ps-md-5 ms-md-5 pt-md-2 mb-0">
                                        Stock produk ini sedang kosong, kamu tidak bisa checkout saat ini
                                    </p>
                                @endif
                            @endif --}}
                </div>

                <div class="product-order-action mt-4 d-flex">

                    {{-- <form action="{{ route('cart.store') }}" onsubmit="return validateCart()" method="POST" enctype="multipart/form-data"
                            id="add-to-cart-form">
                                @csrf
                                @auth
                                    <input type="text" name="user_id" value="{{ auth()->user()->id }}">
                                @endauth
                                <input type="text" name="type" value="cart">
                                <input type="text" name="product_id" value="{{ $product->id }}">
                                <input type="text" name="product_variant_id" value="">
                                <input type="text" name="quantity" value="">
                                <input type="text" name="subtotal" value="">
                                <button type="submit" class="btn btn-outline-danger add-to-cart-btn px-3 py-2 my-1 me-2"
                                    id="add-to-cart-btn">
                                    <i class="bi bi-cart"></i>
                                    Masukkan keranjang
                                </button>
                            </form> --}}

                    <form action="{{ route('cart.store') }}" onsubmit="return validateForm()" method="POST"
                        enctype="multipart/form-data" id="add-to-cart-form">
                        @csrf
                        @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        @endauth
                        <input type="hidden" name="type" value="cart">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_variant_id" value="">
                        <input type="hidden" name="sender_address_id" value="">
                        <input type="hidden" name="quantity"
                            value="{{ count($product->productvariant) == 0 ? '1' : '' }}">
                        <input type="hidden" name="subtotal"
                            value="{{ count($product->productvariant) == 0 ? $product->price : '' }}">
                        <button type="submit"
                            class="btn btn-outline-danger add-to-cart-btn px-3 py-2 my-1 me-2 {{ count($product->productvariant) == 0 ? (empty($product->stock) ? 'disabled' : '') : '' }}"
                            id="add-to-cart-btn">
                            <i class="bi bi-cart"></i>
                            Masukkan Keranjang
                        </button>
                    </form>

                    <form action="{{ route('buy.now') }}" onsubmit="return validateForm()" method="POST"
                        enctype="multipart/form-data" id="add-to-cart-form">
                        @csrf
                        @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        @endauth
                        <input type="hidden" name="type" value="buyNow">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_variant_id" value="">
                        <input type="hidden" name="sender_address_id" value="">
                        <input type="hidden" name="quantity" value="">
                        <input type="hidden" name="subtotal" value="">
                        <button type="submit" id="checkout-button"
                            class="btn btn-danger checkout-btn px-3 py-2 my-1 {{ count($product->productvariant) == 0 ? (empty($product->stock) ? 'disabled' : '') : '' }}">
                            <i class="bi bi-wallet"></i>
                            Beli Sekarang
                        </button>
                    </form>

                </div>
                {{-- </form> --}}
                {{-- </div> --}}
            </div>
            <div class="col-md-12 mt-5">
                <h5 class="mb-2">Spesifikasi Produk</h5>
                <div class="product-spec">
                    <ul class="m-0">
                        <li>
                            <span>
                                Merk :
                            </span>
                            <span>
                                <a class="text-danger text-decoration-none fw-600"
                                    href="/merk/{{ $product->productmerk->slug }}">
                                    {{ $product->productmerk->name }}
                                </a>
                            </span>
                        </li>
                        <li>
                            <span>
                                Kategori :
                            </span>
                            <span>
                                <a class="text-danger text-decoration-none fw-600"
                                    href="/merk/{{ $product->productcategory->slug }}">
                                    {{ $product->productcategory->name }}
                                </a>
                            </span>
                        </li>
                        <li>
                            <span>
                                Stock :
                            </span>
                            <span>
                                {{ $stock }}
                            </span>
                        </li>
                        <li>
                            <span>
                                Berat :
                            </span>
                            <span>
                                @if (count($product->productvariant) == 1)
                                    {{ $product->productvariant->sortBy('weight')->first()->weight_used / 1000 }}kg
                                @elseif (count($product->productvariant) > 1)
                                    @if ($product->productvariant->sortBy('weight')->first()->weight_used ==
                                        $product->productvariant->sortBy('weight')->last()->weight_used)
                                        {{ round($product->productvariant->sortBy('weight')->first()->weight_used / 1000, 2) }}kg
                                    @else
                                        {{ round($product->productvariant->sortBy('weight')->first()->weight_used / 1000, 2) }}
                                        -
                                        {{ round($product->productvariant->sortBy('weight')->last()->weight_used / 1000, 2) }}kg
                                    @endif
                                @else
                                    {{ $product->weight_used / 1000 }}kg
                                @endif
                            </span>
                        </li>
                    </ul>
                    {!! $product->specification !!}
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <h5 class="mb-2">Deskripsi Produk</h5>
                <div class="product-description">
                    {!! $product->description !!}
                </div>
            </div>

            <div class="col-md-12 mt-5 rating-section" id="rating-section">
                <h5 class="mb-2">Penilaian Produk</h5>
                <div class="d-flex my-3">
                    <div class="">
                        <h2>
                            <i class="bi bi-star-fill text-warning"></i>
                        </h2>
                    </div>
                    <div class="ps-2">
                        <h2 class="">
                            <p class="m-0">
                                {{ round($star, 1) }}
                                dari 5.0
                            </p>
                        </h2>
                        <h5>{{ $count_comments }} Penilaian</h5>
                    </div>
                </div>
                <div class="comment-section">
                    @foreach ($comments as $comment)
                        @if ($comment->reply_comment_id == 0 ||
                            is_null($comment->reply_comment_id) ||
                            empty($comment->reply_comment_id) ||
                            !isset($comment->reply_comment_id))
                            <div class="d-flex mt-4">
                                <div class="flex-shrink-0">
                                    @if (isset($comment->user->profile_image))
                                        <img src="{{ asset($comment->user->profile_image) }}" class="rounded-circle"
                                            alt="user profile image" width="50" height="50">
                                    @elseif (isset($comment->admin->profile_image))
                                        <img src="{{ asset($comment->admin->profile_image) }}" class="rounded-circle"
                                            alt="user profile image" width="50" height="50">
                                    @else
                                        <img src="{{ asset('/assets/avatars.svg') }}" class="rounded-circle"
                                            alt="" width="50" height="50">
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="comment-text mb-1">
                                        @for ($i = 0; $i < $comment->star; $i++)
                                            <i class="bi bi-star-fill text-warning"></i>
                                        @endfor
                                        @for ($i = 0; $i < 5 - $comment->star; $i++)
                                            <i class="bi bi-star text-warning"></i>
                                        @endfor
                                    </p>
                                    <h5 class="comment-text mb-1">{{ $comment->user->username }}
                                        <small class="text-muted comment-text fw-light ms-1">
                                            <i>Diposting
                                                {{ $comment->created_at->diffForHumans() }}
                                            </i>
                                        </small>
                                    </h5>
                                    @if (isset($comment->productvariant))
                                        <div class="comment-text text-grey fs-13 mb-2">
                                            Varian : {{ $comment->productvariant->variant_name }}
                                        </div>
                                    @endif
                                    <div class="comment-text mb-2">
                                        {!! $comment->comment !!}
                                    </div>
                                    @if (!is_null($comment->comment_image) && !empty($comment->comment_image) && isset($comment->comment_image))
                                        <img src="{{ asset($comment->comment_image) }}" class="commentImage"
                                            id="commentImage" alt="" width="10%">
                                    @endif
                                </div>
                            </div>
                            {{-- {{ print_r($comment->children) }} --}}
                            @php
                                $countChild = 0;
                                foreach ($comment->children as $commentChild) {
                                    if ($commentChild->product_id == $comment->product_id) {
                                        $countChild += 1;
                                    }
                                }
                            @endphp
                            @if ($countChild > 0)
                                @php
                                    $iterate = $loop->iteration;
                                @endphp
                                <div class="ms-1">
                                    <a class="btn mb-0 py-0 ms-5 comment-text fw-bold shadow-none"
                                        data-bs-toggle="collapse" href="#collapseSubcomment{{ $iterate }}"
                                        role="button" aria-expanded="false" aria-controls="collapseExample">
                                        Lihat Balasan ({{ $countChild }})
                                    </a>
                                </div>
                            @endif
                            @foreach ($comment->children as $commentChild)
                                @if ($commentChild->product_id == $comment->product_id)
                                    <div class="collapse mt-2" id="collapseSubcomment{{ $iterate }}">
                                        <div class="d-flex ms-5">
                                            <div class="flex-shrink-0 ms-3">
                                                @if (isset($commentChild->user->profile_image))
                                                    <img src="{{ asset($commentChild->user->profile_image) }}"
                                                        class="rounded-circle" alt="user profile image" width="50"
                                                        height="50">
                                                @elseif (isset($commentChild->admin))
                                                    {{-- <img src="{{ asset($commentChild->admin->profile_image) }}"
                                                        class="rounded-circle" alt="admin profile image" width="50"
                                                        height="50"> --}}
                                                    <img src="{{ asset('/assets/klikspl-admin-icon.svg') }}"
                                                        class="rounded-circle" alt="" width="50"
                                                        height="50">
                                                @else
                                                    <img src="{{ asset('/assets/avatars.svg') }}" class="rounded-circle"
                                                        alt="" width="50" height="50">
                                                @endif
                                            </div>
                                            <div class="flex-grow-1 ms-3 mb-3">
                                                {{-- <p class="comment-text mb-1">
                                                        @for ($i = 0; $i < $commentChild->star; $i++)
                                                            <i class="bi bi-star-fill text-warning"></i>
                                                        @endfor
                                                        @for ($i = 0; $i < 5 - $commentChild->star; $i++)
                                                            <i class="bi bi-star text-warning"></i>
                                                        @endfor
                                                    </p> --}}
                                                <div>

                                                </div>
                                                <h5 class="comment-text mb-1">
                                                    @if (isset($commentChild->user->username))
                                                        {{ $commentChild->user->username }}
                                                    @elseif (isset($commentChild->admin->username))
                                                        {{ $commentChild->admin->admintype->admin_type }}
                                                    @endif
                                                    <small class="text-muted comment-text fw-light ms-1">
                                                        <i>Diposting
                                                            {{ $commentChild->created_at->diffForHumans() }}
                                                        </i>
                                                    </small>
                                                </h5>
                                                <div class="comment-text">{!! $commentChild->comment !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- {{ $commentChild->parent }} --}}
                                @else
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        {{-- {{ (json_encode($product)) }} --}}
        {{-- </div> --}}
    </div>
    <script>
        try {
            //code
            function validateForm() {
                $('.product_variant_ids_error').add('.invalid-feedback').empty();
                // $('.product_variant_ids_error').empty();
                if ($('input[name="product_variant_id"]').val() == '') {
                    $('.product_variant_ids_error').html(
                        '<p class="text-danger m-0">Pilih varian produk terlebih dahulu</p>');
                    return false;
                }
                if ($('input[name="sender_address_id"]').val() == 0) {
                    $('.sender_address_id_error').html(
                        '<p class="text-danger m-0 ps-2">Pilih alamat pengirim terlebih dahulu</p>');
                    return false;
                }

            }
            $(window).on('load', function() {
                var var_ids = $('input[name="product_variant_ids"]').val();
                var token = $('input[name="csrf-token"]').val();
                var city_destinations = $('input[name="city_destinations"]').val();
                var product = {!! json_encode($product) !!};
                var origins = {!! json_encode($from_city->city_id) !!};
                var courier = 'all';
                window.varianIdGlobal = [];
                // window.city_origins = {!! json_encode($product->productorigin->unique('sender_address_id')) !!}
                window.city_origins = {!! json_encode($senderAddress) !!};
                console.log(city_origins);
                if (city_origins == '') {
                    window.location.reload();
                }
                window.city_origin_status = '';
                if (var_ids == 0) {
                    $('input[name="product_variant_id"]').val(var_ids);
                    $('input[name="quantity"]').val($('input[name="quantity_product"]').val());
                    $('input[name="subtotal"]').val($('input[name="product_price"]').val());
                }

                // console.log({!! json_encode(json_decode($product)) !!});
                console.log(product);
                console.log(product['productvariant'].length);

            });
            $(document).ready(function() {
                $('body').on('click', '#commentImage', function() {
                    $('.commentImagePreview').attr('src', $(this).attr('src'));
                    $('#commentImageModal').modal('show');
                });

                var $easyzoom = $('.easyzoom').easyZoom();
                var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');
                $('.thumbnails-modal').on('click', 'a', function(e) {
                    var $this = $(this);
                    e.preventDefault();
                    api1.swap($this.data('standard'), $this.attr('href'));
                })

                window.city_id = '';
                $('select[name="city_origin"]').on('change', function() {
                    let senderAddressId = ($('select[name="city_origin"]').find(":selected").val());
                    console.log(senderAddressId);
                    $('input[name="sender_address_id"]').val(senderAddressId);
                    $('.sender_address_id_error').html('');
                    $.each(city_origins, function(key, value) {
                        if (value['id'] == senderAddressId) {
                            $('.send-from-city').text(value['city']['type'] + ' ' + value['city'][
                                'name'
                            ]);
                            console.log(value['city']['city_id']);
                            city_id = value['city']['city_id'];
                            accordionShipmentId = [];
                            $.each(varianIdGlobal, function(key, value) {
                                console.log('variant ID : ' + value);
                                $('.shipment-' + value).empty();
                                $('.shipment-' + value).html(
                                    '<div class="modal-ongkir row d-flex align-items-center mb-3"> <div class="col-11">Memuat data...</div> <div class="col-1"><div class="spinner-border spinner-border-sm" role="status"> <span class="visually-hidden">Loading...</span> </div> </div> </div>'
                                );
                            })

                        }
                    });
                    if (senderAddressId == 0) {
                        console.log('sender address 0 : ' + senderAddressId);
                        $('.sender_address_id_error').html(
                            '<p class="text-danger m-0 ps-2">Pilih alamat pengirim terlebih dahulu</p>');
                    }

                });

                var var_ids = $('input[name="product_variant_ids"]').val();
                var token = $('input[name="csrf-token"]').val();
                var city_destinations = $('input[name="city_destinations"]').val();
                var product = {!! json_encode($product) !!};
                var origins = $('input[name="sender_address_id"]').val();
                var courier = 'all';

                function getShipmentCost(token, city_origin, city_destination, courier, weight) {

                    console.log('token ' + token);
                    console.log('origin ' + city_origin);
                    console.log('destination ' + city_destination);
                    console.log('courier ' + courier);
                    console.log('weight ' + weight);
                    return $.ajax({
                        url: "/ongkir",
                        data: {
                            _token: token,
                            city_origin: city_origin,
                            city_destination: city_destination,
                            courier: courier,
                            weight: weight,
                        },
                        dataType: "JSON",
                        type: "POST",
                    });
                }
                if ($('input[name="city_destinations"]').val() != null) {
                    if ((product['productvariant'].length > 0)) {
                        window.accordionShipmentId = [];
                        window.city_ids = '';
                        // window.varianIdGlobal = [];
                        $.each(product['productvariant'], function(key, value) {
                            $('.accordion-shipment-' + value['id']).on('click', function() {
                                console.log(value['id']);
                                console.log('city ids : ' + city_ids);
                                console.log('city id : ' + city_id);
                                console.log('accordionShipmentId : ' + accordionShipmentId);
                                console.log('value["id"] : ' + value['id']);
                                console.log('global value["id"] : ' + varianIdGlobal);
                                if (city_id == '') {
                                    alert(
                                        'Pilih varian dan kota asal pengiriman terlebih dahulu untuk melihat perkiraan ongkir'
                                    );
                                    return false;
                                }
                                if (city_ids != city_id || !accordionShipmentId.includes(value[
                                        'id'])) {
                                    if (!varianIdGlobal.includes(value['id'])) {
                                        window.varianIdGlobal.push(value['id']);
                                    }
                                    city_ids = city_id;
                                    accordionShipmentId.push(value['id']);
                                    // setTimeout(function() {
                                    //     $('.shipment-' + variantID).empty();
                                    //     $('.shipment-' +
                                    //         variantID).append('ini city id ' + city_id +
                                    //         ' dan variant id' + accordionShipmentId);
                                    // }, 2000);

                                    $.when(getShipmentCost(token, city_id, city_destinations,
                                            courier,
                                            value['weight_used']))
                                        .done(
                                            function(response) {
                                                console.log(response);
                                                if (response.length > 1) {
                                                    $('.shipment-' + variantID).empty();
                                                    for (let index = 0; index < response
                                                        .length; index++) {
                                                        $.each(response[index][0]['costs'],
                                                            function(key, value) {
                                                                if (response[index][0].code !=
                                                                    'pos') {
                                                                    $('.shipment-' + variantID)
                                                                        .append(
                                                                            '<div class="modal-ongkir row d-flex align-items-center mb-3"><div class="col-1 pe-0 text-center"><i class="bi bi-circle-fill"></i></div><div class="col-8"><p class="m-0 d-inline-block modal-courier-type pe-1">' +
                                                                            ' hari</p></div><div class="col-3"><p class="text-end m-0 modal-courier-price">' +
                                                                            formatRupiah(value
                                                                                .cost[0].value,
                                                                                "Rp") +
                                                                            ' </p></div></div>'
                                                                        );
                                                                }
                                                            }
                                                        );
                                                    }
                                                } else {
                                                    $('.shipment-' + variantID).empty();
                                                    $.each(response[index][0]['costs'], function(
                                                        key,
                                                        value) {
                                                        $('.shipment-' + variantID).append(
                                                            '<div class="modal-ongkir row d-flex align-items-center mb-3"><div class="col-1 pe-0 text-center"><i class="bi bi-circle-fill"></i></div><div class="col-8"><p class="m-0 d-inline-block modal-courier-type">' +
                                                            response[index][0].code
                                                            .toUpperCase() +
                                                            '</p><p class="m-0 d-inline-block modal-courier-package">' +
                                                            value.service +
                                                            '</p><p class="m-0 modal-courier-etd"> Estimasi ' +
                                                            value.cost[0].etd +
                                                            ' hari</p></div><div class="col-3"><p class="text-end m-0 modal-courier-price">' +
                                                            formatRupiah(value.cost[0]
                                                                .value,
                                                                "Rp") +
                                                            ' </p></div></div>'
                                                        )
                                                    });
                                                }
                                            }).fail(function(data) {
                                            $('.shipment-' + variantID).empty();
                                            $('.shipment-' + variantID).append(
                                                '<div class="modal-ongkir row d-flex align-items-center mb-3"> <div class="col-11"> Gagal memuat data ongkir. Periksa koneksi internet anda atau coba muat ulang halaman</div><div class="col-1"></div></div>'
                                            );
                                        });
                                }
                            });
                            var variantID = value['id'];
                            console.log(value['weight_used']);
                        });
                    } else {
                        var productID = product['id'];
                        var productWeight = product['weight_used'];
                        console.log(productWeight);
                        window.accordionShipmentId = [];
                        window.city_ids = '';
                        $('.accordion-shipment-' + product['id']).on('click', function() {
                            console.log(product['id']);
                            console.log('city ids : ' + city_ids);
                            console.log('city id : ' + city_id);
                            console.log('accordionShipmentId : ' + accordionShipmentId);
                            console.log('product["id"] : ' + product['id']);
                            console.log('global value["id"] : ' + varianIdGlobal);
                            if (city_id == '') {
                                alert(
                                    'Pilih varian dan kota asal pengiriman terlebih dahulu untuk melihat perkiraan ongkir'
                                );
                                return false;
                            }
                            if (city_ids != city_id || !accordionShipmentId.includes(product[
                                    'id'])) {
                                if (!varianIdGlobal.includes(product['id'])) {
                                    window.varianIdGlobal.push(product['id']);
                                }
                                city_ids = city_id;
                                accordionShipmentId.push(product['id']);
                                $.when(getShipmentCost(token, city_id, city_destinations, courier,
                                        productWeight))
                                    .done(
                                        function(response) {
                                            console.log(response);
                                            if (response.length > 1) {
                                                $('.shipment-' + productID).empty();
                                                for (let index = 0; index < response.length; index++) {
                                                    $.each(response[index][0]['costs'], function(key,
                                                        value) {
                                                        $('.shipment-' + productID).append(
                                                            '<div class="modal-ongkir row d-flex align-items-center mb-3"><div class="col-1 pe-0 text-center"><i class="bi bi-circle-fill"></i></div><div class="col-8"><p class="m-0 d-inline-block modal-courier-type pe-1">' +
                                                            response[index][0].code
                                                            .toUpperCase() +
                                                            '</p><p class="m-0 d-inline-block modal-courier-package">' +
                                                            value.service +
                                                            '</p><p class="m-0 modal-courier-etd"> Estimasi ' +
                                                            value.cost[0].etd +
                                                            ' hari</p></div><div class="col-3"><p class="text-end m-0 modal-courier-price">' +
                                                            formatRupiah(value.cost[0].value,
                                                                "Rp") +
                                                            ' </p></div></div>'
                                                        )
                                                    });
                                                }
                                            } else {
                                                $('.shipment-' + productID).empty();
                                                $.each(response[index][0]['costs'], function(key, value) {
                                                    $('.shipment-' + productID).append(
                                                        '<div class="modal-ongkir row d-flex align-items-center mb-3"><div class="col-1 pe-0 text-center"><i class="bi bi-circle-fill"></i></div><div class="col-8"><p class="m-0 d-inline-block modal-courier-type">' +
                                                        response[index][0].code.toUpperCase() +
                                                        '</p><p class="m-0 d-inline-block modal-courier-package">' +
                                                        value.service +
                                                        '</p><p class="m-0 modal-courier-etd"> Estimasi ' +
                                                        value.cost[0].etd +
                                                        ' hari</p></div><div class="col-3"><p class="text-end m-0 modal-courier-price">' +
                                                        formatRupiah(value.cost[0].value,
                                                            "Rp") +
                                                        ' </p></div></div>'
                                                    )
                                                });
                                            }
                                        }).fail(function(data) {
                                        $('.shipment-' + productID).empty();
                                        $('.shipment-' + productID).append(
                                            '<div class="modal-ongkir row d-flex align-items-center mb-3"> <div class="col-11"> Gagal memuat data ongkir coba lagi nanti ya </div><div class="col-1"></div></div>'
                                        );
                                    });
                            }
                        });
                    }
                }
                // var newStateVal = 'test';
                // var newState = new Option(newStateVal, newStateVal, true, true);
                // // Append it to the select
                // // $(".sender-address").append(newState).trigger('change');
                // $('.sender-address').html('').select2({data: [{id: '', text: ''}]});
                // $(".sender-address").append(new Option('Pilih kota pengirim',0,true,true)).trigger('change');
            });
        } catch (err) {
            location.reload();
        }
        // $(window).focus(function() {
        //     window.location.reload();
        // });
    </script>
@endsection
