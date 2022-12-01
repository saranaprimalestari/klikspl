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
    <h5 class="mb-4">
        Penilaian Produk
    </h5>
    <div class="card mb-3 order-card fs-14">
        <div class="card-body p-4">
            <div class="container p-0 mb-3">
                <div class="row align-items-center">
                    <div class="col-md-3 col-4 fw-600">
                        Cari Produk Pesanan
                    </div>
                    <div class="col-md-9 col-8">
                        <div class="input-group me-3">
                            <div class="input-group fs-14">
                                <input type="text"
                                    class="form-control border-radius-075rem fs-14 shadow-none border-end-0"
                                    id="searchKeyword" placeholder="Cari nama produk, no.inv"
                                    aria-label="Cari nama produk, pembeli" aria-describedby="search-order" name="search">
                                <span class="input-group-text border-radius-075rem fs-14 bg-white border-start-0"
                                    id="search-order"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (count($orderItems) > 0)
                @foreach ($orderItems as $order)
                    <div class="card mb-4 order-card-item box-shadow ">
                        <div
                            class="card-body p-4 {{ $order->order_item_status === 'expired' ? 'btn disabled text-start' : '' }}">
                            <div class="mb-2 fs-13">
                                <span class="">No Invoice:
                                </span>
                                @if (is_null($order->order->invoice_no))
                                    Belum terbit
                                @else
                                    <span class="fw-600">
                                        {{ $order->order->invoice_no }}
                                    </span>
                                @endif
                                {{-- {{ is_null($order->invoice_no) ? 'No.Inv belum terbit' : $order->invoice_no }} --}}
                            </div>
                            {{-- {{ $order->id }} --}}
                            {{-- <a href="{{ ($order->order_status === 'expired' ? route('order.show', $order) : $order->order_status === 'Pesanan Dibatalkan') ? route('order.show', $order) : route('order.show', $order) }}"
                                class="text-dark text-decoration-none fs-14"> --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-12">
                                        {{-- @foreach ($order->orderitem as $item) --}}
                                        {{-- {{ $item->id }}
                                    order item userid : 
                                    {{ $item->user_id }} --}}
                                        <div class="row my-3 align-items-center">
                                            <div class="col-md-2 col-4 text-end">
                                                @if (!is_null($order->orderproduct->orderproductimage->first()))
                                                    {{-- {{ $order->orderproduct->orderproductimage->first()->name }} --}}
                                                    <img src="{{ asset('/storage/' . $order->orderproduct->orderproductimage->first()->name) }}"
                                                        class="w-100 border-radius-5px" alt="">
                                                @endif
                                            </div>
                                            <div class="col-md-10 col-8 ps-0">
                                                <div class="order-items-product-info text-start">
                                                    <div class="text-truncate order-items-product-name">
                                                        {{ $order->orderproduct->name }}
                                                    </div>
                                                    <div class="text-truncate order-items-product-variant text-grey fs-13">
                                                        Varian:
                                                        {{ !is_null($order->orderproduct->variant_name) ? $order->orderproduct->variant_name : 'Tidak ada Varian' }}
                                                    </div>
                                                    <div
                                                        class="text-truncate order-items-product-price-qty text-grey text-end text-md-start fs-13">
                                                        Jumlah:
                                                        {{ $order->quantity }} item
                                                        {{-- {{ $order->quantity }} x Rp{{ price_format_rupiah($order->price) }} --}}
                                                    </div>
                                                    {{-- <div
                                                            class="text-truncate order-items-product-price-qty text-grey text-end text-md-start">
                                                            {{ $order->quantity }} x
                                                            Rp{{ price_format_rupiah($order->orderproduct->price) }}
                                                        </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                        {{-- @endforeach --}}
                                    </div>
                                    {{-- <div class="col-md-3 text-end order-item-total-payment py-2">
                                        <p class="m-0">
                                            Total Harga Item
                                        </p>
                                        <p class="m-0 fw-bold text-danger">
                                            Rp{{ price_format_rupiah($order->total_price_item) }}
                                        </p>
                                    </div> --}}
                                </div>
                            {{-- </a> --}}
                           
                            <div class="row d-flex align-items-center fs-13">
                                <div class="col-md-9 col-12 my-2">
                                    Pesanan kamu sudah selesai, yuk <strong>Beri Nilai dan Ulasan</strong> produk yang kamu
                                    pesan. Penilaian kamu sangat berharga untuk perkembangan KLIKSPL
                                </div>
                                <div class="col-md-3 col-12 text-end my-2">
                                    <a href="{{ route('rating.show',$order) }}" class="btn btn-danger fs-13">
                                        <i class="bi bi-star"></i> Beri Nilai
                                    </a>
                                    {{-- <button type="button" class="btn btn-danger fs-13 confirm-order-button"
                                        id="order-{{ $order->id }}" data-bs-toggle="modal"
                                        data-bs-target="#confirmOrder">
                                        <i class="bi bi-star"></i> Beri Nilai
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="modal fade" id="confirmOrder" tabindex="-1" aria-labelledby="confirmOrderModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content border-radius-075rem">
                            <form class="confirm-order-form" action="{{ route('confirm.order') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header border-bottom-0 px-4">
                                    <h5 class="modal-title" id="confirmOrderModalLabel">Konfirmasi Pesanan Diterima</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-4">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <p class="mb-3 fs-14">
                                                Apakah anda sudah menerima pesanan anda?
                                            </p>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="card order-card-item ">
                                                <div class="card-body p-4 fs-14">
                                                    <div class="mb-2 fs-13">
                                                        <span class="">No Invoice:
                                                        </span>
                                                        <span class="fw-600 invoice-no-modal"></span>
                                                    </div>
                                                    <div
                                                        class="row d-flex align-items-center justify-content-center text-center">
                                                        <div class="col-md-9">
                                                            <div class="orderproduct-confirm-modal">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-md-3 text-end orderitem-total-payment-confirm-modal py-2">
                                                            <p class="m-0">
                                                                Total Pesanan
                                                            </p>
                                                            <p
                                                                class="m-0 fw-bold text-danger orderitem-total-payment-confirm-modal-ammount">
                                                                Rp{{ price_format_rupiah($order->total_price_item) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <p class="mt-3 fs-14 text-danger">
                                                Apabila pesanan sudah sampai dan anda terima klik tombol konfirmasi di bawah
                                                ini ya
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-top-0 px-4">
                                    <button type="button" class="btn btn-secondary fs-14"
                                        data-bs-dismiss="modal">Tutup</button>
                                    {{-- <input type="hidden" name="order_id" value="{{ $orderItems[0]->id }}"> --}}
                                    <input type="hidden" class="confirm-order-id" name="orderId" value="">
                                    <button type="submit" class="btn btn-danger shadow-none fs-14">Konfirmasi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center notification-empty">
                    <img class="my-4 cart-items-logo" src="/assets/footer-logo.png" width="300" alt="">
                    <p>
                        Tidak ada produk yang belum kamu nilai saat ini, yuk cari produk menarik dan pesan sekarang
                    </p>
                </div>
            @endif
        </div>
    </div>
    <script>
        $(window).focus(function() {
            window.location.reload();
        });
        $(document).ready(function() {
            window.orders = {!! json_encode($orderItems) !!};
            console.log(orders);

            $('#searchKeyword').on("keyup", function() {
                // $('.filter-btn').on("click", function() {
                // var search = $(this).val().toLowerCase();
                var search = $('input[name="search"]').val().toLowerCase();
                console.log(search);
                $(".order-card-item").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(search) > -1);
                    // });
                });
            });

            $('body').on('click', '.confirm-order-button', function(e) {
                $('.orderproduct-confirm-modal').empty();
                console.log(e.currentTarget.id);
                console.log('confirm order clicked');
                var targetId = e.currentTarget.id;
                var orderId = targetId.replace(/[^\d.]/g, '');
                var base_url = window.location.origin;
                console.log(orderId);
                $('input[name="orderId"]').val(orderId);
                $.each(orders, function(id, order) {
                    if (order['id'] == orderId) {
                        console.log(order['invoice_no']);
                        $('.invoice-no-modal').text(order['invoice_no']);
                        console.log(order['id']);
                        $.each(order['orderitem'], function(id, orderItem) {
                            console.log(orderItem['id']);
                            console.log(orderItem['orderproduct']);
                            console.log(orderItem['orderproduct']['orderproductimage'][0][
                                'name'
                            ]);
                            $('.orderproduct-confirm-modal').append(
                                '<div class="row my-3 align-items-center"><div class="col-md-2 col-4 text-end"><img src="' +
                                base_url + '/' + orderItem['orderproduct'][
                                    'orderproductimage'
                                ][0]['name'] +
                                '" class="w-100 border-radius-5px" alt=""></div><div class="col-md-10 col-8 ps-0"><div class="order-items-product-info text-start"><div class="text-truncate order-items-product-name">' +
                                orderItem['orderproduct']['name'] +
                                '</div><div class="text-truncate order-items-product-variant text-grey"> Varian: ' +
                                ((orderItem['orderproduct']['variant_name'] == null) ?
                                    'Tidak ada varian' : orderItem['orderproduct'][
                                        'variant_name'
                                    ]) + '</div></div></div></div>'
                            );

                            $('.orderitem-total-payment-confirm-modal-ammount').text(
                                formatRupiah((parseInt(order['courier_price']) +
                                    parseInt(order['total_price']) + parseInt(order[
                                        'unique_code'])), "Rp"));
                        });
                    }
                });
                var route = "{{ route('confirm.order', ':orderId') }}";
                route = route.replace(':orderId', orderId);
                // var route = "http://klikspl.test/administrator/promobanner/" + promoBannerId;
                console.log(route);
                console.log(base_url);
                console.log(($('input[name="promo_banner_image_' + orderId + '"]').val()));
                $('.deleted-promo-banner').text($('input[name="promo_banner_name_' + orderId + '"]').val());
                $('.deleted-promo-banner-image').attr('src', base_url + '/' + ($(
                    'input[name="promo_banner_image_' +
                    orderId + '"]').val()));
                $('.promo-banner-form-delete').attr('action', route);
                $('.promo-banner-form-delete').append(
                    '<input name="_method" type="hidden" value="DELETE">');
                $('.promo-banner-form-delete').append('<input name="merk_id" type="hidden" value="' +
                    orderId +
                    '">');
            });

        });
    </script>
@endsection
