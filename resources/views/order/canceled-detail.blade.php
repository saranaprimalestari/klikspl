@extends('user.layout')
@section('account')
    {{-- <div class="container-fluid">
        {{ Breadcrumbs::render('order.detail') }}
    </div> --}}
    <div class="container p-0">
        <div class="card mb-3 order-card fs-14">
            <div class="card-body p-4">
                <div class="row mb-3">
                    <div class="col-12">
                        <a href="{{ route('order.index') }}" class="text-decoration-none link-dark">
                            <i class="bi bi-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </div>
                {{-- {{ dd($orders) }} --}}
                @foreach ($orders as $order)
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="card fs-14 border-radius-075rem mb-4 box-shadow">
                                <div class="card-body p-4">
                                    <p class="mb-3 fs-14 fw-bold">Detail Pesanan</p>
                                    <div class="row mb-2">
                                        <div class="col-md-3 col-6">
                                            Status Pesanan
                                        </div>
                                        <div class="col-md-9 col-6">
                                            <p class="m-0">
                                                {{-- <span class="me-1">
                                                    :
                                                </span> --}}
                                                <span>
                                                    {{ ucwords($order->order_status) }}
                                                </span>
                                            </p>
                                            <p class="text-danger m-0 fs-12">
                                                {{-- <i class="bi bi-dash-lg"></i> --}}
                                                <span class="">
                                                    {{ $order->orderstatusdetail->last()->status_detail }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-3 col-6">
                                            No. Invoice
                                        </div>
                                        <div class="col-md-9 col-6">
                                            {{-- <span class="me-1">
                                                :
                                            </span> --}}
                                            <span>
                                                @if (!is_null($order->invoice_no))
                                                    {{ $order->invoice_no }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-3 col-6">
                                            Tanggal Pemesanan
                                        </div>
                                        <div class="col-md-9 col-6">
                                            {{-- <span class="me-1">
                                                :
                                            </span> --}}
                                            <span>
                                                {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('D MMMM Y, HH:mm') }}
                                            </span>
                                            <span>
                                                WIB
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-3 col-6">
                                            Detail
                                        </div>
                                        <div class="col-md-9 col-6">
                                            {{-- <span class="me-1">
                                                :
                                            </span> --}}
                                            <span class="fw-bold text-danger">
                                                <a href="#"
                                                    class="text-decoration-none text-danger expand-detail-order fs-13"
                                                    role="button" data-bs-toggle="button" aria-pressed="true">
                                                    <span class="expand-detail-order-text">
                                                        Lihat Selengkapnya
                                                    </span>
                                                    <span>
                                                        <i class="bi bi-chevron-down expand-detail-order-chevron"></i>
                                                    </span>
                                                </a>

                                            </span>
                                        </div>
                                    </div>

                                    <div class="row px-1">
                                        <div class="col-md-12 col-12 p-0 order-detail d-none my-2">
                                            @foreach ($order->orderstatusdetail->sortByDesc('created_at') as $statusDetail)
                                                <div class="d-none d-sm-flex d-flex">
                                                    <div class="p-1 flex-shrink-1">
                                                        <i class="bi bi-record-circle"></i>
                                                    </div>
                                                    <div class="p-1 flex-shrink-0">
                                                        {{ \Carbon\Carbon::parse($statusDetail->status_date)->isoFormat('D MMMM Y, HH:mm') }}
                                                        WIB
                                                    </div>
                                                    <div class="p-1 flex-shrink-1">
                                                        <i class="bi bi-dash-lg"></i>
                                                    </div>
                                                    <div class="p-1 w-100">
                                                        <span class="d-inline-block">
                                                            <div class="{{ $loop->first ? 'text-danger' : '' }} fw-500">
                                                                {{ $statusDetail->status }}
                                                            </div>
                                                            <div class="fs-12 text-grey">
                                                                {{ $statusDetail->status_detail }}
                                                            </div>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row d-block d-md-none d-flex mb-2">
                                                    <div class="col-md-1 col-1">
                                                        <i class="bi bi-record-circle"></i>
                                                    </div>
                                                    <div class="col-md-3 col-4">
                                                        <span>
                                                            {{ \Carbon\Carbon::parse($statusDetail->status_date)->isoFormat('D MMMM Y, HH:mm') }}
                                                            WIB
                                                        </span>
                                                    </div>
                                                    <div class="col-md-1 col-1">
                                                        <i class="bi bi-dash-lg"></i>
                                                    </div>
                                                    <div class="col-md-7 col-6">
                                                        <span class="d-inline-block">
                                                            <div class="{{ $loop->first ? 'text-danger' : '' }} fw-500">
                                                                {{ $statusDetail->status }}
                                                            </div>
                                                            <div class="fs-12 text-grey">
                                                                {{ $statusDetail->status_detail }}
                                                            </div>
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="card fs-14 border-radius-075rem mb-4 box-shadow">
                                <div class="card-body p-4">
                                    <p class=" fs-14 fw-bold m-0 mb-3">Detail Produk</p>
                                    <div class="row d-flex align-items-center justify-content-center text-center ">
                                        <div class="col-md-8">
                                            @foreach ($order->orderitem as $item)
                                                <div class="row my-3 align-items-center">
                                                    <div class="col-md-2 col-4 text-end">
                                                        @if (!is_null($item->orderproduct->orderproductimage->first()))
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
                                                                class="text-truncate order-items-product-variant text-grey">
                                                                Varian: {{ $item->orderproduct->variant_name }}
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
                                                Total Harga Produk
                                            </p>
                                            <p class="m-0 fw-bold text-danger">
                                                Rp{{ price_format_rupiah($order->total_price) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="card fs-14 border-radius-075rem mb-4 box-shadow">
                                <div class="card-body p-4">
                                    <p class="mb-3 fs-14 fw-bold">Informasi Pengiriman</p>
                                    <div class="row mb-2">
                                        <div class="col-md-2 col-4">
                                            Kurir
                                        </div>
                                        <div class="col-md-10 col-8">
                                            <p class="m-0">
                                                {{-- <span class="me-1">
                                                    :
                                                </span> --}}
                                                <span>
                                                    {{ ucwords($order->courier) }} -
                                                    {{ ucwords($order->courier_package_type) }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-2 col-4">
                                            No. Resi
                                        </div>
                                        <div class="col-md-10 col-8">
                                            {{-- <span class="me-1">
                                                :
                                            </span> --}}
                                            <span>
                                                {{ !is_null($order->resi) ? $order->resi : 'No. Resi belum terbit' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-2 col-4">
                                            Alamat
                                        </div>
                                        <div class="col-md-10 col-8 d-flex">
                                            {{-- <span class="me-2">
                                                :
                                            </span> --}}
                                            <span>
                                                <p class="m-0 checkout-shipment-address-name">
                                                    {{ $order->orderaddress->name }}
                                                </p>
                                                <p class="m-0 checkout-shipment-address-phone">
                                                    {{ $order->orderaddress->telp_no }}
                                                </p>
                                                <p class="m-0 checkout-shipment-address-address">
                                                    {{ $order->orderaddress->address }}
                                                </p>
                                                <div class="checkout-shipment-address-city">
                                                    <span class="m-0 me-1 ">
                                                        {{ $order->orderaddress->city->name }},
                                                    </span>
                                                    <span class="m-0 checkout-shipment-address-province">
                                                        {{ $order->orderaddress->province->name }}
                                                    </span>
                                                    <span class="m-0 checkout-shipment-address-postalcode">
                                                        {{ !empty($order->orderaddress->postal_code) ? ', ' . $order->orderaddress->postal_code : '' }}
                                                    </span>
                                                </div>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-2 col-4">
                                            Detail
                                        </div>
                                        <div class="col-md-10 col-8">
                                            {{-- <span class="me-1">
                                                :
                                            </span> --}}
                                            <span class="fw-bold text-danger">
                                                <a href="#"
                                                    class="text-decoration-none text-danger expand-detail-shipment-order fs-13"
                                                    role="button" data-bs-toggle="button" aria-pressed="true">
                                                    <span class="expand-detail-shipment-order-text">
                                                        Lihat Selengkapnya
                                                    </span>
                                                    <span>
                                                        <i
                                                            class="bi bi-chevron-down expand-detail-shipment-order-chevron"></i>
                                                    </span>
                                                </a>

                                            </span>
                                        </div>
                                    </div>

                                    <div class="row px-1">
                                        <div class="col-md-12 col-12 p-0 order-shipment-detail d-none my-2">
                                            @if ($order->orderdeliverystatus->count())
                                                @foreach ($order->orderdeliverystatus->sortByDesc('created_at') as $deliveryStatus)
                                                    <div class="d-none d-sm-flex d-flex ">
                                                        <div class="p-1 flex-shrink-1">
                                                            <i class="bi bi-record-circle"></i>
                                                        </div>
                                                        <div class="p-1 flex-shrink-0">
                                                            {{ \Carbon\Carbon::parse($deliveryStatus->delivery_date)->isoFormat('D MMMM Y, HH:mm') }}
                                                            WIB
                                                        </div>
                                                        <div class="p-1 flex-shrink-1">
                                                            <i class="bi bi-dash-lg"></i>
                                                        </div>
                                                        <div class="p-1 w-100">
                                                            <span class="d-inline-block">
                                                                <div
                                                                    class="{{ $loop->first ? 'text-danger fw-500' : 'text-grey' }}">
                                                                    {{ $deliveryStatus->delivery_status }}
                                                                </div>
                                                                <div class="fs-12 text-grey">
                                                                    {{-- {{ $deliveryStatus->status_detail }} --}}
                                                                </div>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row d-block d-md-none d-flex mb-2">
                                                        <div class="col-md-1 col-1">
                                                            <i class="bi bi-record-circle"></i>
                                                        </div>
                                                        <div class="col-md-3 col-4">
                                                            <span>
                                                                {{ \Carbon\Carbon::parse($deliveryStatus->delivery_date)->isoFormat('D MMMM Y, HH:mm') }}
                                                                WIB
                                                            </span>
                                                        </div>
                                                        <div class="col-md-1 col-1">
                                                            <i class="bi bi-dash-lg"></i>
                                                        </div>
                                                        <div class="col-md-7 col-6">
                                                            <span class="d-inline-block">
                                                                <div
                                                                    class="{{ $loop->first ? 'text-danger' : 'text-grey' }}">
                                                                    {{ $deliveryStatus->delivery_status }}
                                                                </div>
                                                                <div class="fs-12 text-grey">
                                                                    {{-- {{ $deliveryStatus->status_detail }} --}}
                                                                </div>
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-grey fs-13 m-0 px-2">Barang belum dikirimkan, menunggu
                                                    proses
                                                    verifikasi oleh tim Admin KLIKSPL</p>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="card fs-14 border-radius-075rem mb-4 box-shadow">
                                <div class="card-body p-4">
                                    <p class="mb-4 fs-14 fw-bold">Pembayaran</p>
                                    <div class="row mb-2">
                                        <div class="col-md-3 col-6">
                                            Metode Pembayaran
                                        </div>
                                        <div class="col-md-9 col-6 text-end">
                                            <p class="m-0">
                                                <span>
                                                    {{ ucwords($order->paymentmethod->type) }} -
                                                    {{ ucwords($order->paymentmethod->name) }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    @if (!is_null($order->proof_of_payment))
                                        <div class="row mb-2">
                                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingOne">
                                                        <button
                                                            class="accordion-button collapsed p-0 fs-14 shadow-none text-danger"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapseOne" aria-expanded="false"
                                                            aria-controls="flush-collapseOne">
                                                            Bukti Pembayaran
                                                        </button>
                                                    </h2>
                                                    <div id="flush-collapseOne" class="accordion-collapse collapse"
                                                        aria-labelledby="flush-headingOne"
                                                        data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body p-0 py-3">
                                                            <img src="{{ asset('/storage/' . $order->proof_of_payment) }}"
                                                                class="w-100 border-radius-5px" alt="">
                                                            <div class="d-md-flex d-grid gap-2 mt-2">
                                                                <form
                                                                    action="{{ route('order.detail.proof.of.payment') }} "
                                                                    method="post" class="me-2" target="_blank">
                                                                    @csrf
                                                                    <input type="hidden" name="proofOfPayment"
                                                                        value="{{ $order->proof_of_payment }}">
                                                                    <button type="submit"
                                                                        class="btn btn-danger fs-14 my-md-3">
                                                                        <i class="bi bi-box-arrow-up-right"></i> Buka di
                                                                        Halaman Baru
                                                                    </button>
                                                                </form>
                                                                <form
                                                                    action="{{ route('order.detail.proof.of.payment.download') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="proofOfPayment"
                                                                        value="{{ $order->proof_of_payment }}">
                                                                    <input type="hidden" name="inv_no"
                                                                        value="{{ $order->invoice_no }}">
                                                                    <button type="submit"
                                                                        class="btn btn-danger fs-14 my-md-3">
                                                                        <i class="bi bi-download"></i> Download
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-6 col-6">
                                            Total Harga ({{ $orderProducts->count() }}) Produk
                                        </div>
                                        <div class="col-md-6 col-6 text-end">
                                            Rp{{ price_format_rupiah($order->total_price) }}
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-7 checkout-payment-weight-text">
                                            Berat total: <span
                                                class="total-weight-checkout">{{ round($orderProducts->sum('weight') / 1000) }}
                                                kg</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-6">
                                            Total Ongkos Kirim
                                        </div>
                                        <div class="col-md-6 col-6 text-end">
                                            Rp{{ price_format_rupiah($order->courier_price) }}
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-6 text-grey fs-12">
                                            {{ $order->courier }} - {{ $order->courier_package_type }}
                                            maksimal {{ $order->estimation_day }} hari pengiriman
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-6">
                                            Kode Unik
                                        </div>
                                        <div class="col-md-6 col-6 text-end">
                                            Rp{{ price_format_rupiah($order->unique_code) }}
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-6 col-md-8 text-grey fs-12">
                                            Kode Unik digunakan untuk mempermudah dalam proses VERIFIKASI Pembayaran oleh
                                            Admin
                                            KLIKSPL
                                        </div>
                                    </div>

                                    <div class="my-3 border-bottom">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-7">
                                            Total Pembayaran
                                        </div>
                                        <div class="col-md-6 col-5 text-end text-danger fw-bold">
                                            Rp{{ price_format_rupiah($order->courier_price + $order->total_price + $order->unique_code) }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.expand-detail-order').click(function() {
                // console.log($('.order-detail'));
                if ($('.order-detail').hasClass("d-none")) {
                    $('.order-detail').removeClass("d-none");
                } else {
                    $('.order-detail').addClass('d-none');
                }
                if ($('.expand-detail-order-chevron').hasClass("bi-chevron-up")) {
                    $('.expand-detail-order-text').text("Lihat Selengkapnya");
                    $('.expand-detail-order-chevron').removeClass("bi-chevron-up");
                    $('.expand-detail-order-chevron').addClass("bi-chevron-down");

                    // console.log($('.expand-detail-order-chevron'));
                } else if ($('.expand-detail-order-chevron').hasClass("bi-chevron-down")) {
                    $('.expand-detail-order-text').text("Sembunyikan");
                    $('.expand-detail-order-chevron').removeClass("bi-chevron-down");
                    $('.expand-detail-order-chevron').addClass("bi-chevron-up");
                    // console.log($('.expand-detail-order-chevron'));
                }
            });
            $('.expand-detail-shipment-order').click(function() {
                console.log($('.order-shipment-detail'));
                if ($('.order-shipment-detail').hasClass("d-none")) {
                    $('.order-shipment-detail').removeClass("d-none");
                } else {
                    $('.order-shipment-detail').addClass('d-none');
                }
                if ($('.expand-detail-shipment-order-chevron').hasClass("bi-chevron-up")) {
                    // console.log($('.expand-detail-shipment-order-text').text());
                    $('.expand-detail-shipment-order-text').text("Lihat Selengkapnya");
                    $('.expand-detail-shipment-order-chevron').removeClass("bi-chevron-up");
                    $('.expand-detail-shipment-order-chevron').addClass("bi-chevron-down");

                    // console.log($('.expand-detail-shipment-order-chevron'));
                } else if ($('.expand-detail-shipment-order-chevron').hasClass("bi-chevron-down")) {
                    $('.expand-detail-shipment-order-text').text("Sembunyikan");
                    $('.expand-detail-shipment-order-chevron').removeClass("bi-chevron-down");
                    $('.expand-detail-shipment-order-chevron').addClass("bi-chevron-up");
                    // console.log($('.expand-detail-shipment-order-chevron'));
                }
            });
        });
    </script>
@endsection
