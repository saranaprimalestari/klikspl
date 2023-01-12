@extends('layouts.main')

@section('container')
    {{-- {{ dd(auth()->user()->cartitem) }} --}}
    <div class="carousel-index">
        <div class="row">
            <div class="col-md-12 col-12">
                <div id="promoBannerIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators carousel-indicator-banners">
                        <button type="button" data-bs-target="#promoBannerIndicators" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        @if (count($promoBanner) > 0)
                            @foreach ($promoBanner->skip(1) as $promo)
                                <button type="button" data-bs-target="#promoBannerIndicators"
                                    data-bs-slide-to="{{ $loop->iteration }}" aria-current="true"
                                    aria-label="Slide {{ $loop->iteration }}"></button>
                            @endforeach
                        @endif
                        {{-- <button type="button" data-bs-target="#promoBannerIndicators" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#promoBannerIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#promoBannerIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button> --}}
                    </div>
                    <div class="carousel-inner rounded-3 carousel-inner-index">
                        @if (count($promoBanner) > 0)
                            <div class="carousel-item active index-banner">
                                <img src="{{ asset('/storage/'.$promoBanner[0]->image) }}" class="d-block w-100"
                                    alt="https://source.unsplash.com/1200x400">
                            </div>
                            @foreach ($promoBanner->skip(1) as $promo)
                                <div class="carousel-item index-banner">
                                    <img src="{{ asset('/storage/'.$promo->image) }}" class="d-block w-100"
                                        alt="https://source.unsplash.com/1200x400">
                                </div>
                            @endforeach
                        @endif
                        {{-- <div class="carousel-item index-banner">
                            <img src="https://source.unsplash.com/1200x400?product" class="d-block w-100"
                                alt="https://source.unsplash.com/1200x400">
                        </div>
                        <div class="carousel-item index-banner">
                            <img src="https://source.unsplash.com/1200x400?product" class="d-block w-100"
                                alt="https://source.unsplash.com/1200x400">
                        </div> --}}
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#promoBannerIndicators"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#promoBannerIndicators"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="index-adp mt-4 d-none d-sm-block mb-5">
        <div class="row justify-content-center align-items-center text-center">
            @foreach ($merksIndex as $merk)
                <div class="index-adp-item col-md-2 col-6 my-3 col-sm-4">
                    <a class="index-adp-img" href="/products?merk={{ $merk->slug }}">
                        <img class="w-75" src="{{ url($merk->image) }}" alt="">
                    </a>
                </div>
            @endforeach
            <div class="index-adp-item col-md-2 col-6 my-3 text-center">
                <a class="text-decoration-none text-danger fs-14" href="{{ route('merk') }}">Lihat Semua</a>
            </div>
        </div>
    </div>

    <div class="index-adp-mobile d-block d-sm-none my-5">
        <h4>Produk Keagenan</h4>
        <div class="row align-items-center text-center">
            @foreach ($merksIndex as $merk)
                @if (!empty($merk->image))
                    <div class="index-adp-item col-md-2 col-5 my-3">
                        <a class="index-adp-img-mobile" href="/products?merk={{ $merk->slug }}">
                            <img src="{{ $merk->image }}" alt="">
                        </a>
                    </div>
                @endif
            @endforeach
            <div class="index-adp-item col-md-2 col-6 my-3">
                <a class="text-decoration-none text-danger fs-14" href="{{ route('merk') }}">Lihat Semua</a>
            </div>
        </div>
    </div>

    <div class="index-category-mobile d-block d-sm-none mb-5">
        <h4>Kategori</h4>
        <div class="row row-cols-2 row-cols-md-6 text-center ps-2">
            @foreach ($categories as $category)
                <div class="col-6 my-2 p-0 px-1">
                    {{-- <a class="text-decoration-none text-dark" href="/category/{{ $category->slug }}"> --}}
                    <a class="text-decoration-none text-dark" href="/products?category={{ $category->slug }}">
                        <div class="card h-100 product-card">
                            @if (count($category->product))
                                @if (count($category->product[0]->productimage))
                                    @if (Storage::exists($category->product[0]->productimage[0]->name))
                                        {{-- {{ ($category->product[0]->productimage[0]->name) }} --}}
                                        <img src="{{ asset('/storage/' . $category->product[0]->productimage[0]->name) }}"
                                            class="card-img-top" alt="Foto Produk">
                                    @else
                                        <img src="/assets/cart.svg" class="card-img-top"
                                            alt="https://source.unsplash.com/500x500?fire-extinguisher">
                                    @endif
                                @else
                                    <img src="/assets/cart.svg" class="card-img-top"
                                        alt="https://source.unsplash.com/500x500?fire-extinguisher">
                                @endif
                            @else
                                <img src="/assets/cart.svg" class="card-img-top"
                                    alt="https://source.unsplash.com/500x500?fire-extinguisher">
                            @endif
                            <div class="card-body d-flex justify-content-center align-items-center">
                                {{-- <i class="fas fa-boxes"></i>&nbsp; --}}

                                <p class="card-title fw-bold">
                                    {{ $category->name }}
                                </p>
                                <p class="card-text"></p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="d-flex">
            <div class="ms-auto">
                <a href="{{ route('category') }}" class="text-decoration-none text-danger fs-14">Lihat Semua</a>
            </div>
        </div>
    </div>

    <div class="index-category d-none d-sm-block">
        <div class="d-flex bd-highlight">
            <div class="flex-grow-1 bd-highlight">
                <h4>Kategori</h4>
            </div>
            <div class="bd-highlight index-all-product-redirect">
                <a href="{{ route('category') }}" class="text-decoration-none text-danger fs-14">Lihat Semua</a>
            </div>
        </div>
    </div>
    <div class="container mb-5 index-product d-none d-sm-block mb-5">
        <div class="row card-group">
            @foreach ($categories as $category)
                <div class="col-6 col-md-3 col-lg-2 my-2 p-0 px-1 col-sm-4">
                    {{-- <a class="text-decoration-none text-dark" href="/category/{{ $category->slug }}"> --}}
                    <a class="text-decoration-none text-dark" href="/products?category={{ $category->slug }}">
                        <div class="card h-100 product-card">
                            @if (count($category->product))
                                @if (count($category->product->last()->productimage))
                                    @if (Storage::exists($category->product->last()->productimage[0]->name))
                                        {{-- {{ ($category->product->last()->productimage[0]->name) }} --}}
                                        <img src="{{ asset('/storage/' . $category->product->last()->productimage[0]->name) }}" 
                                            class="card-img-top" alt="Foto Produk">
                                    @else
                                        <img src="/assets/cart.svg" class="card-img-top"
                                            alt="https://source.unsplash.com/500x500?fire-extinguisher">
                                    @endif
                                @else
                                    <img src="/assets/cart.svg" class="card-img-top"
                                        alt="https://source.unsplash.com/500x500?fire-extinguisher">
                                @endif
                            @else
                                <img src="/assets/cart.svg" class="card-img-top"
                                    alt="https://source.unsplash.com/500x500?fire-extinguisher">
                            @endif
                            <div class="card-body d-flex justify-content-center align-items-center text-center">
                                {{-- <i class="fas fa-boxes"></i>&nbsp; --}}

                                <p class="card-title m-0 fw-bold">
                                    {{ $category->name }}
                                </p>
                                <p class="card-text"></p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="index-product">
        <div class="d-flex bd-highlight">
            <div class="flex-grow-1 bd-highlight">
                <h4>Produk Terbaru</h4>
            </div>
            <div class="bd-highlight index-all-product-redirect d-none d-sm-block">
                <a href="/products" class="text-decoration-none text-danger fs-14">Lihat Semua</a>
            </div>
        </div>
    </div>
    <div class="mb-5 index-product">
        <div class="row card-group">
            @foreach ($productsLatest as $productLatest)
                <div class="col-md-3 col-6 col-lg-2 my-2 p-0 px-1 col-6 col-sm-4">
                    <a href="/product/{{ $productLatest->slug }}" class="text-decoration-none text-dark">
                        <div class="card h-100 mb-3 product-card">
                            @if (count($promosPL) > 0)
                                {{-- {{ count($productLatest->productpromo) }} VOUCHER PROMO --}}
                                @foreach ($promosPL as $promoPL)
                                    @if ($promoPL->id == $productLatest->id)
                                        <div
                                            class="position-absolute px-3 py-2 text-white bg-red-klikspl border-radius-075rem fs-11 box-shadows">
                                            {{ $promoPL->promoActive }} VOUCHER PROMO
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            {{-- {{ $productLatest->productimage[0] }}
                            {{ (asset('/storage/' . $productLatest->productimage[0]->name)) }} --}}
                            @if (count($productLatest->productimage) > 0)
                                @if (Storage::exists($productLatest->productimage[0]->name))
                                    <img src="{{ asset('/storage/' . $productLatest->productimage[0]->name) }}"
                                        class="card-img-top" alt="Foto Produk">
                                @else
                                    <img src="https://source.unsplash.com/400x400?product-{{ $loop->iteration }}"
                                        class="card-img-top" alt="Foto Produk">
                                @endif
                            @else
                                <img src="https://source.unsplash.com/400x400?product-{{ $loop->iteration }}"
                                    class="card-img-top" alt="Foto Produk">
                            @endif
                            <div class="card-body p-0 px-2 pt-2">
                                <p class="m-0 text-truncate" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="{{ $productLatest->name }}">{{ $productLatest->name }}</p>
                            </div>
                            <div class="card-body p-0 px-2 pb-1">
                                <p class="card-text text-danger m-0 mb-1 text-truncate fw-600">
                                    <span class="price-span" id="price-span">
                                        @if (count($productLatest->productvariant) == 1)
                                            Rp{{ price_format_rupiah($productLatest->productvariant->sortBy('price')->first()->price) }}
                                        @elseif (count($productLatest->productvariant) > 1)
                                            @if ($productLatest->productvariant->sortBy('price')->first()->price ==
                                                $productLatest->productvariant->sortBy('price')->last()->price)
                                                Rp{{ price_format_rupiah($productLatest->productvariant->sortBy('price')->first()->price) }}
                                            @else
                                                Rp{{ price_format_rupiah($productLatest->productvariant->sortBy('price')->first()->price) }}
                                                -
                                                {{ price_format_rupiah($productLatest->productvariant->sortBy('price')->last()->price) }}
                                            @endif
                                        @else
                                            Rp{{ price_format_rupiah($productLatest->price) }}
                                        @endif
                                    </span>
                                </p>
                            </div>
                            <div class="card-body p-0 px-2">
                                <p class="m-0 text-truncate fs-14" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Tersedia di @foreach ($productLatest->productorigin->unique('city_ids') as $origin){{ $origin->city->type }} {{ $origin->city->name }}@if (!$loop->last),@endif @endforeach">
                                    @foreach ($productLatest->productorigin->unique('city_ids') as $origin)
                                        {{ $origin->city->type }} {{ $origin->city->name }}
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </p>
                                {{-- {{ $productLatest->productorigin }} --}}
                            </div>
                            <div class="card-footer bg-transparent border-0 p-0 px-2 pb-3">
                                <div class="rate">
                                    <div class="d-flex">
                                        <div class="d-inline">
                                            {{-- <i class="fas fa-star text-warning"></i> --}}
                                            <i class="bi bi-star-fill text-warning"></i>
                                            {{-- {{ round($productLatest->productcomment->avg('star'), 1) }} --}}
                                            {{ round($productLatest->star, 1) }}
                                        </div>
                                        <div class="d-inline mx-1 d-none d-sm-block">|</div>
                                        <div class="d-inline d-none d-sm-block">
                                            {{ count($productLatest->productvariant) > 0 ? $productLatest->productvariant->sum('sold') : $productLatest->sold }}
                                            terjual</div>
                                        <div class="d-inline ms-auto" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="{{ $productLatest->view }} kali dilihat">
                                            {{-- <i class="far fa-eye text-dark"></i> --}}
                                            <i class="bi bi-eye"></i>
                                            {{ $productLatest->view }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="d-flex">
            <div class="ms-auto index-all-product-redirect d-block d-sm-none">
                <a href="/products" class="text-decoration-none text-danger fs-14">Lihat Semua</a>
            </div>
        </div>
    </div>

    <div class="index-product">
        <div class="d-flex bd-highlight">
            <div class="flex-grow-1 bd-highlight">
                <h4>Produk Terbaik</h4>
            </div>
            {{-- <div class="bd-highlight index-all-product-redirect">
                <a href="/products" class="text-decoration-none text-danger fs-14">Lihat Semua</a>
            </div> --}}
        </div>
        <div class="row row-cols-1"></div>
    </div>
    <div class="mb-5">
        <div class="row card-group">
            @foreach ($productsStar as $star)
                <div class="col-md-3 col-6 col-lg-2 my-2 p-0 px-1 col-sm-4">
                    <a href="/product/{{ $star->slug }}" class="text-decoration-none text-dark">
                        <div class="card h-100 mb-3 product-card">
                            @if (count($promosStar) > 0)
                                {{-- {{ count($productLatest->productpromo) }} VOUCHER PROMO --}}
                                @foreach ($promosStar as $promoStar)
                                    @if ($promoStar->id == $star->id)
                                        <div
                                            class="position-absolute px-3 py-2 text-white bg-red-klikspl border-radius-075rem fs-11 ">
                                            {{ $promoStar->promoActive }} VOUCHER PROMO
                                        </div>
                                    @endif
                                @endforeach
                            @else
                            @endif
                            @if (count($star->productimage) > 0)
                                @if (Storage::exists($star->productimage[0]->name))
                                    <img src="{{ asset('/storage/' . $star->productimage[0]->name) }}"
                                        class="card-img-top" alt="Foto Produk">
                                @else
                                    <img src="https://source.unsplash.com/400x400?product-{{ $loop->iteration }}"
                                        class="card-img-top" alt="Foto Produk">
                                @endif
                            @else
                                <img src="https://source.unsplash.com/400x400?product-{{ $loop->iteration }}"
                                    class="card-img-top" alt="Foto Produk">
                            @endif
                            <div class="card-body p-0 px-2 pt-2">
                                <p class="m-0 text-truncate" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="{{ $star->name }}">{{ $star->name }}</p>
                            </div>
                            <div class="card-body p-0 px-2 pb-1">
                                <p class="card-text text-danger m-0 mb-1 text-truncate fw-600">
                                    <span class="price-span" id="price-span">
                                        @if (count($star->productvariant) == 1)
                                            Rp{{ price_format_rupiah($star->productvariant->sortBy('price')->first()->price) }}
                                        @elseif (count($star->productvariant) > 1)
                                            @if ($star->productvariant->sortBy('price')->first()->price ==
                                                $star->productvariant->sortBy('price')->last()->price)
                                                Rp{{ price_format_rupiah($star->productvariant->sortBy('price')->first()->price) }}
                                            @else
                                                Rp{{ price_format_rupiah($star->productvariant->sortBy('price')->first()->price) }}
                                                -
                                                {{ price_format_rupiah($star->productvariant->sortBy('price')->last()->price) }}
                                            @endif
                                        @else
                                            Rp{{ price_format_rupiah($star->price) }}
                                        @endif
                                    </span>
                                </p>
                            </div>
                            <div class="card-body p-0 px-2">
                                <p class="m-0 text-truncate fs-14" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Tersedia di @foreach ($star->productorigin->unique('city_ids') as $origin){{ $origin->city->type }} {{ $origin->city->name }}@if (!$loop->last),@endif @endforeach">
                                    @foreach ($star->productorigin->unique('city_ids') as $origin)
                                        {{ $origin->city->type }} {{ $origin->city->name }}
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </p>
                                {{-- {{ $productLatest->productorigin }} --}}
                            </div>
                            <div class="card-footer bg-transparent border-0 p-0 px-2 pb-3">
                                <div class="rate">
                                    <div class="d-flex">
                                        <div class="d-inline">
                                            {{-- <i class="fas fa-star text-warning"></i> --}}
                                            <i class="bi bi-star-fill text-warning"></i>
                                            {{-- {{ round($star->productcomment->avg('star'), 1) }} --}}
                                            {{ round($star->star, 1) }}
                                        </div>
                                        <div class="d-inline mx-1 d-none d-sm-block">|</div>
                                        <div class="d-inline d-none d-sm-block">
                                            {{ count($star->productvariant) > 0 ? $star->productvariant->sum('sold') : $star->sold }}
                                            terjual</div>
                                        <div class="d-inline ms-auto" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="{{ $star->view }} kali dilihat">
                                            {{-- <i class="far fa-eye text-dark"></i> --}}
                                            <i class="bi bi-eye"></i>
                                            {{ $star->view }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="index-product">
        <div class="d-flex bd-highlight">
            <div class="flex-grow-1 bd-highlight">
                <h4>Produk Terlaris</h4>
            </div>
            {{-- <div class="bd-highlight index-all-product-redirect">
                <a href="/products" class="text-decoration-none text-danger fs-14">Lihat Semua</a>
            </div> --}}
        </div>
        <div class="row row-cols-1"></div>
    </div>
    <div class="mb-5">
        <div class="row card-group">
            @foreach ($productsBestSeller as $productBS)
                <div class="col-md-3 col-6 col-lg-2 my-2 p-0 px-1 col-sm-4">
                    <a href="/product/{{ $productBS->slug }}" class="text-decoration-none text-dark">
                        <div class="card h-100 mb-3 product-card">
                            {{-- @if (count($productBS->productpromo) > 0) --}}
                            @if (count($promosBS) > 0)
                                {{-- {{ count($productLatest->productpromo) }} VOUCHER PROMO --}}
                                @foreach ($promosBS as $promoBS)
                                    @if ($promoBS->id == $productBS->id)
                                        <div
                                            class="position-absolute px-3 py-2 text-white bg-red-klikspl border-radius-075rem fs-11">
                                            {{ $promoBS->promoActive }} VOUCHER PROMO
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if (count($productBS->productimage) > 0)
                                @if (Storage::exists($productBS->productimage[0]->name))
                                    <img src="{{ asset('/storage/' . $productBS->productimage[0]->name) }}"
                                        class="card-img-top" alt="Foto Produk">
                                @else
                                    <img src="https://source.unsplash.com/400x400?product-{{ $loop->iteration }}"
                                        class="card-img-top" alt="Foto Produk">
                                @endif
                            @else
                                <img src="https://source.unsplash.com/400x400?product-{{ $loop->iteration }}"
                                    class="card-img-top" alt="Foto Produk">
                            @endif
                            <div class="card-body p-0 px-2 pt-2">
                                <p class="m-0 text-truncate" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="{{ $productBS->name }}">{{ $productBS->name }}</p>
                            </div>
                            <div class="card-body p-0 px-2 pb-1">
                                <p class="card-text text-danger m-0 mb-1 text-truncate fw-600">
                                    <span class="price-span" id="price-span">
                                        @if (count($productBS->productvariant) == 1)
                                            Rp{{ price_format_rupiah($productBS->productvariant->sortBy('price')->first()->price) }}
                                        @elseif (count($productBS->productvariant) > 1)
                                            @if ($productBS->productvariant->sortBy('price')->first()->price ==
                                                $productBS->productvariant->sortBy('price')->last()->price)
                                                Rp{{ price_format_rupiah($productBS->productvariant->sortBy('price')->first()->price) }}
                                            @else
                                                Rp{{ price_format_rupiah($productBS->productvariant->sortBy('price')->first()->price) }}
                                                -
                                                {{ price_format_rupiah($productBS->productvariant->sortBy('price')->last()->price) }}
                                            @endif
                                        @else
                                            Rp{{ price_format_rupiah($productBS->price) }}
                                        @endif
                                    </span>
                                </p>
                            </div>
                            <div class="card-body p-0 px-2">
                                <p class="m-0 text-truncate fs-14" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Tersedia di @foreach ($productBS->productorigin->unique('city_ids') as $origin){{ $origin->city->type }} {{ $origin->city->name }}@if (!$loop->last),@endif @endforeach">
                                    @foreach ($productBS->productorigin->unique('city_ids') as $origin)
                                        {{ $origin->city->type }} {{ $origin->city->name }}
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-0 p-0 px-2 pb-3">
                                <div class="rate">
                                    <div class="d-flex">
                                        <div class="d-inline">
                                            {{-- <i class="fas fa-star text-warning"></i> --}}
                                            <i class="bi bi-star-fill text-warning"></i>
                                            {{-- {{ round($productBS->productcomment->avg('star'), 1) }} --}}
                                            {{ round($productBS->star, 1) }}
                                        </div>
                                        <div class="d-inline mx-1 d-none d-sm-block">|</div>
                                        <div class="d-inline d-none d-sm-block">
                                            {{ count($productBS->productvariant) > 0 ? $productBS->productvariant->sum('sold') : $productBS->sold }}
                                            terjual</div>
                                        <div class="d-inline ms-auto" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="{{ $productBS->view }} kali dilihat">
                                            {{-- <i class="far fa-eye text-dark"></i> --}}
                                            <i class="bi bi-eye"></i>
                                            {{ $productBS->view }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
