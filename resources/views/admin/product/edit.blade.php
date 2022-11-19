@extends('admin.layouts.main')
@section('container')
    {{-- {{ dd(($product->productvariant)) }} --}}
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
    <div class="alert-notification-wrapper">
    </div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-md-3 pt-5 pb-3 mb-1">
        <h4 class="m-0">
            <a href="{{ route('adminproduct.index') }}" class="text-decoration-none link-dark">
                <i class="bi bi-arrow-left"></i>
            </a>
            Edit Produk
        </h4>
        <a class="btn btn-secondary fs-14" href="{{ route('product.show', $product) }}" target="_blank"><i
                class="bi bi-eye"></i> Preview produk</a>
    </div>
    <form action="{{ route('adminproduct.update', $product) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
        <div class="container p-0 mb-4">
            <div class="card product-image-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Foto Produk</h5>
                    </div>
                </div>
                <div class="card-body p-4 pt-2 pb-0 create-product-image">
                    <div class="row pt-1">
                        <label for="" class="col-sm-3 col-form-label product-image-label">
                            <p class="fw-600 m-0">
                                Tambahkan Foto Produk
                            </p>
                            <p class="text-grey fs-12 m-0">Format Gambar (.jpg, .jpeg, .png), ukuran maksimal 2MB,
                                Cantumkan
                                minimal 1 foto</p>
                        </label>
                        <div class="col-sm-9">
                            <div class="row mb-3">
                                <div class="col-md-7 col-12">
                                    <input required type="hidden" name="admin_id"
                                        value="{{ auth()->guard('adminMiddle')->user()->id }}">
                                    <input class="form-control form-control-sm product-image-class" id="productImage_0"
                                        type="file" name="productImage[0]">
                                    <input required type="hidden" id="productImageUpload_0" class="productImageUpload_0"
                                        name="productImageUpload[0]">
                                    {{-- <input required class="form-control form-control-sm product-image-class" id="productImageTemp_0"
                                        type="file" name="productImageTemp[0]"> --}}
                                    <div id="imageSource_0"></div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <img class="img-preview-0 img-fluid">
                                    <div class="show-before-upload-0"></div>
                                </div>
                            </div>
                            <div id="new_product_img"></div>
                            <input required type="hidden" value="0" id="total_product_img">
                        </div>
                    </div>
                    <div class="col-sm-5">
                        {{-- <img class="img-fluid mt-3" id="img-preview" src="" alt="" style="max-width: 800px; max-height: 400px;"> --}}
                    </div>
                </div>
                <div class="card-footer bg-transparent p-4 border-0">
                    <div class="d-flex justify-content-end">
                        <div class="btn btn-outline-danger mx-1 fs-14" onclick="removeImage()"><i class="bi bi-trash3"></i>
                            Hapus</div>
                        <div class="btn btn-danger mx-1 fs-14" onclick="addImage()"><i class="bi bi-folder-plus"></i> Tambah
                            Foto</div>
                        {{-- <button type="submit" class="btn btn-danger mx-1 fs-14">Upload</button> --}}
                    </div>
                    <div class="d-flex mt-3">
                        <div class="row">
                            <h5 class="m-0 mb-3">Diupload</h5>
                            @foreach ($product->productimage as $image)
                                <div class="col-md-2 col-6 mb-4">
                                    {{-- <form action="{{ route('admin.product.delete.image') }}" method="post"> --}}
                                    {{-- @csrf --}}
                                    <img class="w-100" src="{{ asset('/storage/' . $image->name) }}" alt="">
                                    <input type="hidden" name="image_id" value="{{ $image->id }}">
                                    <button type="button" class="btn btn-danger fs-14 mt-2 btn-delete-image"
                                        id="{{ $image->id }}">
                                        <i class="bi bi-trash3"></i> Hapus
                                    </button>
                                    {{-- <input class="btn btn-primary btn-test" type="button" value="Input" id="{{ $image->id }}"> --}}
                                    {{-- </form> --}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container p-0 mb-4">
            <div class="card product-info-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Informasi Produk</h5>
                        <p class="text-grey fs-13 m-0">Isikan nama, ID, kategori, dan merk produk</p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-3 row">
                        <label for="productName" class="col-sm-3 col-form-label fw-600">Nama Produk</label>
                        <div class="col-sm-9">
                            <input required type="text" class="form-control fs-14 @error('name') is-invalid @enderror"
                                id="productName" name="name" placeholder="Ketikkan nama produk"
                                value="{{ $product->name }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="productSlug" class="col-sm-3 col-form-label ">
                            <p class="fw-600 m-0">
                                Slug Produk
                            </p>
                            <p class="text-grey fs-12 m-0">Slug akan otomatis terisi mengikuti nama produk, berguna untuk
                                ditampilkan di URL website</p>
                        </label>
                        <div class="col-sm-9">
                            <input required type="text"
                                class="form-control fs-14 bg-white @error('product_category_id') is-invalid @enderror"
                                id="productSlug" name="slug" placeholder="" value="{{ $product->slug }}" readonly>
                            @error('slug')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="productCode" class="col-sm-3 col-form-label">
                            <p class="fw-600 m-0">
                                ID Produk
                            </p>
                            <p class="text-grey fs-12 m-0">Digunakan untuk mempermudah dalam menandai produk dan harus
                                UNIK/tidak boleh sama dengan produk lainnya</p>
                        </label>
                        <div class="col-sm-9">
                            <input required type="text"
                                class="form-control fs-14 @error('product_code') is-invalid @enderror" id="productCode"
                                name="product_code" placeholder="ID Produk" value="{{ $product->product_code }}">
                            @error('product_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="productCategory" class="col-sm-3 col-form-label fw-600">Kategori</label>
                        <div class="col-sm-9">
                            <select required
                                class="form-control shadow-none admin-product-category form-select shadow-none fs-14 @error('product_category_id') is-invalid @enderror"
                                name="product_category_id" required>
                                <option value="0" class="fs-14">Kategori produk
                                </option>
                                @foreach ($categories as $category)
                                    <option class="fs-14" value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="productMerk" class="col-sm-3 col-form-label fw-600">Merk</label>
                        <div class="col-sm-9">
                            <select required
                                class="form-control shadow-none admin-product-merk form-select shadow-none fs-14 @error('product_merk_id') is-invalid @enderror"
                                name="product_merk_id" required>
                                <option value="" class="fs-14">Merk produk
                                </option>
                                @foreach ($merks as $merk)
                                    <option class="fs-14" value="{{ $merk->id }}">
                                        {{ $merk->name }}</option>
                                @endforeach
                            </select>
                            @error('product_merk_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container p-0 mb-4">
            <div class="card product-detail-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Detail Produk</h5>
                        <p class="text-grey fs-13 m-0">Tuliskan penjelasan detail tentang produk yang akan dijual</p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-3 row">
                        <label for="excerpt" class="col-sm-3 col-form-label fw-600">Deskripsi Singkat
                            Produk</label>
                        <div class="col-sm-9">
                            <input id="excerpt" type="hidden" name="excerpt" value="{{ $product->excerpt }}">
                            <trix-editor input="excerpt"></trix-editor>
                            @error('excerpt')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="specification" class="col-sm-3 col-form-label fw-600">Spesifikasi
                            Produk</label>
                        <div class="col-sm-9">
                            <input id="specification" type="hidden" name="specification"
                                value="{{ $product->specification }}">
                            <trix-editor input="specification"></trix-editor>
                            @error('specification')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="description" class="col-sm-3 col-form-label fw-600">Deskripsi Produk</label>
                        <div class="col-sm-9">
                            <input id="description" type="hidden" name="description"
                                value="{{ $product->description }}">
                            <trix-editor input="description"></trix-editor>
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container product-activation-container p-0 mb-4">
            <div class="card product-activation-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Status Produk</h5>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    {{-- <form action="{{ route('adminproduct.store') }}" method="post" enctype="multipart/form-data">
                        @csrf --}}
                    <div class="mb-3 row">
                        <label for="productStatus" class="col-sm-3 col-form-label">
                            <p class="fw-600 m-0">
                                Status Produk
                            </p>
                            <p class="text-grey fs-12 m-0">Jika status produk Aktif maka pembeli dapat melihat produk
                                ini
                            </p>
                        </label>
                        <div class="col-sm-9 py-1">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="productStatus"
                                    {{ $product->is_active == 1 ? 'checked' : '' }} name="is_active" value="1">
                                <label class="form-check-label" for="productStatus">
                                    <div class="product-status">
                                        Aktif
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="productStatus" class="col-sm-3 col-form-label">
                            <p class="fw-600 m-0">
                                Notifikasi Stock
                            </p>
                            <p class="text-grey fs-12 m-0">
                                Jika Notifikasi stock produk Aktif maka anda akan mendapat pemberitahuan jika stock produk
                                akan/sedang habis
                            </p>
                        </label>
                        <div class="col-sm-9 py-1">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="productStockNotification" {{ $product->stock_notification ? 'checked' : '' }}
                                    name="stock_notification" value="1">
                                <label class="form-check-label" for="productStockNotification">
                                    <div class="product-stock-notification">
                                        Aktif
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- <button type="submit">Submit</button> --}}
                    {{-- </form> --}}
                </div>
            </div>
        </div>
        {{-- <form action="{{ route('adminproduct.store') }}" method="post" enctype="multipart/form-data">
            @csrf --}}
        <div class="container p-0 mb-4">
            <div class="card product-variant-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Varian Produk</h5>
                        <p class="text-grey fs-13 m-0">klik tambah jika produk memiliki varian</p>
                    </div>
                </div>
                <div class="card-body p-0">

                </div>
                <input required type="hidden" value="{{ count($product->productvariant) }}" id="total_product_variant">
                <div class="card-footer bg-transparent p-0 border-0">

                </div>
            </div>
        </div>
        <div id="new_product_variant">
            @foreach ($product->productvariant as $variantId => $variant)
                <div class="varian-{{ $loop->index }}">
                    <div class="container p-0 mb-4">
                        <div class="card product-variant-card border-0 border-radius-1-5rem fs-14">
                            <div class="card-header bg-transparent p-4 border-0">
                                <div class="header">
                                    <div class="row align-items-center">
                                        <div class="col-md-6 col-7">
                                            <h5 class="m-0">Varian Produk</h5>
                                        </div>
                                        <div class="col-md-6 col-5 text-end">
                                            <div class="btn btn-outline-danger fs-14" id="{{ $loop->index }}"
                                                onclick="removeSpecificProductVariant({{ $loop->iteration }})">
                                                <i class="bi bi-trash3"></i> Hapus
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4 pt-0">
                                <div class="">
                                    <input type="hidden" name="variant_id[{{ $loop->index }}]"
                                        value="{{ $variant->id }}">
                                    <div class="mb-3 row row-variant-{{ $loop->index }}">
                                        <div class="col-md-6 col-sm-6 col-12">
                                            <label for="variantName" class="form-label">Nama Varian</label>
                                            <input required type="text"
                                                class="form-control fs-14 variant-name variantName-{{ $loop->index }}"
                                                id="variantName_{{ $loop->index }}" aria-describedby="variantName"
                                                name="variant_name[{{ $loop->index }}]"
                                                placeholder="Contoh: Dodos 4&ldquo; + Safety Kit/Warna Cokelat Ukuran 42/dll"
                                                value="{{ $variant->variant_name }}">
                                            <div id="variantNames" class="form-text"></div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-12">
                                            <label for="variantSlug" class="form-label">Slug Varian</label>
                                            <input required type="text"
                                                class="form-control fs-14 bg-white variant-slug"
                                                id="variantSlug_{{ $loop->index }}" aria-describedby="variantSlug"
                                                name="variant_slug[{{ $loop->index }}]"
                                                value="{{ $variant->variant_slug }}" readonly>
                                            <div id="variantSlug" class="form-text">Slug Varian akan otomatis terisi
                                                mengikuti
                                                nama varian, berguna untuk ditampilkan pada URL WEB</div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-md-6 col-sm-6 col-12">
                                            <label for="variantValue" class="form-label">Detail Varian</label>
                                            <input required type="text" class="form-control fs-14 vaiant-value"
                                                id="variantValue_{{ $loop->index }}" aria-describedby="variantValue"
                                                name="variant_value[{{ $loop->index }}]"
                                                placeholder="deskripsi singkat tentang varian"
                                                value="{{ $variant->variant_value }}">
                                            <div id="variantValue" class="form-text"></div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-12">
                                            <label for="variantCode" class="form-label">Kode Varian</label>
                                            <input required type="text" class="form-control fs-14 variant-code"
                                                id="variantCode_{{ $loop->index }}" aria-describedby="variantCode"
                                                name="variant_code[{{ $loop->index }}]" placeholder="Kode varian"
                                                value="{{ $variant->variant_code }}">
                                            <div id="variantCode-description" class="form-text">
                                                UNIK dan tidak boleh sama dengan varian lainnya
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-md-6 col-sm-6 col-12">
                                            <label for="variantStock" class="form-label">Stok Varian</label>
                                            <input required type="number" class="form-control fs-14 variant-stock"
                                                id="variantStock_{{ $loop->index }}" aria-describedby="variantStock"
                                                name="variant_stock[{{ $loop->index }}]" placeholder="Stok varian"
                                                value="{{ $variant->stock }}">
                                            <div id="variantStock" class="form-text"></div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-12">
                                            <label for="variantWeight" class="form-label">Berat Varian (gr)</label>
                                            <input required type="number" class="form-control fs-14 variant-weight"
                                                id="variantWeight_{{ $loop->index }}" aria-describedby="variantWeight"
                                                name="variant_weight[{{ $loop->index }}]"
                                                placeholder="Berat varian dalam gram (gr)"
                                                value="{{ $variant->weight }}">
                                            <div id="variantWeight" class="form-text">Berat varian setelah dikemas</div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-md-6 col-sm-6 col-12">
                                            <label for="variantLong" class="form-label">Panjang Varian (cm)</label>
                                            <input required type="number" class="form-control fs-14 variant-long"
                                                id="variantLong_{{ $loop->index }}" aria-describedby="variantLong"
                                                name="variant_long[{{ $loop->index }}]"
                                                placeholder="Ukuran panjang varian dalam centimeter (cm)"
                                                value="{{ $variant->long }}">
                                            <div id="variantLong" class="form-text">Panjang varian setelah dikemas</div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-12">
                                            <label for="variantWidth" class="form-label">Lebar Varian (cm)</label>
                                            <input required type="number" class="form-control fs-14 variant-width"
                                                id="variantWidth_{{ $loop->index }}" aria-describedby="variantWidth"
                                                name="variant_width[{{ $loop->index }}]"
                                                placeholder="Ukuran lebar varian dalam centimeter (cm)"
                                                value="{{ $variant->width }}">
                                            <div id="variantWidth" class="form-text">Lebar varian setelah dikemas</div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-md-6 col-sm-6 col-12">
                                            <label for="variantHeight" class="form-label">Tinggi Varian (cm)</label>
                                            <input required type="number" class="form-control fs-14 variant-height"
                                                id="variantHeight_{{ $loop->index }}" aria-describedby="variantHeight"
                                                name="variant_height[{{ $loop->index }}]"
                                                placeholder="Ukuran tinggi varian dalam centimeter (cm)"
                                                value="{{ $variant->height }}">
                                            <div id="variantHeight" class="form-text">Tinggi varian setelah dikemas</div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-12">
                                            <label for="variantPrice" class="form-label">Harga Varian (Rp)</label>
                                            <input required type="number" class="form-control fs-14 variant-price"
                                                id="variantPrice_{{ $loop->index }}" aria-describedby="variantPrice"
                                                name="variant_price[{{ $loop->index }}]" placeholder="Contoh: 1800000"
                                                value="{{ $variant->price }}">
                                            <div id="variantPrice" class="form-text">Harga varian menggunakan mata uang
                                                Rupiah
                                                (Rp)
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row variant-total-volume-weight-{{ $loop->index }}">
                                    </div>
                                    <div class="mb-3 mt-5 row">
                                        <p class="m-0 fw-600">Lokasi Pengiriman Produk</p>
                                        <p class="text-grey fs-13 m-0">Pilih lokasi pengiriman produk</p>
                                        <div class="chk_option_error text-danger fs-14 fw-600 mb-2">
                                            Pilih setidaknya satu alamat pengiriman!
                                        </div>
                                        <div class="senderAddr-{{ $variantId }}">
                                            @foreach ($senderAddresses as $sender)
                                                <div class="mb-3 form-check">
                                                    <input type="hidden" name="city_ids[{{ $loop->index }}]"
                                                        value=" {{ $sender->city_ids }} ">
                                                    <input type="hidden"
                                                        name="sender_id[{{ $variantId }}][{{ $loop->index }}]"
                                                        value=" @foreach ($variant->productorigin as $origin) {{ $origin->sender_address_id == $sender->id ? $origin->id : '' }} @endforeach">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="sender-{{ $sender->id }}-{{ $variantId }}"
                                                        name="sender[{{ $variantId }}][{{ $loop->index }}]"
                                                        value=" {{ $sender->id }}"
                                                        @foreach ($variant->productorigin as $origin) {{ $origin->sender_address_id == $sender->id ? 'checked' : '' }} @endforeach>
                                                    <label class="form-check-label"
                                                        for="sender-{{ $sender->id }}-{{ $variantId }}">
                                                        <p class="fw-600 m-0"> {{ $sender->name }}</p>
                                                        <p class="m-0"> {{ $sender->address }} </p>
                                                        <div class="d-flex">
                                                            <p class="m-0">
                                                                {{ $sender->city->name }} ,
                                                            </p>
                                                            <p class="m-0">
                                                                {{ $sender->province->name }} ,
                                                            </p>
                                                            <p class="m-0">
                                                                {{ $sender->postal_code }}
                                                            </p>
                                                        </div>
                                                        <p class="m-0"> {{ $sender->telp_no }}</p>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-end mb-4">
            <div class="btn btn-outline-danger mx-1 fs-14" onclick="removeProductVariant()"><i class="bi bi-trash3"></i>
                Hapus Varian</div>
            <div class="btn btn-danger mx-1 fs-14 add-variant-btn" onclick="addProductVariant()"><i
                    class="bi bi-plus-lg"></i> Tambah Varian</div>
            {{-- <button type="submit" class="btn btn-danger mx-1 fs-14">Upload</button> --}}
        </div>
        {{-- </form> --}}
        {{-- @if (count($product->productvariant) > 0)
        @else --}}
        <div class="container product-manage-container p-0 mb-4">
            <div class="card product-manage-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Pengelolaan Produk</h5>
                        <p class="text-grey fs-13 m-0">Untuk mempermudah dalam mengelola produk anda</p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-3 row">
                        <label for="productStock" class="col-sm-3 col-form-label">
                            <p class="fw-600 m-0">
                                Jumlah Stok Produk
                            </p>
                            {{-- <p class="text-grey fs-12 m-0">Digunakan untuk mempermudah dalam menandai produk</p> --}}
                        </label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control fs-14 @error('stock') is-invalid @enderror"
                                id="productStock" name="stock" placeholder="Jumlah stok"
                                value="{{ $product->stock }}">
                            @error('stock')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    {{-- <form action="{{ route('adminproduct.store') }}" method="post" enctype="multipart/form-data">
                        @csrf --}}
                    {{-- <button type="submit">Submit</button> --}}
                    {{-- </form> --}}
                </div>
            </div>
        </div>
        <div class="container product-physical-container p-0 mb-4">
            <div class="card product-physical-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Fisik Produk</h5>
                        <p class="text-grey fs-13 m-0">Berat, ukuran panjang, lebar, dan tinggi produk sesudah dikemas
                        </p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-3 row">
                        <label for="productWeight" class="col-sm-3 col-form-label">
                            <p class="fw-600 m-0">
                                Berat Produk (gr)
                            </p>
                            <p class="text-grey fs-12 m-0">Berat setelah produk <span class="m-0 fw-600">dikemas</span>
                            </p>
                        </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="number" class="form-control fs-14 @error('weight') is-invalid @enderror"
                                    id="productWeight" name="weight"
                                    placeholder="Berat produk dalam gram (gr). Contoh : 1234"
                                    value="{{ $product->weight }}">
                                <span class="input-group-text bg-transparent p-0 py-1 px-2 fs-14"
                                    id="basic-addon2">gram</span>
                                @error('weight')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-sm-3 col-form-label">
                            <p class="fw-600 m-0">
                                Ukuran Produk
                            </p>
                            <p class="text-grey fs-12 m-0">Panjang, lebar, dan tinggi produk setelah <span
                                    class="m-0 fw-600">dikemas</span></p>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="number"
                                            class="form-control fs-14 @error('long') is-invalid @enderror"
                                            id="productLong" name="long" placeholder="Panjang produk (cm)"
                                            value="{{ $product->long }}">
                                        <span class="input-group-text bg-transparent p-0 py-1 px-2 fs-14"
                                            id="basic-addon2">cm</span>
                                        @error('long')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="number"
                                            class="form-control fs-14 @error('width') is-invalid @enderror"
                                            id="productWidth" name="width" placeholder="Lebar produk (cm)"
                                            value="{{ $product->width }}">
                                        <span class="input-group-text bg-transparent p-0 py-1 px-2 fs-14"
                                            id="basic-addon2">cm</span>
                                        @error('width')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="number"
                                            class="form-control fs-14 @error('height') is-invalid @enderror"
                                            id="productHeight" name="height" placeholder="Tinggi produk (cm)"
                                            value="{{ $product->height }}">
                                        <span class="input-group-text bg-transparent p-0 py-1 px-2 fs-14"
                                            id="basic-addon2">cm</span>
                                        @error('height')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="product-total-volume-weight">
                                <div class="fs-12 text-danger my-2">
                                    Ongkir akan dihitung menggunakan Berat Volume jika Berat Volume lebih besar dari berat
                                    produk aktual
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container product-price-container p-0 mb-4">
            <div class="card product-price-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Harga</h5>
                        <p class="text-grey fs-13 m-0">Masukkan harga produk</p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-3 row">
                        <label for="productPrice" class="col-sm-3 col-form-label fw-600">Harga Produk</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control fs-14 @error('price') is-invalid @enderror"
                                id="productPrice" name="price" placeholder="Masukkan Harga produk, Contoh: 180000"
                                value="{{ $product->price }}">
                            @error('price')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container product-shipment-origin-container p-0 mb-4">
            <div class="card product-shipment-origin-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Lokasi Pengiriman Produk</h5>
                        <p class="text-grey fs-13 m-0">Pilih lokasi pengiriman produk</p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="chk_option_error text-danger fs-14 fw-600 mb-2">
                        Pilih setidaknya satu alamat pengiriman!
                    </div>
                    @foreach ($senderAddresses as $sender)
                        {{-- {{ $loop->index }} --}}
                        <div class="mb-3 form-check">
                            <input type="hidden" name="city_ids_single[{{ $loop->index }}]"
                                value="{{ $sender->city_ids }}">
                            <input type="checkbox" class="form-check-input @error('sender') is-invalid @enderror"
                                id="{{ $sender->id }}" name="sender_no_variant[{{ $loop->index }}]"
                                value="{{ $sender->id }}"
                                @foreach ($product->productorigin as $origin) {{ $origin->sender_address_id }}
                                    {{ $origin->sender_address_id == $sender->id ? 'checked' : '' }} @endforeach>
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
                        @if ($errors->has('sender'))
                            <div class="error text-danger fw-600">
                                {{ $errors->first('sender') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- @endif --}}

        @if (auth()->guard('adminMiddle')->user()->admin_type == 1)
            <div class="container product-company-container p-0 mb-4">
                <div class="card product-company-card border-0 border-radius-1-5rem fs-14">
                    <div class="card-header bg-transparent p-4 border-0">
                        <div class="header">
                            <h5 class="m-0">Perusahaan</h5>
                            <p class="text-grey fs-13 m-0">Pilih perusahaan dimana produk akan ditampilkan</p>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="mb-3 row">
                            <label for="productCompany" class="col-sm-3 col-form-label fw-600">Perusahaan</label>
                            <div class="col-sm-9">
                                <select required
                                    class="form-control shadow-none admin-product-company form-select shadow-none fs-14 @error('company_id') is-invalid @enderror"
                                    name="company_id" required>
                                    <option value="" class="fs-14">Pilih Perusahaan
                                    </option>
                                    @foreach ($companies as $company)
                                        <option class="fs-14" value="{{ $company->id }}"
                                            {{ $product->company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <input type="hidden" name="company_id" value="{{ auth()->guard('adminMiddle')->user()->company_id }}">
        @endif

        <div class="container p-0 mb-5 pb-5">
            <div class="row">
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-danger fs-14  ">
                        <i class="far fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="upload-product-img-modal" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="previewImgUserModal" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="previewImgUserModal">Upload Foto Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <!--  default image where we will set the src via jquery-->
                                    <img id="image-on-modal" class="img-user">
                                </div>
                                <div class="col-md-4">
                                    <div class="preview-img-user"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary fs-14" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger fs-14" id="upload-product-image">Tambahkan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener("trix-file-accept", event => {
            event.preventDefault();
            alert("File attachment not supported!");
        })

        function addImage() {
            var img_no = parseInt($('#total_product_img').val()) + 1;
            var new_image =
                '<div class="row mb-3 row-product-image-' + img_no + '">' +
                '<div class="col-md-7 col-12 col1-product-image-' + img_no + '">' +
                '<input class="form-control form-control-sm product-image-class input-product-image-' + img_no +
                '" type="file" id="productImage_' + img_no + '" name="productImage[' + img_no +
                ']">' +
                '<input required type="hidden" id="productImageUpload_' + img_no + '" class="productImageUpload_' + img_no +
                '" name="productImageUpload[' + img_no + ']">' +
                '<div id="imageSource_' + img_no + '"></div>' +
                '</div>' +
                '<div class="col-md-4 col-12 col2-product-image-' + img_no + '"">' +
                '<img class="img-preview-' + img_no + ' img-fluid">' +
                '<div class="show-before-upload-' + img_no + '"></div>' +
                '</div>' +
                '</div>';
            console.log(img_no);
            console.log(new_image);
            $('#new_product_img').append(new_image);
            $('#total_product_img').val(img_no);
        }

        function removeImage() {
            var last_img_no = $('#total_product_img').val();
            console.log('last image no : ' + last_img_no);
            if (last_img_no > 0) {
                $('.row-product-image-' + last_img_no).remove();
                // $('.col1-product-image-' + last_img_no).remove();
                // $('#productImage_' + last_img_no).remove();
                // $('#productImageUpload_' + last_img_no).remove();
                // $('#imageSource_' + last_img_no).remove();

                // $('.col2-product-image-' + last_img_no).remove();
                // $('.img-preview-' + last_img_no).remove();
                // $('.show-before-upload-' + last_img_no).remove();
                $('#total_product_img').val(last_img_no - 1);
            }
        }

        function addProductVariant() {
            window.global_product_variant_no = parseInt($('#total_product_variant').val());
            var product_variant_no = parseInt($('#total_product_variant').val());
            var sender = {!! json_encode($senderAddresses) !!};
            var new_product_variant =
                '<div class="varian-' + product_variant_no + '">' +
                '<div class="container p-0 mb-4">' +
                '<div class="card product-variant-card border-0 border-radius-1-5rem fs-14">' +
                '<div class="card-header bg-transparent p-4 border-0">' +
                '<div class="header">' +
                '<div class="row">' +
                '<div class="col-md-6">' +
                '<h5 class="m-0">Varian Produk</h5>' +
                '</div>' +
                '<div class="col-md-6 text-end">' +
                '<div class="btn btn-outline-danger fs-14" id="' + product_variant_no + '"' +
                'onclick="removeSpecificProductVariant(' + (parseInt(product_variant_no) + 1) + ')">' +
                '<i class="bi bi-trash3"></i> Hapus' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="card-body p-4 pt-0">' +
                '<div class="">' +
                '<div class="header mb-2 header-variant-0">' +
                // '<p class="m-0 fw-600">Varian Produk ' + (parseInt(product_variant_no) + 1) + '</p>' +
                '</div>' +
                '<div class="mb-3 row row-variant-' + product_variant_no + '">' +
                '<div class="col-md-6 col-sm-6 col-12">' +
                '<label for="variantName" class="form-label">Nama Varian</label>' +
                '<input required type="text" class="form-control fs-14 variant-name variantName-' + product_variant_no +
                '" id="variantName_' + product_variant_no + '" aria-describedby="variantName" name="variant_name[' +
                product_variant_no +
                ']" placeholder="Contoh: Dodos 4&ldquo; + Safety Kit/Warna Cokelat Ukuran 42/dll">' +
                '<div id="variantNames" class="form-text"></div>' +
                '</div>' +
                '<div class="col-md-6 col-sm-6 col-12">' +
                '<label for="variantSlug" class="form-label">Slug Varian</label>' +
                '<input required type="text" class="form-control fs-14 bg-white variant-slug" id="variantSlug_' +
                product_variant_no + '" aria-describedby="variantSlug" name="variant_slug[' +
                product_variant_no + ']" value="" readonly>' +
                '<div id="variantSlug" class="form-text">Slug Varian akan otomatis terisi mengikuti nama varian, berguna untuk ditampilkan pada URL WEB</div>' +
                '</div>' +
                '</div>' +
                '<div class="mb-3 row">' +
                '<div class="col-md-6 col-sm-6 col-12">' +
                '<label for="variantValue" class="form-label">Detail Varian</label>' +
                '<input required type="text" class="form-control fs-14 vaiant-value" id="variantValue_' +
                product_variant_no +
                '" aria-describedby="variantValue" name="variant_value[' +
                product_variant_no + ']" placeholder="deskripsi singkat tentang varian">' +
                '<div id="variantValue" class="form-text"></div>' +
                '</div>' +
                '<div class="col-md-6 col-sm-6 col-12">' +
                '<label for="variantCode" class="form-label">Kode Varian</label>' +
                '<input required type="text" class="form-control fs-14 variant-code" id="variantCode_' +
                product_variant_no +
                '" aria-describedby="variantCode" name="variant_code[' +
                product_variant_no + ']" placeholder="Kode varian">' +
                '<div id="variantCode-description" class="form-text">UNIK dan tidak boleh sama dengan varian lainnya</div>' +
                '</div>' +
                '</div>' +
                '<div class="mb-3 row">' +
                '<div class="col-md-6 col-sm-6 col-12">' +
                '<label for="variantStock" class="form-label">Stok Varian</label>' +
                '<input required type="number" class="form-control fs-14 variant-stock" id="variantStock_' +
                product_variant_no +
                '" aria-describedby="variantStock" name="variant_stock[' +
                product_variant_no + ']" placeholder="Stok varian">' +
                '<div id="variantStock" class="form-text"></div>' +
                '</div>' +
                '<div class="col-md-6 col-sm-6 col-12">' +
                '<label for="variantWeight" class="form-label">Berat Varian (gr)</label>' +
                '<input required type="number" class="form-control fs-14 variant-weight" id="variantWeight_' +
                product_variant_no +
                '" aria-describedby="variantWeight" name="variant_weight[' +
                product_variant_no + ']" placeholder="Berat varian dalam gram (gr)">' +
                '<div id="variantWeight" class="form-text">Berat varian setelah dikemas</div>' +
                '</div>' +
                '</div>' +
                '<div class="mb-3 row">' +
                '<div class="col-md-6 col-sm-6 col-12">' +
                '<label for="variantLong" class="form-label">Panjang Varian (cm)</label>' +
                '<input required type="number" class="form-control fs-14 variant-long" id="variantLong_' +
                product_variant_no +
                '" aria-describedby="variantLong" name="variant_long[' +
                product_variant_no + ']" placeholder="Ukuran panjang varian dalam centimeter (cm)">' +
                '<div id="variantLong" class="form-text">Panjang varian setelah dikemas</div>' +
                '</div>' +
                '<div class="col-md-6 col-sm-6 col-12">' +
                '<label for="variantWidth" class="form-label">Lebar Varian (cm)</label>' +
                '<input required type="number" class="form-control fs-14 variant-width" id="variantWidth_' +
                product_variant_no +
                '" aria-describedby="variantWidth" name="variant_width[' +
                product_variant_no + ']" placeholder="Ukuran lebar varian dalam centimeter (cm)">' +
                '<div id="variantWidth" class="form-text">Lebar varian setelah dikemas</div>' +
                '</div>' +
                '</div>' +
                '<div class="mb-3 row">' +
                '<div class="col-md-6 col-sm-6 col-12">' +
                '<label for="variantHeight" class="form-label">Tinggi Varian (cm)</label>' +
                '<input required type="number" class="form-control fs-14 variant-height" id="variantHeight_' +
                product_variant_no +
                '" aria-describedby="variantHeight" name="variant_height[' +
                product_variant_no + ']" placeholder="Ukuran tinggi varian dalam centimeter (cm)">' +
                '<div id="variantHeight" class="form-text">Tinggi varian setelah dikemas</div>' +
                '</div>' +
                '<div class="col-md-6 col-sm-6 col-12">' +
                '<label for="variantPrice" class="form-label">Harga Varian (Rp)</label>' +
                '<input required type="number" class="form-control fs-14 variant-price" id="variantPrice_' +
                product_variant_no +
                '" aria-describedby="variantPrice" name="variant_price[' +
                product_variant_no + ']" placeholder="Contoh: 1800000">' +
                '<div id="variantPrice" class="form-text">Harga varian menggunakan mata uang Rupiah (Rp)</div>' +
                '</div>' +
                '</div>' +
                '<div class="mb-3 row variant-total-volume-weight-' + product_variant_no + '">' +
                '</div>' +
                '<div class="mb-3 mt-5 row">' +
                '<p class="m-0 fw-600">Lokasi Pengiriman Produk</p>' +
                '<p class="text-grey fs-13 m-0">Pilih lokasi pengiriman produk</p>' +
                '<div class="chk_option_error text-danger fs-14 fw-600 mb-2">' +
                'Pilih setidaknya satu alamat pengiriman!' +
                '</div>' +
                '<div class="senderAddr-' + product_variant_no + '">' +
                '</div>' +
                '<div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
            console.log(product_variant_no);
            // console.log(new_product_variant);
            $('#new_product_variant').append(new_product_variant);
            // if(product_variant_no == 0){
            //     $('#new_product_variant').append(new_product_variant);
            // }
            var product_variant_no = parseInt($('#total_product_variant').val()) + 1;
            $('#total_product_variant').val(product_variant_no);

            if (!$(".product-manage-container").hasClass("d-none")) {
                $(".product-manage-container").addClass("d-none");
            }
            if (!$(".product-physical-container").hasClass("d-none")) {
                $(".product-physical-container").addClass("d-none");
            }
            if (!$(".product-price-container").hasClass("d-none")) {
                $(".product-price-container").addClass("d-none");
            }
            if (!$(".product-shipment-origin-container").hasClass("d-none")) {
                $(".product-shipment-origin-container").addClass("d-none");
            }
        }

        function removeProductVariant() {
            var last_product_variant_no = $('#total_product_variant').val();
            if (last_product_variant_no > 0) {
                last_product_variant_no = $('#total_product_variant').val() - 1;
                $('#total_product_variant').val(last_product_variant_no);
                $('.varian-' + last_product_variant_no).remove();
            }
            if (last_product_variant_no == 0) {
                if ($(".product-manage-container").hasClass("d-none")) {
                    $(".product-manage-container").removeClass("d-none");
                }
                if ($(".product-physical-container").hasClass("d-none")) {
                    $(".product-physical-container").removeClass("d-none");
                }
                if ($(".product-price-container").hasClass("d-none")) {
                    $(".product-price-container").removeClass("d-none");
                }
                if ($(".product-shipment-origin-container").hasClass("d-none")) {
                    $(".product-shipment-origin-container").removeClass("d-none");
                }
            }
            console.log('last variant no : ' + last_product_variant_no);
        }

        function removeSpecificProductVariant(val) {
            console.log(val);
            id = val;
            var last_product_variant_no = $('#total_product_variant').val();
            console.log(last_product_variant_no);
            if (id == last_product_variant_no) {
                console.log('last variant');
                if (last_product_variant_no > 0) {
                    last_product_variant_no = $('#total_product_variant').val() - 1;
                    $('#total_product_variant').val(last_product_variant_no);
                    $('.varian-' + last_product_variant_no).remove();
                }
            } else {
                console.log('delete variant : ' + (val - 1));
                $('.varian-' + (val - 1)).remove();

            }
            // if (last_product_variant_no == 0) {
            //     if ($(".product-manage-container").hasClass("d-none")) {
            //         $(".product-manage-container").removeClass("d-none");
            //     }
            //     if ($(".product-physical-container").hasClass("d-none")) {
            //         $(".product-physical-container").removeClass("d-none");
            //     }
            //     if ($(".product-price-container").hasClass("d-none")) {
            //         $(".product-price-container").removeClass("d-none");
            //     }
            //     if ($(".product-shipment-origin-container").hasClass("d-none")) {
            //         $(".product-shipment-origin-container").removeClass("d-none");
            //     }
            // }
            console.log('last variant no : ' + last_product_variant_no);
            if (last_product_variant_no == 0) {
                if ($(".product-manage-container").hasClass("d-none")) {
                    $(".product-manage-container").removeClass("d-none");
                }
                if ($(".product-physical-container").hasClass("d-none")) {
                    $(".product-physical-container").removeClass("d-none");
                }
                if ($(".product-price-container").hasClass("d-none")) {
                    $(".product-price-container").removeClass("d-none");
                }
                if ($(".product-shipment-origin-container").hasClass("d-none")) {
                    $(".product-shipment-origin-container").removeClass("d-none");
                }
            }
        }
        // if (last_product_variant_no > 0) {
        //     last_product_variant_no = $('#total_product_variant').val() - 1;
        //     $('#total_product_variant').val(last_product_variant_no);
        //     $('.varian-' + last_product_variant_no).remove();
        // }
        // if (last_product_variant_no == 0) {
        //     if ($(".product-manage-container").hasClass("d-none")) {
        //         $(".product-manage-container").removeClass("d-none");
        //     }
        //     if ($(".product-physical-container").hasClass("d-none")) {
        //         $(".product-physical-container").removeClass("d-none");
        //     }
        //     if ($(".product-price-container").hasClass("d-none")) {
        //         $(".product-price-container").removeClass("d-none");
        //     }
        //     if ($(".product-shipment-origin-container").hasClass("d-none")) {
        //         $(".product-shipment-origin-container").removeClass("d-none");
        //     }
        // }
        // console.log('last variant no : ' + last_product_variant_no);


        function previewImage(img, imgPreview) {
            // mengambil sumber image dari input required dengan id image
            const image = document.querySelector(img);
            console.log(img);
            // mengambil tag img dari class img-preview
            const imagePreview = document.querySelector(imgPreview);

            // mengubah style tampilan image menjadi block
            imagePreview.style.display = 'block';

            // perintah untuk mengambil data gambar
            const oFReader = new FileReader();
            // mengambil dari const image
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(OFREvent) {
                imagePreview.src = OFREvent.target.result;
            }
        }

        function handleData() {
            console.log('onsubmit');
            var form_data = new FormData(document.querySelector("form"));
            console.log(form_data);
            if (!form_data.has("langs[]")) {
                document.getElementById("chk_option_error").style.visibility = "visible";
                return false;
            } else {
                document.getElementById("chk_option_error").style.visibility = "hidden";
                return true;
            }

        }

        $(window).on('load', function() {
            console.log($('#productStatus').prop("checked"));
            if ($('#productStatus').prop("checked") == true) {
                $('.product-status').text('Aktif');
                $('input[name="is_active"]').val(1);
            } else {
                $('.product-status').text('Tidak Aktif');
                $('input[name="is_active"]').val(0);
            }

            if ($('#productStockNotification').prop("checked") == true) {
                $('.product-stock-notification').text('Aktif');
                $('input[name="stock_notification"]').val(1);
            } else {
                $('.product-stock-notification').text('Tidak Aktif');
                $('input[name="stock_notification"]').val(0);
            }

            var product_variant_no = parseInt($('#total_product_variant').val());
            $('#total_product_variant').val(product_variant_no);
            if (product_variant_no > 0) {
                if (!$(".product-manage-container").hasClass("d-none")) {
                    $(".product-manage-container").addClass("d-none");
                }
                if (!$(".product-physical-container").hasClass("d-none")) {
                    $(".product-physical-container").addClass("d-none");
                }
                if (!$(".product-price-container").hasClass("d-none")) {
                    $(".product-price-container").addClass("d-none");
                }
                if (!$(".product-shipment-origin-container").hasClass("d-none")) {
                    $(".product-shipment-origin-container").addClass("d-none");
                }
            }
        });
        $(document).ready(function() {
            var product = {!! json_encode($product) !!};
            $('.admin-product-category').val(parseInt(product['product_category_id'])).trigger('change');
            $('.admin-product-merk').val(parseInt(product['product_merk_id'])).trigger('change');
            // console.log(sender);
            // $.each(sender, function(key, value) {
            //     console.log(value['id']);
            //     console.log(value['name']);
            //     console.log(value['address']);
            //     console.log(value['city']['name']);
            //     console.log(value['province']['name']);
            //     console.log(value['postal_code']);
            //     console.log(value['telp_no']);
            // });
            $('.add-variant-btn').on('click', function() {
                var sender = {!! json_encode($senderAddresses) !!};
                console.log(sender);
                console.log(global_product_variant_no);
                $.each(sender, function(key, value) {
                    $('.senderAddr-' + global_product_variant_no).append(
                        '<div class="mb-3 form-check">' +
                        '<input type="hidden" name="city_ids[' + key + ']" value="' + value[
                            'city_ids'] + '">' +
                        '<input type="checkbox" class="form-check-input"' +
                        'id="sender-' + value['id'] + '-' + global_product_variant_no +
                        '" name="sender[' + global_product_variant_no + '][' + key + ']"' +
                        'value="' + value['id'] + '">' +
                        '<label class="form-check-label" for="sender-' + value['id'] + '-' +
                        global_product_variant_no + '">' +
                        '<p class="fw-600 m-0">' + value['name'] + '</p>' +
                        '<p class="m-0">' + value['address'] + '</p>' +
                        '<div class="d-flex">' +
                        '<p class="m-0">' +
                        value['city']['name'] + ',' +
                        '</p>' +
                        '<p class="m-0">' +
                        value['province']['name'] + ',' +
                        '</p>' +
                        '<p class="m-0">' +
                        value['postal_code'] +
                        '</p>' +
                        '</div>' +
                        '<p class="m-0">' + value['telp_no'] + '</p>' +
                        '</label>' +
                        '</div>'
                    );
                });
            });

            $("#productStatus").add().on('change', function() {
                if ($(this).prop("checked") == true) {
                    $('.product-status').text('Aktif');
                    $('input[name="is_active"]').val(1);
                } else {
                    $('.product-status').text('Tidak Aktif');
                    $('input[name="is_active"]').val(0);
                }
            });

            $("#productStockNotification").add().on('change', function() {
                if ($(this).prop("checked") == true) {
                    $('.product-stock-notification').text('Aktif');
                    $('input[name="stock_notification"]').val(1);
                } else {
                    $('.product-stock-notification').text('Tidak Aktif');
                    $('input[name="stock_notification"]').val(0);
                }
            });
            $('#productWeight').add('#productLong').add('#productWidth').add('#productHeight').change(function(e) {
                // console.log(e.currentTarget.value);
                // var targetId = e.currentTarget.id;
                // console.log(targetId);
                // window.variantId = targetId.replace(/[^\d.]/g, '');
                // console.log(variantId);
                var weight = $('#productWeight').val();
                var long = $('#productLong').val();
                var width = $('#productWidth').val();
                var height = $('#productHeight').val();

                var volume_weight = (long * width * height) / 6000;
                console.log(volume_weight);
                console.log(weight / 1000);
                if (volume_weight > weight / 1000) {
                    console.log('lebih berat volume weight');
                    $('.product-total-volume-weight').empty();
                    $('.product-total-volume-weight').html(
                        '<div class="fs-12 text-danger my-2">Ongkir akan dihitung menggunakan Berat Volume ' +
                        Math.round(volume_weight * 1000 * 100) / 100 + 'gr (' + Math.round(
                            volume_weight * 100) / 100 +
                        'kg) karena Berat Volume lebih besar dari berat produk aktual </div>'
                    );
                } else {
                    console.log('lebih berat product weight');
                    $('.product-total-volume-weight').empty();
                }
                console.log($('#productLong').val());
                console.log($('#productWidth').val());
                console.log($('#productHeight').val());

            });

            $('body').on('change', '.variant-weight, .variant-long, .variant-width, .variant-height', function(e) {
                console.log(e.currentTarget.value);
                var targetId = e.currentTarget.id;
                console.log(targetId);
                window.variantId = targetId.replace(/[^\d.]/g, '');
                console.log(variantId);
                var variant_weight = $('#variantWeight_' + variantId).val();
                var variant_long = $('#variantLong_' + variantId).val();
                var variant_width = $('#variantWidth_' + variantId).val();
                var variant_height = $('#variantHeight_' + variantId).val();

                var volume_weight = (variant_long * variant_width * variant_height) / 6000;
                console.log(volume_weight);
                console.log(variant_weight / 1000);
                if (volume_weight > variant_weight / 1000) {
                    console.log('lebih berat volume');
                    $('.variant-total-volume-weight-' + variantId).html(
                        '<div class="fs-12 text-danger my-2">Ongkir akan dihitung menggunakan Berat Volume ' +
                        Math.round(volume_weight * 1000 * 100) / 100 + 'gr (' + Math.round(
                            volume_weight * 100) / 100 +
                        'kg) karena Berat Volume lebih besar dari berat produk varian </div>'
                    );
                } else {
                    console.log('lebih berat weight');
                    $('.variant-total-volume-weight-' + variantId).empty();
                }
                console.log($('#variantLong_' + variantId).val());
                console.log($('#variantWidth_' + variantId).val());
                console.log($('#variantHeight_' + variantId).val());

            });

            $('body').on('click', '.btn-delete-image', function(e) {
                console.log(e.currentTarget.id);
                var imageId = e.currentTarget.id;
                var token = $('input[name="csrf_token"]').val();
                console.log(token);
                deleteImage(token, imageId);
            });

            function deleteImage(csrfToken, imageId) {
                $.ajax({
                    url: "{{ url('/administrator/adminproduct/deleteproductimage') }}",
                    type: 'post',
                    data: {
                        _token: csrfToken,
                        image_id: imageId,
                    },
                    success: function(response) {
                        window.location.reload();
                        // console.log(response);

                        $('.alert-notification-wrapper').append(
                            '<div class="alert alert-success alert-dismissible fade show alert-notification" role="alert">Berhasil memperbarui menghapus foto produk<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                        );

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('.alert-notification-wrapper').append(
                            '<div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">Gagal menghapus foto produk. (' +
                            jqXHR.status + ' ' + errorThrown +
                            ')<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                        );
                    },
                    dataType: "json",

                });
                // $(document).ajaxStop(function() {
                //     window.location.reload();
                // });
            }
            $('body').on('click', '.btn-test', function(e) {
                console.log(e.currentTarget);
            });

            $('body').on('change', '.variant-name', function(e) {
                console.log(e.currentTarget.value);
                var targetId = e.currentTarget.id;
                console.log(targetId);
                window.variantId = targetId.replace(/[^\d.]/g, '');
                console.log(variantId);
                console.log($('#variantName_' + variantId).val());

                const product_slug = $('#variantSlug_' + variantId);

                fetch('/administrator/adminproduct/checkSlug?name=' + e.target.value)
                    .then(response => response.json())
                    .then(data => product_slug.val(data.slug));
            });

            const product_name = document.querySelector('#productName');
            const product_slug = document.querySelector('#productSlug');

            product_name.addEventListener('change', function() {
                fetch('/administrator/adminproduct/checkSlug?name=' + product_name.value)
                    .then(response => response.json())
                    .then(data => product_slug.value = data.slug);
            });

            // const variant_name = document.querySelector('#variantName');
            // const variant_slug = document.querySelector('#variantSlug');
            // console.log(variant_name.value);
            // variant_name.addEventListener('change', function() {
            //     fetch('/administrator/adminproduct/checkSlug?name=' + variant_name.value)
            //         .then(response => response.json())
            //         .then(data => variant_slug.value = data.slug);
            // })

            var $modal = $('#upload-product-img-modal');
            // console.log($modal);
            var image = document.getElementById('image-on-modal');
            console.log(image);
            var cropper;
            $("body").on("change", ".product-image-class", function(e) {
                console.log(e);
                var files = e.target.files;
                console.log(files);
                var targetId = e.currentTarget.id;
                window.imageId = targetId.replace(/[^\d.]/g, '');

                var clone = $(this).clone();
                clone.attr("name", "productImageTemp[" + imageId + "]").attr("id", "productImageTemp_" +
                    imageId).addClass('d-none');
                $('#imageSource_' + imageId).html(clone);

                console.log(imageId);

                if (files.length == 0) {
                    console.log('undefined');
                    $('.img-preview-' + imageId).attr("src", "");
                    $('.show-before-upload-' + imageId).html("");
                    $('#imageSource_' + imageId).html("");
                    $('#productImageUpload_' + imageId).val("");
                }
                var done = function(url) {
                    console.log(url);
                    image.src = url;
                    console.log(files[0]['name']);
                    $modal.modal('show');
                };
                if (files.length != 0) {
                    var reader;
                    var file;
                    var url;
                    var filePath = files[0]['name'];
                    var fileSize = files[0].size;
                    console.log(files[0].size);
                }
                // Allowing file type

                var allowedExtensions =
                    /(\.jpg|\.jpeg|\.png)$/i;
                var allowedSize = 2100000;

                if (!allowedExtensions.exec(filePath)) {
                    alert('Format file tidak sesuai! Gunakan gambar dengan format (.jpg, .jpeg, .png)');
                    $('input[name="productImage[' + imageId + ']"]').val('');
                    return false;
                }
                if (fileSize > allowedSize) {
                    alert('Ukuran foto maksimal 2MB');
                    $('input[name="productImage[' + imageId + ']"]').val('');
                    return false;
                }
                if (files && files.length > 0) {
                    file = files[0];
                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function(e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }

            });
            $("body").on("click", ".preview-product-image-button", function(e) {
                console.log(e.target.id);
                var targetId = e.currentTarget.id;
                window.imageId = targetId.replace(/[^\d.]/g, '');

                console.log(imageId);
                console.log(document.getElementById('productImageTemp_' + imageId).files);
                var files = document.getElementById('productImageTemp_' + imageId).files;

                if (files.length == 0) {
                    console.log('undefined');
                    $('.img-preview-' + imageId).attr("src", "");
                    $('.show-before-upload-' + imageId).html("");
                    $('#imageSource_' + imageId).html("");
                    $('#productImageUpload_' + imageId).val("");
                }
                var done = function(url) {
                    console.log(url);
                    image.src = url;
                    console.log(files[0]['name']);
                    $modal.modal('show');
                };
                if (files.length != 0) {
                    var reader;
                    var file;
                    var url;
                    var filePath = files[0]['name'];
                    var fileSize = files[0].size;
                    console.log(files[0].size);
                }
                if (files && files.length > 0) {
                    file = files[0];
                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function(e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 3,
                    preview: '.preview-img-user'
                });
            }).on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
            });
            $("#upload-product-image").click(function() {
                canvas = cropper.getCroppedCanvas({
                    width: 800,
                    height: 800,
                });
                canvas.toBlob(function(blob) {
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        var base64data = reader.result;
                        var admin_id = $('input[name="admin_id"]').val();
                        console.log($('meta[name="csrf-token"]').attr('content'));
                        console.log(base64data);
                        $('.img-preview-' + imageId).attr('src', base64data);
                        console.log(admin_id);
                        $('.show-before-upload-' + imageId).html(
                            ' <button type="button" class="fs-14 btn btn-danger preview-product-image-button mt-3" data-bs-toggle="modal" id="preview-modal-product-image-' +
                            imageId +
                            '" data-bs-target="#upload-product-img-modal">Lihat Foto </button>'
                        );
                        $('.productImageUpload_' + imageId).val(base64data);
                        $modal.modal('toggle');
                        // $.ajax({
                        //     type: "POST",
                        //     dataType: "json",
                        //     url: "profile-image-upload",
                        //     data: {
                        //         'admin_id': admin_id,
                        //         '_token': $('meta[name="csrf-token"]').attr('content'),
                        //         'profile_image': base64data
                        //     },
                        //     success: function(data) {
                        //         console.log(data);
                        //         $modal.modal('hide');
                        //         alert(data['success']);
                        //         window.location.reload();
                        //     }
                        // });
                    }
                });
            });

        });
    </script>
@endsection
