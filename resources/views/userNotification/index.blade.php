@extends('user.layout')
@section('account')
    <div class="col-12">
        @if (session()->has('success') or session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show alert-success-cart" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('failed') or session()->has('failed'))
            <div class="alert alert-danger alert-dismissible fade show alert-success-cart" role="alert">
                {{ session('failed') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div class="d-flex">
        <h5 class="mb-4">Notifikasi Saya</h5>
        <div class="ms-auto">
            <form action="{{ route('read.all.notifications') }}" method="POST">
                @csrf
                @if ($notifications->count() > 0)
                    <button type="submit" class="btn btn-danger fs-14">
                        Tandai semua telah dibaca
                    </button>
                @endif
            </form>
        </div>
    </div>
    <div class="card mb-3 profile-card">
        <div class="card-body p-4">
            @if ($notifications->count() > 0)
                @foreach ($notifications as $notification)
                    <div class="card mb-3 notification-card">
                        <div class="card-body p-4">
                            <a href="{{ route('notifications.show', $notification) }}"
                                class="text-dark text-decoration-none">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="header d-flex align-items-center">
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-md-2 col-3">
                                        @if (!is_null($notification->image))
                                            <img src="{{ asset($notification->image) }}"
                                                class="img-fluid w-100 border-radius-05rem" alt="...">
                                        @else
                                            <img src="{{ asset('assets/pict.png') }}"
                                                class="img-fluid w-100 border-radius-05rem" alt="...">
                                        @endif
                                    </div>
                                    <div class="col-md-8 col-7">
                                        <p class="fs-14 mb-1 fw-600 text-truncate">
                                            [{{ $notification->type }}] {{ $notification->excerpt }}
                                        </p>
                                        <div class="fs-14 mb-1 notification-description-index">
                                            {!! $notification->description !!}
                                        </div>
                                        <div class="d-md-flex fs-12 text-secondary text-truncate">
                                            <span class="m-0 me-1">
                                                {{ \Carbon\Carbon::parse($notification->created_at)->isoFormat('D MMMM Y, HH:mm') }}
                                                WIB</span>
                                            <span class="m-0"> Sekitar
                                                {{ $notification->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-2 text-end">
                                        @if ($notification->is_read == 0)
                                            <span class="ms-auto badge bg-danger mb-2 d-none d-lg-inline-block">Belum
                                                dibaca</span>
                                            <span
                                                class="ms-auto badge bg-danger border-light p-2 rounded-circle mb-2 d-inline-block d-lg-none">
                                                <span class="visually-hidden">Belum dibaca</span>
                                            </span>
                                        @endif
                                        <form action="{{ route('notifications.destroy', $notification) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"
                                                class="btn m-0 p-0 text-decoration-none shadow-none profile-address-change-link"
                                                role="button">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
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
                        Tidak ada notifikasi untuk anda sekarang ini
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection
