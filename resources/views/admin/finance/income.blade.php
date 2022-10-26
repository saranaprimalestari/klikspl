@extends('admin.layouts.main')
@section('container')
    {{-- {{ dd($incomeValues) }} --}}
    @if (session()->has('addSuccess'))
        <div class="alert alert-success alert-dismissible fade show alert-notification" role="alert">
            {{ session('addSuccess') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session()->has('addFailed'))
        <div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">
            {{ session('addFailed') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2">Penghasilan Saya</h1>
    </div>
    @if ($errors->any())
        {!! implode(
            '',
            $errors->all(
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">:message<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
            ),
        ) !!}
    @endif
    <div class="alert-notification-wrapper" id="alert-notification-wrapper">
    </div>
    <div class="container p-0">
        <div class="row">
            <div class="col-md-9 col-12 mb-4">
                <div class="card border-0 h-100 border-radius-1-5rem fs-14">
                    <div class="card-body p-4">
                        <h6 class="fw-600 mb-3">
                            Informasi Penghasilan
                        </h6>
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="card h-100 border-radius-075rem box-shadows border-0">
                                            <div class="card-body p-4">
                                                <div class="row align-items-center">
                                                    <div class="col-2">
                                                        <i class="bi bi-wallet fs-1 text-red-klikspl"></i>
                                                    </div>
                                                    <div class="col-9">
                                                        <p class="mb-1">
                                                            Total Penghasilan Saya
                                                        </p>
                                                        <h2 class="fw-bold text-red-klikspl">
                                                            Rp{{ price_format_rupiah($incomeValues) }}
                                                        </h2>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 py-4">
                                        {{-- <div class="card h-100 border-radius-075rem box-shadows border-0">
                                    <div class="card-body px-4"> --}}
                                        <p class="mb-1">
                                            Penghasilan Bulan ini
                                        </p>
                                        <h3 class="fw-bold">
                                            Rp{{ price_format_rupiah($incomeThisMonth) }}
                                        </h3>
                                        {{-- </div>
                                </div> --}}
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-4 col-6">
                        <p class="mb-1">
                            Total Penghasilan Saya
                        </p>
                        <h2 class="fw-bold">
                            Rp{{ price_format_rupiah($incomeValues) }}
                        </h2>
                    </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-12 mb-4">
                <div class="card border-0 h-100 border-radius-1-5rem fs-14">
                    <div class="card-body p-4">
                        <h6 class="fw-600 mb-3">
                            Laporan Penghasilan
                        </h6>
                        <div class="row">
                            <div class="col-md-12 col-12">
                                @foreach ($incomesPerMonth->take(3)->sortByDesc('month_year_income') as $incomeReport)
                                    <div class="mb-1">
                                        {{ \Carbon\Carbon::parse($incomeReport->month_year_income)->isoFormat('MMMM Y') }}
                                        <i class="bi bi-download"></i>
                                    </div>
                                @endforeach
                                <a href="#income-report" class="text-decoration-none text-danger fw-600">Lihat Semua</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container p-0 mb-4">
        <div class="card border-0 border-radius-1-5rem fs-14">
            <div class="card-body p-4">
                <h6 class="fw-600 mb-3">
                    Detail Penghasilan
                </h6>
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link link-dark active" id="nav-total-income-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-total-income" type="button" role="tab"
                                    aria-controls="nav-total-income" aria-selected="true">Total
                                    Penghasilan
                                </button>
                                <button class="nav-link link-dark" id="nav-this-month-income-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-this-month-income" type="button" role="tab"
                                    aria-controls="nav-this-month-income" aria-selected="false">Bulan
                                    ini
                                </button>
                                <button class="nav-link link-dark" id="nav-per-month-income-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-per-month-income" type="button" role="tab"
                                    aria-controls="nav-per-month-income" aria-selected="false">Perbulan
                                </button>
                                <button class="nav-link link-dark" id="nav-per-month-income-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-per-payment-method-income" type="button" role="tab"
                                    aria-controls="nav-per-payment-method-income" aria-selected="false">per Metode Pembayaran
                                </button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-total-income" role="tabpanel"
                                aria-labelledby="nav-total-income-tab">
                                <div class="table-responsive">
                                    <table id="totalIncome"
                                        class="table hover fs-14 nowrap table-borderless table-hover cell-border order-column"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="min-mobile">No</th>
                                                {{-- <th class="min-mobile">Pesanan</th> --}}
                                                <th class="min-mobile">No. Invoice</th>
                                                <th class="min-mobile">Status</th>
                                                <th class="min-mobile">Metode Pembayaran</th>
                                                <th class="not-mobile">Total Pembayaran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr class="">
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('adminorder.show', $order) }}"
                                                            class="fs-13 my-1 mx-1 me-2 text-decoration-none link-dark">
                                                            {{ $order->invoice_no }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $order->order_status }}
                                                    </td>
                                                    <td>
                                                        {{ $order->paymentmethod->type }}
                                                        {{ $order->paymentmethod->name }}
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            Rp{{ price_format_rupiah($order->courier_price + $order->total_price + $order->unique_code - $order->discount) }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-this-month-income" role="tabpanel"
                                aria-labelledby="nav-this-month-income-tab">
                                <div class="table-responsive">
                                    <table id="totalIncomeThisMonth"
                                        class="table hover fs-14 nowrap table-borderless table-hover cell-border order-column"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="min-mobile">No</th>
                                                <th class="min-mobile">No. Invoice</th>
                                                <th class="min-mobile">Status</th>
                                                <th class="min-mobile">Metode Pembayaran</th>
                                                <th class="not-mobile">Total Pembayaran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ordersThisMonth as $orderThisMonth)
                                                <tr class="">
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('adminorder.show', $orderThisMonth) }}"
                                                            class="fs-13 my-1 mx-1 me-2 text-decoration-none link-dark">
                                                            {{ $orderThisMonth->invoice_no }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $orderThisMonth->order_status }}
                                                    </td>
                                                    <td>
                                                        {{ $orderThisMonth->paymentmethod->type }}
                                                        {{ $orderThisMonth->paymentmethod->name }}
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            Rp{{ price_format_rupiah($orderThisMonth->courier_price + $orderThisMonth->total_price + $orderThisMonth->unique_code - $orderThisMonth->discount) }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-per-month-income" role="tabpanel"
                                aria-labelledby="nav-per-month-income-tab">
                                <div class="table-responsive">
                                    <table id="totalIncomePerMonth"
                                        class="table hover fs-14 nowrap table-borderless table-hover cell-border order-column"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="min-mobile">No</th>
                                                <th class="min-mobile">Periode</th>
                                                <th class="not-mobile">Total Penghasilan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($incomesPerMonth as $incomePerMonth)
                                                <tr class="">
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($incomePerMonth->month_year_income)->isoFormat('MMMM Y') }}
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            Rp{{ price_format_rupiah($incomePerMonth->total_income_per_month) }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-per-payment-method-income" role="tabpanel"
                                aria-labelledby="nav-per-payment-method-income-tab">
                                <div class="table-responsive">
                                    <table id="totalIncomePerPaymentMethod"
                                        class="table hover fs-14 nowrap table-borderless table-hover cell-border order-column"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="min-mobile">No</th>
                                                <th class="min-mobile">Metode Pembayaran</th>
                                                <th class="min-mobile">Nama Rekening</th>
                                                <th class="not-mobile">Total Penghasilan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($incomesPerPaymentMethod as $incomePerPaymentMethod)
                                                <tr class="">
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>
                                                       {{ $incomePerPaymentMethod->paymentmethod->type }}
                                                       {{ $incomePerPaymentMethod->paymentmethod->name }}
                                                    </td>
                                                    <td>
                                                       {{ $incomePerPaymentMethod->paymentmethod->account_name }}
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            Rp{{ price_format_rupiah($incomePerPaymentMethod->total_income_per_payment_method) }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container p-0 mb-4 income" id="income-report">
        <div class="card border-0 border-radius-1-5rem fs-14">
            <div class="card-body p-4">
                <h6 class="fw-600 mb-3">
                    Unduh Laporan Penghasilan
                </h6>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var table = $('#totalIncome').DataTable({
                columnDefs: [{
                        "targets": 0,
                        "className": "text-start",
                        // "width": "4%"
                    },
                    {
                        "targets": 1,
                        "className": "text-center",
                        // "width": "4%"
                    },
                    {
                        "targets": 2,
                        "className": "text-center",
                        // "width": "4%"
                    },
                    {
                        "targets": 3,
                        "className": "text-center",
                    },
                    {
                        "targets": 4,
                        "className": "text-center",
                    },
                ],
            });
            var tableThisMonth = $('#totalIncomeThisMonth').DataTable({
                columnDefs: [{
                        "targets": 0,
                        "className": "text-start",
                        // "width": "4%"
                    },
                    {
                        "targets": 1,
                        "className": "text-center",
                        // "width": "4%"
                    },
                    {
                        "targets": 2,
                        "className": "text-center",
                        // "width": "4%"
                    },
                    {
                        "targets": 3,
                        "className": "text-center",
                    },
                    {
                        "targets": 4,
                        "className": "text-center",
                    },
                ],
            });
            var tablePerMonth = $('#totalIncomePerMonth').DataTable({
                columnDefs: [{
                        "targets": 0,
                        "className": "text-start",
                        // "width": "4%"
                    },
                    {
                        "targets": 1,
                        "className": "text-center",
                        // "width": "4%"
                    },
                    {
                        "targets": 2,
                        "className": "text-center",
                        // "width": "4%"
                    },

                ],
            });
            var tablePerPaymentMethod = $('#totalIncomePerPaymentMethod').DataTable({
                columnDefs: [{
                        "targets": 0,
                        "className": "text-start",
                        // "width": "4%"
                    },
                    {
                        "targets": 1,
                        "className": "text-center",
                        // "width": "4%"
                    },
                    {
                        "targets": 2,
                        "className": "text-center",
                        // "width": "4%"
                    },
                    {
                        "targets": 3,
                        "className": "text-center",
                        // "width": "4%"
                    },

                ],
            });
        })
    </script>
@endsection
