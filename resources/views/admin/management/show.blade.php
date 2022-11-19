@extends('admin.layouts.main')
@section('container')
    {{-- {{ dd($admin) }} --}}
    {{-- {{ print_r(session()->all()) }} --}}
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
    @if ($errors->any())
        {!! implode(
            '',
            $errors->all(
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">:message<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
            ),
        ) !!}
    @endif
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-md-3 pt-5 pb-3 mb-1">
        <h4 class="m-0">
            <a href="{{ route('management.index') }}" class="text-decoration-none link-dark">
                <i class="bi bi-arrow-left"></i>
            </a>
            Detail Data Admin
        </h4>
    </div>
    <form action="{{ route('management.update', $admin) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="container p-0 mb-4">
            <div class="card product-info-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Informasi Admin</h5>
                        <p class="text-grey fs-13 m-0">Isikan username, nama depan, nama belakang, tipe, perusahaan, no
                            telepon, dan email</p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-3 row align-items-center">
                        <div class="col-sm-3">
                            <p class="m-0 fw-600">
                                Username
                            </p>
                        </div>
                        <div class="col-sm-9">
                            <p class="m-0">
                                {{ $admin->username }}
                            </p>
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <div class="col-sm-3">
                            <p class="m-0 fw-600">
                                Nama Depan / Belakang
                            </p>
                        </div>
                        <div class="col-sm-9">
                            <p class="m-0">
                                {{ $admin->firstname }} / {{ $admin->lastname }}
                            </p>
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <div class="col-sm-3">
                            <p class="m-0 fw-600">
                                Tipe Admin
                            </p>
                        </div>
                        <div class="col-sm-9">
                            <p class="m-0">
                                {{ $admin->adminType->admin_type }}
                            </p>
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <div class="col-sm-3">
                            <p class="m-0 fw-600">
                                Perusahaan
                            </p>
                        </div>
                        <div class="col-sm-9">
                            <p class="m-0">
                                @if (!empty($admin->company_id))
                                    {{ $admin->company->name }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <div class="col-sm-3">
                            <p class="m-0 fw-600">
                                Nomor Telepon
                            </p>
                        </div>
                        <div class="col-sm-9">
                            <p class="m-0">
                                @if (!empty($admin->telp_no))
                                    {{ $admin->telp_no }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <div class="col-sm-3">
                            <p class="m-0 fw-600">
                                Email
                            </p>
                        </div>
                        <div class="col-sm-9">
                            <p class="m-0">
                                @if (!empty($admin->email))
                                    {{ $admin->email }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container product-shipment-origin-container p-0 mb-4">
            <div class="card product-shipment-origin-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Lokasi Pengiriman</h5>
                        <p class="text-grey fs-13 m-0">Lokasi pengiriman untuk melihat dan mengelola pesanan yang
                            masuk</p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    @if (auth()->guard('adminMiddle')->user()->admin_type == 1)
                        Superadmin tidak memerlukan lokasi pengiriman untuk melihat dan mengelola pesanan
                    @else
                    <ul>
                        @foreach ($admin->adminSenderAddress as $sender)
                            <li>
                                <div class="mb-3">
                                    <p class="fw-600 m-0">{{ $sender->senderAddress->name }}</p>
                                    <p class="m-0">{{ $sender->senderAddress->address }}</p>
                                    <div class="d-flex">
                                        <p class="m-0">
                                            {{ $sender->senderAddress->city->name }},
                                        </p>
                                        <p class="m-0">
                                            {{ $sender->senderAddress->province->name }},
                                        </p>
                                        <p class="m-0">
                                            {{ $sender->senderAddress->postal_code }}
                                        </p>
                                    </div>
                                    <p class="m-0">{{ $sender->senderAddress->telp_no }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
        });
    </script>
@endsection
