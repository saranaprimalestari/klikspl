@extends('admin.layouts.main')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2">Statistik</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12 mb-4">
                <div class="card admin-card-dashboard border-radius-1-5rem box-shadow">
                    <div class="card-body p-4">
                        <h4>Pengujung</h4>
                        <div class="row pt-2 pb-2 fs-14">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-6 px-2 py-2">
                                <div class="card admin-card-dashboard border-radius-075rem ">
                                    <div class="card-body px-4">
                                        <i class="bi bi-calendar2-event fs-3"></i>
                                        <p class="mb-2 mt-1">
                                            Hari ini
                                        </p>
                                        <h3>
                                            {{ count($visitorDay) }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-6 px-2 py-2">
                                <div class="card admin-card-dashboard border-radius-075rem ">
                                    <div class="card-body px-4">
                                        <i class="bi bi-calendar2-week fs-3"></i>
                                        <p class="mb-2 mt-1">
                                            Bulan ini
                                        </p>
                                        <h3>
                                            {{ count($visitorThisMonth) }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-6 px-2 py-2">
                                <div class="card admin-card-dashboard border-radius-075rem ">
                                    <div class="card-body px-4">
                                        <i class="bi bi-calendar2-range fs-3"></i>
                                        <p class="mb-2 mt-1">
                                            Total
                                        </p>
                                        <h3>
                                            {{ count($visitorTotal) }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-12 mb-4">
                <div class="card border-radius-1-5rem admin-card-dashboard box-shadow">
                    <div class="card-body p-4">
                        <h4>Pengunjung Perbulan</h4>
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <canvas class="my-4 w-100" id="visitorPerMonth" width="900" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-12 mb-4">
                <div class="card border-radius-1-5rem admin-card-dashboard box-shadow">
                    <div class="card-body p-4">
                        <h4>Penghasilan Perbulan</h4>
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <canvas class="my-4 w-100" id="incomeChart" width="900" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const ctx = document.getElementById('visitorPerMonth');
            var visitorPerMonth = {!! json_encode($visitorPerMonth) !!};

            var visitorChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: $.map(visitorPerMonth, function(val, id) {
                        return (new Date(val['month_year']).toLocaleDateString(
                            'id', {
                                year: 'numeric',
                                month: 'long',
                            }))
                    }),
                    datasets: [{
                        data: $.map(visitorPerMonth, function(val, id) {
                            return ((val['visitor_per_month']));
                        }),
                        lineTension: 0,
                        backgroundColor: 'transparent',
                        borderColor: '#007bff',
                        borderWidth: 4,
                        pointBackgroundColor: '#007bff',
                        label: 'Data Pengunjung Perbulan'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            var incomePerMonth = {!! json_encode($incomePerMonth) !!};
            console.log(typeof incomePerMonth);
            console.log({!! json_encode($incomePerMonth) !!});
            (function() {
                'use strict'

                feather.replace({
                    'aria-hidden': 'true'
                })

                // Graphs
                var incomeChart = document.getElementById('incomeChart')
                // eslint-disable-next-line no-unused-vars
                var incomeChartX = new Chart(incomeChart, {
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
