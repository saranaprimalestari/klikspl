@extends('layouts.main')
@section('container')
    <div class="container mb-5 row">
        <div class="col-md-6 col-12 mx-auto">
        <div class="pt-3 pb-2 mb-1 header">
            <h1 class="h2">Metode Pembayaran</h1>
        </div>
        <div class="content fs-14">
                <p>Metode pembayaran yang tersedia di KLIKSPL antara lain: </p>
                <div class="payment-methods">
                    @foreach ($paymentMethods as $payment)
                        <div class="row mb-3">
                            <div class="col-2 pe-0">
                                @if (isset($payment->logo))
                                    <img id="available-payment-method-image-{{ $payment->id }}"
                                        class="img-fluid" src="{{ asset($payment->logo) }}" alt="..." width="100%" height="100%">
                                @endif
                            </div>
                            <div class="col-10">
                                <p class="ps-2 m-0 fw-500">
                                    {{ $payment->name }} - {{ $payment->account_name }}
                                </p>
                                <p class="ps-2 m-0 fs-11">
                                    {{ $payment->type }}
                                </p>
                                <p class="ps-2 m-0 fs-11">
                                    {{ $payment->account_number }}
                                </p>
                                <p class="ps-2 m-0 fs-11">
                                    {{ $payment->code }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
