@extends('user.layout')
{{-- @section('container') --}}
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
                <button type="submit" class="btn btn-danger fs-14">
                    Tandai semua telah dibaca
                </button>
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
                                        <div class="heeader d-flex align-items-center">
                                            <h5 class="mt-0 notification-list-excerpt me-auto">{{ $notification->type }}
                                            </h5>
                                            @if ($notification->is_read == 0)
                                                <span class="ms-auto badge bg-danger">Belum dibaca</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-md-9 col-12">
                                        <div class="row align-items-center">
                                            <div class="col-md-2 col-4">
                                                {{-- {{ public_path($notification->image) }} --}}
                                                @if (File::exists(public_path($notification->image)))
                                                    <img src="{{ asset($notification->image) }}"
                                                        class="img-fluid w-100 border-radius-075rem" alt="...">
                                                @else
                                                    <img src="https://source.unsplash.com/400x400?product-1"
                                                        class="img-fluid w-100 border-radius-075rem" alt="...">
                                                @endif
                                            </div>
                                            <div class="col-md-10 col-8 my-2 ps-0">
                                                <span class="d-md-flex notification-list-created-at mb-1">
                                                    <p class="m-0 me-2">
                                                        {{ \Carbon\Carbon::parse($notification->created_at)->isoFormat('D MMMM Y, HH:mm') }}
                                                        WIB</p>
                                                    <small class="mt-1 fst-italic"> Sekitar
                                                        {{ $notification->created_at->diffForHumans() }}</small>
                                                </span>
                                                <p class="notification-list-excerpt text-truncate m-0">
                                                    {{ $notification->excerpt }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 text-end">
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
                        Tidak ada notifikasi buat kamu sekarang ini
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection
