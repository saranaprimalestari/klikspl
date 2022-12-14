@extends('user.layout')
@section('account')
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
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">
            <p><strong>Gagal Menyelesaikan transaksi</strong></p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h5 class="mb-4">
        Komentar Produk
    </h5>
    <div class="card mb-3 border-radius-075rem fs-14">
        <div class="card-body p-4">
            <div class="card mb-4 border-radius-075rem box-shadow">
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
                            <div class="row align-items-center">
                                <div class="col-md-2 col-4 text-end">
                                    @if (!is_null($comment->product->productimage->first()))
                                        {{-- {{ $comment->product->productimage->first()->name }} --}}
                                        <img src="{{ asset('/storage/' . $comment->product->productimage->first()->name) }}"
                                            class="w-100 border-radius-5px" alt="">
                                    @endif
                                </div>
                                <div class="col-md-10 col-8 ps-0">
                                    <div class="order-items-product-info text-start">
                                        <div class="text-truncate order-items-product-name">
                                            {{ $comment->product->name }}
                                        </div>
                                        <div class="text-truncate order-items-product-variant text-grey fs-13">
                                            Varian:
                                            {{ !is_null($comment->product->variant_name) ? $comment->product->variant_name : 'Tidak ada Varian' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4 border-radius-075rem box-shadow">
                <div class="card-body p-4">
                    {{-- <p class="mb-3 fs-14 fw-bold">Beri Nilai Produk</p> --}}
                    <p class="mb-3 fs-14 fw-600">Bintang Produk</p>
                    <p class="comment-text mb-1">
                        @for ($i = 0; $i < $comment->star; $i++)
                            <i class="bi bi-star-fill text-warning"></i>
                        @endfor
                        @for ($i = 0; $i < 5 - $comment->star; $i++)
                            <i class="bi bi-star text-warning"></i>
                        @endfor
                    </p>
                    <div class="my-3 fs-14">
                        <p class="fw-600">
                            Komentar
                        </p>
                        <p class="">
                            {{ $comment->comment }}
                        </p>
                    </div>
                    @if (!empty($comment->comment_image))
                        <div class="my-3 fs-14">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="fw-600">Foto yang di upload</div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <img class="img-preview w-100" src="{{ asset($comment->comment_image) }}">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
