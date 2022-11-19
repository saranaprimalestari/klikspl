<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Pemesanan</title>
</head>

<body>
    {{-- ICON WEB --}}
    {{-- <link rel="shortcut icon" href="/assets/klikspl.ico"> --}}

    {{-- Bootstrap CSS --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> --}}
    {{-- Bootstrap ICON --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css"> --}}

    {{-- Style CSS --}}
    {{-- <link rel="stylesheet" href="/css/style.css"> --}}

    {{-- <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" /> --}}
    <style>
        @media screen,
        print {
            @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');

            /* .bg-klikspl {
                background-color: #db162f;
                /* background-color: #f5f5f5; */
            } */

            .text-klikspl {
                color: #db162f;
            }
            .main-content{
               margin-left: 10%;
               margin-right: 10%;
            }
            body {
                margin: 0 !important;
                padding: 0 !important;
                font-family: 'Open Sans', sans-serif;
                font-size: 12px;
                color: #393939;
                line-height: 150%;
            }

            .table-100 {
                width: 100%;
            }

            table td,
            table td * {
                vertical-align: top;
            }

            td {
                vertical-align: top;
            }

            .header {
                padding: 30px;
                /* border-bottom: 2px dashed #212121; */
                /* background-color: #f5f5f5; */
                background-color: #db162f;
                color: #ffffff;
            }

            .body {
                padding: 30px;
                background-color: #f5f5f5;
            }

            .header>.inner {
                /* display: flex; */
                /* justify-content: center; */
                align-items: center;
                text-align: center;
            }
            .text-center{
                text-align: center;
            }
            .header-invoice {
                /* font-weight: 600; */
                font-size: 20px;
                padding-top: 10px;
            }

            .receipt-img {
                width: 10%;
                height: 5%;
            }

            .payment-method-logo {
                width: 50%;
                height: 5%;
            }

            p {
                margin: 0;
            }

            .total-payment {
                font-weight: bold;
            }

            .account-number {
                font-weight: bold;
            }

            .div-header {
                font-weight: bold;
                font-size: 20px;
                margin-top: 30px;
                margin-bottom: 5px;
            }

            .total-order-header {
                font-weight: bold;
                font-size: 18px;
                margin-top: 20px;
                margin-bottom: 5px;
            }

            .sub-header {
                font-weight: bold;
                font-size: 16px;
                margin-top: 10px;
                margin-bottom: 3px;
            }

            .qty-item {
                margin-left: 20px;
            }

            .divider {
                margin-left: 7px;
                margin-right: 7px;
            }

            .line-through {
                text-decoration: line-through;
            }

            .bold {
                font-weight: bold;
            }

            .text-end {
                text-align: right;
            }

            .ps-5px {
                padding-left: 5px;
            }

            .pe-5px {
                padding-right: 5px;
            }

            .pt-5px {
                padding-top: 5px;
            }

            .pt-10px {
                padding-top: 10px;
            }
            .p-50px{
                padding: 50px;
            }
            .p-30px{
                padding: 30px;
            }
            .h-50px {
                height: 50px;
            }
            .fs-10{
                font-size: 10px;
            }
            .sub-detail {
                margin-top: 8px;
                margin-bottom: 8px;
            }

            .note {
                padding-top: 30px;
            }

            .pt-0{
                padding-top: 0;
            }
            .pb-0{
                padding-bottom: 0;
            }
            .ps-0{
                padding-left: 0;
            }
            .pe-0{
                padding-right: 0;
            }
            .footer{
                /* border-top:2px dashed #8d8d8d; */
                background-color: #d8d8d8;
            }
        }
    </style>
    {{-- {{ dd($promoUse->promo->promo_type_id) }} --}}

    <div class="main-content">
        <div class="header bg-klikspl">
            <div class="inner">
                <div>
                    {{-- <img class="" width="30%" src="{{ url('/assets/footer-logo h-100px.png') }}" alt=""> --}}
                <img class="receipt-img" width="30%" src="{{ url('/assets/receipt.png') }}" alt="">
                </div>
                <div>
                    <p class="header-invoice" style="">
                        Invoice Pembayaran
                        {{ $order->invoice_no }}
                    </p>
                </div>
            </div>
        </div>
        <div class="body" style="">
            <div class="user-opening-container">
                <span>
                    @if (isset($order->users->username))
                        {{ $order->users->username }},
                    @elseif (isset($order->users->email))
                        {{ $order->users->email }},
                    @else
                        {{ $order->users->telp_no }},
                    @endif
                </span>
                <span>
                    Silakan lakukan pembayaran sebesar
                    <span class="total-payment text-klikspl">
                        Rp{{ price_format_rupiah($order->courier_price + $order->total_price + $order->unique_code - $order->discount) }}
                    </span>
                </span>
                <span>dengan detail pemesanan sebagai berikut:</span>
            </div>

            <div class="payment-method-information-container">
                <p class="div-header">
                    Informasi Pembayaran
                </p>
                <table>
                    <tr>
                        <td>
                            {{ $order->paymentMethod->type }}
                        </td>
                        <td class="ps-5px pe-5px">
                            :
                        </td>
                        <td class="bold">
                            {{ $order->paymentMethod->name }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nomor Rekening
                        </td>
                        <td class="ps-5px pe-5px">
                            :
                        </td>
                        <td class="bold">
                            {{ $order->paymentMethod->account_number }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Atas Nama
                        </td>
                        <td class="ps-5px pe-5px">
                            :
                        </td>
                        <td class="bold">
                            {{ $order->paymentMethod->account_name }}
                        </td>
                    </tr>
                </table>
            </div>

            <div class="detail-order-container">
                <p class="div-header">
                    Detail Pesanan
                </p>
                {{-- <p class="sub-header">
                    Produk Pesanan
                </p> --}}
                <div class="sub-detail">
                    <table class="table-100">
                        @foreach ($order->orderitem as $orderItem)
                            <tr class="h-50px">
                                <td>
                                    {{ $loop->iteration }}.
                                </td>
                                <td>
                                    <div>
                                        {{ $orderItem->orderProduct->name }}
                                    </div>
                                    <div>
                                        <span>
                                            {{ $orderItem->quantity }} x
                                        </span>
                                        <span
                                            class="{{ !empty($orderItem->discount) ? 'text-decoration-line-through' : '' }}">
                                            @if (!empty($orderItem->discount))
                                                <span class="">
                                                    Rp{{ price_format_rupiah($orderItem->orderproduct->price) }}
                                                </span>
                                                {{-- <span>
                                                    Rp{{ price_format_rupiah($orderItem->orderproduct->price - $order->discount) }}
                                                </span> --}}
                                            @else
                                                Rp{{ price_format_rupiah($orderItem->orderproduct->price) }}
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    Rp{{ price_format_rupiah($orderItem->total_price_item) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td style="border-top: 0.25px solid #8d8d8d" colspan="3"></td>
                        </tr>
                        <tr style="border-top: 0.25px solid #8d8d8d">
                            <td colspan="2">TOTAL HARGA PRODUK</td>
                            <td class="text-end">
                                Rp{{ price_format_rupiah($order->total_price) }}
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="sub-detail">
                    {{-- <p class="sub-header">
                        Ongkos Kirim
                    </p> --}}
                    <table class="table-100">
                        <tr>
                            <td>
                                <div>
                                   TOTAL ONGKOS KIRIM
                                </div>
                                <div class="fs-10">
                                    {{-- <span class="fs-10"> --}}
                                        {{ $order->courier }}
                                        {{ $order->courier_package_type }}
                                    {{-- </span> --}}
                                </div>
                            </td>
                            <td class="text-end">
                                Rp{{ price_format_rupiah($order->courier_price) }}
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="sub-detail">
                    {{-- <p class="sub-header">
                        Kode Unik
                    </p> --}}
                    <table class="table-100">
                        <tr>
                            <td>
                                <span>
                                    KODE UNIK
                                </span>
                            </td>
                            <td class="text-end">
                                Rp{{ price_format_rupiah($order->unique_code) }}
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="sub-detail">
                    {{-- <p class="sub-header">
                        Diskon
                    </p> --}}
                    <table class="table-100">
                        @foreach ($order->userPromoOrderUse as $userPromoOrderUse)
                            <tr>
                                <td>
                                    <div>
                                        DISKON PROMO
                                    </div>
                                    <div class="fs-10">
                                        {{ $userPromoOrderUse->promo_name }}
                                    </div>
                                </td>
                                {{-- <td>
                                    -
                                </td> --}}
                                <td class="text-end">
                                    - Rp{{ price_format_rupiah($userPromoOrderUse->discount) }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <table class="table-100">
                    <tr style="border-top: 0.5px solid #8d8d8d">
                        <td style="border-top: 0.25px solid #8d8d8d">

                        </td>
                    </tr>
                </table>
                <div class="sub-detail">
                    {{-- <p class="sub-header">
                        Total
                    </p> --}}
                    <table class="table-100">
                        <tr>
                            <td class="bold sub-header">
                                TOTAL
                            </td>
                            <td class="text-end bold sub-header">
                                Rp{{ price_format_rupiah($order->courier_price + $order->total_price + $order->unique_code - $order->discount) }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="payment-due-date-container">
                <p class="div-header">
                    Batas Waktu Pembayaran
                </p>
                <div>
                    <span>
                        Bayar sebelum
                        <span class="text-klikspl bold">
                            {{ \Carbon\Carbon::parse($order->payment_due_date)->isoFormat('dddd,D MMMM Y') }}
                            Jam
                            {{ \Carbon\Carbon::parse($order->payment_due_date)->isoFormat('HH:mm') }}
                            WIB
                        </span>
                    </span>
                    <span>
                    </span>
                </div>
            </div>
            <div class="note pt-10px">
                <div>
                    <p>
                        <span class="bold">Catatan:</span>
                        <span>
                            Silakan transfer sesuai dengan jumlah yang tertera diatas, tidak kurang dan tidak lebih.
                            Agar sistem kami dapat memverifikasi pembayaran yang dilakukan. Terimakasih.
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="footer p-30px text-center">
                <img class="" width="50%" src="{{ url('/assets/footer-logo h-100px.png') }}" alt="">
                <p class="pt-10px">www.klikspl.com</p>
        </div>
    </div>
    {{-- SCRIPT BOOTSTRAP 5 Bundle --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script> --}}

    {{-- FONTAWESOME --}}
    {{-- <script src="https://kit.fontawesome.com/c4d8626996.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" type="text/js"></script> --}}
</body>

</html>
