<nav
    class="navbar navbar-expand navbar-light bg-white shadow-sm p-0 py-3 mb-5 bg-body rounded fixed-top d-block d-sm-none">
    <div class="container-fluid">
        <a class="navbar-brand d-none d-sm-block" href="/"> <img class="w-auto" src="/assets/logotype2.svg"
                alt=""> </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-lg-0">

                <li class="nav-item navbar-dropdown dropdown mx-1 d-none d-sm-block">
                    <a class="nav-link dropdown-toggle navbar-category" href="/categories" id="navbarDropdownMenuLink"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Kategori
                    </a>
                    <ul class="dropdown-menu category-dropdown">
                        <div class="row">
                            <div class="col-md-6">
                                <li>
                                    <h5 class="dropdown-item disabled text-dark fs-6">Produk</h5>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/products">
                                        <i class="bi bi-border-all"></i>&nbsp; Semua Produk
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/products/latest">
                                        <i class="bi bi-megaphone"></i>&nbsp; Produk Terbaru
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/products/star">
                                        <i class="bi bi-star"></i>&nbsp; Produk Terbaik
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/products/best-seller">
                                        <i class="bi bi-basket3"></i>&nbsp; Produk Terlaris
                                    </a>
                                </li>
                                <li>
                                    <h5 class="dropdown-item disabled text-dark fs-6 mt-3">Kategori</h5>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/category">
                                        <i class="bi bi-box"></i>&nbsp;
                                        Semua Kategori
                                    </a>
                                </li>
                                @foreach ($categories as $category)
                                    <li>
                                        <a class="dropdown-item" href="/category/{{ $category->slug }}">
                                            <i class="bi bi-box"></i>&nbsp;
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                <li>
                                    <h5 class="dropdown-item disabled text-dark fs-6 mt-3">Merk</h5>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/merk">
                                        <i class="bi bi-box"></i>&nbsp;
                                        Semua Merk
                                    </a>
                                </li>
                                @foreach ($merks as $merk)
                                    <li>
                                        <a class="dropdown-item" href="/merk/{{ $merk->slug }}">
                                            <img class="w-25" src="/{{ $merk->image }}" alt="">&nbsp;
                                            {{ $merk->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </div>
                        </div>
                    </ul>
                </li>
                <li>
                    {{-- {{ print_r($queries) }} --}}
                </li>
                <li class="nav-item">
                    <form action="{{ route('product') }}" method="GET">

                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if (request('merk'))
                            <input type="hidden" name="merk" value="{{ request('merk') }}">
                        @endif
                        <div class="input-group">
                            <input type="text" class="form-control shadow-none" placeholder="Cari produk..." aria-label="" aria-describedby="" name="keyword" value="{{ request('keyword') }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                        {{-- <div class="input-group">
                            <input type="text" class="form-control search-input shadow-none"
                                placeholder="Cari produk..." name="keyword" aria-describedby="basic-addon2"
                                value="{{ request('keyword') }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary search-submit shadow-none" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div> --}}
                    </form>
                </li>
                <li class="nav-item mx-1 navbar-dropdown dropdown">
                    <a class="nav-link dropdown-toggle navbar-cart" href="{{ route('cart.index') }}">
                        <i class="bi bi-cart"></i>
                        @auth
                            @if (count($userCartItems) > 0)
                                <span class="position-absolute top-5 start-100 translate-middle badge  bg-danger">
                                    {{ count($userCartItems) }}
                                    <span class="visually-hidden">cart items</span>
                                </span>
                            @endif
                        @endauth
                    </a>
                    @auth
                        <ul class="dropdown-menu cart-dropdown cart-dropdown-logged-in">
                            <div class="">
                                <div class="d-flex fixed-top bg-white p-3">
                                    <div class="mx-3">
                                        Keranjang({{ count($userCartItems) }})
                                    </div>
                                    <div class="mx-3 ms-auto">
                                        <a href="{{ route('cart.index') }}"
                                            class="text-decoration-none text-danger fw-bold">Lihat Semua</a>
                                    </div>
                                </div>
                                <div class="nav-cart-items mt-5">
                                    @if (count($userCartItems) > 0)
                                        @foreach ($userCartItems as $cart)
                                            <li>
                                                <a class="dropdown-item my-2 cart-dropdown-item"
                                                    href="{{ route('cart.index') }}">
                                                    <div class="row align-items-center">
                                                        <div class="col-2">
                                                            {{-- <i class="bi bi-box"></i>&nbsp; --}}
                                                            <img src="https://source.unsplash.com/400x400?product-2" alt=""
                                                                width="40">
                                                            {{-- <img src="/assets/cheetah-adv-army.png" alt="" width="40"> --}}

                                                        </div>
                                                        <div class="col-6 ps-0 text-truncate">
                                                            {{ $cart->product->name }}
                                                        </div>
                                                        {{-- <div class="col-2 ps-3 text-truncate">
                                                           x{{ $cart->quantity }}
                                                        </div> --}}
                                                        <div class="col-4 text-end text-danger">
                                                            Rp{{ price_format_rupiah($cart->subtotal) }}
                                                            {{-- @if (isset($cart->productVariant))
                                                        Rp{{ price_format_rupiah($cart->productVariant->price) }}
                                                        @else
                                                        Rp{{ price_format_rupiah($cart->product->price) }}  
                                                        @endif --}}
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    @else
                                        <div class="cart-no-auth pt-3 justify-content-center text-center rounded-3 px-3">
                                            <img class="cart-img" src="/assets/klikspl-logo.png" alt="" width="100">
                                            <p class="text-muted pt-1 px-1">
                                                Keranjang belanjamu kosong, yuk cari produk menarik dan masukkan ke
                                                keranjangmu
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </ul>
                    @else
                        <ul class="dropdown-menu cart-dropdown">
                            <li>
                                <div class="cart-no-auth pt-3 justify-content-center text-center rounded-3 px-3">
                                    <img class="cart-img" src="/assets/klikspl-logo.png" alt="" width="100">
                                    <p class="text-muted pt-1 px-1">
                                        Masuk/daftar membership untuk memasukkan produk ke dalam Keranjang
                                    </p>
                                </div>
                            </li>
                        </ul>
                    @endauth
                </li>

                <li class="nav-item mx-1 navbar-dropdown dropdown">
                    <a class="nav-link dropdown-toggle navbar-cart" href="{{ route('notifications.index') }}">
                        <i class="bi bi-bell"></i>
                        @auth
                            @if (count($userNotifications) > 0)
                                <span class="position-absolute top-5 start-100 translate-middle badge  bg-danger">
                                    {{ count($userNotifications) }}
                                    <span class="visually-hidden">Notifications</span>
                                </span>
                            @endif
                        @endauth
                    </a>
                    @auth
                        <ul class="dropdown-menu cart-dropdown cart-dropdown-logged-in">
                            <div class="">
                                <div class="d-flex fixed-top bg-white p-3">
                                    <div class="mx-3">
                                        {{-- {{ dd($userNotifications) }} --}}
                                        Notifikasi({{ count($userNotifications) }})
                                    </div>
                                    <div class="mx-3 ms-auto">
                                        <a href="{{ route('notifications.index') }}"
                                            class="text-decoration-none text-danger fw-bold">Lihat Semua Notifikasi</a>
                                    </div>
                                </div>
                                {{-- {{ dd($userCartItems) }} --}}
                                <div class="nav-notification-items mt-5">
                                    @if (count($userNotifications) > 0)
                                        @foreach ($userNotifications as $notification)
                                            <li>
                                                <a class="dropdown-item my-2 cart-dropdown-item"
                                                    href="{{ route('notifications.show', $notification) }}">
                                                    <div class="row align-items-center">
                                                        <div class="col-2">
                                                            {{-- <i class="bi bi-box"></i>&nbsp; --}}
                                                            <img src="https://source.unsplash.com/350x350?notification"
                                                                alt="" width="40">
                                                        </div>
                                                        <div class="col-10 ps-0 text-truncate ">
                                                            {{ $notification->excerpt }}
                                                        </div>
                                                        {{-- <div class="col-4 text-end text-danger">
                                                        Rp{{ price_format_rupiah($notification->product->price) }}
                                                    </div> --}}
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    @else
                                        <div class="cart-no-auth pt-3 justify-content-center text-center rounded-3 px-3">
                                            <img class="cart-img" src="/assets/klikspl-logo.png" alt="" width="100">
                                            <p class="text-muted pt-1 px-1">
                                                Tidak ada notifikasi buat kamu sekarang ini
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </ul>
                    @else
                        <ul class="dropdown-menu notification-dropdown">
                            <li>
                                <div class="nofitication-no-auth pt-3 justify-content-center text-center rounded-3 px-3">
                                    <i class="bi bi-bell fs-1 text-secondary"></i>
                                    <p class="text-muted pt-1 px-1">
                                        Tidak ada notifikasi untuk anda saat ini, masuk untuk melihat notifikasi di akun
                                        membership anda.
                                    </p>
                                </div>
                            </li>
                        </ul>
                    @endauth
                </li>
                <li class="nav-item mx-1 navbar-dropdown">
                     <a class="nav-link navbar-cart" href="{{ route('profile.index') }}">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
            </ul>

            @auth
                <div class="navbar-nav ms-auto navbar-account d-none d-sm-block">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle mx-1 nav-acc" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            @if (!empty(auth()->user()->profile_image))
                            @else
                                <i class="far fa-user-circle"></i>
                            @endif
                            {{ auth()->user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end account-dropdown" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item account-dropdown-item" href="/dashboard ">
                                    <i class="far fa-user-circle"></i> Akun saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item account-dropdown-item" href="/dashboard ">
                                    <i class="bi bi-bag"></i> Pesanan saya
                                </a>
                            </li>
                            <li>
                                <form action="/logout" method="post">
                                    @csrf
                                    <button class="dropdown-item account-dropdown-item">
                                        <i class="bi bi-box-arrow-in-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </div>
            @else
                <div class="navbar-nav ms-auto navbar-signup-login d-none d-sm-block">
                    <div class="nav-item">
                        <a href="/login" class="p-0 px-3 py-2 mx-1 nav-link navbar-action login">
                            Masuk
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="/register" class="p-0 px-3 py-2 mx-1 nav-link navbar-action register">
                            Daftar
                        </a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>
