<div class="container-fluid">
    <nav class="navbar bg-white navbar-expand fixed-bottom d-md-none d-lg-none d-xl-none p-0 py-1 shadow-lg">
        <ul class="navbar-nav nav-justified w-100">
            <li class="nav-item {{ isset($active) ? ($active == 'index' ? 'nav-mobile-active' : '') : '' }}">
                <a href="{{ route('home') }}" class="nav-link text-center text-dark">
                    <i class="bi bi-house"></i>
                    <span class="small d-block">Beranda</span>
                </a>
            </li>
            <li class="nav-item {{ isset($active) ? ($active == 'order' ? 'nav-mobile-active' : '') : '' }} navbar-dropdown dropdown">
                <a href="{{ route('order.index') }}" class="nav-link text-center text-dark">
                    <i class="bi bi-bag"></i>
                    @auth
                    @if (count($userOrders) > 0)
                        <span class="position-absolute top-5 start-100 bot-nav-badge badge bg-danger">
                            {{ count($userOrders) }}
                            <span class="visually-hidden">Order</span>
                        </span>
                    @endif
                @endauth
                    <span class="small d-block">Pesanan</span>
                </a>
            </li>
            {{-- <li class="nav-item {{ isset($active) ? ($active == 'notification' ? 'nav-mobile-active' : '') : '' }}">
                <a href="{{ route('notifications.index') }}" class="nav-link text-center text-dark">
                    <i class="bi bi-bell"></i>
                    <span class="small d-block">Notifikasi</span>
                </a>
            </li> --}}
            <li class="nav-item {{ isset($active) ? ($active == 'rating' ? 'nav-mobile-active' : '') : '' }}">
                <a href="{{ route('rating.index') }}" class="nav-link text-center text-dark">
                    <i class="bi bi-star"></i>
                    <span class="small d-block">Penilaian</span>
                </a>
            </li>
            <li class="nav-item {{ isset($active) ? ($active == 'profile' ? 'nav-mobile-active' : '') : '' }}">
                <a href="{{ route('profile.index') }}" class="nav-link text-center text-dark" role="button"
                    id="dropdownMenuProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if (!empty(auth()->user()->profile_image))
                        <img class="navbar-profile-image"
                            src="{{ asset('/storage/' . auth()->user()->profile_image) }}" alt="">
                    @else
                        <i class="far fa-user-circle"></i>
                    @endif
                    {{-- <i class="bi bi-person"></i> --}}
                    <span class="small d-block">Profil</span>
                </a>
                <!-- Dropup menu for profile -->
                <div class="dropdown-menu" aria-labelledby="dropdownMenuProfile">
                    <a class="dropdown-item" href="#">Edit Profile</a>
                    <a class="dropdown-item" href="#">Notification</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    {{-- <div class="bottom-nav-bar-mobile fixed-bottom p-3 bg-white shadow-lg d-block d-sm-none">
            <div class="row text-center">
                <div class="col">
                    <i class="bi bi-house"></i>
                    <p class="m-0 bottom-nav-bar-mobile-text">Beranda</p>
                </div>
                <div class="col">
                    <i class="bi bi-receipt-cutoff"></i>
                    <p class="m-0 bottom-nav-bar-mobile-text">Transaksi</p>
                </div>
                <div class="col">
                    <i class="bi bi-bell"></i>
                    <p class="m-0 bottom-nav-bar-mobile-text">Notifikasi</p>
                </div>
                <div class="col">
                    <i class="bi bi-person"></i>
                    <p class="m-0 bottom-nav-bar-mobile-text">Profil</p>
                </div>
            </div>
        </div> --}}
</div>
