@extends('layouts.main')
@section('container')
    <div class="container-fluid breadcrumb-notification text-truncate">
        {{ Breadcrumbs::render('promo.show', $promo) }}
    </div>
    <div class="container mt-5">
        {{-- {{ dd($order) }} --}}
        <div class="row my-3">
            <div class="col-md-8 col-12 mx-auto">
                <a href="{{ route('promo.index') }}" class="text-decoration-none link-dark">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-12 mx-auto">
                <div class="card mb-3 border-radius-075rem">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="row align-items-center">
                                    <div class="col-md-2 col-4">
                                        @if (!empty($promo->image))
                                            @if (File::exists(public_path($promo->image)))
                                                <img src="{{ asset($promo->image) }}"
                                                    class="img-fluid w-100 border-radius-075rem" alt="...">
                                            @elseif(Storage::exists($promo->image))
                                                <img src="{{ asset('/storage/' . $promo->image) }}"
                                                    class="img-fluid w-100 border-radius-075rem" alt="...">
                                            @else
                                                <img src="{{ asset('assets/voucher.png') }}"
                                                    class="img-fluid w-100 border-radius-075rem" alt="...">
                                            @endif
                                        @else
                                            <img src="{{ asset('assets/voucher.png') }}"
                                                class="img-fluid w-100 border-radius-075rem" alt="...">
                                        @endif
                                    </div>
                                    <div class="col-md-10 col-12 my-2 ps-md-0">
                                        <p class="m-0 fw-600 pb-1 fs-14">
                                            {{ $promo->name }}
                                        </p>
                                        <p class="m-0 fs-14">
                                            Min, transaksi Rp{{ price_format_rupiah($promo->min_transaction, 'Rp') }}
                                        </p>
                                        <span class="d-md-flex notification-list-created-at mb-1">
                                            <p class="m-0 me-2 fs-12 text-grey">
                                                Berlaku hingga
                                                {{ \Carbon\Carbon::parse($promo->end_period)->isoFormat('D MMMM Y, HH:mm') }}
                                                WIB
                                            </p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-12 mx-auto fs-14">
                <h5 class="mb-3">{{ $promo->name }}</h5>
                <div class="mb-3">
                    <p class="m-0 fw-600">
                        Jenis Promo
                    </p>
                    <p class="m-0">
                        {{ ucwords($promo->promotype->name) }}
                    </p>
                </div>
                <div class="mb-3">
                    <p class="m-0 fw-600">
                        Produk yang mendapatkan potongan / diskon
                    </p>
                    <p class="m-0">
                        @if (count($promo->productpromo) == 1)
                            @foreach ($promo->productpromo as $productPromo)
                                {{ $productPromo->product->name }}
                            @endforeach
                        @else
                            Semua Produk
                        @endif
                    </p>
                </div>
                <div class="mb-3">
                    <p class="m-0 fw-600">
                        Periode Promo
                    </p>
                    <p class="m-0">
                        {{ \Carbon\Carbon::parse($promo->start_period)->isoFormat('D MMMM') }}
                        -
                        {{ \Carbon\Carbon::parse($promo->end_period)->isoFormat('D MMMM Y, HH:mm') }} WIB
                    </p>
                </div>
                <div class="mb-3">
                    <p class="m-0 fw-600">
                        Minimal Transaksi
                    </p>
                    <p class="m-0">
                        Rp{{ price_format_rupiah($promo->min_transaction, 'Rp') }}
                    </p>
                </div>
                <div class="mb-3">
                    <p class="m-0 fw-600">
                        Potongan / diskon
                    </p>
                    <p class="m-0">
                        @if ($promo->promo_type_id == 1 || $promo->promo_type_id == 3)
                            {{ $promo->discount }}%
                        @else
                            Rp{{ price_format_rupiah($promo->discount, 'Rp') }}
                        @endif
                    </p>
                </div>
                <div class="mb-3">
                    <p class="m-0 fw-600">
                        Metode Pembayaran
                    </p>
                    <p class="m-0">
                        @foreach ($promo->promopaymentmethod as $paymentMethod)
                            <div class="">
                                <img id="" class="" src="{{ asset($paymentMethod->paymentmethod->logo) }}"
                                    class="img-fluid" alt="..." width="5%" height="5%">
                                {{ $paymentMethod->paymentmethod->type }}
                                {{ $paymentMethod->paymentmethod->name }}
                            </div>
                        @endforeach
                    </p>
                </div>
                <div class="mb-3">
                    <p class="m-0 fw-600">
                        Detail / Syarat dan ketentuan voucher promo
                    </p>
                    <p class="m-0">
                        {!! $promo->description !!}
                    </p>
                </div>
                <div class="mb-3">
                    <p class="m-0 fw-600">
                        Kuota Voucher
                    </p>
                    <p class="m-0">
                        @if (count($promo->userPromoUse))
                            @foreach ($promo->userPromoUse as $userPromoUse)
                                @if ($userPromoUse->user_id == auth()->user()->id)
                                    @if ($userPromoUse->promo_use <= $promo->quota)
                                        {{ $promo->quota - $userPromoUse->promo_use }}
                                    @else
                                        0
                                    @endif
                                @endif
                            @endforeach
                        @else
                            {{ $promo->quota }}
                        @endif
                        Voucher
                    </p>
                </div>
            </div>

            <div class="col-md-8 col-12 mx-auto mb-5 fs-14">
                <div class="d-grid mt-4 mb-3">
                    <a href="@foreach ($promo->productpromo as $product) @if (count($promo->productpromo) > 1) {{ route('product') }} @break  @else {{ route('product.show', $product->product->slug) }} @endif @endforeach"
                        class="btn btn-danger border-radius-05rem py-2 fs-14 
                        @if (count($promo->userPromoUse)) @foreach ($promo->userPromoUse as $userPromoUse)
                            @if ($userPromoUse->user_id == auth()->user()->id)
                                @if ($userPromoUse->promo_use >= $promo->quota)
                                    disabled @endif
                            @endif @endforeach
                        @endif">
                        Gunakan
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
         $(window).focus(function() {
            window.location.reload();
        });
    </script>
@endsection
