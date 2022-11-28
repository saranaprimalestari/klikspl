@extends('layouts.main')

@section('container')
    <div class="container-fluid breadcrumb-products px-0">
        {{ Breadcrumbs::render('product') }}
    </div>
    {{-- @if (request('category'))
        <input type="hidden" name="category" value="{{ request('category') }}">
    @endif
    @if (request('merk'))
        <input type="hidden" name="merk" value="{{ request('merk') }}">
    @endif
    @if (request('sortby'))
        <input type="hidden" name="sortby" value="{{ request('sortby') }}">
    @endif --}}
    <div class="row mb-3">
        <div class="col-md-3 col-sm-12 col-12 d-none d-sm-block">
            <div class="col-md-12">
                <div class="card mb-3 category-card-left-side">
                    <div class="card-body">
                        @include('search.category')
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card mb-3 category-card-left-side">
                    <div class="card-body">
                        @include('search.merk')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row align-items-center d-block d-sm-none">
                <div class="col-12 ps-1">
                    {{-- <button type="button" class="btn product-reset-filter mx-1 products-clear-filter-btn shadow-none mb-3">
                        Filter <i class="bi bi-funnel"></i>
                    </button> --}}
                    <div class="dropdown">
                        <button class="btn product-reset-filter mx-1 products-clear-filter-btn shadow-none mb-3"
                            type="button" id="FilterButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter <i class="bi bi-funnel"></i>
                        </button>
                        <div class="dropdown-menu filter-search-category-merk-mobile p-4 w-100"
                            aria-labelledby="FilterButton">
                            <div class="row">
                                <div class="col-6 mb-4">
                                    @include('search.category')
                                </div>
                                <div class="col-6">
                                    @include('search.merk')
                                </div>
                            </div>


                            {{-- <li><a class="dropdown-item" href="#">Action</a></li>
                          <li><a class="dropdown-item" href="#">Another action</a></li>
                          <li><a class="dropdown-item" href="#">Something else here</a></li> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-7 me-auto d-flex ps-1">
                    @include('search.clear-filter')
                </div>
                <div class="col-md-2 text-end product-sortby-text d-none">
                    Urutkan
                </div>
                <div class="col-md-3 text-end p-0 d-none">
                    @include('search.sortby')
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 product-search-results">
                    @if (strlen(request('keyword')) > 0)
                        <p class="d-inline-block">
                            Hasil pencarian untuk
                        </p>
                        "
                        <p class="d-inline-block keyword">
                            {{ request('keyword') }}
                        </p>
                        "
                    @endif
                </div>
            </div>
            @if (count($products) > 0)
                <div class="row card-group">
                    @foreach ($products as $product)
                        <div class="col-md-3 col-6 col-sm-6 mb-3 p-0 px-1">
                            <a href="/product/{{ $product->slug }}" class="text-decoration-none text-dark">
                                <div class="card h-100 mb-3 product-card">
                                    @if (count($promos) > 0)
                                        {{-- {{ count($productLatest->productpromo) }} VOUCHER PROMO --}}
                                        @foreach ($promos as $promo)
                                            @if ($promo->id == $product->id)
                                                <div
                                                    class="position-absolute px-3 py-2 text-white bg-red-klikspl border-radius-075rem fs-11">
                                                    {{ $promo->promoActive }} VOUCHER PROMO
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if (count($product->productimage) > 0)
                                        @if (Storage::exists($product->productimage[0]->name))
                                            <img src="{{ asset('/storage/' . $product->productimage[0]->name) }}"
                                                class="card-img-top" alt="Foto Produk">
                                        @else
                                            <img src="https://source.unsplash.com/400x400?product-{{ $loop->iteration }}"
                                                class="card-img-top" alt="Foto Produk">
                                        @endif
                                    @else
                                        <img src="https://source.unsplash.com/400x400?product-{{ $loop->iteration }}"
                                            class="card-img-top" alt="Foto Produk">
                                    @endif
                                    {{-- <img src="{{ asset('/assets/cart.svg') }}" alt="Foto Produk" class="card-img-top"> --}}
                                    <div class="card-body p-0 px-2 pt-2">
                                        <p class="m-0 text-truncate" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="{{ $product->name }}">{{ $product->name }}</p>
                                    </div>
                                    <div class="card-body p-0 px-2 pb-1">
                                        <p class="card-text text-danger m-0 mb-1 text-truncate fw-600">
                                            <span class="price-span" id="price-span">
                                                @if (count($product->productvariant) == 1)
                                                    Rp{{ price_format_rupiah($product->productvariant->sortBy('price')->first()->price) }}
                                                @elseif (count($product->productvariant) > 1)
                                                    @if ($product->productvariant->sortBy('price')->first()->price ==
                                                        $product->productvariant->sortBy('price')->last()->price)
                                                        Rp{{ price_format_rupiah($product->productvariant->sortBy('price')->first()->price) }}
                                                    @else
                                                        Rp{{ price_format_rupiah($product->productvariant->sortBy('price')->first()->price) }}
                                                        -
                                                        {{ price_format_rupiah($product->productvariant->sortBy('price')->last()->price) }}
                                                    @endif
                                                @else
                                                    Rp{{ price_format_rupiah($product->price) }}
                                                @endif
                                            </span>
                                        </p>
                                    </div>
                                    <div class="card-body p-0 px-2">
                                        <p class="m-0 text-truncate fs-14" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom"
                                            title="Tersedia di @foreach ($product->productorigin->unique('city_ids') as $origin){{ $origin->city->type }} {{ $origin->city->name }}@if (!$loop->last),@endif @endforeach">
                                            @foreach ($product->productorigin->unique('city_ids') as $origin)
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
                                                    {{-- {{ round($product->productcomment->avg('star'), 1) }} --}}
                                                    {{ round($product->star, 1) }}
                                                </div>
                                                <div class="d-inline mx-1">|</div>
                                                <div class="d-inline">
                                                    {{ count($product->productvariant) > 0 ? $product->productvariant->sum('sold') : $product->sold }}
                                                    terjual</div>
                                                <div class="d-inline ms-auto" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="{{ $product->view }} kali dilihat">
                                                    {{-- <i class="far fa-eye text-dark"></i> --}}
                                                    <i class="bi bi-eye"></i>
                                                    {{ $product->view }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center cart-items-empty">
                    <img class="my-4 cart-items-logo" src="/assets/footer-logo.png" width="300" alt="">
                    <p>
                        Tidak ada produk ditemukan
                    </p>
                </div>
            @endif
        </div>
    </div>
    <div class="d-flex justify-content-end mb-5">
        {{ $products->links() }}
    </div>
@endsection
