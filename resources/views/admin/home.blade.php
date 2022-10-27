@extends('admin.layouts.main')
@section('container')
    {{-- {{ dd($orderStatistics) }} --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2">Dashboard</h1>
        {{-- <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar"></span>
                This week
            </button>
        </div> --}}
    </div>

    {{-- <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas> --}}
    <div class="container p-0 mb-5">
        <div class="card admin-card-dashboard border-radius-1-5rem">
            <div class="card-body p-4">
                <h5>Menu Cepat Pesanan</h5>
                <div class="row pt-2 pb-2 fs-14">
                    @if (auth()->guard('adminMiddle')->user()->admin_type == 1 || auth()->guard('adminMiddle')->user()->admin_type == 2)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 px-2 py-2">
                            <a class="text-decoration-none link-dark color-red-klikspl-hover"
                                href="{{ route('adminorder.index') }}">
                                <div class="card admin-card-dashboard border-radius-075rem box-shadow">
                                    <div class="card-body px-4">
                                        <i class="bi bi-cart fs-3"></i>
                                        <p class="mb-2 mt-1">
                                            Pesanan Dikeranjang
                                        </p>
                                        <h3>
                                            {{ count($cartItems) }}
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 px-2 py-2">
                            <a class="text-decoration-none link-dark color-red-klikspl-hover"
                                href="{{ route('adminorder.index', ['status=belum bayar']) }}">
                                <div class="card admin-card-dashboard border-radius-075rem box-shadow">
                                    <div class="card-body px-4">
                                        <i class="bi bi-credit-card admin-card-dashboard fs-3"></i>
                                        <p class="mb-2 mt-1">
                                            Menunggu Pembayaran
                                        </p>
                                        <h3>
                                            {{ count($waitingPayment) }}
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (auth()->guard('adminMiddle')->user()->admin_type == 1 || auth()->guard('adminMiddle')->user()->admin_type == 2 ||
                        auth()->guard('adminMiddle')->user()->admin_type == 3)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 px-2 py-2">
                            <a class="text-decoration-none link-dark color-red-klikspl-hover"
                                href="{{ route('adminorder.index', ['status=pesanan dibayarkan']) }}">
                                <div class="card admin-card-dashboard border-radius-075rem box-shadow">
                                    <div class="card-body px-4">
                                        <i class="bi bi-check-square fs-3"></i>
                                        <p class="mb-2 mt-1">
                                            Konfirmasi Pembayaran
                                        </p>
                                        <h3>
                                            {{ count($confirmPayment) }}
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (auth()->guard('adminMiddle')->user()->admin_type == 1 || auth()->guard('adminMiddle')->user()->admin_type == 2 ||
                        auth()->guard('adminMiddle')->user()->admin_type == 4)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 px-2 py-2">
                            <a class="text-decoration-none link-dark color-red-klikspl-hover"
                                href="{{ route('adminorder.index', ['status=pembayaran dikonfirmasi']) }}">
                                <div class="card admin-card-dashboard border-radius-075rem box-shadow">
                                    <div class="card-body px-4">
                                        <i class="bi bi-receipt fs-3"></i>
                                        <p class="mb-2 mt-1">
                                            Perlu Diproses
                                        </p>
                                        <h3>
                                            {{ count($mustBeProcess) }}
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 px-2 py-2">
                            <a class="text-decoration-none link-dark color-red-klikspl-hover"
                                href="{{ route('adminorder.index', ['status=pesanan disiapkan']) }}">
                                <div class="card admin-card-dashboard border-radius-075rem box-shadow">
                                    <div class="card-body px-4">
                                        <i class="bi bi-truck fs-3"></i>
                                        <p class="mb-2 mt-1">
                                            Perlu Dikirim
                                        </p>
                                        <h3>
                                            {{ count($mustBeSent) }}
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 px-2 py-2">
                            <a class="text-decoration-none link-dark color-red-klikspl-hover"
                                href="{{ route('adminorder.index', ['status=pesanan dikirim']) }}">
                                <div class="card admin-card-dashboard border-radius-075rem box-shadow">
                                    <div class="card-body px-4">
                                        <i class="bi bi-truck fs-3"></i>
                                        <p class="mb-2 mt-1">
                                            Dalam Pengiriman
                                        </p>
                                        <h3>
                                            {{ count($onDelivery) }}
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (auth()->guard('adminMiddle')->user()->admin_type == 1 || auth()->guard('adminMiddle')->user()->admin_type == 2)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 px-2 py-2">
                            <a class="text-decoration-none link-dark color-red-klikspl-hover"
                                href="{{ route('adminorder.index', ['status=sampai tujuan']) }}">
                                <div class="card admin-card-dashboard border-radius-075rem box-shadow">
                                    <div class="card-body px-4">
                                        <i class="bi bi-geo-alt fs-3"></i>
                                        <p class="mb-2 mt-1">
                                            Sampai Tujuan
                                        </p>
                                        <h3>
                                            {{ count($arrived) }}
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 px-2 py-2">
                            <a class="text-decoration-none link-dark color-red-klikspl-hover"
                                href="{{ route('adminorder.index', ['status=selesai']) }}">
                                <div class="card admin-card-dashboard border-radius-075rem box-shadow">
                                    <div class="card-body px-4">
                                        <i class="bi bi-cart-check fs-3"></i>
                                        <p class="mb-2 mt-1">
                                            Selesai
                                        </p>
                                        <h3>

                                            {{ count($finish) }}
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 px-2 py-2">
                            <a class="text-decoration-none link-dark color-red-klikspl-hover"
                                href="{{ route('adminorder.index', ['status=expired']) }}">
                                <div class="card admin-card-dashboard border-radius-075rem box-shadow">
                                    <div class="card-body px-4">
                                        <i class="bi bi-x-square fs-3"></i>
                                        <p class="mb-2 mt-1">
                                            Dibatalkan
                                        </p>
                                        <h3>
                                            {{ count($canceled) }}
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 px-2 py-2">
                            <a class="text-decoration-none link-dark color-red-klikspl-hover"
                                href="{{ route('admin.product.out.stock') }}">
                                <div class="card admin-card-dashboard border-radius-075rem box-shadow">
                                    <div class="card-body px-4">
                                        <i class="bi bi-archive fs-3"></i>
                                        <p class="mb-2 mt-1">
                                            Produk Habis
                                        </p>
                                        <h3>
                                            {{ count($outStock) }}
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container p-0 mb-3">
        <div class="card admin-card-dashboard border-radius-1-5rem">
            <div class="card-body p-4">
                <h5>Menu Cepat Promo</h5>
                <div class="row pt-2 pb-2 fs-14">
                    @if (auth()->guard('adminMiddle')->user()->admin_type == 1 || auth()->guard('adminMiddle')->user()->admin_type == 2)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 px-2 py-2">
                            <a class="text-decoration-none link-dark color-red-klikspl-hover"
                                href="{{ route('promovoucher.index') }}">
                                <div class="card admin-card-dashboard border-radius-075rem box-shadow">
                                    <div class="card-body px-4">
                                        <i class="bi bi-percent fs-3"></i>
                                        <p class="mb-2 mt-1">
                                            Promo Aktif
                                        </p>
                                        <h3>
                                            {{ count($activedPromo) }}
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 px-2 py-2">
                            <a class="text-decoration-none link-dark color-red-klikspl-hover"
                                href="{{ route('promovoucher.index') }}">
                                <div class="card admin-card-dashboard border-radius-075rem box-shadow">
                                    <div class="card-body px-4">
                                        <i class="bi bi-megaphone fs-3"></i>
                                        <p class="mb-2 mt-1">
                                            Promo Banner Aktif
                                        </p>
                                        <h3>
                                            {{ count($activedBannerPromo) }}
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
    </div>
    <div class="card border-radius-1-5rem admin-card-dashboard">
        <div class="card-body p-4">
            <h5>Statistik Penjualan</h5>
            <div class="row">
                <div class="col-12">
                    <canvas class="my-4 w-100" id="myChart" width="900" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function() {
            'use strict'

            feather.replace({
                'aria-hidden': 'true'
            })

            // Graphs
            var ctx = document.getElementById('myChart')
            // eslint-disable-next-line no-unused-vars
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [
                        'Sunday',
                        'Monday',
                        'Tuesday',
                        'Wednesday',
                        'Thursday',
                        'Friday',
                        'Saturday'
                    ],
                    datasets: [{
                        data: [
                            15339,
                            21345,
                            18483,
                            24003,
                            23489,
                            24092,
                            12034
                        ],
                        lineTension: 0,
                        backgroundColor: 'transparent',
                        borderColor: '#007bff',
                        borderWidth: 4,
                        pointBackgroundColor: '#007bff'
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: false
                            }
                        }]
                    },
                    legend: {
                        display: false
                    }
                }
            })
        })()
    </script>
@endsection
