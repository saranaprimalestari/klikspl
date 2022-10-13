@extends('layouts.main')

@section('container')
    @if ($page == 'Kategori')
        <div class="container-fluid breadcrumb-products">
            {{ Breadcrumbs::render('category.show', $var) }}

        </div>
    @elseif($page == 'Merk')
        <div class="container-fluid breadcrumb-products">
            {{ Breadcrumbs::render('merk.show', $var) }}

        </div>
    @endif
    <div class="row mb-3">
        <div class="col-md-3 col-sm-12 col-12 d-none d-sm-block">
            <div class="card my-2 category-card-left-side">
                <div class="card-body">
                    <h5 class="fs-6">{{ $page }}</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($queries as $queryLeftSide)
                            <li class="list-group-item border-0 products-category-li p-0 ps-1">
                                <a class="text-dark text-decoration-none category-left-side {{ $queryLeftSide->id === $var->id ? 'fw-bold' : '' }}"
                                    href="/{{ $page === 'Kategori' ? 'category' : ($page === 'Merk' ? 'merk' : '') }}/{{ $queryLeftSide->slug }}">
                                    {{ $queryLeftSide->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-6">
                    {{ $page }} <span class="fw-bold">{{ $var->name }}</span>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            <div class="row card-group">
                @foreach ($products as $product)
                    <div class="col-md-3 col-6 col-sm-6 my-2 p-0 px-1">
                        <a href="/product/{{ $product->slug }}" class="text-decoration-none text-dark">
                            <div class="card h-100 mb-3 product-card">
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
                                {{-- <img src="https://source.unsplash.com/400x400?new-product" class="card-img-top"
                                    alt="https://source.unsplash.com/400x400"> --}}
                                <div class="card-body p-0 px-2 pt-2">
                                    <p class="m-0 text-truncate">{{ $product->name }}</p>
                                </div>
                                <div class="card-body p-0 px-2 pb-1">
                                    <p class="card-text text-danger m-0 mb-1">Rp
                                        {{ price_format_rupiah($product->price) }}</p>
                                </div>
                                <div class="card-footer bg-transparent border-0 p-0 px-2 pb-3">
                                    <div class="rate">
                                        <div class="d-flex">
                                            <div class="d-inline">
                                                {{-- <i class="fas fa-star text-warning"></i> --}}
                                                <i class="bi bi-star-fill text-warning"></i>
                                                {{ round($product->productcomment->avg('star'), 1) }}
                                            </div>
                                            <div class="d-inline mx-1">|</div>
                                            <div class="d-inline">{{ $product->sold }} terjual</div>
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
        </div>
    </div>
    <div class="d-flex justify-content-end mb-5 shadow-none">
        {{ $products->links() }}
    </div>
@endsection
