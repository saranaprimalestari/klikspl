@extends('admin.layouts.main')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-md-3 pt-5 pb-3 mb-1">
        <h4 class="m-0">Detail Produk</h4>
        <a class="btn btn-secondary fs-14" href="{{ route('product.show', $product) }}" target="_blank"><i
                class="bi bi-eye"></i> Preview produk</a>
    </div>
    <div class="container p-0 mb-4">
        <div class="card border-radius-1-5rem fs-14 border-0">
            <div class="card-header bg-transparent p-4 border-0">
                <div class="header">
                    <h5 class="m-0">Foto Produk</h5>
                </div>
            </div>
            <div class="card-body p-4 pt-2">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="img">
                            <div class="product-main-img mb-3">
                                @if (count($product->productimage) > 0)
                                    @if (Storage::exists($product->productimage[0]->name))
                                        <img id="main-image"
                                            src="{{ asset('/storage/' . $product->productimage[0]->name) }}"
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

                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="thumbnail">
                            @foreach ($product->productImage as $productImg)
                                @if (Storage::exists($productImg->name))
                                    <img role="button" class="product-detail-img me-1 mb-2"
                                        id="thumbnail-img-{{ $loop->iteration }}"
                                        src="{{ asset('/storage/' . $productImg->name) }}" width="62"
                                        onclick="change_image(this,{{ $loop->iteration }},{{ $loop->count }})">
                                @else
                                    <img role="button" class="product-detail-img me-1 mb-2"
                                        id="thumbnail-img-{{ $loop->iteration }}"
                                        src="https://source.unsplash.com/400x400?product-{{ $loop->iteration }}"
                                        width="62"
                                        onclick="change_image(this,{{ $loop->iteration }},{{ $loop->count }})">
                                @endif
                            @endforeach
                        </div>

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
                    <p class="text-grey fs-13 m-0">Nama, ID, kategori, dan merk produk</p>
                </div>
            </div>
            <div class="card-body p-4 pt-0">
                <div class="mb-3 row">
                    <div for="productName" class="col-sm-3 fw-600">Nama Produk</div>
                    <div class="col-sm-9">
                        {{ $product->name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <div for="productSlug" class="col-sm-3  ">
                        <p class="fw-600 m-0">
                            Slug Produk
                        </p>
                    </div>
                    <div class="col-sm-9">
                        {{ $product->slug }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <div for="productCode" class="col-sm-3 ">
                        <p class="fw-600 m-0">
                            ID Produk
                        </p>
                    </div>
                    <div class="col-sm-9">
                        {{ $product->product_code }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <div for="productCategory" class="col-sm-3  fw-600">Kategori</div>
                    <div class="col-sm-9">
                        {{ $product->productcategory->name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <div for="productMerk" class="col-sm-3  fw-600">Merk</div>
                    <div class="col-sm-9">
                        {{ $product->productmerk->name }}
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
                    <p class="text-grey fs-13 m-0">Penjelasan singkat, spesifikasim dan detail tentang produk</p>
                </div>
            </div>
            <div class="card-body p-4 pt-0">
                <div class="mb-3 row">
                    <div for="excerpt" class="col-sm-3  fw-600">Deskripsi Singkat
                        Produk</div>
                    <div class="col-sm-9">
                        {!! $product->excerpt !!}
                    </div>
                </div>
                <div class="mb-3 row">
                    <div for="specification" class="col-sm-3  fw-600">Spesifikasi
                        Produk</div>
                    <div class="col-sm-9">
                        {!! $product->specification !!}
                    </div>
                </div>
                <div class="mb-3 row">
                    <div for="description" class="col-sm-3  fw-600">Deskripsi Produk</div>
                    <div class="col-sm-9">
                        {!! $product->description !!}
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
                    <div for="productStatus" class="col-sm-3 ">
                        <p class="fw-600 m-0">
                            Status Produk
                        </p>
                        <p class="text-grey fs-12 m-0">Jika status produk Aktif maka pembeli dapat melihat produk
                            ini
                        </p>
                    </div>
                    <div class="col-sm-9 py-1">
                        {{ $product->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <div for="productStatus" class="col-sm-3 ">
                        <p class="fw-600 m-0">
                            Notifikasi Stock
                        </p>
                        <p class="text-grey fs-12 m-0">
                            Jika Notifikasi stock produk Aktif maka anda akan mendapat pemberitahuan jika stock produk
                            akan/sedang habis
                        </p>
                    </div>
                    <div class="col-sm-9 py-1">
                        {{ $product->stock_notification == 1 ? 'Aktif' : 'Tidak Aktif' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (count($product->productvariant) > 0)
        <div class="container p-0 mb-4">
            @foreach ($product->productvariant as $variantId => $variant)
                <div class="varian-{{ $loop->index }}">
                    <div class="container p-0 mb-4">
                        <div class="card product-variant-card border-0 border-radius-1-5rem fs-14">
                            <div class="card-header bg-transparent p-4 border-0">
                                <div class="header">
                                    <h5 class="m-0">Varian Produk {{ $loop->iteration }}</h5>
                                </div>
                            </div>
                            <div class="card-body p-4 pt-0">
                                <div class="mb-3 row">
                                    <div for="excerpt" class="col-sm-3  fw-600">
                                        Nama Varian
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $variant->variant_name }}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div for="specification" class="col-sm-3  fw-600">
                                        Slug Varian
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $variant->variant_slug }}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div for="description" class="col-sm-3  fw-600">
                                        Detail Varian
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $variant->variant_value }}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div for="description" class="col-sm-3  fw-600">
                                        Kode Varian
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $variant->variant_code }}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div for="description" class="col-sm-3  fw-600">
                                        Stok Varian
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $variant->stock }} pcs
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div for="description" class="col-sm-3  fw-600">
                                        Berat Varian (gr)
                                        <p class="text-grey fs-12 m-0">Berat setelah produk <span
                                                class="m-0 fw-600">dikemas</span>
                                        </p>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $variant->weight }} gram
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div for="description" class="col-sm-3  fw-600">
                                        Panjang Varian (cm)
                                        <p class="text-grey fs-12 m-0">Panjang setelah produk <span
                                                class="m-0 fw-600">dikemas</span>
                                        </p>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $variant->long }} cm
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div for="description" class="col-sm-3  fw-600">
                                        Lebar Varian (cm)
                                        <p class="text-grey fs-12 m-0">Lebar setelah produk <span
                                                class="m-0 fw-600">dikemas</span>
                                        </p>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $variant->width }} cm
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div for="description" class="col-sm-3  fw-600">
                                        Tinggi Varian (cm)
                                        <p class="text-grey fs-12 m-0">Tinggi setelah produk <span
                                                class="m-0 fw-600">dikemas</span>
                                        </p>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $variant->height }} cm
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div for="description" class="col-sm-3  fw-600">
                                        Harga Varian
                                    </div>
                                    <div class="col-sm-9">
                                        Rp{{ price_format_rupiah($variant->price, 'Rp') }}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div for="description" class="col-sm-3 mb-2 fw-600">
                                        Lokasi Varian
                                    </div>
                                    <div class="col-sm-9">
                                        <ul class="p-0 ps-3">
                                            @foreach ($senderAddresses as $sender)
                                                @foreach ($variant->productorigin as $origin)
                                                    @if ($origin->sender_address_id == $sender->id)
                                                        <li>
                                                            <div class="sender-address-detail mb-2">
                                                                <p class="fw-600 m-0"> {{ $sender->name }}</p>
                                                                <p class="m-0"> {{ $sender->address }} </p>
                                                                <div class="">
                                                                    <span class="m-0">
                                                                        {{ $sender->city->name }} ,
                                                                    </span>
                                                                    <span class="m-0">
                                                                        {{ $sender->province->name }} ,
                                                                    </span>
                                                                    <span class="m-0">
                                                                        {{ $sender->postal_code }}
                                                                    </span>
                                                                </div>
                                                                <p class="m-0"> {{ $sender->telp_no }}</p>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="container product-manage-container p-0 mb-4">
            <div class="card product-manage-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Pengelolaan Produk</h5>
                        <p class="text-grey fs-13 m-0">Berisi jumlah stok produk</p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-3 row">
                        <div for="productStock" class="col-sm-3 ">
                            <p class="fw-600 m-0">
                                Jumlah Stok Produk
                            </p>
                        </div>
                        <div class="col-sm-9">
                            {{ $product->stock }} pcs
                        </div>
                    </div>
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
                        <div for="productWeight" class="col-sm-3 ">
                            <p class="fw-600 m-0">
                                Berat Produk (gr)
                            </p>
                            <p class="text-grey fs-12 m-0">Berat setelah produk <span class="m-0 fw-600">dikemas</span>
                            </p>
                        </div>
                        <div class="col-sm-9">
                            {{ $product->weight }} gram
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div for="" class="col-sm-3 mb-3">
                            <p class="fw-600 m-0">
                                Ukuran Produk
                            </p>
                            <p class="text-grey fs-12 m-0">Panjang, lebar, dan tinggi produk setelah <span
                                    class="m-0 fw-600">dikemas</span>
                            </p>
                        </div>
                        <div class="col-sm-9">
                            <ul class="p-0 ps-3" >
                                <li>
                                    <div class="mb-3 row">
                                        <div for="productWeight" class="col-sm-4 ">
                                            <p class="fw-600 m-0">
                                                Panjang Produk (cm)
                                            </p>
                                            <p class="text-grey fs-12 m-0">Panjang setelah produk <span
                                                    class="m-0 fw-600">dikemas</span>
                                            </p>
                                        </div>
                                        <div class="col-sm-8">
                                            {{ $product->long }} cm
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="mb-3 row">
                                        <div for="productWeight" class="col-sm-4 ">
                                            <p class="fw-600 m-0">
                                                Lebar Produk (cm)
                                            </p>
                                            <p class="text-grey fs-12 m-0">Lebar setelah produk <span
                                                    class="m-0 fw-600">dikemas</span>
                                            </p>
                                        </div>
                                        <div class="col-sm-8">
                                            {{ $product->width }} cm
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="mb-3 row">
                                        <div for="productWeight" class="col-sm-4 ">
                                            <p class="fw-600 m-0">
                                                Tinggi Produk (cm)
                                            </p>
                                            <p class="text-grey fs-12 m-0">Tinggi setelah produk <span
                                                    class="m-0 fw-600">dikemas</span>
                                            </p>
                                        </div>
                                        <div class="col-sm-8">
                                            {{ $product->height }} cm
                                        </div>
                                    </div>
                                </li>
                            </ul>
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
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-3 row">
                        <div for="productPrice" class="col-sm-3  fw-600">Harga Produk</div>
                        <div class="col-sm-9">
                            Rp{{ price_format_rupiah($product->price) }}
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
                        <p class="text-grey fs-13 m-0">Lokasi dimana produk tersedia dan akan dikirimkan</p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    @foreach ($senderAddresses as $sender)
                        <ul class="p-0 ps-3">
                            @foreach ($product->productorigin as $origin)
                                @if ($origin->sender_address_id == $sender->id)
                                    <li>
                                        <div class="sender-address-detail mb-2">
                                            <p class="fw-600 m-0"> {{ $sender->name }}</p>
                                            <p class="m-0"> {{ $sender->address }} </p>
                                            <div class="">
                                                <span class="m-0">
                                                    {{ $sender->city->name }} ,
                                                </span>
                                                <span class="m-0">
                                                    {{ $sender->province->name }} ,
                                                </span>
                                                <span class="m-0">
                                                    {{ $sender->postal_code }}
                                                </span>
                                            </div>
                                            <p class="m-0"> {{ $sender->telp_no }}</p>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
@endsection
