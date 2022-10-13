@extends('user.layout')
{{-- @section('container') --}}
@section('account')
    <h5 class="mb-4">Voucher Promo Saya</h5>
    <div class="card mb-3 profile-card">
        <div class="card-body p-4">
            @if ($promos->count() > 0)
                {{-- {{ dd($promos) }} --}}
                @foreach ($promos as $promo)
                    <div class="card mb-3 border-radius-075rem box-shadow">
                        <div class="card-body p-4">
                            <a href="{{ route('promo.show', $promo) }}" class="text-dark text-decoration-none">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="row align-items-center">
                                            <div class="col-md-2 col-4">
                                                @if (!empty($promo->image))
                                                    @if (File::exists(public_path($promo->image)))
                                                        <img src="{{ asset($promo->image) }}"
                                                            class="img-fluid w-100 border-radius-075rem" alt="...">
                                                    @elseif(Storage::exists($promo->image))
                                                        <img src="{{ asset('/storage/' . $promo->image) }}"
                                                            class="img-fluid w-100 border-radius-075rem" alt="...">
                                                    @else
                                                        <img src="{{ asset('assets/voucher.png') }}"
                                                            class="img-fluid w-100 border-radius-075rem" alt="...">
                                                    @endif
                                                @else
                                                    <img src="{{ asset('assets/voucher.png') }}"
                                                        class="img-fluid w-100 border-radius-075rem" alt="...">
                                                @endif
                                            </div>
                                            <div class="col-md-10 col-12 my-2 ps-md-0">
                                                <p class="m-0 fw-600 pb-1 fs-14">
                                                    {{ $promo->name }}
                                                </p>
                                                <p class="m-0 fs-14">
                                                    Min, transaksi
                                                    Rp{{ price_format_rupiah($promo->min_transaction, 'Rp') }}
                                                </p>
                                                <span class="d-md-flex notification-list-created-at mb-1">
                                                    @if ($promo->start_period >= \Carbon\Carbon::now()->toDateTimeString())
                                                        <p class="m-0 me-2 fs-12 text-grey">
                                                            Baru berlaku mulai
                                                            {{ \Carbon\Carbon::parse($promo->start_period)->isoFormat('D MMM') }}
                                                            -
                                                            {{ \Carbon\Carbon::parse($promo->end_period)->isoFormat('D MMM Y, HH:mm') }}
                                                            WIB
                                                        </p>
                                                    @else
                                                        <p class="m-0 me-2 fs-12 text-danger">
                                                            Berlaku hingga
                                                            {{ \Carbon\Carbon::parse($promo->end_period)->isoFormat('D MMM Y, HH:mm') }}
                                                            WIB
                                                        </p>
                                                    @endif
                                                </span>
                                                <p class="notification-list-excerpt text-truncate m-0">
                                                    {{ $promo->excerpt }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center notification-empty">
                    <img class="my-4 cart-items-logo" src="/assets/footer-logo.png" width="300" alt="">
                    <p>
                        Tidak ada voucher promo buat kamu sekarang ini
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection
