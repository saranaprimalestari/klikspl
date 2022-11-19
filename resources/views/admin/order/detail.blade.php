@extends('admin.layouts.main')
@section('container')
    {{-- {{ dd($orders) }} --}}
    {{-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2">Detail Pesanan</h1>
    </div> --}}
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
            <p><strong>Gagal</strong></p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container p-0">
        {{-- <div class="card mb-3 order-card fs-14"> --}}
        <div class="card-body p-4">
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('adminorder.index') }}" class="text-decoration-none link-dark">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>

            {{-- @foreach ($orders as $order) --}}
            {{-- {{ dd($orders->orderitem->count()) }} --}}
            <div class="row">
                @if (auth()->guard('adminMiddle')->user()->admin_type == 1)
                    <div class="col-md-12 col-12">
                        <div class="card fs-14 border-radius-1-5rem border-0 mb-4 box-shadow">
                            <div class="card-body p-4">
                                <p class=" fs-14 fw-bold m-0 mb-1">
                                    Perusahaan
                                </p>
                                <p class="fs-14 m-0 mb-1">
                                    {{ $orders->senderaddress->name }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-12 col-12">
                    @if ($orders->order_status === 'pesanan dibayarkan' || $orders->order_status === 'upload ulang bukti pembayaran')
                        <div class="card fs-14 border-radius-1-5rem border-0 mb-4 box-shadow">
                            <div class="card-body p-4">
                                {{-- @if ($orders->order_status === 'pesanan dibayarkan') --}}
                                <p class=" fs-14 fw-bold m-0 mb-1">
                                    Konfirmasi Pembayaran Pesanan
                                </p>
                                <p class="fs-12 m-0 mb-4">
                                    Pembeli sudah membayarkan pesanan, segera konfirmasi
                                </p>
                                <div class="row mb-2">
                                    <div class="col-md-3 col-6">
                                        Metode Pembayaran
                                    </div>
                                    <div class="col-md-9 col-6 text-end">
                                        <p class="m-0">
                                            <span>
                                                {{ ucwords($orders->paymentmethod->type) }} -
                                                {{ ucwords($orders->paymentmethod->name) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 col-6">
                                        Nomor Rekening
                                    </div>
                                    <div class="col-md-9 col-6 text-end">
                                        <p class="m-0">
                                            <span>
                                                {{ ucwords($orders->paymentmethod->account_number) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 col-6">
                                        Kode
                                    </div>
                                    <div class="col-md-9 col-6 text-end">
                                        <p class="m-0">
                                            <span>
                                                {{ ucwords($orders->paymentmethod->code) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                @if (!is_null($orders->proof_of_payment))
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
                                                        <img src="{{ asset('/storage/' . $orders->proof_of_payment) }}"
                                                            class="w-100 border-radius-5px" alt="">
                                                        <div class="d-md-flex mt-2">
                                                            <form
                                                                action="{{ route('adminorder.detail.proof.of.payment') }} "
                                                                method="post" class="me-1" target="_blank">
                                                                @csrf
                                                                <input type="hidden" name="proofOfPayment"
                                                                    value="{{ $orders->proof_of_payment }}">
                                                                <button type="submit"
                                                                    class="btn btn-danger fs-14 my-md-3 mb-2">
                                                                    <i class="bi bi-box-arrow-up-right"></i> Buka di
                                                                    Halaman Baru
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ route('adminorder.detail.proof.of.payment.download') }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="proofOfPayment"
                                                                    value="{{ $orders->proof_of_payment }}">
                                                                <input type="hidden" name="inv_no"
                                                                    value="{{ $orders->invoice_no }}">
                                                                <button type="submit"
                                                                    class="btn btn-danger fs-14 my-md-3 mb-2">
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
                                <div class="d-flex justify-content-end">
                                    <div class="row my-3 text-end">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-secondary fs-14 mb-2"
                                                data-bs-toggle="modal" data-bs-target="#cancelConfirmPayment">
                                                Tolak Pembayaran
                                            </button>
                                            <button type="button" class="btn btn-danger fs-14 mb-2" data-bs-toggle="modal"
                                                data-bs-target="#paymentConfirm">
                                                Konfirmasi Pembayaran
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                {{-- @else
                                @endif --}}
                            </div>
                        </div>

                        <div class="modal fade" id="paymentConfirm" tabindex="-1" aria-labelledby="paymentConfirmModal"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-radius-1-5rem">
                                    <div class="modal-header border-0 pt-4 px-4">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center py-2 px-5">
                                        <h5 class="mb-3">Konfirmasi Pembayaran Pesanan</h5>
                                        <p class="fs-14 mb-0">
                                            Apakah anda yakin ingin mengonfirmasi pembayaran?
                                        </p>
                                        <small class="text-danger">
                                            *Ketika anda mengonfirmasi pembayaran maka anda tidak dapat
                                            membatalkan pesanan dan harus melakukan pengemasan serta pengiriman
                                            pesanan
                                        </small>
                                    </div>
                                    <div class="modal-footer border-0 d-flex justify-content-center pb-4">
                                        <button type="button" class="btn btn-outline-secondary fs-14"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <form class="confirm-payment-form" action="{{ route('confirm.payment') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $orders->id }}">
                                            <button type="submit"
                                                class="btn btn-danger fs-14 my-2 shadow-none">Konfirmasi
                                                Pembayaran
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($orders->order_status === 'pembayaran dikonfirmasi' || $orders->order_status === 'pesanan disiapkan')
                        <div class="card fs-14 border-radius-1-5rem border-0 mb-4 box-shadow">
                            <div class="card-body p-4 pb-0">
                                <p class=" fs-14 fw-bold m-0 mb-1">
                                    @if ($orders->order_status === 'pembayaran dikonfirmasi')
                                        Pesanan Perlu Diproses
                                    @elseif($orders->order_status === 'pesanan disiapkan')
                                        Kirimkan Pesanan
                                    @endif
                                </p>

                                <p class="fs-12 m-0 mb-4">
                                    @if ($orders->order_status === 'pembayaran dikonfirmasi')
                                        Pembayaran pesanan sudah dikomfirmasi, segera siapkan pesanan pembeli! klik tombol
                                        <span class="text-danger fw-600">SIAPKAN PESANAN</span> di bawah ini untuk
                                        memproses
                                        pesanan.
                                    @elseif($orders->order_status === 'pesanan disiapkan')
                                        Kirimkan pesanan yang sudah disiapkan klik tombol
                                        <span class="text-danger fw-600">Kirim PESANAN</span> di bawah ini untuk
                                        memproses
                                        pesanan.
                                    @endif
                                </p>
                            </div>
                            <div class="card-footer px-4 pt-0 bg-transparent border-0">
                                <div class="d-flex justify-content-end">
                                    <div class="row my-3">
                                        <div class="col-md-12">
                                            @if ($orders->order_status === 'pembayaran dikonfirmasi')
                                                <button type="button" class="btn btn-danger fs-14"
                                                    data-bs-toggle="modal" data-bs-target="#prepareOrder">
                                                    Siapkan Pesanan
                                                </button>
                                            @elseif($orders->order_status === 'pesanan disiapkan')
                                                <button type="button" class="btn btn-danger fs-14"
                                                    data-bs-toggle="modal" data-bs-target="#deliveOrder">
                                                    Kirim Pesanan
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="prepareOrder" tabindex="-1" aria-labelledby="prepareOrderModal"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-radius-1-5rem">
                                    <div class="modal-header border-0 pt-4 px-4">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    {{-- @method('delete') --}}
                                    @csrf
                                    <div class="modal-body text-center py-2 px-5">
                                        <h5 class="mb-3">Konfirmasi Siapkan Pesanan</h5>
                                        <p class="fs-14 mb-0">
                                            Apakah anda yakin ingin mengonfirmasi dan menyiapkan pesanan?
                                        </p>
                                        <small class="text-danger">
                                            *Ketika anda mengonfirmasi maka anda tidak dapat
                                            membatalkan dan harus melakukan pengemasan serta pengiriman
                                            pesanan
                                        </small>
                                    </div>
                                    <div class="modal-footer border-0 d-flex justify-content-center pb-4">
                                        <button type="button" class="btn btn-outline-secondary fs-14"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <form class="prepare-order-form" action="{{ route('prepare.order') }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $orders->id }}">
                                            <button type="submit" class="btn btn-danger fs-14 my-2 shadow-none">
                                                Siapkan Pesanan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="deliveOrder" tabindex="-1" aria-labelledby="deliveOrderModal"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-radius-1-5rem">
                                    <div class="modal-header border-0 pt-4 px-4">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    {{-- @method('delete') --}}
                                    @csrf
                                    <div class="modal-body text-center py-2 px-5">
                                        <h5 class="mb-3">Konfirmasi Kirim Pesanan</h5>
                                        <p class="fs-14 mb-0">
                                            Apakah anda yakin ingin mengirim pesanan?
                                        </p>
                                        <small class="text-danger">
                                            *Ketika anda mengonfirmasi maka anda tidak dapat
                                            membatalkan dan harus mengantarka/mengirimkan pengemasan pesanan
                                        </small>
                                    </div>
                                    <div class="modal-footer border-0 d-flex justify-content-center pb-4">
                                        <button type="button" class="btn btn-outline-secondary fs-14"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <form class="delive-order-form" action="{{ route('delive.order') }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $orders->id }}">
                                            <button type="submit" class="btn btn-danger fs-14 my-2 shadow-none">Kirim
                                                Pesanan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($orders->order_status === 'pesanan dikirim' &&
                        $orders->orderstatusdetail->last()->status != 'Nomor resi telah terbit')
                        <div class="card fs-14 border-radius-1-5rem border-0 mb-4 box-shadow">
                            <div class="card-body p-4 pb-0">
                                {{-- <form action="{{ route('shipping.receipt.upload') }}" method="POST">
                                    @csrf --}}
                                <p class=" fs-14 fw-bold m-0 mb-1">
                                    @if ($orders->order_status === 'pesanan dikirim')
                                        Masukkan Nomor Resi
                                    @elseif($orders->order_status === 'pesanan disiapkan')
                                        Kirimkan Pesanan
                                    @endif
                                </p>
                                <p class="fs-12 m-0 mb-4">
                                    @if ($orders->order_status === 'pesanan dikirim')
                                        Masukkan nomor resi/bukti pengiriman ke kurir di bawah ini
                                    @endif
                                </p>
                                <div class="mb-3 row">
                                    <label for="resi" class="col-sm-3 col-form-label fw-600">Nomor Resi</label>
                                    <div class="col-sm-9">
                                        <input required type="text"
                                            class="form-control fs-14 @error('resi') is-invalid @enderror" id="resi"
                                            name="resi-input" placeholder="Ketikkan nomor resi"
                                            value="{{ old('resi') }}">
                                        @error('resi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- </form> --}}
                            </div>
                            <div class="modal-footer border-0 px-4 pb-4">
                                {{-- <div class="d-flex justify-content-end"> --}}
                                <div class="row m-0">
                                    <div class="col-md-12 p-0">
                                        @if ($orders->order_status === 'pesanan dikirim')
                                            <button type="button" class="shipping-receipt-btn btn btn-danger fs-14"
                                                data-bs-toggle="modal" data-bs-target="#shippingReceiptUpload">
                                                {{-- <i class="far fa-save"></i> --}}
                                                Selanjutnya
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                {{-- </div> --}}
                            </div>
                        </div>

                        <div class="modal fade" id="shippingReceiptUpload" tabindex="-1"
                            aria-labelledby="shippingReceiptUploadModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-radius-1-5rem">
                                    <div class="modal-header border-0 pt-4 px-4">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    {{-- @method('delete') --}}
                                    @csrf
                                    <div class="modal-body text-center py-2 px-5">
                                        <h5 class="mb-3">Konfirmasi Nomor Resi </h5>
                                        <div class="fs-14">
                                            <p class="mb-1">
                                                Nomor Resi yang anda masukkan adalah
                                            </p>
                                            <p class="fw-600 mb-1 shipping-receipt-text-modal">
                                            </p>
                                            <p class="mb-1 text-danger">
                                                Apakah anda yakin nomor resi yang anda masukkan sudah benar? Jika iya, tekan
                                                Simpan untuk menyimpan perubahan.
                                            </p>
                                        </div>
                                        {{-- <small class="text-danger">
                                            *Ketika anda mengonfirmasi maka anda tidak dapat
                                            membatalkan dan harus melakukan pengemasan serta pengiriman
                                            pesanan
                                        </small> --}}
                                    </div>
                                    <div class="modal-footer border-0 d-flex justify-content-center pb-4">
                                        <button type="button" class="btn btn-outline-secondary fs-14"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <form class="" action="{{ route('shipping.receipt.upload') }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="resi" value="">
                                            <input type="hidden" name="order_id" value="{{ $orders->id }}">
                                            <button type="submit" class="btn btn-danger fs-14 my-2 shadow-none">Simpan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="prepareOrder" tabindex="-1" aria-labelledby="prepareOrderModal"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-radius-1-5rem">
                                    <div class="modal-header border-0 pt-4 px-4">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    {{-- @method('delete') --}}
                                    @csrf
                                    <div class="modal-body text-center py-2 px-5">
                                        <h5 class="mb-3">Konfirmasi Siapkan Pesanan</h5>
                                        <p class="fs-14 mb-0">
                                            Apakah anda yakin ingin mengonfirmasi dan menyiapkan pesanan?
                                        </p>
                                        <small class="text-danger">
                                            *Ketika anda mengonfirmasi maka anda tidak dapat
                                            membatalkan dan harus melakukan pengemasan serta pengiriman
                                            pesanan
                                        </small>
                                    </div>
                                    <div class="modal-footer border-0 d-flex justify-content-center pb-4">
                                        <button type="button" class="btn btn-outline-secondary fs-14"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <form class="prepare-order-form" action="{{ route('prepare.order') }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $orders->id }}">
                                            <button type="submit" class="btn btn-danger fs-14 my-2 shadow-none">Siapkan
                                                Pesanan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="deliveOrder" tabindex="-1" aria-labelledby="deliveOrderModal"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-radius-1-5rem">
                                    <div class="modal-header border-0 pt-4 px-4">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    {{-- @method('delete') --}}
                                    @csrf
                                    <div class="modal-body text-center py-2 px-5">
                                        <h5 class="mb-3">Konfirmasi Kirim Pesanan</h5>
                                        <p class="fs-14 mb-0">
                                            Apakah anda yakin ingin mengirim pesanan?
                                        </p>
                                        <small class="text-danger">
                                            *Ketika anda mengonfirmasi maka anda tidak dapat
                                            membatalkan dan harus mengantarka/mengirimkan pengemasan pesanan
                                        </small>
                                    </div>
                                    <div class="modal-footer border-0 d-flex justify-content-center pb-4">
                                        <button type="button" class="btn btn-outline-secondary fs-14"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <form class="delive-order-form" action="{{ route('delive.order') }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $orders->id }}">
                                            <button type="submit" class="btn btn-danger fs-14 my-2 shadow-none">Kirim
                                                Pesanan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($orders->order_status === 'expired' ||
                        $orders->order_status == 'belum bayar' ||
                        $orders->order_status == 'pembayaran dikonfirmasi')
                        <div class="card fs-14 border-radius-1-5rem border-0 mb-4 box-shadow">
                            <div class="card-body p-4">
                                {{-- @if ($orders->order_status === 'pesanan dibayarkan') --}}
                                <p class=" fs-14 fw-bold m-0 mb-1">
                                    Edit Pesanan
                                </p>
                                <p class="fs-12 m-0 mb-4">
                                    Apabila pembeli lupa melakukan konfirmasi pembayaran pesanan, anda bisa mengonfimasi
                                    pesanannya secara manual
                                </p>
                                <div class="row mb-2">
                                    <div class="col-md-3 col-6">
                                        Metode Pembayaran
                                    </div>
                                    <div class="col-md-9 col-6 text-end">
                                        <p class="m-0">
                                            <span>
                                                {{ ucwords($orders->paymentmethod->type) }} -
                                                {{ ucwords($orders->paymentmethod->name) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 col-6">
                                        Nomor Rekening
                                    </div>
                                    <div class="col-md-9 col-6 text-end">
                                        <p class="m-0">
                                            <span>
                                                {{ ucwords($orders->paymentmethod->account_number) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 col-6">
                                        Kode
                                    </div>
                                    <div class="col-md-9 col-6 text-end">
                                        <p class="m-0">
                                            <span>
                                                {{ ucwords($orders->paymentmethod->code) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                @if (!is_null($orders->proof_of_payment))
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
                                                        <img src="{{ asset('/storage/' . $orders->proof_of_payment) }}"
                                                            class="w-100 border-radius-5px" alt="">
                                                        <div class="d-md-flex mt-2">
                                                            <form
                                                                action="{{ route('adminorder.detail.proof.of.payment') }} "
                                                                method="post" class="me-1" target="_blank">
                                                                @csrf
                                                                <input type="hidden" name="proofOfPayment"
                                                                    value="{{ $orders->proof_of_payment }}">
                                                                <button type="submit"
                                                                    class="btn btn-danger fs-14 my-md-3 mb-2">
                                                                    <i class="bi bi-box-arrow-up-right"></i> Buka di
                                                                    Halaman Baru
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ route('adminorder.detail.proof.of.payment.download') }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="proofOfPayment"
                                                                    value="{{ $orders->proof_of_payment }}">
                                                                <input type="hidden" name="inv_no"
                                                                    value="{{ $orders->invoice_no }}">
                                                                <button type="submit"
                                                                    class="btn btn-danger fs-14 my-md-3 mb-2">
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
                                <div class="d-flex justify-content-end">
                                    <div class="row my-3 text-end">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-danger fs-14 mb-2"
                                                data-bs-toggle="modal" data-bs-target="#paymentConfirm">
                                                Konfirmasi Pembayaran
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                {{-- @else
                                @endif --}}
                            </div>
                        </div>
                        <div class="modal fade" id="cancelOrder" tabindex="-1" aria-labelledby="cancelOrderModal"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-radius-1-5rem">
                                    <div class="modal-header border-0 pt-4 px-4">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('decline.payment') }}" method="post" class="d-inline">
                                        {{-- @method('delete') --}}
                                        @csrf
                                        <div class="modal-body text-center py-2 px-5">
                                            <h5 class="mb-3">Konfirmasi Penolakan Pembayaran Pesanan</h5>
                                            <p class="fs-14 mb-0">
                                                Berikan alasan/deskripsi penolakan pembayaran pesanan pembeli
                                            </p>
                                            <div class="form-floating mt-3">
                                                <input type="hidden" name="order_id" value="{{ $orders->id }}">
                                                <textarea class="form-control fs-14 h-100" placeholder="Tuliskan alasan pembatalan pesanan" id="cancel-order"
                                                    rows="6" required name="cancel_order_detail"></textarea>
                                                <label for="cancel-order" class="fs-14">Alasan Penolakan
                                                    Pembayaran
                                                    Pesanan
                                                </label>
                                                <div class="cancel_order_error_message fs-12 text-danger text-start my-1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 d-flex justify-content-center pb-4">
                                            <button type="button" class="btn btn-outline-secondary fs-14"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-danger fs-14 my-2 shadow-none">Tolak
                                                Pembayaran</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="paymentConfirm" tabindex="-1" aria-labelledby="paymentConfirmModal"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-radius-1-5rem">
                                    <div class="modal-header border-0 pt-4 px-4">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form class="confirm-payment-form" action="{{ route('confirm.payment') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body py-2 px-5">
                                            <h5 class="mb-3">Konfirmasi Pembayaran Pesanan</h5>
                                            <p class="fs-14 mb-0">
                                                Apakah anda yakin ingin mengonfirmasi pembayaran?
                                            </p>
                                            <div class="my-1">
                                                <label for="inputProofOfPaymentManual" class="form-label fs-14">Tambahkan
                                                    bukti
                                                    pembayaran *jika ada</label>
                                                <input class="form-control form-control-sm" id="inputProofOfPaymentManual"
                                                    type="file" onchange="previewImagePayment()"
                                                    name="proof_of_payment">
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <img class="img-preview w-100">
                                            </div>
                                            <p class="text-danger fs-13">
                                                *Ketika anda mengonfirmasi pembayaran maka anda tidak dapat
                                                membatalkan pesanan dan harus melakukan pengemasan serta pengiriman
                                                pesanan
                                            </p>
                                        </div>
                                        <div class="modal-footer border-0 d-flex justify-content-center pb-4">
                                            <button type="button" class="btn btn-outline-secondary fs-14"
                                                data-bs-dismiss="modal">Tutup</button>

                                            <input type="hidden" name="order_id" value="{{ $orders->id }}">
                                            <button type="submit"
                                                class="btn btn-danger fs-14 my-2 shadow-none">Konfirmasi
                                                Pembayaran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @elseif($orders->order_status === 'pengajuan pembatalan')
                        <div class="card fs-14 border-radius-1-5rem border-0 mb-4 box-shadow">
                            <div class="card-body p-4">
                                {{-- @if ($orders->order_status === 'pesanan dibayarkan') --}}
                                <p class=" fs-14 fw-bold m-0 mb-1">
                                    Konfirmasi Pembatalan Pesanan
                                </p>
                                <p class="fs-12 m-0 mb-4">
                                    Pembeli mengajukan pembatalan pesanan, pilih konfirmasi pembatalan untuk menyetujui
                                    pembatalan pesanan atau pilih tolak pembatalan untuk menolak pengajuan pembatalan
                                    pesanan oleh pembeli.
                                </p>
                                <div class="row mb-2">
                                    <div class="col-md-3 col-6">
                                        {{ ucwords($orders->order_status) }}
                                    </div>
                                    <div class="col-md-9 col-6 text-end text-danger">
                                        <p class="m-0">
                                            <span>
                                                {{ $orders->orderstatusdetail->last()->status_detail }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="row my-3 text-end">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-secondary fs-14 mb-2"
                                                data-bs-toggle="modal" data-bs-target="#rejectCancellation">
                                                Tolak Pembatalan
                                            </button>
                                            <button type="button" class="btn btn-danger fs-14 mb-2"
                                                data-bs-toggle="modal" data-bs-target="#cancellationConfirm">
                                                Konfirmasi Pembatalan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                {{-- @else
                            @endif --}}
                            </div>
                        </div>
                        <div class="modal fade" id="rejectCancellation" tabindex="-1"
                            aria-labelledby="rejectCancellationModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-radius-1-5rem">
                                    <div class="modal-header border-0 pt-4 px-4">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('decline.cancellation.order') }}" method="post"
                                        class="d-inline">
                                        {{-- @method('delete') --}}
                                        @csrf
                                        <div class="modal-body text-center py-2 px-5">
                                            <h5 class="mb-3">Tolak Pengajuan Pembatalan Pesanan</h5>
                                            <p class="fs-14 mb-0">
                                                Berikan alasan/deskripsi penolakan pengajuan pembatalan pesanan pembeli
                                            </p>
                                            <div class="form-floating mt-3">
                                                <input type="hidden" name="order_id" value="{{ $orders->id }}">
                                                <textarea class="form-control fs-14 h-100" placeholder="Tuliskan alasan pembatalan pesanan" id="cancel-order"
                                                    rows="6" required name="cancel_order_detail"></textarea>
                                                <label for="cancel-order" class="fs-14">
                                                    Alasan Penolakan
                                                </label>
                                                <div class="cancel_order_error_message fs-12 text-danger text-start my-1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 d-flex justify-content-center pb-4">
                                            <button type="button" class="btn btn-outline-secondary fs-14"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-danger fs-14 my-2 shadow-none">
                                                Tolak Pengajuan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="cancellationConfirm" tabindex="-1"
                            aria-labelledby="cancellationConfirmModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-radius-1-5rem">
                                    <div class="modal-header border-0 pt-4 px-4">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center py-2 px-5">
                                        <h5 class="mb-3">Konfirmasi Pengajuan Pembatalan Pesanan</h5>
                                        <p class="fs-14 mb-0">
                                            Apakah anda yakin ingin mengonfirmasi pengajuan pembatalan pesanan?
                                        </p>
                                        <small class="text-danger">
                                            *Ketika anda mengonfirmasi pengajuan pembatalan pesanan, maka anda tidak dapat
                                            membatalkan aksi
                                        </small>
                                    </div>
                                    <div class="modal-footer border-0 d-flex justify-content-center pb-4">
                                        <button type="button" class="btn btn-outline-secondary fs-14"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <form class="confirm-cancellation-payment-form"
                                            action="{{ route('confirm.cancellation.order') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $orders->id }}">
                                            <button type="submit"
                                                class="btn btn-danger fs-14 my-2 shadow-none">Konfirmasi
                                                Pembatalan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($orders->order_status != 'pesanan dikirim' &&
                        $orders->order_status != 'selesai' &&
                        $orders->order_status != 'expired' &&
                        $orders->order_status != 'pesanan dibatalkan')
                        <div class="card fs-14 border-radius-1-5rem border-0 mb-4 box-shadow">
                            <div class="card-body p-4">
                                {{-- @if ($orders->order_status === 'pesanan dibayarkan') --}}
                                <p class=" fs-14 fw-bold m-0 mb-1">
                                    Batalkan Pesanan
                                </p>
                                <p class="fs-12 m-0 mb-4">
                                    Batalkan pesanan pembeli
                                </p>
                                <div class="row mb-2">
                                    <div class="col-md-12 col-12">
                                        Anda dapat membatalkan pesanan pembeli saat status pesanan belum menjadi "pesanan
                                        dikirm"
                                    </div>
                                    {{-- <div class="col-md-3 col-12 text-end">
                                </div> --}}
                                </div>

                                <div class="d-flex justify-content-end">
                                    <div class="row my-3">
                                        <div class="col-md-12 col-12">
                                            <button type="button" class="btn btn-danger fs-14" data-bs-toggle="modal"
                                                data-bs-target="#cancelConfirm">
                                                Batalkan Pesanan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal fade" id="cancelConfirmPayment" tabindex="-1"
                    aria-labelledby="cancelConfirmPaymentModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-radius-1-5rem">
                            <div class="modal-header border-0 pt-4 px-4">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('decline.payment') }}" method="post" class="d-inline">
                                {{-- @method('delete') --}}
                                @csrf
                                <div class="modal-body text-center py-2 px-5">
                                    <h5 class="mb-3">Konfirmasi Penolakan Pembayaran Pesanan</h5>
                                    <p class="fs-14 mb-0">
                                        Berikan alasan/deskripsi penolakan pembayaran pesanan pembeli
                                    </p>
                                    <div class="form-floating mt-3">
                                        <input type="hidden" name="order_id" value="{{ $orders->id }}">
                                        <textarea class="form-control fs-14 h-100" placeholder="Tuliskan alasan pembatalan pesanan" id="cancel-order"
                                            rows="6" required name="cancel_order_detail"></textarea>
                                        <label for="cancel-order" class="fs-14">Alasan Penolakan
                                            Pembayaran
                                            Pesanan
                                        </label>
                                        <div class="cancel_order_error_message fs-12 text-danger text-start my-1">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 d-flex justify-content-center pb-4">
                                    <button type="button" class="btn btn-outline-secondary fs-14"
                                        data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-danger fs-14 my-2 shadow-none">Tolak
                                        Pembayaran</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="cancelConfirm" tabindex="-1" aria-labelledby="cancelConfirmModal"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-radius-1-5rem">
                            <div class="modal-header border-0 pt-4 px-4">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('cancel.order') }}" method="post" class="d-inline">
                                {{-- @method('delete') --}}
                                @csrf
                                <div class="modal-body text-center py-2 px-5">
                                    <h5 class="mb-3">Konfirmasi Pembatalan Pesanan</h5>
                                    <p class="fs-14 mb-0">
                                        Berikan alasan/deskripsi pembatalan pesanan pembeli
                                    </p>
                                    <div class="form-floating mt-3">
                                        <input type="hidden" name="order_id" value="{{ $orders->id }}">
                                        <textarea class="form-control fs-14 h-100" placeholder="Tuliskan alasan pembatalan pesanan" id="cancel-order"
                                            rows="6" required name="cancel_order_detail"></textarea>
                                        <label for="cancel-order" class="fs-14">
                                            Alasan Pembatalan Pesanan
                                        </label>
                                        <div class="cancel_order_error_message fs-12 text-danger text-start my-1">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 d-flex justify-content-center pb-4">
                                    <button type="button" class="btn btn-outline-secondary fs-14"
                                        data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-danger fs-14 my-2 shadow-none">
                                        Batalkan Pesanan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-12">
                    <div class="card fs-14 border-radius-1-5rem border-0 mb-4 box-shadow">
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
                                            {{ ucwords($orders->order_status) }}
                                        </span>
                                    </p>
                                    <p class="text-danger m-0 fs-12">
                                        {{-- <i class="bi bi-dash-lg"></i> --}}
                                        <span class="">
                                            {{ $orders->orderstatusdetail->last()->status_detail }}
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
                                        @if (!is_null($orders->invoice_no))
                                            {{ $orders->invoice_no }}
                                            @if (!is_null($orders->invoice_no))
                                                <a href="#" class="pe-auto text-dark"
                                                    onclick="Copy('{{ $orders->invoice_no }}')"><i class="far fa-copy"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="Salin no. invoice"></i>
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
                                        {{ \Carbon\Carbon::parse($orders->created_at)->isoFormat('D MMMM Y, HH:mm') }}
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
                                    @foreach ($orders->orderstatusdetail->sortByDesc('created_at') as $statusDetail)
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
                                                    <div class="{{ $loop->first ? 'text-danger fw-600' : '' }} fw-500">
                                                        {{ ucwords($statusDetail->status) }}
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
                                                    <div class="{{ $loop->first ? 'text-danger fw-600' : '' }} fw-500">
                                                        {{ ucwords($statusDetail->status) }}
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
                    <div class="card fs-14 border-radius-1-5rem border-0 mb-4 box-shadow">
                        <div class="card-body p-4">
                            <div class="row d-flex align-items-center justify-content-center text-center ">
                                <div class="col-md-8">
                                    <p class=" fs-14 fw-bold m-0 mb-3 text-start">Detail Produk</p>
                                    @foreach ($orders->orderitem as $item)
                                        <div class="row my-3">
                                            <div class="col-md-2 col-4 text-end">
                                                @if (!is_null($item->orderproduct->orderproductimage->first()))
                                                    <img src="{{ asset('/storage/' . $item->orderproduct->orderproductimage->first()->name) }}"
                                                        class="w-100 border-radius-5px my-1" alt="">
                                                @endif
                                            </div>
                                            <div class="col-md-10 col-8 ps-0">
                                                <div class="order-items-product-info text-start">
                                                    <div class=" order-items-product-name">
                                                        {{ $item->orderproduct->name }}
                                                    </div>
                                                    <div class=" order-items-product-variant text-grey">
                                                        Varian: {{ $item->orderproduct->variant_name }}
                                                    </div>
                                                    <div
                                                        class=" order-items-product-price-qty text-grey text-end text-md-start">
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
                                        Rp{{ price_format_rupiah($orders->total_price) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-12">
                    <div class="card fs-14 border-radius-1-5rem border-0 mb-4 box-shadow">
                        <div class="card-body p-4">
                            <p class="mb-3 fs-14 fw-bold">Alamat Pengirim</p>
                            <div class="row mb-2">
                                <div class="col-md-2 col-4">
                                    Alamat
                                </div>
                                <div class="col-md-10 col-8 d-flex">
                                    {{-- <span class="me-1">
                                                :
                                            </span> --}}
                                    <span>
                                        <p class="m-0 checkout-shipment-address-name">
                                            {{ $orders->senderaddress->name }}
                                        </p>
                                        <p class="m-0 checkout-shipment-address-phone">
                                            {{ $orders->senderaddress->telp_no }}
                                        </p>
                                        <p class="m-0 checkout-shipment-address-address">
                                            {{ $orders->senderaddress->address }}
                                        </p>
                                        <div class="checkout-shipment-address-city">
                                            <span class="m-0 me-1 ">
                                                {{ $orders->senderaddress->city->name }},
                                            </span>
                                            <span class="m-0 checkout-shipment-address-province">
                                                {{ $orders->senderaddress->province->name }}
                                            </span>
                                            <span class="m-0 checkout-shipment-address-postalcode">
                                                {{ !empty($orders->senderaddress->postal_code) ? ', ' . $orders->senderaddress->postal_code : '' }}
                                            </span>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            {{-- @if ($orders->order_status != 'pesanan dibatalkan')
                                <div class="row mb-2">
                                    <div class="col-md-2 col-4">
                                        Detail
                                    </div>
                                    <div class="col-md-10 col-8">
                                        <span class="fw-bold text-danger">
                                            <a href="#"
                                                class="text-decoration-none text-danger expand-detail-shipment-order fs-13"
                                                role="button" data-bs-toggle="button" aria-pressed="true">
                                                <span class="expand-detail-shipment-order-text">
                                                    Lihat Selengkapnya
                                                </span>
                                                <span>
                                                    <i class="bi bi-chevron-down expand-detail-shipment-order-chevron"></i>
                                                </span>
                                            </a>

                                        </span>
                                    </div>
                                </div>
                            @endif --}}

                            <div class="row px-2">
                                <div class="col-md-12 col-12 p-0 order-shipment-detail d-none">
                                    @if ($orders->orderdeliverystatus->count())
                                        @foreach ($orders->orderdeliverystatus->sortByDesc('created_at') as $deliveryStatus)
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
                                                        {{ \Carbon\Carbon::parse($deliveryStatus->delivery_date)->isoFormat('D MMMM Y, HH:mm') }}
                                                        WIB
                                                    </span>
                                                </div>
                                                <div class="col-md-1 col-1">
                                                    <i class="bi bi-dash-lg"></i>
                                                </div>
                                                <div class="col-md-7 col-6">
                                                    <span class="d-inline-block">
                                                        <div class="{{ $loop->first ? 'text-danger' : 'text-grey' }}">
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
                    <div class="card fs-14 border-radius-1-5rem border-0 mb-4 box-shadow">
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
                                            {{ ucwords($orders->courier) }} -
                                            {{ ucwords($orders->courier_package_type) }}
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
                                        {{ !is_null($orders->resi) ? $orders->resi : 'No. Resi belum terbit' }}
                                        @if (!is_null($orders->resi))
                                            <a href="#" class="pe-auto text-dark"
                                                onclick="Copy('{{ $orders->resi }}')"><i class="far fa-copy"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    title="Salin no. resi"></i>
                                            </a>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-4">
                                    Alamat
                                </div>
                                <div class="col-md-10 col-8 d-flex">
                                    {{-- <span class="me-1">
                                                :
                                            </span> --}}
                                    <span>
                                        <p class="m-0 checkout-shipment-address-name">
                                            {{ $orders->orderaddress->name }}
                                        </p>
                                        <p class="m-0 checkout-shipment-address-phone">
                                            {{ $orders->orderaddress->telp_no }}
                                        </p>
                                        <p class="m-0 checkout-shipment-address-address">
                                            {{ $orders->orderaddress->address }}
                                        </p>
                                        <div class="checkout-shipment-address-city">
                                            <span class="m-0 me-1 ">
                                                {{ $orders->orderaddress->city->name }},
                                            </span>
                                            <span class="m-0 checkout-shipment-address-province">
                                                {{ $orders->orderaddress->province->name }}
                                            </span>
                                            <span class="m-0 checkout-shipment-address-postalcode">
                                                {{ !empty($orders->orderaddress->postal_code) ? ', ' . $orders->orderaddress->postal_code : '' }}
                                            </span>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            {{-- @if ($orders->order_status != 'pesanan dibatalkan')
                                <div class="row mb-2">
                                    <div class="col-md-2 col-4">
                                        Detail
                                    </div>
                                    <div class="col-md-10 col-8">
                                        <span class="fw-bold text-danger">
                                            <a href="#"
                                                class="text-decoration-none text-danger expand-detail-shipment-order fs-13"
                                                role="button" data-bs-toggle="button" aria-pressed="true">
                                                <span class="expand-detail-shipment-order-text">
                                                    Lihat Selengkapnya
                                                </span>
                                                <span>
                                                    <i class="bi bi-chevron-down expand-detail-shipment-order-chevron"></i>
                                                </span>
                                            </a>

                                        </span>
                                    </div>
                                </div>
                            @endif --}}

                            <div class="row px-2">
                                <div class="col-md-12 col-12 p-0 order-shipment-detail d-none">
                                    @if ($orders->orderdeliverystatus->count())
                                        @foreach ($orders->orderdeliverystatus->sortByDesc('created_at') as $deliveryStatus)
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
                                                        {{ \Carbon\Carbon::parse($deliveryStatus->delivery_date)->isoFormat('D MMMM Y, HH:mm') }}
                                                        WIB
                                                    </span>
                                                </div>
                                                <div class="col-md-1 col-1">
                                                    <i class="bi bi-dash-lg"></i>
                                                </div>
                                                <div class="col-md-7 col-6">
                                                    <span class="d-inline-block">
                                                        <div class="{{ $loop->first ? 'text-danger' : 'text-grey' }}">
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
                    <div class="card fs-14 border-radius-1-5rem border-0 mb-4 box-shadow">
                        <div class="card-body p-4 pb-0">
                            <p class="mb-3 fs-14 fw-bold">Pembayaran</p>
                            <div class="row mb-2">
                                <div class="col-md-3 col-6">
                                    Metode Pembayaran
                                </div>
                                <div class="col-md-9 col-6 text-end">
                                    <p class="m-0">
                                        <span>
                                            {{ ucwords($orders->paymentmethod->type) }} -
                                            {{ ucwords($orders->paymentmethod->name) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            @if (!is_null($orders->proof_of_payment))
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
                                                    <img src="{{ asset('/storage/' . $orders->proof_of_payment) }}"
                                                        class="w-100 border-radius-5px" alt="">
                                                    <div class="d-md-flex mt-2">
                                                        <form action="{{ route('adminorder.detail.proof.of.payment') }} "
                                                            method="post" class="me-1" target="_blank">
                                                            @csrf
                                                            <input type="hidden" name="proofOfPayment"
                                                                value="{{ $orders->proof_of_payment }}">
                                                            <button type="submit"
                                                                class="btn btn-danger fs-14 my-md-3 mb-2">
                                                                <i class="bi bi-box-arrow-up-right"></i> Buka di
                                                                Halaman Baru
                                                            </button>
                                                        </form>
                                                        <form
                                                            action="{{ route('adminorder.detail.proof.of.payment.download') }}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" name="proofOfPayment"
                                                                value="{{ $orders->proof_of_payment }}">
                                                            <input type="hidden" name="inv_no"
                                                                value="{{ $orders->invoice_no }}">
                                                            <button type="submit"
                                                                class="btn btn-danger fs-14 my-md-3 mb-2">
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
                            {{-- @foreach ($orderItems as $item) --}}
                            <div class="row">
                                <div class="col-md-6 col-6">
                                    Total Harga ({{ $orderItems->count() }}) Produk
                                </div>
                                <div class="col-md-6 col-6 text-end">
                                    Rp{{ price_format_rupiah($orders->total_price) }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-7 checkout-payment-weight-text">
                                    Berat total: <span class="total-weight-checkout">{{ $weight }}
                                        kg</span>
                                </div>
                            </div>
                            {{-- @endforeach --}}
                            <div class="row">
                                <div class="col-md-6 col-6">
                                    Total Ongkos Kirim
                                </div>
                                <div class="col-md-6 col-6 text-end">
                                    Rp{{ price_format_rupiah($orders->courier_price) }}
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6 text-grey fs-12">
                                    {{ $orders->courier }} - {{ $orders->courier_package_type }}
                                    maksimal {{ $orders->estimation_day }} hari pengiriman
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-6">
                                    Kode Unik
                                </div>
                                <div class="col-md-6 col-6 text-end">
                                    Rp{{ price_format_rupiah($orders->unique_code) }}
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6 col-md-8 text-grey fs-12">
                                    Kode Unik digunakan untuk mempermudah dalam proses VERIFIKASI Pembayaran oleh
                                    Admin
                                    KLIKSPL
                                </div>
                            </div>

                            @if (!empty($orders->discount))
                                <div class="row">
                                    <div class="col-md-6 col-6">
                                        Diskon Promo
                                    </div>
                                    <div class="col-md-6 col-6 text-end">
                                        - Rp{{ price_format_rupiah($orders->discount) }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-9 text-grey fs-12">
                                        {{ $orders->UserPromoOrderUse->first()->promo_name }}
                                        ({{ $orders->UserPromoOrderUse->first()->promo_type }})
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent border-0 p-4 pt-0">
                            <div class=" mt-2 mb-3 border-bottom">
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-7">
                                    Total Pembayaran
                                </div>
                                <div class="col-md-6 col-5 text-end text-danger fw-bold">
                                    Rp{{ price_format_rupiah($orders->courier_price + $orders->total_price + $orders->unique_code - $orders->discount) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- @if ($orders->order_status != 'pesanan dibatalkan')
                    <div class="col-md-12 col-12">
                        <div class="card fs-14 border-radius-1-5rem border-0 mb-4 box-shadow">
                            <div class="card-body p-4">
                                <p class="mb-3 fs-14 fw-bold">Ajukan Pembatalan</p>
                                <div class="row mb-2">
                                    <div class="col-md-12 col-12">
                                        Ajukan pembatalan untuk pesanan ini dengan menyertakan alasan pembatalan,
                                        Tim
                                        Admin kami akan secepat mungkin merespon anda
                                    </div>
                                </div>
                                <div class="row mb-2 text-end">
                                    <div class="col-md-12 col-12">
                                        <a href="{{ route('order.show', $orders) }}" class="btn btn-danger fs-13">
                                            Ajukan Pembatalan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif --}}
            </div>
            {{-- @endforeach --}}
        </div>
        {{-- </div> --}}
    </div>
    <script>
        function previewImagePayment() {
            // mengambil sumber image dari input dengan id image
            const image = document.querySelector('#inputProofOfPaymentManual');

            // mengambil tag img dari class img-preview
            const imgPreview = document.querySelector('.img-preview');
            document.querySelector('.img-preview').classList.add('my-2');

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
            $('.shipping-receipt-btn').click(function() {
                var resi_input = $('input[name="resi-input"]').val();
                $('input[name="resi"]').val(resi_input);
                $('.shipping-receipt-text-modal').text(resi_input);
            });

            $('.expand-detail-order').click(function() {
                console.log($('.order-detail'));
                if ($('.order-detail').hasClass("d-none")) {
                    $('.order-detail').removeClass("d-none");
                } else {
                    $('.order-detail').addClass('d-none');
                }
                if ($('.expand-detail-order-chevron').hasClass("bi-chevron-up")) {
                    $('.expand-detail-order-text').text("Lihat Selengkapnya");
                    $('.expand-detail-order-chevron').removeClass("bi-chevron-up");
                    $('.expand-detail-order-chevron').addClass("bi-chevron-down");

                    console.log($('.expand-detail-order-chevron'));
                } else if ($('.expand-detail-order-chevron').hasClass("bi-chevron-down")) {
                    $('.expand-detail-order-text').text("Sembunyikan");
                    $('.expand-detail-order-chevron').removeClass("bi-chevron-down");
                    $('.expand-detail-order-chevron').addClass("bi-chevron-up");
                    console.log($('.expand-detail-order-chevron'));
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
                    console.log($('.expand-detail-shipment-order-text').text());
                    $('.expand-detail-shipment-order-text').text("Lihat Selengkapnya");
                    $('.expand-detail-shipment-order-chevron').removeClass("bi-chevron-up");
                    $('.expand-detail-shipment-order-chevron').addClass("bi-chevron-down");

                    console.log($('.expand-detail-shipment-order-chevron'));
                } else if ($('.expand-detail-shipment-order-chevron').hasClass("bi-chevron-down")) {
                    $('.expand-detail-shipment-order-text').text("Sembunyikan");
                    $('.expand-detail-shipment-order-chevron').removeClass("bi-chevron-down");
                    $('.expand-detail-shipment-order-chevron').addClass("bi-chevron-up");
                    console.log($('.expand-detail-shipment-order-chevron'));
                }
            });
        });
    </script>
@endsection
