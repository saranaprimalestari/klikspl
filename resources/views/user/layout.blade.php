@extends('layouts.main')
@section('container')
    <div class="container-fluid breadcrumb-products">
        {{ Breadcrumbs::render('profile.index') }}
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3 d-none d-sm-block">
                <ul class="list-unstyled">
                    <li class="">
                        <a class="btn btn-toggle align-items-center shadow-none user-button-menu-collapse accordion-button py-2 ps-3"
                            data-bs-toggle="collapse" href="#account-collapse" role="button" aria-expanded="false"
                            aria-controls="account-collapse">
                            <i class="far fa-user-circle me-2"></i> Akun Saya
                        </a>
                        {{-- <button class="btn btn-toggle align-items-center shadow-none" data-bs-toggle="collapse"
                            data-bs-target="#account-collapse" aria-expanded="true">
                            <i class="far fa-user-circle me-1"></i> Akun Saya
                        </button> --}}
                        <div class="collapse show" id="account-collapse" style="">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li>
                                    <a href="{{ route('profile.index') }}"
                                        class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex {{ isset($active) ? ($active == 'profile' ? 'active-menu' : '') : '' }}">Profil</a>
                                </li>
                                <li>
                                    <a href="{{ route('useraddress.index') }}"
                                        class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex {{ isset($active) ? ($active == 'manageAddress' ? 'active-menu' : '') : '' }}">Kelola
                                        Alamat</a>
                                </li>
                                <li>
                                    <a href="{{ route('change.password') }}"
                                        class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex {{ isset($active) ? ($active == 'changePassword' ? 'active-menu' : '') : '' }}">Ubah
                                        Password</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="">
                        <a class="btn btn-toggle align-items-center shadow-none notification-button-menu-collapse ps-3 py-2 {{ isset($active) ? ($active == 'order' ? 'active-menu' : '') : '' }}"
                            href="{{ route('order.index') }}">
                            <i class="bi bi-bag me-2"></i>Pesanan Saya
                        </a>
                    </li>
                    
                    <li class="">
                        <a class="btn btn-toggle align-items-center shadow-none notification-button-menu-collapse ps-3 py-2 {{ isset($active) ? ($active == 'rating' ? 'active-menu' : '') : '' }}"
                            href="{{ route('rating.index') }}">
                            <i class="bi bi-star me-2"></i>Penilaian
                        </a>
                    </li>
                    
                    <li class="">
                        <a class="btn btn-toggle align-items-center shadow-none notification-button-menu-collapse ps-3 py-2 {{ isset($active) ? ($active == 'comment' ? 'active-menu' : '') : '' }}"
                            href="{{ route('comment.index') }}">
                            <i class="bi bi-chat-left-text me-2"></i>Komentar
                        </a>
                    </li>
                    
                    <li class="">
                        <a class="btn btn-toggle align-items-center shadow-none notification-button-menu-collapse ps-3 py-2 {{ isset($active) ? ($active == 'promo' ? 'active-menu' : '') : '' }}"
                            href="{{ route('promo.index') }}">
                            <i class="bi bi-percent me-2"></i>Voucher Promo Saya
                        </a>
                    </li>

                    <li class="">
                        <a class="btn btn-toggle align-items-center shadow-none notification-button-menu-collapse ps-3 py-2 {{ isset($active) ? ($active == 'notification' ? 'active-menu' : '') : '' }}"
                            href="{{ route('notifications.index') }}">
                            <i class="bi bi-bell me-2"></i>Notifikasi
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9 mb-5">
                @yield('account')
            </div>
        </div>
    </div>
@endsection
