@extends('layouts.main')
@section('container')
    {{-- <script type="text/javascript">
        function disableBack() {
            window.history.forward();
        }
        setTimeout("disableBack()", 0);
        window.onunload = function() {
            null
        };
    </script> --}}
    <div class="container-fluid">
        {{ Breadcrumbs::render('order.payment') }}
    </div>
    <div class="container my-5">
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
        @if ($orders[0]->orderStatusDetail->last()->status == 'Pesanan Dibatalkan')
        <div class="alert alert-danger alert-dismissible" role="alert">
            {{ $orders[0]->orderStatusDetail->last()->status_detail }}
        </div>
        @endif
        <div class="row">
            <div class="col-md-6 col-12">
                <h5 class="mb-3">Pembayaran</h5>
                <div class="card fs-14 border-radius-075rem mb-4 box-shadows">
                    <div class="card-header bg-transparent py-3 fw-bold">
                        <div class="d-flex align-items-center">
                            <div class="me-auto">
                                Ringkasan Pembayaran
                            </div>
                            <div>
                                <a target="_blank"
                                    href="{{ route('payment.order.bind.pdf', ['id' => Crypt::encrypt($orders[0]->id)]) }}"
                                    class="btn btn-danger fs-14">
                                    <i class="bi bi-file-earmark-pdf"></i> PDF
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach ($orders as $order)
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
                                    Berat total: <span class="total-weight-checkout">
                                        {{ $weight }}
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
                                <div class="col-9 text-grey fs-12">
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
                                <div class="col-9 text-grey fs-12">
                                    Kode Unik digunakan untuk mempermudah dalam proses VERIFIKASI Pembayaran oleh Admin
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

                            {{-- <div class="row mb-2">
                                <div class="col-9 text-grey fs-12">
                                    @if (empty($order->discount))
                                        @foreach ($order->orderItem as $item)
                                            @if (!empty($item->discount))
                                                Diskon harga item :
                                                {{ $item->orderproduct->name }}
                                            @endif
                                        @endforeach
                                    @else
                                        - Rp{{ price_format_rupiah($order->unique_code) }}
                                    @endif
                                </div>
                            </div> --}}

                            <div class="my-3 border-bottom">
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-7">
                                    Total yang harus dibayar
                                </div>
                                <div class="col-md-6 col-5 text-end text-danger fw-bold">
                                    Rp{{ price_format_rupiah($order->courier_price + $order->total_price + $order->unique_code - $order->discount) }}
                                </div>
                            </div>
                            <div class="col-7 text-grey fs-12 text-danger">
                                *Pastikan pembayaran sesuai dengan yang tertera
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card fs-14 border-radius-075rem mb-4 box-shadows">
                    <div class="card-header bg-transparent py-3 fw-bold">
                        <div class="row align-items-center">
                            {{-- @if (!empty($paymentMethod->logo))
                                <div class="col-2 col-md- pe-0">
                                    <img class="w-100" src=" {{ asset($paymentMethod->logo) }}" alt="">
                                </div>
                            @endif --}}
                            @if (!empty($orders[0]->paymentMethod->logo))
                                <div class="col-2 col-md-1 pe-0">
                                    <img src="{{ asset($orders[0]->paymentmethod->logo) }}" class="w-100" alt="">
                                </div>
                            @endif
                            <div class="col-10 col-md-11">
                                {{ $orders[0]->paymentmethod->type }} {{ $orders[0]->paymentmethod->name }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($orders[0]->paymentmethod->type != 'COD')
                            No. Rekening
                            <h5 class="text-danger fw-bold py-2 m-0">
                                {{ $orders[0]->paymentmethod->account_number }}
                            </h5>
                        @endif
                    </div>
                </div>

                {{-- <div class="accordion mb-4 fs-14 box-shadows border-radius-075rem" id="accordionExample">
                    <div class="accordion-item payment-guide-accordion">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed bg-transparent fs-14 shadow-none" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                aria-controls="collapseOne">
                                Petunjuk Transfer ATM
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body border-top">
                                <ul>
                                    <li>
                                        Masukan kartu ATM ke dalam mesin ATM
                                    </li>
                                    <li>
                                        Pilih bahasa Indonesia atau Inggris
                                    </li>
                                    <li>
                                        Masukan no PIN ATM
                                    </li>
                                    <li>
                                        Pilih menu transfer
                                    </li>
                                    <li>
                                        Pilih bank tujuan transfer
                                    </li>
                                    <li>
                                        Masukan kode Bank CIMB Niaga, yaitu 022 dan nomor rekening Bank CIMB Niaga yang akan
                                        dituju
                                    </li>
                                    <li>
                                        Masukan nominal uang yang akan ditransfer
                                    </li>
                                    <li>
                                        Pastikan kode Bank CIMB Niaga, nominal uang, dan nama penerima sudah benar
                                    </li>
                                    <li>
                                        Tekan tombol “Benar”
                                    </li>
                                    <li>
                                        Transaksi berhasil dan anda akan menerima struk serta kartu ATM-mu kembali
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed shadow-none bg-transparent fs-14" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                aria-controls="collapseTwo">
                                Petunjuk Transfer iBanking
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body border-top">
                                <ul>
                                    <li>
                                        Masukan kartu ATM ke dalam mesin ATM
                                    </li>
                                    <li>
                                        Pilih bahasa Indonesia atau Inggris
                                    </li>
                                    <li>
                                        Masukan no PIN ATM
                                    </li>
                                    <li>
                                        Pilih menu transfer
                                    </li>
                                    <li>
                                        Pilih bank tujuan transfer
                                    </li>
                                    <li>
                                        Masukan kode Bank CIMB Niaga, yaitu 022 dan nomor rekening Bank CIMB Niaga yang akan
                                        dituju
                                    </li>
                                    <li>
                                        Masukan nominal uang yang akan ditransfer
                                    </li>
                                    <li>
                                        Pastikan kode Bank CIMB Niaga, nominal uang, dan nama penerima sudah benar
                                    </li>
                                    <li>
                                        Tekan tombol “Benar”
                                    </li>
                                    <li>
                                        Transaksi berhasil dan anda akan menerima struk serta kartu ATM-mu kembali
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item payment-guide-accordion-bottom">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed bg-transparent fs-14 bg-transparent shadow-none"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                aria-expanded="false" aria-controls="collapseThree">
                                Petunjuk Transfer Mobile Banking (OCTO)
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body border-top">
                                <ul>
                                    <li>
                                        Login ke akun Octo Mobile Anda
                                    </li>
                                    <li>
                                        Pilih Menu Transfer
                                    </li>
                                    <li>
                                        Pilih Menu Transfer Rekening CIMB/Rekening Ponsel Lain
                                    </li>
                                    <li>
                                        Pilih rekening sumber dana, di rekening penerima, masukkan No. Rekening yang tertera
                                        diatas
                                    </li>
                                    <li>
                                        Pilih bank tujuan transfer
                                    </li>
                                    <li>
                                        Masukan kode Bank CIMB Niaga, yaitu 022 dan nomor rekening Bank CIMB Niaga yang akan
                                        dituju
                                    </li>
                                    <li>
                                        Masukan nominal uang yang akan ditransfer
                                    </li>
                                    <li>
                                        Pastikan kode Bank CIMB Niaga, nominal uang, dan nama penerima sudah benar
                                    </li>
                                    <li>
                                        Tekan tombol “Benar”
                                    </li>
                                    <li>
                                        Transaksi berhasil dan anda akan menerima struk serta kartu ATM-mu kembali
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="card fs-14 border-radius-075rem mb-4 box-shadows">
                    <div class="card-header bg-transparent py-3 fw-bold">
                        Batas Waktu Pembayaran
                    </div>
                    <div class="card-body">
                        <div class="fs-14">
                            <span>
                                Bayar dalam:
                            </span>
                            <span class="text-danger fw-bold" id="payment_due">

                            </span>
                            <div class="col-12 text-grey fs-12 text-danger">
                                *Pesanan akan otomatis dibatalkan jika melewati batas waktu diatas
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-1 mt-4">
                    {{-- {{ dd($order) }} --}}
                    {{-- <p class="fs-14" id="payment_due"></p> --}}
                    <div class="modal fade" id="paymentConfirm" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" tabindex="-1" aria-labelledby="paymentConfirm" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content border-radius-075rem">
                                <form class="payment-form" action="{{ route('payment.completed') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="paymentConfirm">Konfirmasi Pembayaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
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
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary fs-14"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <input type="hidden" name="order_id" value="{{ $orders[0]->id }}">
                                        <button type="submit"
                                            class="btn btn-danger shadow-none fs-14 submit-button">Konfirmasi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="cancelConfirm" tabindex="-1" aria-labelledby="cancelConfirmModal"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-radius-075rem">
                                <div class="modal-header border-0 pt-4 px-4">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('order.delete', $order) }}" method="post" class="d-inline">
                                    {{-- @method('delete') --}}
                                    @csrf
                                    <div class="modal-body text-center py-2 px-5">
                                        <h5 class="mb-3">Konfirmasi Pembatalan Pesanan</h5>
                                        <p class="fs-14 mb-0">
                                            Apakah anda yakin ingin membatalkan pesanan ini? Pesanan yang dibatalkan akan
                                            dihapus dari daftar pesananmu. Mohon tuliskan alasan mengapa anda membatalkan
                                            pesananmu.
                                        </p>
                                        <div class="form-floating my-3">
                                            <textarea class="form-control fs-14" placeholder="Tuliskan alasan pembatalan pesanan" id="cancel-order"
                                                style="height: 100px" required name="cancel_order_detail"></textarea>
                                            <label for="cancel-order" class="fs-14">Alasan Pembatalan
                                                Pesanan
                                            </label>
                                            <div class="cancel_order_error_message fs-12 text-danger text-start my-1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 d-flex justify-content-center">
                                        <button type="button" class="btn btn-outline-secondary fs-14"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-danger fs-14 my-2 shadow-none">Batalkan
                                            Pesanan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if ($order->orderStatusDetail->last()->status != 'Pesanan Dibatalkan')
                        <button type="button" class="btn btn-outline-secondary fs-14 my-2 shadow-none"
                            data-bs-toggle="modal" data-bs-target="#cancelConfirm">Batalkan Pesanan</button>
                        <button type="button" class="btn btn-danger fs-14 my-2 shadow-none" data-bs-toggle="modal"
                            data-bs-target="#paymentConfirm">Sudah Bayar</button>
                        <p class="fs-12">
                            *Klik <strong>Sudah Bayar</strong> ketika sudah melakukan pembayaran pesanan agar mempermudah
                            verifikasi
                            oleh tim admin KLIKSPL
                        </p>
                    @endif
                </div>
                {{-- <div class="card fs-14 border-radius-075rem mb-4">
                    <div class="card-header bg-transparent py-3 fw-bold">
                        <div class="row align-items-center">
                            <p class="m-0 fw-bold">Pembayaran</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="fs-14">
                            <span>
                                Bayar dalam:
                            </span>
                            <span class="text-danger fw-bold" id="payment_due">
            
                            </span>
                        </div>
                        <a href="#" class="btn btn-danger fs-14 my-2">Sudah Bayar</a>
                        <a href="#" class="btn btn-outline-secondary fs-14 my-2">Batalkan Pesanan</a>
                        <p class="fs-12">
                            *Klik <strong>Sudah Bayar</strong> ketika sudah melakukan pembayaran pesanan agar mempermudah verifikasi
                            oleh tim admin KLIKSPL
                        </p>
                    </div>
                </div> --}}
            </div>

            <div class="col-md-6 col-12 mb-5 d-none d-sm-block">
                <h5 class="mb-3">Detail Pesanan</h5>
                <div class="card fs-14 border-radius-075rem mb-4 box-shadows">
                    <div class="card-header bg-transparent py-3">
                        <p class="m-0 fw-bold">Alamat Asal Pengiriman</p>
                    </div>
                    <div class="card-body p-4">
                        @foreach ($orders as $order)
                            {{-- {{ $order->orderaddress }} --}}
                            <p class="m-0 checkout-shipment-address-name">
                                {{ $order->senderaddress->name }}
                            </p>
                            <p class="m-0 checkout-shipment-address-phone">
                                {{ $order->senderaddress->telp_no }}
                            </p>
                            <p class="m-0 checkout-shipment-address-address">
                                {{ $order->senderaddress->address }}
                            </p>
                            <div class="checkout-shipment-address-city">
                                <span class="m-0 me-1 ">
                                    {{ $order->senderaddress->city->name }},
                                </span>
                                <span class="m-0 checkout-shipment-address-province">
                                    {{ $order->senderaddress->province->name }}
                                </span>
                                <span class="m-0 checkout-shipment-address-postalcode">
                                    {{ !empty($order->senderaddress->postal_code) ? ', ' . $order->senderaddress->postal_code : '' }}
                                </span>
                            </div>
                            <div class="input-data">
                                <input class="city-origin" type="hidden" name="cityOrigin" value="36">
                                <input class="address-id" type="hidden" name="addressId"
                                    value="{{ $order->orderaddress->id }}">
                                <input class="city-destination" type="hidden" name="cityDestination"
                                    value="{{ $order->orderaddress->city->city_id }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card fs-14 border-radius-075rem mb-4 box-shadows">
                    <div class="card-header bg-transparent py-3">
                        <p class="m-0 fw-bold">Alamat Tujuan Pengiriman</p>
                    </div>
                    <div class="card-body p-4">
                        @foreach ($orders as $order)
                            {{-- {{ $order->orderaddress }} --}}
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
                            <div class="input-data">
                                <input class="city-origin" type="hidden" name="cityOrigin" value="36">
                                <input class="address-id" type="hidden" name="addressId"
                                    value="{{ $order->orderaddress->id }}">
                                <input class="city-destination" type="hidden" name="cityDestination"
                                    value="{{ $order->orderaddress->city->city_id }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card fs-14 border-radius-075rem mb-4 box-shadows">
                    <div class="card-header bg-transparent py-3">
                        <p class="m-0 fw-bold">Kurir Pengirim</p>
                    </div>
                    <div class="card-body p-4">
                        @foreach ($orders as $order)
                            <div class="row d-flex align-items-center">
                                <div class="col-md-9 col-8 text-start">
                                    <div class="checkout-courier-label m-0">
                                        <p class="m-0 d-inline-block modal-courier-type pe-1 fw-bold">
                                            {{ $order->courier }}
                                        </p>
                                        <p class="m-0 d-inline-block modal-courier-package fw-bold">
                                            {{ $order->courier_package_type }}
                                        </p>
                                        <p class="m-0">
                                            Perkiraan tiba dalam {{ $order->estimation_day }} hari /
                                            {{ \Carbon\Carbon::parse($order->estimation_date)->isoFormat('dddd, D MMMM Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-4 text-end">
                                    <p class="m-0 text-danger checkout-courier-cost my-2 fw-bold">
                                        <span class="checkout-courier-cost">
                                            Rp{{ price_format_rupiah($order->courier_price) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card mb-4 border-radius-075rem fs-14 box-shadows">
                    <div class="card-header bg-transparent py-3">
                        <p class="m-0 fw-bold">Produk Pesanan</p>
                    </div>
                    <div class="card-body px-4 py-1">
                        <div class="row d-flex align-items-center justify-content-center text-center">
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
                                                    Varian:
                                                    {{ isset($item->orderproduct->variant_name) ? $item->orderproduct->variant_name : 'Tidak ada varian' }}
                                                </div>
                                                <div
                                                    class="text-truncate order-items-product-price-qty text-grey text-end text-md-start">
                                                    <span>
                                                        {{ $item->quantity }} x
                                                    </span>
                                                    {{-- <span class="{{ (!empty($item->discount) ? 'text-decoration-line-through' : '') }}">
                                                        Rp{{ price_format_rupiah($item->orderproduct->price) }}
                                                    </span> --}}
                                                    <span>
                                                        Rp{{ price_format_rupiah($item->orderproduct->price) }}
                                                        {{-- @if (!empty($item->discount)) --}}
                                                        {{-- Rp{{ price_format_rupiah($item->orderproduct->price - $item->discount) }} --}}
                                                        {{-- @endif --}}
                                                    </span>
                                                </div>
                                                @if ($item->order_item_status == 'stock habis')
                                                    <div class="text-danger fw-600">
                                                        {{ $item->order_item_status }}
                                                    </div>
                                                @endif
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
        </div>
    </div>

    <div class="fixed-bottom d-block d-sm-none p-0 mb-5">
        <div class="col-12">
            <div class="card border-radius-075rem">
                <div class="card-header bg-transparent border-0 p-4">
                    <a href="#" class="btn active d-block pt-0 expand-payment-detail shadow-none" role="button"
                        data-bs-toggle="button" aria-pressed="true">
                        Detail Pesanan <i class="bi bi-chevron-up mx-2 expand-payment-detail-chevron"></i>
                    </a>
                </div>
                <div class="card-body p-4 payment-detail d-none">
                    <div class="col-12 mb-5">
                        <h5 class="mb-3">Detail Pesanan</h5>
                        <div class="card fs-14 border-radius-075rem mb-4 ">
                            <div class="card-header bg-transparent py-3">
                                <p class="m-0 fw-bold">Alamat Pengiriman</p>
                            </div>
                            <div class="card-body p-4">
                                @foreach ($orders as $order)
                                    {{-- {{ $order->orderaddress }} --}}
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
                                    <div class="input-data">
                                        <input class="city-origin" type="hidden" name="cityOrigin" value="36">
                                        <input class="address-id" type="hidden" name="addressId"
                                            value="{{ $order->orderaddress->id }}">
                                        <input class="city-destination" type="hidden" name="cityDestination"
                                            value="{{ $order->orderaddress->city->city_id }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="order-courier-payment  mb-4">
                            <div class="card border-radius-075rem fs-14">
                                <div class="card-header bg-transparent py-3">
                                    <p class="m-0 fw-bold">Kurir Pengirim</p>
                                </div>
                                <div class="card-body p-4">
                                    @foreach ($orders as $order)
                                        <div class="row d-flex align-items-center">
                                            <div class="col-md-9 col-8 text-start">
                                                <div class="checkout-courier-label m-0">
                                                    <p class="m-0 d-inline-block modal-courier-type pe-1 fw-bold">
                                                        {{ $order->courier }}
                                                    </p>
                                                    <p class="m-0 d-inline-block modal-courier-package fw-bold">
                                                        {{ $order->courier_package_type }}
                                                    </p>
                                                    <p class="m-0">
                                                        Perkiraan tiba dalam {{ $order->estimation_day }} hari /
                                                        {{ \Carbon\Carbon::parse($order->estimation_date)->isoFormat('dddd,D MMMM Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-4 text-end">
                                                <p class="m-0 text-danger checkout-courier-cost my-2 fw-bold">
                                                    <span class="checkout-courier-cost">
                                                        Rp{{ price_format_rupiah($order->courier_price) }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4 border-radius-075rem fs-14">
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
                </div>
            </div>
        </div>
    </div>
    @include('chat')
    {{-- <div class="container-fluid fixed-bottom bg-white py-md-3 pb-5 pt-3 px-4 mb-3 mb-md-0 border-radius-075rem shadow-lg">
        <div class="container px-4">
            <div class="fs-14">
                <span>
                    Bayar dalam:
                </span>
                <span class="text-danger fw-bold" id="payment_due">

                </span>
            </div>
            <a href="#" class="btn btn-danger fs-14 my-2">Sudah Bayar</a>
            <a href="#" class="btn btn-outline-secondary fs-14 my-2">Batalkan Pesanan</a>
            <p class="fs-12">
                *Klik <strong>Sudah Bayar</strong> ketika sudah melakukan pembayaran pesanan agar mempermudah verifikasi
                oleh tim admin KLIKSPL
            </p>
        </div>
    </div> --}}
    <script>
        //  $(window).focus(function() {
        //     window.location.reload();
        // });
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        // console.log(timezone);
        if (timezone == 'Asia/Makassar') {
            var payment_due = new Date("{{ $orders[0]->payment_due_date }}").getTime() + 3600000;
            // console.log(payment_due);
        } else if (timezone == 'Asia/Jakarta') {
            var payment_due = new Date("{{ $orders[0]->payment_due_date }}").getTime();
            // console.log(payment_due);
        } else if (timezone == 'Asia/Manokwari') {
            var payment_due = new Date("{{ $orders[0]->payment_due_date }}").getTime() + 7200000;
            // console.log(payment_due);
        }
        var x = setInterval(() => {
            var now = new Date().getTime();

            var distance = payment_due - now;

            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / (1000));

            // console.log('distance : ' + Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)) + ':' +
            //     Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)) + ':' + Math.floor((distance % (1000 *
            //         60)) / (1000)));
            document.getElementById("payment_due").innerHTML = hours + "jam " + minutes + "menit " + seconds +
                "detik ";
        }, 1000);

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

        $(document).ready(function() {
            $('.expand-payment-detail').click(function() {
                console.log($('.payment-detail'));
                if ($('.payment-detail').hasClass("d-none")) {
                    $('.payment-detail').removeClass("d-none");
                } else {
                    $('.payment-detail').addClass('d-none');
                }
                if ($('.expand-payment-detail-chevron').hasClass("bi-chevron-up")) {
                    $('.expand-payment-detail-chevron').removeClass("bi-chevron-up");
                    $('.expand-payment-detail-chevron').addClass("bi-chevron-down");
                    console.log($('.expand-payment-detail-chevron'));
                } else if ($('.expand-payment-detail-chevron').hasClass("bi-chevron-down")) {
                    $('.expand-payment-detail-chevron').removeClass("bi-chevron-down");
                    $('.expand-payment-detail-chevron').addClass("bi-chevron-up");
                    console.log($('.expand-payment-detail-chevron'));
                }
            });
            $('textarea[name="cancel_order_detail"]').on('keypress', function(e) {
                console.log($('textarea[name="cancel_order_detail"]').val());
                if (/^[a-zA-Z\.\,\b\s]+$/.test(String.fromCharCode(e.keyCode))) {
                    return;
                } else {
                    $('.cancel_order_error_message').text(
                        '*Jangan gunakan karakter khusus dan angka untuk menuliskan alasan pembatalan');
                    e.preventDefault();
                }
            });
            $('.payment-form').submit(function(e) {
                console.log(e);
                $('.submit-button').append(
                    '<span class="ms-2 spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                );
                $('.submit-button').attr('disabled', true);

                // e.preventDefault();
            });
        });
    </script>
@endsection
