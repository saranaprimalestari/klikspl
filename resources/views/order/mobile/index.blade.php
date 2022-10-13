@extends('user.layout')
@section('account')
    <h5 class="mb-4">Semua Pesanan</h5>
    @if ($userOrders->count())
        @foreach ($userOrders as $order)
            <div class="card mb-4 profile-card box-shadow">
                <div class="card-body p-4">
                    {{-- Order ID : {{ $order->id }} --}}
                    {{-- {{ $item->orderproduct }} --}}
                    <div class="mb-2 fs-13">
                        <span class="">No Invoice:
                        </span>
                        <span class="text-grey">
                            {{ is_null($order->invoice_no) ? 'No. Inv belum terbit' : $order->invoice_no }}
                        </span>
                    </div>
                    <div class="row d-flex align-items-center justify-content-center text-center ">
                        <div class="col-md-9">
                            @foreach ($order->orderitem as $item)
                                {{-- {{ $item->id }}
                                    order item userid : 
                                    {{ $item->user_id }} --}}
                                <div class="row my-3 align-items-center">
                                    <div class="col-md-2 col-4 text-end">
                                        @if (!is_null($item->orderproduct->orderproductimage->first()))
                                            <img src="{{ asset('/storage/' . $item->orderproduct->orderproductimage->first()->name) }}"
                                                class="w-100" alt="">
                                        @endif
                                    </div>
                                    <div class="col-md-10 col-8">
                                        <div class="order-items-product-info text-start">
                                            <div class="text-truncate order-items-product-name">
                                                {{ $item->orderproduct->name }}
                                            </div>
                                            <div class="text-truncate order-items-product-variant text-grey">
                                                Varian: {{ $item->orderproduct->variant_name }}
                                            </div>
                                            <div class="text-truncate order-items-product-price-qty text-grey text-end">
                                                {{ $item->quantity }} x
                                                Rp{{ price_format_rupiah($item->orderproduct->price) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-3 text-end border-top py-2">
                            <p class="m-0">
                                Total Pesanan
                            </p>
                            <p class="m-0 fw-bold text-danger">
                                Rp{{ price_format_rupiah($order->courier_price + $order->total_price + $order->unique_code) }}
                            </p>
                        </div>
                    </div>
                    <div class="row d-flex align-items-center fs-13 border-top">
                        <div class="col-md-6 col-12 my-2">
                            <p class="m-0">
                                Status Pesanan Saya
                            </p>
                            <div>
                                <span class="m-0 text-danger">
                                    {{ $order->order_status }}
                                </span>
                                <span class="text-grey">
                                    | {{ is_null($order->resi) ? 'No Resi belum terbit' : 'No Resi: ' . $order->resi }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 text-end my-2">
                            @if ($order->order_status === 'belum bayar')
                                <a href="" class="btn btn-danger fs-13 my-1">
                                    Bayar Sekarang
                                </a>
                            @endif
                            <a href="" class="btn btn-outline-danger fs-13 my-1">
                                Hubungi Admin
                            </a>
                            {{-- <a href="" class="btn btn-outline-danger fs-14">
                                        Selengkapnya
                                    </a> --}}
                        </div>
                    </div>
                    {{-- {{ $order->orderitem }} --}}
                    {{-- {{ $order->id }}
                    {{ $order->invoice_no }}
                    {{ $order->resi }}
                    {{ $order->user_id }}
                    {{ $order->order_address_id }}
                    {{ $order->courier }}
                    {{ $order->courier_package_type }}
                    {{ $order->estimation_day }}
                    {{ $order->estimation_date }}
                    {{ $order->courier_price }}
                    {{ $order->total_price }}
                    {{ $order->order_status }}
                    {{ $order->proof_of_payment }}
                    {{ $order->payment_method_id }}
                    {{ $order->payment_due_date }} --}}
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center notification-empty">
            <img class="my-4 cart-items-logo" src="/assets/footer-logo.png" width="300" alt="">
            <p>
                Tidak ada pesanan yang dalam proses saat ini, yuk cari produk menarik dan pesan sekarang
            </p>
        </div>
    @endif
@endsection
