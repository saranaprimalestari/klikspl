@extends('admin.layouts.main')
@section('container')
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
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1 mt-sm-0 mt-5">
        <h1 class="h2">{{ $header }}</h1>
    </div>
    {{-- {{ dd(auth()->guard('adminMiddle')->user()) }} --}}
    {{-- {{ dd($orders) }} --}}
    {{-- {{ print_r(request('status')) }}
    {{ print_r(request('date_start')) }}
    {{ print_r(request('date_end')) }} --}}
    {{-- {{ print_r(request('orderBy')) }} --}}
    <div class="container p-0 mb-5">
        <div class="card border-radius-1-5rem fs-14 border-0">
            <div class="card-header bg-transparent px-4 py-3 pb-1 border-bottom-0">
                <h5>Filter</h5>
            </div>
            <div class="card-body p-4 pt-2">
                <form class="status-form" action="{{ route('adminorder.index') }}" method="GET">
                    @csrf
                    {{-- <input type="hidden" name="status" value="pesanan dibayarkan"> --}}
                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="row gx-3 gy-2 align-items-center mb-4">

                        <div class="col-md-3 col-12">
                            <label class="form-label" for="startDate">Pencarian</label>
                            <input type="text" class="form-control form-control-sm fs-14 border-radius-05rem shadow-none" id="searchKeyword" placeholder="Cari nama produk, pembeli, nomor resi"
                            aria-label="Cari nama produk, pembeli, nomor resi" aria-describedby="basic-addon2"
                            name="search">
                        </div>
                        <div class="col-md-3 col-12">
                            <label class="form-label" for="startDate">Tanggal Awal</label>
                            <input type="date" class="form-control form-control-sm fs-14 border-radius-05rem shadow-none"
                                id="startDate" name="date_start"
                                value="{{ !is_null(request('date_start')) ? request('date_start') : '' }}">
                        </div>
                        <div class="col-md-3 col-12">
                            <label class="form-label" for="endDate">Tanggal Akhir</label>
                            <input type="date" class="form-control form-control-sm fs-14 border-radius-05rem shadow-none"
                                id="endDate" name="date_end"
                                value="{{ !is_null(request('date_end')) ? request('date_end') : '' }}">
                        </div>
                        <div class="col-md-3 col-12">
                            <label class="form-label" for="Filter">Urut Berdasarkan</label>
                            <select class="form-select form-select-sm border-radius-05rem shadow-none" id="Filter"
                                name="orderBy">
                                <option value="" disabled selected>Filter <i class="bi bi-funnel"></i></option>
                                <option value="asc"
                                    {{ !is_null(request('orderBy')) && request('orderBy') == 'asc' ? 'selected' : '' }}>
                                    Pesanan terlama</option>
                                <option value="desc"
                                    {{ !is_null(request('orderBy')) && request('orderBy') == 'desc' ? 'selected' : '' }}>
                                    Pesanan terbaru</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <a href="{{ route('adminorder.index') }}" class="btn btn-secondary fs-14 filter-btn">Bersihkan
                                Filter</a>
                            <button type="submit" class="btn btn-danger fs-14 filter-btn ms-1 submit-button">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- <div class="container p-0 mb-3">
        <div class="card border-radius-1-5rem fs-14 border-0">
            <div class="card-body p-4 pt-2">
                <div class="col-sm-3 my-3 fs-14">
                    <label class="form-label" for="searchKeyword">Cari produk, pembeli, no resi</label>
                    <input type="text" class="form-control form-control-sm fs-14 border-radius-05rem shadow-none"
                        id="searchKeyword" placeholder="Cari nama produk, pembeli, nomor resi" name="search">
                </div>
            </div>
        </div>
    </div> --}}

    @if (count($orders) > 0)
        {{-- <div class="container p-0 mb-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group me-3">
                        <div class="input-group fs-14">
                            <input type="text" class="form-control border-radius-1-75rem fs-14 shadow-none border-end-0"
                                id="searchKeyword" placeholder="Cari nama produk, pembeli, nomor resi"
                                aria-label="Cari nama produk, pembeli, nomor resi" aria-describedby="basic-addon2"
                                name="search">
                            <span class="input-group-text border-radius-1-75rem fs-14 bg-white border-start-0"
                                id="basic-addon2"><i class="bi bi-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        @foreach ($orders as $order)
            <div class="container p-0 mb-3">
                <div class="card border-radius-1-5rem fs-14 border-0 card-product-order">
                    {{-- <a href="{{ route('adminorder.show', $order) }}" class="text-decoration-none text-dark"> --}}
                    <div class="card-header bg-transparent px-4 py-3 border-bottom-0">
                        <a href="{{ route('adminorder.show', $order) }}" class="text-decoration-none text-dark">
                            <div class="row">
                                <div class="col-md-4 py-2 col-6 fw-600">
                                    @if ($order->order_status === 'expired' || $order->order_status === 'pembayaran ditolak')
                                        <span class="badge bg-danger">
                                            {{ ucwords($order->order_status) }}
                                        </span>
                                    @elseif ($order->order_status === 'pesanan dibatalkan')
                                        <span class="badge bg-danger">
                                            {{ ucwords($order->order_status) }}
                                        </span>
                                    @elseif($order->order_status === 'pesanan dibayarkan' ||
                                        $order->order_status === 'pembayaran dikonfirmasi' ||
                                        $order->order_status === 'upload ulang bukti pembayaran' ||
                                        $order->order_status === 'pesanan disiapkan' ||
                                        $order->order_status === 'pesanan dikirim')
                                        <span class="badge bg-warning ">
                                            {{ ucwords($order->order_status) }}
                                        </span>
                                    @elseif ($order->order_status === 'selesai')
                                        <span class="badge bg-success">
                                            {{ ucwords($order->order_status) }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary ">
                                            {{ ucwords($order->order_status) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-8 fs-13 py-2 col-6 text-end">
                                    <span class="">
                                        {{-- {{ isset($order->invoice_no) }} --}}
                                        @if (isset($order->invoice_no))
                                            {{ $order->invoice_no }}
                                        @else
                                            No Inv belum terbit
                                        @endif
                                    </span>
                                    <span class="mx-1">
                                        /
                                    </span>
                                    <span class="">
                                        {{ $order->orderaddress->name }}
                                    </span>
                                    <span class="mx-1">
                                        /
                                    </span>
                                    <span class="">
                                        {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('D MMM Y, HH:mm') }} WIB
                                    </span>
                                </div>
                                <input type="hidden" name="order_date"
                                    value="{{ \Carbon\Carbon::parse($order->created_at)->isoFormat('Y-MM-D') }}">
                            </div>
                            <div class="created-date d-none">
                                {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('Y-MM-D') }}
                            </div>
                        </a>
                    </div>
                    <div class="card-body px-4 py-2">
                        <div class="row">
                            <div class="col-md-5">
                                <a href="{{ route('adminorder.show', $order) }}" class="text-decoration-none text-dark">
                                    <div class="row">
                                        <div class="col-md-2 col-3 pe-0">
                                            @if (!is_null($order->orderitem[0]->orderproduct->orderproductimage->first()))
                                                <img src="{{ asset('/storage/' . $order->orderitem[0]->orderproduct->orderproductimage->first()->name) }}"
                                                    class="w-100 border-radius-5px {{ $order->order_status == 'pesanan dibatalkan' || $order->order_status == 'expired' ? 'grayscale-filter' : '' }}"
                                                    alt="">
                                            @endif
                                        </div>
                                        <div class="col-md-10 col-9">
                                            <div class=" order-items-product-name fw-600">
                                                {{ $order->orderitem[0]->orderproduct->name }}
                                            </div>
                                            <div class="text-truncate order-items-product-variant text-grey fs-12">
                                                Varian:
                                                {{ !is_null($order->orderitem[0]->orderproduct->variant_name) ? $order->orderitem[0]->orderproduct->variant_name : 'Tidak ada Varian' }}
                                            </div>
                                            <div
                                                class="text-truncate order-items-product-price-qty text-grey text-end text-md-start fs-12">
                                                {{ $order->orderitem[0]->quantity }} x
                                                Rp{{ price_format_rupiah($order->orderitem[0]->orderproduct->price) }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="row">
                                    <div class="col-12">
                                        @if (count($order->orderitem) > 1)
                                            <div class="accordion accordion-flush"
                                                id="accordionAdminProduct-{{ $loop->iteration }}">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingOne">
                                                        <button
                                                            class="accordion-button collapsed p-0 fs-14 shadow-none text-danger pt-2"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#accordion-product-order-{{ $loop->iteration }}"
                                                            aria-expanded="false"
                                                            aria-controls="accordion-product-order-{{ $loop->iteration }}">
                                                            Lihat {{ count($order->orderitem) - 1 }} produk lainnya
                                                        </button>
                                                    </h2>
                                                    <a href="{{ route('adminorder.show', $order) }}"
                                                        class="text-decoration-none text-dark">
                                                        <div id="accordion-product-order-{{ $loop->iteration }}"
                                                            class="accordion-collapse collapse"
                                                            aria-labelledby="flush-headingOne"
                                                            data-bs-parent="#accordionAdminProduct-{{ $loop->iteration }}">
                                                            <div class="accordion-body p-0 py-3">
                                                                @foreach ($order->orderitem->skip(1) as $item)
                                                                    <div class="row py-2">
                                                                        <div class="col-md-2 col-3 pe-0">
                                                                            @if (!is_null($item->orderproduct->orderproductimage->first()))
                                                                                <img src="{{ asset('/storage/' . $item->orderproduct->orderproductimage->first()->name) }}"
                                                                                    class="w-100 border-radius-5px {{ $order->order_status == 'pesanan dibatalkan' || $order->order_status == 'expired' ? 'grayscale-filter' : '' }}"
                                                                                    alt="">
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-md-10 col-9">
                                                                            <div class=" order-items-product-name fw-600">
                                                                                {{ $item->orderproduct->name }}
                                                                            </div>
                                                                            <div
                                                                                class="text-truncate order-items-product-variant text-grey fs-12">
                                                                                Varian:
                                                                                {{ !is_null($item->orderproduct->variant_name) ? $item->orderproduct->variant_name : 'Tidak ada Varian' }}
                                                                            </div>
                                                                            <div
                                                                                class="text-truncate order-items-product-price-qty text-grey text-end text-md-start fs-12">
                                                                                {{ $item->quantity }} x
                                                                                Rp{{ price_format_rupiah($item->orderproduct->price) }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('adminorder.show', $order) }}" class="text-decoration-none text-dark">
                                    <div>
                                        <div class="fw-600">
                                            Alamat
                                        </div>
                                        <div class="fs-12">
                                            {{ $order->orderaddress->name }}
                                        </div>
                                        <div class="fs-12">
                                            {{ $order->orderaddress->address }}
                                        </div>
                                        <div class="fs-12">
                                            {{ $order->orderaddress->telp_no }}
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('adminorder.show', $order) }}" class="text-decoration-none text-dark">
                                    <div class="pt-2">
                                        <div class="fw-600">
                                            Pengirim
                                        </div>
                                        <div class="fs-12">
                                            {{ $order->senderAddress->name }}
                                        </div>
                                        <div class="fs-12">
                                            {{ $order->senderAddress->address }}
                                        </div>
                                        <div class="fs-12">
                                            {{ $order->senderAddress->telp_no }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('adminorder.show', $order) }}" class="text-decoration-none text-dark">
                                    <div class="fw-600">
                                        Kurir
                                    </div>
                                    <div class="fs-12">
                                        {{ $order->courier }}
                                        {{ $order->courier_package_type }}
                                    </div>
                                    <div class="fs-12">
                                        Perkiraan tiba dalam {{ $order->estimation_day }} hari /
                                        {{ \Carbon\Carbon::parse($order->estimation_date)->isoFormat('dddd,D MMMM Y') }}
                                    </div>
                                    <div class="fw-600 pt-2">
                                        No Resi
                                    </div>
                                    <div class="fs-12">
                                        @if (isset($order->resi))
                                        <div class="badge bg-secondary">
                                            {{ $order->resi }}
                                        </div>
                                        @else
                                            belum terbit
                                        @endif
                                    </div>
                                </a>
                            </div>
                            {{-- <div class="col-md-2 text-center">
                                <div class="fw-600">
                                    Status Pesanan
                                </div>
                                <div class="fs-12">
                                    @if ($order->order_status === 'expired')
                                        <span class="badge bg-danger">
                                            {{ ucwords($order->order_status) }}
                                        </span>
                                    @elseif($order->order_status === 'pesanan dibayarkan')
                                        <span class="badge bg-success">
                                            {{ ucwords($order->order_status) }}
                                        </span>
                                    @else
                                        {{ ucwords($order->order_status) }}
                                    @endif
                                    </div>
                                </div> --}}
                            <div class="col-md-2 text-end">
                                <a href="{{ route('adminorder.show', $order) }}" class="text-decoration-none text-dark">
                                    <div class="fw-600">
                                        Total Pesanan
                                    </div>
                                    <div class="fs-14 text-red-klikspl">
                                        Rp{{ price_format_rupiah($order->courier_price + $order->total_price + $order->unique_code - $order->discount) }}
                                    </div>
                                </a>
                            </div>
                        </div>
                        @if ($order->order_status === 'pesanan dibatalkan')
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="alert alert-danger mb-0 fs-12" role="alert">
                                        {{-- {{ $order->orderstatusdetail->last()->status_detail }} --}}
                                        {{-- {{ strpos($order->orderstatusdetail->last()->status_detail, "Alasan") }} --}}
                                        {{-- {{ strpos($order->orderstatusdetail->last()->status_detail, ":") }} --}}
                                        {{ substr($order->orderstatusdetail->last()->status_detail, strpos($order->orderstatusdetail->last()->status_detail, 'Alasan'), strpos(substr($order->orderstatusdetail->last()->status_detail, strpos($order->orderstatusdetail->last()->status_detail, 'Alasan')), ':')) }}
                                        {{-- <br> --}}
                                        <span class="fw-bold">
                                            {{ substr($order->orderstatusdetail->last()->status_detail, strpos($order->orderstatusdetail->last()->status_detail, ':') + 1) }}
                                        </span>
                                        {{-- {{ substr('Pesanan akan dihapus otomatis 60 hari setelah hari pembatalan. Alasan pembatalan: test',strpos($order->orderstatusdetail->last()->status_detail, "Alasan"),strpos(strpos($order->orderstatusdetail->last()->status_detail, "Alasan"), "pemabta")) }} --}}
                                        {{-- {{ substr('Pesanan akan dihapus otomatis 60 hari setelah hari pembatalan. Alasan pembatalan: test',strpos($order->orderstatusdetail->last()->status_detail, ": ")) }} --}}
                                    </div>
                                </div>
                            </div>
                        @elseif($order->order_status === 'expired')
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="alert alert-danger mb-0 fs-12" role="alert">
                                        Pesanan kedaluwarsa! Pembeli tidak membayar pesanan sesuai dengan batas pembayaran 1
                                        x 24 jam
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-transparent px-4 py-3 border-top-0">
                        {{-- <div class="d-flex justify-content-end"> --}}
                        <div class="row">
                            <div class="col-md-6 col-7">
                                @if (auth()->guard('adminMiddle')->user()->admon_type == 1)
                                    {{ $order->senderaddress->name }}
                                @endif
                            </div>
                            <div class="col-md-6 col-5 text-end">
                                {{-- <a href="{{ route('order.show', $order) }}" class="btn btn-danger fs-13 my-1 mx-1"> --}}
                                {{-- <a href="{{ route('order.show', $order) }}" class="text-red-klikspl fs-14 py-2 fw-600 text-decoration-none">
                                            <i class="bi bi-receipt"></i> Detail Pesanan
                                        </a> --}}
                                <a href="{{ route('adminorder.show', $order) }}"
                                    class="text-danger fs-13 my-1 mx-1 me-2 text-decoration-none fw-bold">
                                    <i class="bi bi-receipt"></i> Detail Pesanan
                                </a>
                                {{-- </a> --}}
                            </div>
                        </div>
                        {{-- </div> --}}
                    </div>
                    {{-- </a> --}}
                </div>
            </div>
        @endforeach
    @else
    @endif

    <div class="d-flex justify-content-end mb-5">
        {{ $orders->links() }}
    </div>

    <script>
         $(window).focus(function() {
            window.location.reload();
        });
        $(document).ready(function(){
            $('#searchKeyword').on("keyup", function() {
                // $('.filter-btn').on("click", function() {
                // var search = $(this).val().toLowerCase();
                var search = $('input[name="search"]').val().toLowerCase();
                $(".card-product-order").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(search) > -1);
                    // });
                });
            });
            $('.status-form').submit(function(e) {
                console.log(e);
                $('.submit-button').append(
                    '<span class="ms-2 spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                );
                $('.submit-button').attr('disabled', true);

                // e.preventDefault();
            })
        });
    </script>
@endsection
