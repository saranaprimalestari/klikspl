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
        {{ $header }}
    </h5>
    <div class="card mb-3 order-card fs-14">
        <div class="card-body p-4">
            <div class="container p-0 mb-3">
                <div class="row align-items-center">
                    <div class="col-md-2 col-4 fw-600">
                        Cari Pesanan
                    </div>
                    <div class="col-md-10 col-8">
                        <div class="input-group me-3">
                            <div class="input-group fs-14">
                                <input type="text"
                                    class="form-control border-radius-075rem fs-14 shadow-none border-end-0"
                                    id="searchKeyword" placeholder="Cari nama produk, no.inv, no.resi"
                                    aria-label="Cari nama produk, pembeli, nomor resi" aria-describedby="search-order"
                                    name="search">
                                <span class="input-group-text border-radius-075rem fs-14 bg-white border-start-0"
                                    id="search-order"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-status mb-3 d-flex overflow-auto pb-2">
                <div class="status-form">
                    <a href="{{ route('order.index') }}"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem {{ isset($status) ? ($status == '' ? 'active-menu border-danger' : '') : '' }}">
                        Semua
                    </a>
                </div>
                <form class="status-form" action="{{ route('order.index') }}" method="GET">
                    <input type="hidden" name="status" value="aktif">
                    <button type="submit"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem {{ isset($status) ? ($status == 'aktif' ? 'active-menu border-danger' : '') : '' }}">
                        Aktif
                    </button>
                </form>
                <form class="status-form" action="{{ route('order.index') }}" method="GET">
                    <input type="hidden" name="status" value="belum bayar">
                    <button type="submit"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem {{ isset($status) ? ($status == 'belum bayar' ? 'active-menu border-danger' : '') : '' }}">
                        Belum&nbsp;Bayar
                    </button>
                </form>
                <form class="status-form" action="{{ route('order.index') }}" method="GET">
                    <input type="hidden" name="status" value="pesanan dibayarkan">
                    <button type="submit"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem {{ isset($status) ? ($status == 'pesanan dibayarkan' ? 'active-menu border-danger' : '') : '' }}">
                        Verifikasi&nbsp;Pembayaran
                    </button>
                </form>
                <form class="status-form" action="{{ route('order.index') }}" method="GET">
                    <input type="hidden" name="status" value="pembayaran dikonfirmasi">
                    <button type="submit"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem {{ isset($status) ? ($status == 'pembayaran dikonfirmasi' ? 'active-menu border-danger' : '') : '' }}">
                        Pembayaran&nbsp;Dikonfirmasi
                    </button>
                </form>
                <form class="status-form" action="{{ route('order.index') }}" method="GET">
                    <input type="hidden" name="status" value="pesanan disiapkan">
                    <button type="submit"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem {{ isset($status) ? ($status == 'pesanan disiapkan' ? 'active-menu border-danger' : '') : '' }}">
                        Dikemas
                    </button>
                </form>
                <form class="status-form" action="{{ route('order.index') }}" method="GET">
                    <input type="hidden" name="status" value="pesanan dikirim">
                    <button type="submit"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem {{ isset($status) ? ($status == 'pesanan dikirim' ? 'active-menu border-danger' : '') : '' }}">
                        Dikirim
                    </button>
                </form>
                <form class="status-form" action="{{ route('order.index') }}" method="GET">
                    <input type="hidden" name="status" value="selesai">
                    <button type="submit"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem {{ isset($status) ? ($status == 'selesai' ? 'active-menu border-danger' : '') : '' }}">
                        Selesai
                    </button>
                </form>
                <form class="status-form" action="{{ route('order.index') }}" method="GET">
                    <input type="hidden" name="status" value="expired">
                    <button type="submit"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem {{ isset($status) ? ($status == 'expired' ? 'active-menu border-danger' : '') : '' }}">
                        Dibatalkan
                    </button>
                </form>
                {{-- <form class="status-form" action="{{ route('order.index') }}" method="GET">
                    <input type="hidden" name="status" value="expired">
                    <button type="submit"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem {{ isset($status) ? ($status == 'expired' ? 'active-menu border-danger' : '') : '' }}">
                        Kedaluwarsa
                    </button>
                </form> --}}
            </div>
            @if (count($orders) > 0)
                @foreach ($orders as $order)
                    <div class="card mb-4 order-card-item box-shadow ">
                        <div
                            class="card-body p-4 {{ $order->order_status === 'expired' ? 'btn disabled text-start' : '' }}">
                            <div class="mb-2 fs-13">
                                <span class="">No Invoice:
                                </span>
                                @if (is_null($order->invoice_no))
                                    Belum terbit
                                @else
                                    <span class="fw-600">
                                        {{ $order->invoice_no }}
                                    </span>
                                @endif
                                {{-- {{ is_null($order->invoice_no) ? 'No.Inv belum terbit' : $order->invoice_no }} --}}
                            </div>
                            {{-- {{ $order->id }} --}}
                            <a href="{{ ($order->order_status === 'expired' ? route('order.show', $order) : $order->order_status === 'Pesanan Dibatalkan') ? route('order.show', $order) : route('order.show', $order) }}"
                                class="text-dark text-decoration-none fs-14">
                                <div class="row d-flex align-items-center justify-content-center text-center">
                                    <div class="col-md-9">
                                        @foreach ($order->orderitem as $item)
                                            {{-- {{ $item->id }}
                                    order item userid : 
                                    {{ $item->user_id }} --}}
                                            <div class="row my-3 align-items-center">
                                                <div class="col-md-2 col-4 text-end">
                                                    @if (!is_null($item->orderproduct->orderproductimage->first()))
                                                        {{-- {{ $item->orderproduct->orderproductimage->first()->name }} --}}
                                                        <img src="{{ asset('/storage/' . $item->orderproduct->orderproductimage->first()->name) }}"
                                                            class="w-100 border-radius-5px" alt="">
                                                    @endif
                                                </div>
                                                <div class="col-md-10 col-8 ps-0">
                                                    <div class="order-items-product-info text-start">
                                                        <div class="text-truncate order-items-product-name">
                                                            {{ $item->orderproduct->name }}
                                                        </div>
                                                        <div
                                                            class="text-truncate order-items-product-variant text-grey fs-13">
                                                            Varian:
                                                            {{ !is_null($item->orderproduct->variant_name) ? $item->orderproduct->variant_name : 'Tidak ada Varian' }}
                                                        </div>
                                                        <div
                                                            class="text-truncate order-items-product-price-qty text-grey text-md-start fs-13">
                                                            Jumlah:
                                                            {{ $item->quantity }} item
                                                        </div>
                                                        {{-- <div
                                                            class="text-truncate order-items-product-price-qty text-grey text-end text-md-start">
                                                            {{ $item->quantity }} x
                                                            Rp{{ price_format_rupiah($item->orderproduct->price) }}
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-3 text-end order-item-total-payment py-2">
                                        <p class="m-0">
                                            Total Pesanan
                                        </p>
                                        <p class="m-0 fw-bold text-danger">
                                            Rp{{ price_format_rupiah($order->courier_price + $order->total_price + $order->unique_code- $order->discount) }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div class="row d-flex align-items-center fs-13">
                                <div class="col-md-7 col-12 my-2">
                                    <p class="m-0">
                                        Status Pesanan:
                                    </p>
                                    <div>
                                        @if ($order->order_status === 'expired')
                                            <span class="badge bg-secondary">
                                                Pesanan Kedaluwarsa
                                            </span>
                                            {{-- , akan dihapus otomatis dalam 24 jam --}}
                                        @elseif ($order->order_status === 'pesanan dibatalkan')
                                            <span class="badge bg-secondary">
                                                Pesanan Dibatalkan
                                            </span>
                                            <div class="mt-1">
                                                <span class="m-0">
                                                    {{-- <span>
                                                        {{ ucfirst($order->order_status) }},
                                                    </span> --}}
                                                    <span>
                                                        {{-- {{ dd(empty($order->orderstatusdetail)) }} --}}
                                                        @if (count($order->orderstatusdetail) > 0)
                                                            {{-- @foreach ($order->orderstatusdetail as $statusDetail)
                                                            {{ $statusDetail->status_detail }}
                                                        @endforeach --}}
                                                            {{ ucfirst($order->orderstatusdetail->last()->status_detail) }}
                                                        @endif

                                                    </span>
                                                </span>
                                            </div>
                                        @elseif($order->order_status === 'belum bayar' || $order->order_status === 'pembayaran ditolak' || $order->order_status === 'pengajuan pembatalan')
                                            <div>
                                                <span class="badge bg-danger">
                                                    {{ ucfirst($order->order_status) }}
                                                </span>
                                            </div>
                                            <div class="mt-1">
                                                <span class="m-0 text-danger">
                                                    {{-- <span>
                                                        {{ ucfirst($order->order_status) }},
                                                    </span> --}}
                                                    <span>
                                                        {{-- @foreach ($order->orderstatusdetail as $statusDetail)
                                                            {{ $statusDetail->status_detail }}
                                                        @endforeach --}}
                                                        @if (count($order->orderstatusdetail) >0)
                                                            
                                                        {{ ucfirst($order->orderstatusdetail->last()->status_detail) }}
                                                        @endif
                                                    </span>
                                                </span>
                                            </div>
                                        @else
                                            <div>
                                                <span class="badge bg-success">
                                                    {{ ucfirst($order->order_status) }}
                                                </span>
                                            </div>
                                            <div class="mt-1">
                                                <span class="m-0">
                                                    {{-- <span>
                                                        {{ ucfirst($order->order_status) }},
                                                    </span> --}}
                                                    <span>
                                                        {{-- @foreach ($order->orderstatusdetail as $statusDetail)
                                                            {{ $statusDetail->status_detail }}
                                                        @endforeach --}}
                                                        {{ ucfirst($order->orderstatusdetail->last()->status_detail) }}
                                                    </span>
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-5 col-12 text-end my-2">
                                    @if ($order->order_status === 'belum bayar')
                                        <a href="{{ route('order.show', $order) }}"
                                            class="btn btn-danger fs-13 my-1 mx-1">
                                            Bayar Sekarang
                                        </a>
                                    @elseif($order->order_status === 'expired')
                                        <a href="#" class="btn btn-secondary fs-13 my-1 mx-1 disabled">
                                            Kedaluwarsa
                                        </a>
                                    @else
                                        <a href="{{ route('order.show', $order) }}"
                                            class="text-danger fs-13 my-1 mx-1 me-2 text-decoration-none fw-bold d-none d-sm-block">
                                            Detail Pesanan
                                        </a>
                                    @endif
                                    {{-- <a href="#" class="btn btn-outline-secondary fs-13 my-1">
                                        Hubungi Admin
                                    </a> --}}
                                </div>
                            </div>
                            @if ($order->order_status == 'pesanan dikirim' &&
                                $order->orderstatusdetail->last()->status == 'Nomor resi telah terbit')
                                <div class="row d-flex align-items-center fs-13">
                                    <div class="col-md-9 col-12 my-2 d-none d-sm-block">
                                        Tekan tombol <strong>PESANAN DITERIMA</strong> jika pesanan sudah sampai dan anda
                                        terima
                                    </div>
                                    <div class="col-md-3 col-12 text-end my-2">
                                        <button type="button" class="btn btn-danger fs-13 confirm-order-button"
                                            id="order-{{ $order->id }}" data-bs-toggle="modal"
                                            data-bs-target="#confirmOrder">Pesanan Diterima</button>
                                    </div>
                                </div>
                            @elseif ($order->order_status == 'selesai')
                                @php
                                    $itemNotReviewed = 0;
                                @endphp
                                @foreach ($order->orderitem as $item)
                                    @if ($item->is_review != 1)
                                        @php
                                            $itemNotReviewed += 1;
                                        @endphp
                                    @endif
                                @endforeach
                                @if ($itemNotReviewed > 0)
                                    <div class="row d-flex align-items-center fs-13">
                                        <div class="col-md-9 col-12 my-2 d-none d-sm-block">
                                            Pesanan kamu sudah selesai, yuk <strong>Beri Nilai dan Ulasan</strong> produk
                                            yang
                                            kamu pesan. Penilaian kamu sangat berharga untuk perkembangan KLIKSPL
                                        </div>
                                        <div class="col-md-3 col-12 text-end my-2">
                                            <a href="{{ route('order.show', $order) }}"
                                                class="btn btn-danger fs-13 confirm-order-button"
                                                id="order-{{ $order->id }}">
                                                <i class="bi bi-star"></i> Beri Nilai
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
                <div class="modal fade" id="confirmOrder" tabindex="-1" aria-labelledby="confirmOrderModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content border-radius-075rem">

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
                                                            Rp{{ price_format_rupiah($order->courier_price + $order->total_price + $order->unique_code - $order->discount) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <p class="mt-3 fs-14 text-danger">
                                            Apabila pesanan sudah sampai dan anda terima klik tombol konfirmasi di bawah ini
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 px-4">
                                <form class="confirm-order-form" action="{{ route('confirm.order') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <button type="button" class="btn btn-secondary fs-14"
                                        data-bs-dismiss="modal">Tutup</button>
                                    {{-- <input type="hidden" name="order_id" value="{{ $orders[0]->id }}"> --}}
                                    <input type="hidden" class="confirm-order-id" name="orderId" value="">
                                    <button type="submit" class="btn btn-danger shadow-none fs-14">Konfirmasi</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center notification-empty">
                    <img class="my-4 cart-items-logo" src="/assets/footer-logo.png" width="300" alt="">
                    <p>
                        Tidak ada pesanan pada proses ini, yuk cari produk menarik dan pesan sekarang
                    </p>
                </div>
            @endif
        </div>
    </div>
    <script>
        // $(window).focus(function() {
        //     window.location.reload();
        // });
        $(document).ready(function() {
            window.orders = {!! json_encode($orders) !!};
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
                                        'unique_code']) - parseInt(order[
                                        'discount'])), "Rp"));
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
