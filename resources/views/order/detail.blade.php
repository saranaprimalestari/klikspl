@extends('user.layout')
@section('account')
    {{-- <div class="container-fluid">
        {{ Breadcrumbs::render('order.detail') }}
    </div> --}}
    <div class="container p-0">
        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('order.index') }}" class="text-decoration-none link-dark">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
            </div>
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
        <div class="card mb-3 order-card fs-14">
            <div class="card-body p-4">
                @foreach ($orders as $order)
                    {{-- {{ dd($order->orderitem->count()) }} --}}
                    <div class="row">
                        @if ($order->order_status == 'selesai')
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
                                <div class="col-md-12 col-12">
                                    <div class="card fs-14 border-radius-075rem mb-4 box-shadow">
                                        <div class="card-body p-4">
                                            <p class=" fs-14 fw-bold m-0 mb-3">Beri Nilai Produk</p>
                                            <div class="row d-flex align-items-center justify-content-center text-center ">
                                                <div class="col-md-12">
                                                    @foreach ($order->orderitem as $item)
                                                        @if ($item->is_review == 0)
                                                            <div class="row my-3 align-items-center">
                                                                <div class="col-md-2 col-4 text-end">
                                                                    @if (!is_null($item->orderproduct->orderproductimage->first()))
                                                                        <img src="{{ asset('/storage/' . $item->orderproduct->orderproductimage->first()->name) }}"
                                                                            class="w-100 border-radius-5px" alt="">
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-8 col-8 ps-0">
                                                                    <div class="order-items-product-info text-start">
                                                                        <div class="text-truncate order-items-product-name">
                                                                            {{ $item->orderproduct->name }}
                                                                        </div>
                                                                        <div
                                                                            class="text-truncate order-items-product-variant text-grey">
                                                                            Varian:
                                                                            {{ !is_null($item->orderproduct->variant_name) ? $item->orderproduct->variant_name : 'Tidak ada Varian' }}
                                                                        </div>
                                                                        <div
                                                                            class="text-truncate order-items-product-variant text-grey">
                                                                            Berat: {{ $item->orderproduct->weight }}gr
                                                                        </div>
                                                                        <div
                                                                            class="text-truncate order-items-product-price-qty text-grey text-end text-md-start">
                                                                            {{ $item->quantity }} x
                                                                            Rp{{ price_format_rupiah($item->orderproduct->price) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 col-12 ps-0 text-end">
                                                                    <a href="{{ route('rating.show', $item) }}"
                                                                        class="btn btn-danger fs-13">
                                                                        <i class="bi bi-star"></i> Beri Nilai
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        @if (!empty($outStock))
                            <div class="col-md-12 col-12">
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ $orders[0]->orderStatusDetail->last()->status_detail }}
                                </div>
                            </div>
                        @endif

                        @if (count($order->refund) > 0)
                            @if ($order->order_status == 'pengajuan pengembalian dana' || $order->order_status == 'pesanan dibatalkan')
                                @foreach ($order->refund as $refund)
                                    <div class="col-md-12 col-12">
                                        <div class="card fs-14 border-radius-075rem mb-4 box-shadow">
                                            <div class="card-body p-4">
                                                <p class=" fs-14 fw-bold m-0 mb-3">Detail
                                                    {{ $order->order_status == 'pengajuan pengembalian dana' ? 'Pengajuan' : '' }}
                                                    Pengembalian Dana</p>
                                                <div class="row mb-2">
                                                    <div class="col-md-3 col-6">
                                                        Nama Lengkap
                                                    </div>
                                                    <div class="col-md-9 col-6">
                                                        {{ $refund->name }}
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-3 col-6">
                                                        Bank
                                                    </div>
                                                    <div class="col-md-9 col-6">
                                                        {{ $refund->bank_name }}
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-3 col-6">
                                                        Nomor Rekening
                                                    </div>
                                                    <div class="col-md-9 col-6">
                                                        {{ $refund->account_number }}
                                                    </div>
                                                </div>
                                                @if (!is_null($refund->email))
                                                    <div class="row mb-2">
                                                        <div class="col-md-3 col-6">
                                                            Email
                                                        </div>
                                                        <div class="col-md-9 col-6">
                                                            {{ $refund->email }}
                                                        </div>
                                                    </div>
                                                @endif
                                                @if (!is_null($refund->telp_no))
                                                    <div class="row mb-2">
                                                        <div class="col-md-3 col-6">
                                                            No Telepon
                                                        </div>
                                                        <div class="col-md-9 col-6">
                                                            {{ $refund->telp_no }}
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($order->order_status == 'pesanan dibatalkan' && !is_null($refund->proof_of_payment))
                                                    <div class="row mb-2">
                                                        <div class="col-md-3 col-6">
                                                            Bukti Transfer
                                                        </div>
                                                        <div class="col-md-9 col-12">
                                                            <div class="accordion accordion-flush"
                                                                id="accordionProofOfRefund">
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header"
                                                                        id="flush-proof-of-refund-heading">
                                                                        <button
                                                                            class="accordion-button collapsed p-0 fs-14 shadow-none text-danger"
                                                                            type="button" data-bs-toggle="collapse"
                                                                            data-bs-target="#flush-proof-of-refund"
                                                                            aria-expanded="false"
                                                                            aria-controls="flush-proof-of-refund">
                                                                            Lihat Selengkapnya
                                                                        </button>
                                                                    </h2>
                                                                    <div id="flush-proof-of-refund"
                                                                        class="accordion-collapse collapse"
                                                                        aria-labelledby="flush-proof-of-refund-heading"
                                                                        data-bs-parent="#accordionProofOfRefund">
                                                                        <div class="accordion-body p-0 py-3">
                                                                            <img src="{{ asset('/storage/' . $refund->proof_of_payment) }}"
                                                                                class="w-100 border-radius-5px"
                                                                                alt="">
                                                                            <div class="d-md-flex d-grid gap-2 mt-2">
                                                                                <form
                                                                                    action="{{ route('order.detail.proof.of.payment') }} "
                                                                                    method="post" class="me-md-2"
                                                                                    target="_blank">
                                                                                    @csrf
                                                                                    <input type="hidden"
                                                                                        name="proofOfPayment"
                                                                                        value="{{ $refund->proof_of_payment }}">
                                                                                    <div class="d-grid">
                                                                                        <button type="submit"
                                                                                            class="btn btn-danger fs-14 my-md-3">
                                                                                            <i
                                                                                                class="bi bi-box-arrow-up-right"></i>
                                                                                            Buka
                                                                                            di
                                                                                            Halaman Baru
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                                <form
                                                                                    action="{{ route('order.detail.proof.of.payment.download') }}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    <input type="hidden"
                                                                                        name="proofOfPayment"
                                                                                        value="{{ $refund->proof_of_payment }}">
                                                                                    <input type="hidden" name="inv_no"
                                                                                        value="bukti-pengembalian-dana-{{ $order->invoice_no }}">
                                                                                    <div class="d-grid">
                                                                                        <button type="submit"
                                                                                            class="btn btn-danger fs-14 my-md-3">
                                                                                            <i class="bi bi-download"></i>
                                                                                            Download
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            @endif
                        @endif
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
                                                    @if (!is_null($order->invoice_no))
                                                        <a href="#" class="pe-auto text-dark"
                                                            onclick="Copy('{{ $order->invoice_no }}')"><i
                                                                class="far fa-copy" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" title="Salin no. invoice"></i>
                                                        </a>
                                                    @endif
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

                                    <div class="row px-2">
                                        <div class="col-md-12 col-12 p-0 order-detail d-none">
                                            @foreach ($order->orderstatusdetail->sortByDesc('created_at') as $statusDetail)
                                                <div class="d-none d-sm-flex d-flex">
                                                    <div class="p-1 flex-shrink-1">
                                                        <i class="bi bi-record-circle"></i>
                                                    </div>
                                                    <div class="p-1 flex-shrink-0">
                                                        {{ \Carbon\Carbon::parse($statusDetail->status_date)->isoFormat('D MMM Y, HH:mm') }}
                                                        WIB
                                                    </div>
                                                    <div class="p-1 flex-shrink-1">
                                                        <i class="bi bi-dash-lg"></i>
                                                    </div>
                                                    <div class="p-1 w-100">
                                                        <span class="d-inline-block">
                                                            <div class="{{ $loop->first ? 'text-danger' : '' }} fw-500">
                                                                {{ ucfirst($statusDetail->status) }}
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
                                                            {{ \Carbon\Carbon::parse($statusDetail->status_date)->isoFormat('D MMM Y, HH:mm') }}
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
                                    @if ($order->order_status == 'pembayaran ditolak')
                                        <div class="row mb-2 mt-4">
                                            <div class="col-md-12 col-12">
                                                <p class="mb-1 fs-14 fw-bold">Upload Ulang Bukti Pembayaran</p>
                                                <p class="fs-12 m-0">
                                                    bukti pembayaran yang anda upload ditolak oleh Admin KLIKSPL,
                                                    silakan
                                                    upload bukti pembayran yang lebih valid
                                                </p>

                                            </div>
                                            <div class="col-md-12 col-12 text-end">
                                                <button type="button" class="btn btn-danger fs-14 my-2 shadow-none"
                                                    data-bs-toggle="modal" data-bs-target="#paymentConfirm">Upload
                                                    Bukti
                                                    Pembayaran</button>
                                            </div>
                                        </div>
                                    @elseif ($order->order_status == 'pesanan dikirim' &&
                                        ($order->orderstatusdetail->last()->status == 'Nomor resi telah terbit' ||
                                            $order->orderstatusdetail->last()->status == 'Nomor resi diperbarui admin'))
                                        <div class="row mb-2 mt-4">
                                            <div class="col-md-12 col-12">
                                                <p class="mb-1 fs-14 fw-bold">Pesanan Diterima</p>
                                                <p class="fs-12 m-0">
                                                    Tekan tombol <strong>PESANAN DITERIMA</strong> jika pesanan sudah
                                                    sampai
                                                    dan anda terima
                                                </p>
                                            </div>
                                            <div class="col-md-12 col-12 text-end">
                                                <button type="button" class="btn btn-danger fs-14 my-2 shadow-none"
                                                    data-bs-toggle="modal" data-bs-target="#confirmOrder">Pesanan
                                                    Diterima</button>
                                            </div>
                                        </div>
                                    @elseif ($order->order_status == 'pengajuan pembatalan dikonfirmasi' ||
                                        $order->order_status == 'pengajuan pengembalian dana ditolak')
                                        <div class="row mb-2 mt-4">
                                            <div class="col-md-12 col-12">
                                                <p class="mb-1 fs-14 fw-bold">{{ ucWords($order->order_status) }}</p>
                                                <p class="fs-12 m-0">
                                                    Tekan tombol <strong>Isi Form Pengembalian Dana</strong> di bawah ini
                                                    untuk melanjutkan ke proses pengembalian dana pesanan anda
                                                </p>
                                            </div>
                                            <div class="col-md-12 col-12 text-end">
                                                <button type="button" class="btn btn-danger fs-14 my-2 shadow-none"
                                                    data-bs-toggle="modal" data-bs-target="#orderRefund">Isi Form
                                                    Pengembalian Dana</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-12 col-12">
                            <div class="card fs-14 border-radius-075rem mb-4 box-shadow">
                                <div class="card-body p-4">
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-md-12 col-12">
                            <div class="card fs-14 border-radius-075rem mb-4 box-shadow">
                                <div class="card-body p-4">
                                    <p class=" fs-14 fw-bold m-0 mb-3">Detail Produk</p>
                                    <div class="row d-flex align-items-center justify-content-center text-center ">
                                        <div class="col-md-8">
                                            @foreach ($order->orderitem as $item)
                                                <a href="{{ route('order.detail.product', ['id' => Crypt::encrypt($order->id), 'orderItem' => $item->id]) }}"
                                                    class="text-decoration-none text-dark">
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
                                                                    Varian:
                                                                    {{ !is_null($item->orderproduct->variant_name) ? $item->orderproduct->variant_name : 'Tidak ada Varian' }}
                                                                </div>
                                                                <div
                                                                    class="text-truncate order-items-product-variant text-grey">
                                                                    Berat: {{ $item->orderproduct->weight }}g
                                                                </div>
                                                                <div
                                                                    class="text-truncate order-items-product-price-qty text-grey text-end text-md-start">
                                                                    {{ $item->quantity }} x
                                                                    Rp{{ price_format_rupiah($item->orderproduct->price) }}
                                                                </div>
                                                                @if ($item->order_item_status == 'stok habis')
                                                                    <div
                                                                        class="text-truncate order-items-product-variant text-danger fw-600 text-uppercase">
                                                                        {{ $item->order_item_status }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
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
                                            <span>
                                                @if (!is_null($order->resi))
                                                    <a href="#" class="pe-auto text-dark"
                                                        onclick="Copy('{{ $order->resi }}')"><i class="far fa-copy"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Salin no. resi"></i>
                                                    </a>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-2 col-4">
                                            Dikirim dari
                                        </div>
                                        <div class="col-md-10 col-8 d-flex">
                                            {{-- <span class="me-2">
                                                :
                                            </span> --}}
                                            <span>
                                                <p class="m-0 checkout-shipment-address-name">
                                                    {{ $order->senderAddress->name }}
                                                </p>
                                                <p class="m-0 checkout-shipment-address-phone">
                                                    {{ $order->senderAddress->telp_no }}
                                                </p>
                                                <p class="m-0 checkout-shipment-address-address">
                                                    {{ $order->senderAddress->address }}
                                                </p>
                                                <div class="checkout-shipment-address-city">
                                                    <span class="m-0 me-1 ">
                                                        {{ $order->senderAddress->city->name }},
                                                    </span>
                                                    <span class="m-0 checkout-shipment-address-province">
                                                        {{ $order->senderAddress->province->name }}
                                                    </span>
                                                    <span class="m-0 checkout-shipment-address-postalcode">
                                                        {{ !empty($order->senderAddress->postal_code) ? ', ' . $order->senderAddress->postal_code : '' }}
                                                    </span>
                                                </div>
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
                                    @if ($order->order_status != 'pesanan dibatalkan')
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
                                    @endif

                                    <div class="row px-2">
                                        <div class="col-md-12 col-12 p-0 order-shipment-detail d-none">
                                            @if ($order->orderdeliverystatus->count())
                                                @foreach ($order->orderdeliverystatus->sortByDesc('created_at') as $deliveryStatus)
                                                    <div class="d-none d-sm-flex d-flex ">
                                                        <div class="p-1 flex-shrink-1">
                                                            <i class="bi bi-record-circle"></i>
                                                        </div>
                                                        <div class="p-1 flex-shrink-0">
                                                            {{ \Carbon\Carbon::parse($deliveryStatus->delivery_date)->isoFormat('D MMM Y, HH:mm') }}
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
                                                                    {{ $deliveryStatus->delivery_status_detail }}
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
                                                                {{ \Carbon\Carbon::parse($deliveryStatus->delivery_date)->isoFormat('D MMM Y, HH:mm') }}
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
                                                                    {{ $deliveryStatus->delivery_status_detail }}
                                                                </div>
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-grey fs-13 m-0 px-2">Pesanan belum dikirimkan, menunggu
                                                    proses oleh tim Admin KLIKSPL</p>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="card fs-14 border-radius-075rem mb-4 box-shadow">
                                <div class="card-body p-4">
                                    <p class="mb-3 fs-14 fw-bold">Pembayaran</p>
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
                                            <div class="accordion accordion-flush" id="accordionFlushProofOfPayment">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingOne">
                                                        <button
                                                            class="accordion-button collapsed p-0 fs-14 shadow-none text-danger"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#flush-proof-of-payment" aria-expanded="false"
                                                            aria-controls="flush-proof-of-payment">
                                                            Bukti Pembayaran
                                                        </button>
                                                    </h2>
                                                    <div id="flush-proof-of-payment" class="accordion-collapse collapse"
                                                        aria-labelledby="flush-headingOne"
                                                        data-bs-parent="#accordionFlushProofOfPayment">
                                                        <div class="accordion-body p-0 py-3">
                                                            <img src="{{ asset('/storage/' . $order->proof_of_payment) }}"
                                                                class="w-100 border-radius-5px" alt="">
                                                            <div class="d-md-flex d-grid gap-2 mt-2">
                                                                <form
                                                                    action="{{ route('order.detail.proof.of.payment') }} "
                                                                    method="post" class="me-md-2" target="_blank">
                                                                    @csrf
                                                                    <input type="hidden" name="proofOfPayment"
                                                                        value="{{ $order->proof_of_payment }}">
                                                                    <div class="d-grid">
                                                                        <button type="submit"
                                                                            class="btn btn-danger fs-14 my-md-3">
                                                                            <i class="bi bi-box-arrow-up-right"></i> Buka
                                                                            di
                                                                            Halaman Baru
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                                <form
                                                                    action="{{ route('order.detail.proof.of.payment.download') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="proofOfPayment"
                                                                        value="{{ $order->proof_of_payment }}">
                                                                    <input type="hidden" name="inv_no"
                                                                        value="{{ $order->invoice_no }}">
                                                                    <div class="d-grid">
                                                                        <button type="submit"
                                                                            class="btn btn-danger fs-14 my-md-3">
                                                                            <i class="bi bi-download"></i> Download
                                                                        </button>
                                                                    </div>
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
                                            Berat total:
                                            <span class="total-weight-checkout">
                                                {{ $weight }}kg
                                            </span>
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
                                            Kode Unik digunakan untuk mempermudah dalam proses VERIFIKASI Pembayaran
                                            oleh
                                            Admin
                                            KLIKSPL
                                        </div>
                                    </div>

                                    @if (!empty($order->discount))
                                        <div class="row">
                                            <div class="col-md-6 col-6">
                                                Diskon Promo
                                            </div>
                                            <div class="col-md-6 col-6 text-end">
                                                - Rp{{ price_format_rupiah($order->discount) }}
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-9 text-grey fs-12">
                                                {{ $order->UserPromoOrderUse->first()->promo_name }}
                                                ({{ $order->UserPromoOrderUse->first()->promo_type }})
                                            </div>
                                        </div>
                                    @endif

                                    <div class="my-3 border-bottom">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-7">
                                            Total Pembayaran
                                        </div>
                                        <div class="col-md-6 col-5 text-end text-danger fw-bold">
                                            Rp{{ price_format_rupiah($order->courier_price + $order->total_price + $order->unique_code - $order->discount) }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @if ($order->order_status == 'pesanan dibuat' ||
                            $order->order_status == 'pesanan dibayarkan' ||
                            $order->order_status == 'pembayaran dikonfirmasi' ||
                            $order->order_status == 'pesanan disiapkan')
                            <div class="modal fade" id="orderCancellationRequest" tabindex="-1"
                                aria-labelledby="orderCancellationRequestModal" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-radius-075rem">
                                        <div class="modal-header border-0 pt-4 px-4">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('order.cancellation.request', $order) }}" method="post"
                                            class="d-inline">
                                            {{-- @method('delete') --}}
                                            @csrf
                                            <div class="modal-body text-center py-2 px-5">
                                                <h5 class="mb-3">Konfirmasi Pembatalan Pesanan</h5>
                                                <p class="fs-14 mb-0">
                                                    Apakah anda yakin ingin membatalkan pesanan ini? Pesanan yang dibatalkan
                                                    akan
                                                    dihapus dari daftar pesananmu. Mohon tuliskan alasan mengapa anda
                                                    membatalkan
                                                    pesananmu.
                                                </p>
                                                <div class="form-floating my-3">
                                                    <textarea class="form-control fs-14" placeholder="Tuliskan alasan pembatalan pesanan" id="cancel-order"
                                                        style="height: 100px" required name="order_cancellation_request"></textarea>
                                                    <label for="cancel-order" class="fs-14">Alasan Pembatalan
                                                        Pesanan
                                                    </label>
                                                    <div
                                                        class="cancel_order_error_message fs-12 text-danger text-start my-1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 d-flex justify-content-center">
                                                <button type="button" class="btn btn-outline-secondary fs-14"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit"
                                                    class="btn btn-danger fs-14 my-2 shadow-none">Batalkan
                                                    Pesanan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="card fs-14 border-radius-075rem mb-4 box-shadow">
                                    <div class="card-body p-4">
                                        <p class="mb-3 fs-14 fw-bold">Ajukan Pembatalan</p>
                                        <div class="row mb-2">
                                            <div class="col-md-12 col-12">
                                                Ajukan pembatalan untuk pesanan ini dengan menyertakan alasan
                                                pembatalan,
                                                Tim
                                                Admin kami akan secepat mungkin merespon anda
                                            </div>
                                        </div>
                                        <div class="row mb-2 text-end">
                                            <div class="col-md-12 col-12">
                                                <button type="button"
                                                    class="btn btn-outline-secondary fs-14 my-2 shadow-none"
                                                    data-bs-toggle="modal" data-bs-target="#orderCancellationRequest">
                                                    Batalkan Pesanan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="modal fade" id="paymentConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        tabindex="-1" aria-labelledby="paymentConfirm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-radius-075rem">
                <form class="payment-form" action="{{ route('payment.reupload') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title" id="paymentConfirm">Konfirmasi Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <label for="inputProofOfPayment" class="form-label fs-14">
                                    Upload Bukti Pembayaran
                                </label>
                                <input type="file" class="form-control fs-14" id="inputProofOfPayment"
                                    name="proof_of_payment" onchange="previewImagePayment()" required>
                                <small class="text-grey fs-12">
                                    *Bukti pembayaran berguna untuk proses verifikasi oleh Tim Admin KLIKSPL
                                </small>
                            </div>
                            <div class="col-md-12 col-12">
                                <img class="img-preview w-100">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-secondary fs-14" data-bs-dismiss="modal">Tutup</button>
                        <input type="hidden" name="order_id" value="{{ $orders[0]->id }}">
                        <button type="submit" class="btn btn-danger shadow-none fs-14">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmOrder" tabindex="-1" aria-labelledby="confirmOrderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-radius-075rem">
                <form class="confirm-order-form" action="{{ route('confirm.order') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-bottom-0 px-4">
                        <h5 class="modal-title" id="confirmOrderModalLabel">Konfirmasi Pesanan Diterima</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4">
                        <div class="row">
                            <div class="col-md-12 col-12 text-center">
                                <p class="mb-2 fs-14">
                                    <span>
                                        Apakah pesanan dengan No. Invoice
                                    </span>
                                    <strong>
                                        {{ $orders[0]->invoice_no }}
                                    </strong>
                                    <span>
                                        sudah sampai dan anda terima?
                                    </span>
                                </p>
                                <p class="mb-0 fs-14 text-danger">
                                    Klik tombol konfirmasi di bawah ini apabila pesanan sudah sampai dan anda terima!
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 px-4 pb-4 justify-content-center">
                        <button type="button" class="btn btn-secondary fs-14" data-bs-dismiss="modal">Tutup</button>
                        <input type="hidden" class="confirm-order-id" name="orderId" value="{{ $orders[0]->id }}">
                        <button type="submit" class="btn btn-danger shadow-none fs-14">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="orderRefund" tabindex="-1" aria-labelledby="orderRefundModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-radius-075rem">
                <div class="modal-header border-bottom-0 px-4">
                    <h5 class="modal-title" id="orderRefundModalLabel">Form Pengembalian Dana</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="row fs-14">
                        <div class="col-md-12 col-12">
                            <p class="mb-2 fs-14">
                                Isi form pengembalian dana di bawah ini untuk mengembalikan dana pembayaran pesanan
                                anda.
                            </p>
                        </div>
                        <div class="col-md-12 order-2">
                            <form class="refund-order-payment-form" action="{{ route('refundorderpayments.store') }}"
                                method="POST">
                                @csrf
                                <div class="row mb-3 align-items-center">
                                    <label for="name" class="col-sm-2 col-md-3 col-form-label">
                                        <div>
                                            <span>
                                                Nama Lengkap
                                            </span>
                                            <span class="text-danger">
                                                *
                                            </span>
                                        </div>
                                        <p class="text-grey fs-12 m-0">
                                            Nama lengkap pemilik rekening
                                        </p>
                                    </label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text"
                                            class="form-control user-account-input shadow-nonamene my-1 border-radius-05rem py-2 px-3 @error('firstname') is-invalid @enderror"
                                            id="name" value="" placeholder="Nama lengkap" name="name"
                                            required>
                                        @error('firstname')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <label for="bank" class="col-sm-2 col-md-3 col-form-label">
                                        <div>
                                            <span>
                                                Bank
                                            </span>
                                            <span class="text-danger">
                                                *
                                            </span>
                                        </div>
                                        <p class="text-grey fs-12 m-0">
                                            MANDIRI / BNI / BNI / BCA / CIMB / DLL
                                        </p>
                                    </label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text"
                                            class="form-control user-account-input shadow-none my-1 border-radius-05rem py-2 px-3 @error('bank_name') is-invalid @enderror"
                                            id="bank" value="" placeholder="Nama bank" name="bank_name"
                                            required>
                                        @error('bank_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <label for="account_number" class="col-sm-2 col-md-3 col-form-label">
                                        <div>
                                            <span>
                                                Nomor Rekening
                                            </span>
                                            <span class="text-danger">
                                                *
                                            </span>
                                        </div>
                                    </label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text"
                                            class="form-control user-account-input shadow-none my-1 border-radius-05rem py-2 px-3 @error('account_number') is-invalid @enderror"
                                            id="account_number" value="" placeholder="Nomor rekening bank"
                                            name="account_number" required>
                                        @error('account_number')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <label for="inputEmail" class="col-sm-2 col-md-3 col-form-label">
                                        <div>
                                            Email
                                        </div>
                                        <p class="text-grey fs-12 m-0">
                                            Digunakan untuk mengirim notifikasi ketika pengembalian dana sudah diproses
                                        </p>
                                    </label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text"
                                            class="form-control user-account-input shadow-none my-1 border-radius-05rem py-2 px-3 @error('email') is-invalid @enderror"
                                            id="inputEmail" value="" placeholder="Email" name="email">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <label for="inputTelpNo" class="col-sm-2 col-md-3 col-form-label">
                                        <div>
                                            Nomor Telepon/WA
                                        </div>
                                        <p class="text-grey fs-12 m-0">
                                            Digunakan untuk mengirim notifikasi ketika pengembalian dana sudah diproses
                                        </p>
                                    </label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text"
                                            class="form-control user-account-input shadow-none my-1 border-radius-05rem py-2 px-3 @error('telp_no') is-invalid @enderror"
                                            id="inputTelpNo" value="" placeholder="Nomor telepon" name="telp_no">
                                        @error('telp_no')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="order_id" value="{{ $orders[0]->id }}">
                                <input type="hidden" name="company_id"
                                    value="{{ $orders[0]->orderitem[0]->orderproduct->company_id }}">
                                <div class="text-end">
                                    <button type="button" class="btn btn-secondary fs-14"
                                        data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit"
                                        class="btn btn-danger shadow-none fs-14 refund-order-payment-submit-button">Kirim</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 px-4 pb-4 justify-content-end">
                </div>
            </div>
        </div>
    </div>
    @include('chat')
    <script>
        $(document).ready(function() {

            // $(document).on('click', function(e) {
            //     var container = $(".chat-container");
            //     if (!e.target.classList.contains('user-chat-button')) {
            //         if (!$(e.target).closest(container).length) {
            //             container.addClass('d-none');
            //             container.removeClass('d-block');
            //         }
            //     }
            // });

            // window.csrfToken = $("input[name='csrf_token']").val();
            // window.userId = $("input[name='user_id']").val();
            // window.productId = $("input[name='product_id']").val();
            // window.orderId = $("input[name='order_id']").val();
            // window.adminId = $("input[name='admin_id']").val();
            // window.companyId = $("input[name='company_id']").val();
            // // console.log($("input[name='order_id']").val());
            // setInterval(function() {
            //     // console.log('real time');
            //     if (typeof(window.userId) !== 'undefined') {
            //         load_chat(window.csrfToken, window.userId, window.productId, window.orderId, window
            //             .adminId, window
            //             .companyId);
            //     }
            //     // update_chat_status(window.csrfToken, window.userId, window.productId, window.adminId, window
            //     //     .companyId);
            // }, 500);

            // $('.send-chat-button').on('click', function() {
            //     console.log('send chat on progress...');
            //     window.chat = $("textarea[name='chat']").val();

            //     if (window.chat != null && window.chat != '') {
            //         // console.log('order id : ' + window.orderId);
            //         send_chat(window.csrfToken, window.userId, window.productId, window.orderId, window
            //             .adminId, window
            //             .companyId, window.chat);
            //         $('.send-chat-icon').addClass('d-none');
            //         $('.send-chat-spinner').removeClass('d-none');
            //         // $('.send-chat-spinner').addClass('d-block');
            //         $('.send-chat-button').attr('disabled', true);

            //     } else {
            //         alert('chat tidak boleh kosong!');
            //     }
            // });

            // function load_chat(csrfToken, userId, productId, orderId, adminId, companyId) {
            //     // console.log('load chat');
            //     $.ajax({
            //         // url: "{{ url('/userloadchat') }}",
            //         url: window.location.origin + "/userloadchat",
            //         type: 'get',
            //         data: {
            //             _token: csrfToken,
            //             user_id: userId,
            //             product_id: productId,
            //             order_id: orderId,
            //             admin_id: adminId,
            //             company_id: companyId,
            //             // chat_message: chat,
            //         },
            //         success: function(response) {
            //             console.log(response);
            //             // console.log((response) == '');
            //             if (response != '') {
            //                 $('.inner-user-chat-modal').html('');
            //                 $.each(response['chatHistory'], function(id, chats) {
            //                     $.each(chats['chat_message'], function(idChat, chat) {
            //                         console.log(chat['id']);
            //                         if (chat['admin_id'] == null) {
            //                             if (chat['status'] == 0) {
            //                                 var check = 'bi bi-check2';
            //                             } else {
            //                                 var check = 'bi bi-check2-all';
            //                             }
            //                             $('.inner-user-chat-modal').append(
            //                                 '<div class = "row mx-0 justify-content-end mb-3" > ' +
            //                                 '<div class="col-8 bg-danger p-3 text-white border-radius-075rem">' +
            //                                 '<p class="m-0 mb-2">' + chat[
            //                                     'chat_message'] +
            //                                 '</p>' +
            //                                 '<div class="d-flex">' +
            //                                 '<div class="fs-11 m-0">' + moment(
            //                                     chat[
            //                                         'created_at']).fromNow() +
            //                                 '</div>' +
            //                                 '<div class="fs-14 ms-auto"><i class="' +
            //                                 check + '"></i></div>' +
            //                                 '</div>' +
            //                                 '</div>' +
            //                                 '</div>');
            //                             // $('.inner-user-chat-modal').append('<div>'+chat['chat_message']+'</div>');
            //                         } else {
            //                             $('.inner-user-chat-modal').append(
            //                                 '<div class = "row mx-0 mb-3" > ' +
            //                                 '<div class="col-8 bg-success p-3 text-white border-radius-075rem">' +
            //                                 '<p class="m-0 mb-2">' + chat[
            //                                     'chat_message'] +
            //                                 '</p>' +
            //                                 '<p class="fs-11 m-0">' + moment(
            //                                     chat[
            //                                         'created_at']).fromNow() +
            //                                 '</p>' +
            //                                 '</div>' +
            //                                 '</div>');
            //                         }
            //                     });
            //                 });
            //                 if (response['unreadChat'] != '') {
            //                     if ($('.unread-user-chat-badge').hasClass('d-none')) {
            //                         $('.unread-user-chat-badge').removeClass('d-none');
            //                         $('.unread-user-chat-badge').addClass('d-block');
            //                     }
            //                     $('.unread-user-chat-badge').text(response['unreadChat']);
            //                 } else {
            //                     if ($('.unread-user-chat-badge').hasClass('d-block')) {
            //                         $('.unread-user-chat-badge').addClass('d-none');
            //                         $('.unread-user-chat-badge').removeClass('d-block');
            //                     }
            //                     $('.unread-user-chat-badge').text('');
            //                 }
            //             }
            //         },
            //         dataType: "json"
            //     });
            // }

            // function send_chat(csrfToken, userId, productId, orderId, adminId, companyId, chat) {
            //     console.log(csrfToken);
            //     console.log(userId);
            //     console.log(productId);
            //     console.log(orderId);
            //     console.log(adminId);
            //     console.log(companyId);
            //     console.log(chat);
            //     $.ajax({
            //         // url: "{{ url('/usersendchat') }}",
            //         url: window.location.origin + "/usersendchat",
            //         type: 'post',
            //         data: {
            //             _token: csrfToken,
            //             user_id: userId,
            //             product_id: productId,
            //             order_id: orderId,
            //             admin_id: adminId,
            //             company_id: companyId,
            //             chat_message: chat,
            //         },
            //         success: function(response) {
            //             console.log(response);
            //             $("textarea[name='chat']").val('');
            //             $(document).ready(function() {
            //                 console.log('launch once');
            //                 $(".inner-user-chat-modal").animate({
            //                     scrollTop: $(
            //                             ".inner-user-chat-modal").get(0)
            //                         .scrollHeight
            //                 }, 500);
            //             });
            //             $('.send-chat-spinner').addClass('d-none');
            //             $('.send-chat-spinner').removeClass('d-block');
            //             $('.send-chat-icon').removeClass('d-none');
            //             $('.send-chat-button').attr('disabled', false);
            //         },
            //         error: function(xhr, status, error) {
            //             var err = eval("(" + xhr.responseText + ")");
            //             console.log(xhr);
            //             console.log(status);
            //             console.log(error);
            //             alert(err.Message);
            //             $('.send-chat-button').attr('disabled', false);

            //         },
            //         dataType: "json"
            //     });
            // }

            // function update_chat_status(csrfToken, userId, productId, orderId, companyId) {
            //     console.log(csrfToken);
            //     console.log(userId);
            //     console.log(productId);
            //     console.log(orderId);
            //     console.log(companyId);
            //     $.ajax({
            //         // url: "{{ url('/updatechatstatus') }}",
            //         url: window.location.origin + "/updatechatstatus",
            //         type: 'post',
            //         data: {
            //             _token: csrfToken,
            //             user_id: userId,
            //             product_id: productId,
            //             company_id: companyId,
            //             // chat_message: chat,
            //         },
            //         success: function(response) {
            //             console.log(response);
            //             // $("textarea[name='chat']").val('');
            //             // $(document).ready(function() {
            //             //     console.log('launch once');
            //             //     $(".inner-user-chat-modal").animate({
            //             //         scrollTop: $(
            //             //                 ".inner-user-chat-modal").get(0)
            //             //             .scrollHeight
            //             //     }, 0);
            //             // });
            //         },
            //         dataType: "json"
            //     });
            // }

            // $('.user-chat-button, .user-chat-close-button').on('click', function() {
            //     if ($('.chat-container').hasClass('d-none')) {
            //         $('.chat-container').removeClass('d-none');
            //         $('.chat-container').addClass('d-block');
            //         $(".inner-user-chat-modal").animate({
            //             scrollTop: $(
            //                     ".inner-user-chat-modal").get(0)
            //                 .scrollHeight
            //         }, 0);
            //         // update_chat_status(window.csrfToken, window.userId, window.productId, window.orderId, window.companyId);
            //     } else {
            //         $('.chat-container').removeClass('d-block');
            //         $('.chat-container').addClass('d-none');
            //     }
            // });

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
                // console.log($('.order-shipment-detail'));
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
        $('.refund-order-payment-form').submit(function(e) {
            console.log(e);
            $('.refund-order-payment-submit-button').append(
                '<span class="ms-2 spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
            );
            $('.refund-order-payment-submit-button').attr('disabled', true);

            // e.preventDefault();
        });

        function previewImagePayment() {
            // mengambil sumber image dari input dengan id image
            const image = document.querySelector('#inputProofOfPayment');

            // mengambil tag img dari class img-preview
            const imgPreview = document.querySelector('.img-preview');

            // mengubah style tampilan image menjadi block
            imgPreview.style.display = 'block';

            // perintah untuk mengambil data gambar
            const oFReader = new FileReader();
            // mengambil dari const image
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(OFREvent) {
                imgPreview.src = OFREvent.target.result;
            }
        }
    </script>
@endsection
