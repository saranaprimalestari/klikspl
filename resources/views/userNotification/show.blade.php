@extends('layouts.main')
@section('container')
    <div class="container-fluid breadcrumb-notification">
        {{ Breadcrumbs::render('notification.show', $notification) }}
    </div>
    <div class="container mt-5">
        {{-- {{ dd($order) }} --}}
        <div class="row my-3">
            <div class="col-md-8 col-12 mx-auto">
                <a href="{{ route('notifications.index') }}" class="text-decoration-none link-dark">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-12 mx-auto">
                <div class="row">
                    <div class="col-md-3 col-12">
                        @if (!is_null($notification->image))
                            <img id="" class="user-notification-show-img border-radius-075rem" src="{{ asset($notification->image) }}"
                                class="img-fluid" alt="..." width="100%">
                        @else
                            <img id="" class="user-notification-show-img border-radius-075rem"
                                src="{{ asset('assets/pict.png') }}" class="img-fluid" alt="..."
                                width="100%">
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-12 mx-auto mt-3 mb-5">
                <h5>{{ $notification->type }}</h5>
                <span class="d-flex notification-list-created-at-show mb-1">
                    <p class="m-0">{{ $notification->created_at }}</p>
                    <p class="m-0 ms-1">{{ $notification->created_at->diffForHumans() }}</p>
                </span>
                <div class="user-notification-show-desc">
                    {!! $notification->description !!}
                </div>
                @if (isset($order))
                    <div class="card my-4 border-radius-075rem fs-14">
                        <div class="card-header bg-transparent py-3">
                            <p class="m-0 fw-bold">Produk Pesanan</p>
                        </div>
                        <div class="card-body px-4 py-1">
                            <div class="row d-flex align-items-center justify-content-center text-center ">
                                <div class="col-md-8">
                                    @foreach ($order->orderitem as $item)
                                        <div class="row my-3">
                                            <div class="col-md-3 col-4 text-end">
                                                @if (!is_null($item->orderproduct->orderproductimage->first()))
                                                    <img src="{{ asset('/storage/' . $item->orderproduct->orderproductimage->first()->name) }}"
                                                        class="w-100 border-radius-5px my-1" alt="">
                                                @endif
                                            </div>
                                            <div class="col-md-9 col-8 ps-0">
                                                <div class="order-items-product-info text-start">
                                                    <div class="order-items-product-name">
                                                        {{ $item->orderproduct->name }}
                                                    </div>
                                                    <div class="text-truncate order-items-product-variant text-grey">
                                                        Varian: {{ (isset($item->orderproduct->variant_name)) ? $item->orderproduct->variant_name : 'Tidak ada varian' }}
                                                    </div>
                                                    <div
                                                        class="text-truncate order-items-product-price-qty text-grey text-end text-md-start">
                                                        {{ $item->quantity }} x
                                                        Rp{{ price_format_rupiah($item->orderproduct->price) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4 text-end order-item-total-payment py-2">
                                    <p class="m-0">
                                        Total Pesanan
                                    </p>
                                    <p class="m-0 fw-bold text-danger">
                                        Rp{{ price_format_rupiah($order->total_price + $order->courier_price- $order->discount) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="fs-14">
                            <a href="{{ route('order.show', $order) }}" class="text-decoration-none text-danger fw-bold">Klik</a>
                            <span>disini untuk melihat detail pesanan</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
