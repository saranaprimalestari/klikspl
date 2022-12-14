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
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1 mt-sm-0 mt-5">
        <h1 class="h2">
            Penilaian Produk
        </h1>
    </div>
    <div class="container p-0 mb-5">
        <div class="card border-radius-1-5rem fs-14 border-0">
            <div class="card-header bg-transparent px-4 py-3 pb-1 border-bottom-0">
                <h5>Filter</h5>
            </div>
            <div class="card-body p-4 pt-2">
                <form class="status-form" action="{{ route('productcomment.index') }}" method="GET">
                    @csrf
                    {{-- @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif --}}
                    <div class="row gx-3 gy-2 align-items-center mb-4">
                        <div class="col-md-3 col-12">
                            <label class="form-label" for="Filter">Pencarian</label>
                            <input type="text" class="form-control form-control-sm border-radius-05rem fs-14 shadow-none"
                                id="searchKeyword" placeholder="Cari no invoice, username, komentar"
                                aria-label="Cari no invoice, username, komentar" aria-describedby="basic-addon2"
                                name="search">
                        </div>
                        <div class="col-md-3 col-12">
                            <label class="form-label" for="Filter">Penilaian</label>
                            <select class="form-select form-select-sm border-radius-05rem shadow-none" id="Filter"
                                name="star">
                                <option value="" selected>Pilih<i class="bi bi-funnel"></i></option>
                                <option value="asc"
                                    {{ !is_null(request('star')) && request('star') == 'asc' ? 'selected' : '' }}>
                                    Terendah</option>
                                <option value="desc"
                                    {{ !is_null(request('star')) && request('star') == 'desc' ? 'selected' : '' }}>
                                    Tertinggi</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-12">
                            <label class="form-label" for="Filter">Waktu Komentar</label>
                            <select class="form-select form-select-sm border-radius-05rem shadow-none" id="Filter"
                                name="created_at">
                                <option value="" selected>Pilih<i class="bi bi-funnel"></i></option>
                                <option value="asc"
                                    {{ !is_null(request('created_at')) && request('created_at') == 'asc' ? 'selected' : '' }}>
                                    Terlama</option>
                                <option value="desc"
                                    {{ !is_null(request('created_at')) && request('created_at') == 'desc' ? 'selected' : '' }}>
                                    Terbaru</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-12">
                            <label class="form-label" for="Filter">Nomor Invoice</label>
                            <select class="form-select form-select-sm border-radius-05rem shadow-none" id="Filter"
                                name="invoice_no">
                                <option value="" selected>Pilih<i class="bi bi-funnel"></i></option>
                                <option value="asc"
                                    {{ !is_null(request('invoice_no')) && request('invoice_no') == 'asc' ? 'selected' : '' }}>
                                    Awal</option>
                                <option value="desc"
                                    {{ !is_null(request('invoice_no')) && request('invoice_no') == 'desc' ? 'selected' : '' }}>
                                    Akhir</option>
                            </select>
                        </div>

                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <a href="{{ route('productcomment.index') }}" class="btn btn-secondary fs-14 filter-btn">
                                Bersihkan Filter
                            </a>
                            <button type="submit" class="btn btn-danger fs-14 filter-btn ms-1">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if (count($productComments) > 0)
        @foreach ($productComments as $comment)
            @if (count($comment->children) <= 0)
                <div class="container p-0 mb-3">
                    <div class="card border-radius-1-5rem fs-14 border-0 card-product-comment">
                        <div class="card-body p-4">
                            <div class="mb-2 fs-13">
                                <span class="">No Invoice:
                                </span>
                                <span class="fw-600">
                                    {{ $comment->order->invoice_no }}
                                </span>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-md-12">
                                    <div class="card my-3 border-radius-075rem">
                                        <div class="card-body px-4">
                                            <div class="row align-items-center">
                                                <div class="col-md-1 col-4 text-end">
                                                    @if (!is_null($comment->product->productimage->first()))
                                                        <img src="{{ asset('/storage/' . $comment->product->productimage[0]->name) }}"
                                                            class="w-100 border-radius-5px" alt="">
                                                    @endif
                                                </div>
                                                <div class="col-md-10 col-8 ps-0">
                                                    <div class="order-items-product-info text-start">
                                                        <div class="text-truncate order-items-product-name">
                                                            {{ $comment->product->name }}
                                                        </div>
                                                        <div
                                                            class="text-truncate order-items-product-variant text-grey fs-13">
                                                            Varian:
                                                            {{ !is_null($comment->productvariant) ? $comment->productvariant->variant_name : 'Tidak ada Varian' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-3 border-radius-075rem">
                                        <div class="card-body px-4">
                                            <p class="comment-text mb-1">
                                                @for ($i = 0; $i < $comment->star; $i++)
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                @endfor
                                                @for ($i = 0; $i < 5 - $comment->star; $i++)
                                                    <i class="bi bi-star text-warning"></i>
                                                @endfor
                                            </p>
                                            <h5 class="comment-text">
                                                @if (isset($comment->user->username))
                                                    {{ $comment->user->username }}
                                                @endif
                                                <small class="text-muted comment-text fw-light ms-1">
                                                    <i>Diposting
                                                        {{ $comment->created_at->diffForHumans() }}
                                                    </i>
                                                </small>
                                            </h5>
                                            <div class="comment-text mb-2">
                                                {!! $comment->comment !!}
                                            </div>
                                            @if (!is_null($comment->comment_image) && !empty($comment->comment_image) && isset($comment->comment_image))
                                                <img src="{{ asset($comment->comment_image) }}" class=""
                                                    alt="" width="20%">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex align-items-center fs-13">  
                                <div class="col-md-12 col-12 text-end my-2">
                                    {{-- {{ $comment->is_edit }} --}}
                                    {{-- @if ($comment->is_edit != 1) --}}
                                        <a href="{{ route('productcomment.reply', $comment) }}"
                                            class="text-decoration-none btn btn-outline-danger fs-14">
                                            <i class="bi bi-reply"></i> Balas Komentar
                                        </a>
                                    {{-- @else
                                        <a href="{{ route('comment.show', $comment) }}"
                                            class="text-decoration-none btn btn-outline-danger fs-14">
                                            <i class="far fa-star"></i> Lihat Komentar
                                        </a>
                                    @endif --}}
                                    {{-- <a href="{{ route('rating.show', $comment) }}" class="text-decoration-none btn btn-outline-danger fs-14 ms-1">
                                <i class="far fa-trash-alt"></i> Hapus
                            </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- {{ $comment }}
                <div class="container p-0 mb-3">
                    <div class="card border-radius-1-5rem fs-14 border-0 card-product-order">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <img class="my-4 cart-items-logo" src="/assets/footer-logo.png" width="300"
                                    alt="">
                                <div>
                                    Belum ada komentar pembeli saat ini!
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            @endif
        @endforeach
    @else
        <div class="container p-0 mb-3">
            <div class="card border-radius-1-5rem fs-14 border-0 card-product-order">
                <div class="card-body p-4">
                    <div class="text-center">
                        <img class="my-4 cart-items-logo" src="/assets/footer-logo.png" width="300" alt="">
                        <div>
                            Belum ada komentar pembeli saat ini!!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <script>
        $('#searchKeyword').on("keyup", function() {
            // $('.filter-btn').on("click", function() {
            // var search = $(this).val().toLowerCase();
            var search = $('input[name="search"]').val().toLowerCase();
            $(".card-product-comment").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(search) > -1);
                // });
            });
        });
    </script>
@endsection
