@extends('admin.layouts.main')
@section('container')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show alert-notification" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session()->has('failed'))
        <div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">
            {{ session('failed') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2">Notifikasi saya</h1>
        <div class="ms-auto">
            <form action="{{ route('read.all.admin.notifications') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger fs-14">
                    Tandai semua telah dibaca
                </button>
            </form>
        </div>
        </a>
    </div>
    @if ($errors->any())
        {!! implode(
            '',
            $errors->all(
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">:message<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
            ),
        ) !!}
    @endif
    @if ($notifications->count() > 0)
        @foreach ($notifications as $notification)
            <div class="card mb-3 border-radius-1-5rem fs-14 border-0">
                <div class="card-body p-4">
                    <a href="{{ route('adminnotifications.show', $notification) }}" class="text-dark text-decoration-none">
                        <div class="row">
                            <div class="col-12">
                                <div class="heeader d-flex align-items-center">
                                    {{-- <h5 class="mt-0 notification-list-excerpt me-auto">{{ $notification->type }}
                                    </h5> --}}

                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-1">
                                @if (File::exists(public_path($notification->image)))
                                    <img src="{{ asset($notification->image) }}"
                                        class="img-fluid w-100 border-radius-05rem" alt="...">
                                @endif
                            </div>
                            <div class="col-md-9">
                                <p class="fs-14 mb-1 fw-600">
                                    [{{ $notification->type }}] {{ $notification->excerpt }}
                                </p>
                                <div class="fs-14 mb-1">
                                    {!! $notification->description !!}
                                </div>
                                <span class="d-md-flex fs-12 text-secondary">
                                    <p class="m-0 me-1">
                                        {{ \Carbon\Carbon::parse($notification->created_at)->isoFormat('D MMMM Y, HH:mm') }}
                                        WIB</p>
                                    <p class="m-0"> Sekitar
                                        {{ $notification->created_at->diffForHumans() }}</p>
                                </span>
                            </div>
                            <div class="col-md-2 text-end">
                                @if ($notification->is_read == 0)
                                    <span class="ms-auto badge bg-danger">Belum dibaca</span>
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
                Tidak ada notifikasi buat kamu sekarang ini
            </p>
        </div>
    @endif
@endsection
