@extends('layouts.main')

@section('container')
    @if ($page == 'Kategori')
        <div class="container-fluid breadcrumb-products">
            {{ Breadcrumbs::render('category') }}
        </div>
    @elseif($page == 'Merk')
        <div class="container-fluid breadcrumb-products">
            {{ Breadcrumbs::render('merk') }}
        </div>
    @endif

    <div class="index-category">
        <h4>{{ $page }}</h4>
        <div class="row row-cols-2 row-cols-md-6 mt-3 mb-5 text-center">
            @foreach ($queries as $query)
                <div class="col-6 my-2 p-0 px-1">
                    <a class="text-decoration-none text-dark"
                        href="/products?{{ $page === 'Kategori' ? 'category' : ($page === 'Merk' ? 'merk' : '') }}={{ $query->slug }}">

                        <div class="card h-100 product-card">
                            @if ($page == 'Kategori')
                                {{-- <img src="{{ $imgSource }}" class="card-img-top" alt="Gambar gagal dimuat"> --}}
                                @if (count($query->product))
                                    @if (count($query->product[0]->productimage))
                                        @if (Storage::exists($query->product[0]->productimage[0]->name))
                                            {{-- {{ ($query->product[0]->productimage[0]->name) }} --}}
                                            <img src="{{ asset('/storage/' . $query->product[0]->productimage[0]->name) }}"
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
                            @elseif($page == 'Merk')
                                <img src="/{{ $query->image }}" class="card-img-top px-3 py-5" alt="Gambar gagal dimuat">
                            @endif
                            <div class="card-body d-flex justify-content-center align-items-center">
                                {{-- <i class="fas fa-boxes"></i>&nbsp; --}}

                                <p class="card-title  fw-bold">
                                    {{ $query->name }}
                                </p>
                                <p class="card-text"></p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
