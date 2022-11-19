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
    <div class="container p-0 row m-0">
        
        <div class="col-12 mb-4">
            <div class="card admin-card-dashboard border-radius-1-5rem box-shadow">
                <div class="card-body p-4">
                    <h4>Menu Cepat Pesanan</h4>
                    <div class="row pt-2 pb-2 fs-14">
                        @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                            auth()->guard('adminMiddle')->user()->admin_type == 2)
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
                        @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                            auth()->guard('adminMiddle')->user()->admin_type == 2 ||
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
                        @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                            auth()->guard('adminMiddle')->user()->admin_type == 2 ||
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
                        @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                            auth()->guard('adminMiddle')->user()->admin_type == 2)
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
        @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
            auth()->guard('adminMiddle')->user()->admin_type == 2)
            <div class="col-md-6 col-12 mb-4">
                <div class="card admin-card-dashboard border-radius-1-5rem box-shadow">
                    <div class="card-body p-4">
                        <h4>Menu Cepat Promo</h4>
                        <div class="row pt-2 pb-2 fs-14">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 px-2 py-2">
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
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 px-2 py-2">
                                <a class="text-decoration-none link-dark color-red-klikspl-hover"
                                    href="{{ route('promobanner.index') }}">
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12 mb-4">
                <div class="card admin-card-dashboard border-radius-1-5rem box-shadow">
                    <div class="card-body p-4">
                        <h4>Menu Cepat Komentar</h4>
                        <div class="row pt-2 pb-2 fs-14">
                            <div class="col-lg-7 col-md-7 col-sm-7 col-12 px-2 py-2">
                                <a class="text-decoration-none link-dark color-red-klikspl-hover"
                                    href="{{ route('productcomment.index') }}">
                                    <div class="card admin-card-dashboard border-radius-075rem box-shadow">
                                        <div class="card-body px-4">
                                            <i class="bi bi-chat-left-text fs-3"></i>
                                            <p class="mb-2 mt-1">
                                                Komentar belum ditanggapi
                                            </p>
                                            <h3>
                                                {{ $productCommentsCount }}
                                            </h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
            auth()->guard('adminMiddle')->user()->admin_type == 2 || auth()->guard('adminMiddle')->user()->admin_type == 3)
            <div class="col-md-12 col-12 mb-4">
                <a href="{{ route('admin.income') }}" class="text-decoration-none text-dark">
                    <div class="card border-0 h-100 border-radius-1-5rem fs-14 box-shadow">
                        <div class="card-body p-4">
                            <h4 class="fw-600 mb-3">
                                Informasi Penghasilan
                            </h4>
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
                                            <p class="mb-1">
                                                Penghasilan Bulan ini
                                            </p>
                                            <h3 class="fw-bold">
                                                Rp{{ price_format_rupiah($incomeThisMonth) }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-12 col-12 mb-4">
                <div class="card border-radius-1-5rem admin-card-dashboard box-shadow">
                    <div class="card-body p-4">
                        <h4>Penghasilan Perbulan</h4>
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <canvas class="my-4 w-100" id="myChart" width="900" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <script>
        $(window).focus(function() {
            window.location.reload();
        });
        $(document).ready(function() {
            var incomePerMonth = {!! json_encode($incomePerMonth) !!};
            console.log(typeof incomePerMonth);
            console.log({!! json_encode($incomePerMonth) !!});
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
                        labels: $.map(incomePerMonth, function(val, id) {
                                // return (val['month_year_income']);
                                return (new Date(val['month_year_income']).toLocaleDateString(
                                    'id', {
                                        year: 'numeric',
                                        month: 'long'
                                    }))
                            })
                            // 'Sunday',
                            // 'Monday',
                            // 'Tuesday',
                            // 'Wednesday',
                            // 'Thursday',
                            // 'Frida y',
                            // 'Saturday'
                            ,
                        datasets: [{
                            data: $.map(incomePerMonth, function(val, id) {
                                return ((val['total_income_per_month']));
                            }),
                            lineTension: 0,
                            backgroundColor: 'transparent',
                            borderColor: '#007bff',
                            borderWidth: 4,
                            pointBackgroundColor: '#007bff',
                            label: 'Data Penjualan Perbulan'
                        }]
                    },
                    options: {
                        locale: 'id',
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: false,
                                    callback: (value, index, values) => {
                                        // console.log(value);
                                        // console.log(index);
                                        // console.log(values);
                                        return new Intl.NumberFormat('id', {
                                            style: 'currency',
                                            currency: 'IDR',
                                            maximumSignificantDigits: 3
                                        }).format(value)
                                    }
                                }
                            }]
                        },
                        tooltips: {
                            enabled: true,
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var label = data.labels[tooltipItem.index];
                                    var val = data.datasets[tooltipItem.datasetIndex].data[
                                        tooltipItem.index];
                                    return new Intl.NumberFormat('id', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        maximumSignificantDigits: 3
                                    }).format(val);
                                }
                            }

                        },
                        // plugins: {
                        // tooltip: {
                        //     callbacks: {
                        //         labels: function(context) {
                        //             let label = context.dataset.labels || '';
                        //             console.log(label);
                        //             if (label) {
                        //                 label += ': ';
                        //             }
                        //             if (context.parsed.y !== null) {
                        //                 label += new Intl.NumberFormat('id', {
                        //                     style: 'currency',
                        //                     currency: 'IDR'
                        //                 }).format(context.parsed.y);
                        //             }
                        //             return label;
                        //         }
                        //     }
                        // },
                        // },
                        legend: {
                            display: false
                        }
                    }
                })
            })()
        });
    </script>
@endsection
