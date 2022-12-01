{{-- <nav
    class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-5 bg-body rounded fixed-top d-none d-sm-block navbar-bottom"> --}}
<nav
    class="navbar navbar-expand-lg shadow-sm p-3 mb-5 bg-body rounded fixed-top d-none d-lg-block navbar-bottom navbar-main">
    <div class="container-fluid">
        <a class="navbar-brand" href="/"> <img class="w-auto" src=" {{ asset('/assets/logotype2.svg') }}"
                alt=""> </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span><i class="bi bi-list"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                <li class="nav-item navbar-dropdown dropdown mx-1">
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
                                {{-- <li>
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
                                </li> --}}
                                <li>
                                    <h5 class="dropdown-item disabled text-dark fs-6 mt-3">Kategori</h5>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/category">
                                        <i class="bi bi-box"></i>&nbsp;
                                        Semua Kategori
                                    </a>
                                </li>
                                @foreach ($partialCategories as $category)
                                    <li>
                                        <form action="{{ route('product') }}" method="GET">
                                            @if (request('keyword'))
                                                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                                            @endif
                                            @if (request('merk'))
                                                <input type="hidden" name="merk" value="{{ request('merk') }}">
                                            @endif
                                            @if (request('sortby'))
                                                <input type="hidden" name="sortby" value="{{ request('sortby') }}">
                                            @endif
                                            <input type="hidden" name="category" value="{{ $category->slug }}">
                                            <button type="submit"
                                                class="dropdown-item {{ $category->slug == request('category') ? 'fw-bold' : '' }}"><i
                                                    class="bi bi-box"></i>&nbsp;
                                                {{ $category->name }}
                                            </button>
                                            {{-- </li> --}}
                                        </form>
                                    </li>
                                    {{-- <li>
                                        <a class="dropdown-item" href="/category/{{ $category->slug }}">
                                            <i class="bi bi-box"></i>&nbsp;
                                            {{ $category->name }}
                                        </a>
                                    </li> --}}
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
                                @foreach ($partialMerks as $merk)
                                    <li>
                                        <form action="{{ route('product') }}" method="GET">
                                            {{-- <a class="text-dark text-decoration-none category-left-side"
                                                                        href="/merk/{{ $merk->slug }}">
                                                                        <img class="w-25" src="/{{ $merk->image }}" alt="">
                                                                        {{ $merk->name }}
                                                                    </a> --}}
                                            {{-- <a class="text-dark text-decoration-none category-left-side {{ $merk->slug == request('merk') ? 'fw-bold' : '' }}"
                                                                            href="/products?merk={{ $merk->slug }}">
                                                                            {{ $merk->name }}
                                                                        </a> --}}
                                            @if (request('keyword'))
                                                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                                            @endif
                                            @if (request('category'))
                                                <input type="hidden" name="category"
                                                    value="{{ request('category') }}">
                                            @endif
                                            @if (request('sortby'))
                                                <input type="hidden" name="sortby" value="{{ request('sortby') }}">
                                            @endif
                                            <input type="hidden" name="merk" value="{{ $merk->slug }}">
                                            <button type="submit"
                                                class="dropdown-item {{ $merk->slug == request('merk') ? 'fw-bold' : '' }}"><img
                                                    class="w-25" src="/{{ $merk->image }}" alt="">&nbsp;
                                                {{ $merk->name }}
                                            </button>
                                    </li>
                                    </form>
                                    {{-- <a class="dropdown-item" href="/merk/{{ $merk->slug }}">
                                            <img class="w-25" src="/{{ $merk->image }}" alt="">&nbsp;
                                            {{ $merk->name }}
                                        </a> --}}
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
                        @if (request('sortby'))
                            <input type="hidden" name="sortby" value="{{ request('sortby') }}">
                        @endif

                        <div class="input-group me-3">
                            <input id="keyword" type="text" class="form-control search-input shadow-none"
                                placeholder="Cari produk..." name="keyword" value="{{ request('keyword') }}">
                            <button class="btn search-submit shadow-none" type="submit">
                                {{-- <i class="fas fa-search"></i> --}}
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </li>
                <li class="nav-item mx-1 navbar-dropdown dropdown">
                    {{-- <a class="nav-link dropdown-toggle navbar-cart" href="{{ route('cartitems.index') }}">
                        <i class="bi bi-cart"></i>
                        @auth
                            <span class="position-absolute top-5 start-100 translate-middle badge  bg-danger">
                                {{ count($userCartItems) }}
                                <span class="visually-hidden">cart items</span>
                            </span>
                        @endauth
                    </a> --}}
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
                                    <div class="">
                                        Keranjang ({{ count($userCartItems) }})
                                    </div>
                                    <div class="mx-3 ms-auto">
                                        <a href="{{ route('cart.index') }}"
                                            class="text-decoration-none text-danger fw-bold">Lihat Semua</a>
                                    </div>
                                </div>
                                {{-- {{ dd($userCartItems) }} --}}
                                <div class="nav-cart-items mt-5">
                                    @if (count($userCartItems) > 0)
                                        @foreach ($userCartItems as $cart)
                                            <li>
                                                <a class="dropdown-item my-2 cart-dropdown-item"
                                                    href="{{ route('cart.index') }}">
                                                    <div class="row align-items-center">
                                                        <div class="col-2">
                                                            {{-- <i class="bi bi-box"></i>&nbsp; --}}
                                                            @if (count($cart->product->productimage) > 0)
                                                                @if (Storage::exists($cart->product->productimage[0]->name))
                                                                    <img class="img-fluid w-100 border-radius-05rem"
                                                                        src="{{ asset('/storage/' . $cart->product->productimage[0]->name) }}"
                                                                        alt="" width="40">
                                                                @else
                                                                    {{-- <img class="img-fluid w-100 border-radius-05rem"
                                                                        src="https://source.unsplash.com/400x400?product--{{ $loop->iteration }}"
                                                                        alt="" width="40"> --}}
                                                                @endif
                                                            @else
                                                                {{-- <img class="img-fluid w-100 border-radius-05rem"
                                                                    src="https://source.unsplash.com/400x400?product--{{ $loop->iteration }}"
                                                                    alt="" width="40"> --}}
                                                            @endif
                                                            {{-- <img src="/assets/cheetah-adv-army.png" alt="" width="40"> --}}

                                                        </div>
                                                        <div class="col-6 ps-0 text-truncate" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom"
                                                            title="{{ $cart->product->name }}">
                                                            <p class="m-0 fs-14">
                                                                {{ $cart->product->name }}
                                                            </p>
                                                            <p class="m-0 fs-12 text-grey">
                                                                Varian: 
                                                                @if ($cart->product_variant_id != 0)
                                                                    {{ $cart->productvariant->variant_name }}
                                                                @else
                                                                    Tidak ada varian
                                                                @endif
                                                            </p>
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
                                            <img class="cart-img" src="{{ asset('/assets/klikspl-logo.png') }}"
                                                alt="" width="100">
                                            <p class="text-muted py-3 px-2">
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
                                    <img class="cart-img" src="{{ asset('/assets/klikspl-logo.png') }}" alt=""
                                        width="100">
                                    <p class="text-muted py-3 px-2">
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
                                    <div class="">
                                        {{-- {{ dd($userNotifications) }} --}}
                                        Notifikasi ({{ count($userNotifications) }})
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
                                                            {{-- <img src="https://source.unsplash.com/350x350?notification" alt="" width="40"> --}}
                                                            @if (File::exists(public_path($notification->image)))
                                                                <img src="{{ asset($notification->image) }}"
                                                                    class="img-fluid w-100 border-radius-05rem"
                                                                    alt="...">
                                                            @else
                                                                {{-- <img src="https://source.unsplash.com/400x400?product-1"
                                                                    class="img-fluid w-100 border-radius-05rem"
                                                                    alt="..."> --}}
                                                            @endif
                                                        </div>
                                                        <div class="col-10 ps-0 text-truncate notification-dropdown-text">
                                                            {{-- {{ $notification->excerpt }} --}}
                                                            <div class="fw-600 m-0">
                                                                {{ $notification->excerpt }}
                                                            </div>
                                                            <div class="fs-12 notification-description-navbar"> 
                                                                {!! $notification->description !!}
                                                            </div>
                                                            <div class="fs-12 text-secondary">
                                                                {{ \Carbon\Carbon::parse($notification->created_at)->isoFormat('D MMM Y, HH:mm') }}
                                                                WIB
                                                            </div>
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
                                            <img class="cart-img" src="{{ asset('/assets/klikspl-logo.png') }}"
                                                alt="" width="100">
                                            <p class="text-muted py-3 px-2">
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
                                    <p class="text-muted py-3 px-2">
                                        Tidak ada notifikasi untuk anda saat ini, masuk untuk melihat notifikasi di akun
                                        membership anda.
                                    </p>
                                </div>
                            </li>
                        </ul>
                    @endauth
                </li>
                <li class="nav-item mx-1 navbar-dropdown dropdown">
                    {{-- <a class="nav-link dropdown-toggle navbar-cart" href="{{ route('cartitems.index') }}">
                        <i class="bi bi-cart"></i>
                        @auth
                            <span class="position-absolute top-5 start-100 translate-middle badge  bg-danger">
                                {{ count($userCartItems) }}
                                <span class="visually-hidden">cart items</span>
                            </span>
                        @endauth
                    </a> --}}
                    <a class="nav-link dropdown-toggle navbar-cart" href="{{ route('order.index') }}">
                        <i class="bi bi-bag"></i>
                        @auth
                            @if (count($userOrders) > 0)
                                <span class="position-absolute top-5 start-100 translate-middle badge  bg-danger">
                                    {{ count($userOrders) }}
                                    <span class="visually-hidden">Order</span>
                                </span>
                            @endif
                        @endauth
                    </a>
                    @auth
                        <ul class="dropdown-menu cart-dropdown cart-dropdown-logged-in">
                            <div class="">
                                <div class="d-flex fixed-top bg-white p-3">
                                    <div class="">
                                        Pesanan Aktif ({{ count($userOrders) }})
                                    </div>
                                    <div class="mx-3 ms-auto">
                                        <a href="{{ route('order.index') }}"
                                            class="text-decoration-none text-danger fw-bold">Lihat Semua</a>
                                    </div>
                                </div>
                                {{-- {{ dd($userOrders) }} --}}
                                <div class="nav-cart-items mt-5">
                                    @if (count($userOrders) > 0)
                                        @foreach ($userOrders as $order)
                                            <li>
                                                <a class="dropdown-item my-2 cart-dropdown-item"
                                                    href="{{ route('order.show', $order) }}">
                                                    <div class="row align-items-center">
                                                        <div class="col-2">
                                                            {{-- <i class="bi bi-box"></i>&nbsp; --}}
                                                            {{-- <img src="https://source.unsplash.com/400x400?product-2" alt="" width="40"> --}}
                                                            @if (isset($order->orderitem[0]->orderproduct->orderproductimage))
                                                                <img src="{{ asset('/storage/' . $order->orderitem[0]->orderproduct->orderproductimage->first()->name) }}"
                                                                    class="w-100 border-radius-5px" alt="">
                                                            @endif
                                                            {{-- @if (!is_null($order->orderitem[0]->orderproduct->orderproductimage->first()))
                                                                <img src="{{ asset('/storage/' . $order->orderitem[0]->orderproduct->orderproductimage->first()->name) }}"
                                                                    class="w-100 border-radius-5px" alt="">
                                                            @endif --}}
                                                        </div>
                                                        <div class="col-5 ps-0 text-truncate" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom"
                                                            title="{{ is_null($order->invoice_no) ? 'No.Invoice belum terbit' : $order->invoice_no }}">
                                                            {{ is_null($order->invoice_no) ? 'No.Invoice belum terbit' : $order->invoice_no }}
                                                        </div>
                                                        <div class="col-5 ps-0 text-end text-truncate"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="{{ $order->order_status }}">
                                                            @if ($order->order_status == 'pembayaran ditolak')
                                                                <span class="badge bg-danger">
                                                                    {{ $order->order_status }}
                                                                </span>
                                                            @else
                                                                {{ $order->order_status }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    @else
                                        <div class="cart-no-auth pt-3 justify-content-center text-center rounded-3 px-3">
                                            <img class="cart-img" src="{{ asset('/assets/klikspl-logo.png') }}"
                                                alt="" width="100">
                                            <p class="text-muted py-3 px-2">
                                                Tidak ada pesanan yang dalam proses saat ini, yuk cari produk menarik dan
                                                pesan sekarang
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
                                    <img class="cart-img" src="{{ asset('/assets/klikspl-logo.png') }}" alt=""
                                        width="100">
                                    <p class="text-muted py-3 px-2">
                                        Masuk/daftar membership untuk melihat pesananmu yang sedang aktif
                                    </p>
                                </div>
                            </li>
                        </ul>
                    @endauth
                </li>
            </ul>

            @auth
                <div class="navbar-nav ms-auto navbar-account">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle mx-1 nav-acc" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (!empty(auth()->user()->profile_image))
                                <img class="navbar-profile-image"
                                    src="{{ asset('/storage/' . auth()->user()->profile_image) }}" alt="">
                            @else
                                <i class="far fa-user-circle"></i>
                            @endif
                            {{ auth()->user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end account-dropdown" aria-labelledby="navbarDropdown">
                            <li class="my-2">
                                <a class="dropdown-item account-dropdown-item" href="{{ route('profile.index') }}">
                                    <i class="far fa-user-circle me-1"></i> Akun saya
                                </a>
                            </li>
                            <li class="my-2">
                                <a class="dropdown-item account-dropdown-item" href="{{ route('order.index') }}">
                                    <i class="bi bi-bag me-1"></i> Pesanan saya
                                </a>
                            </li>
                            <li class="my-2">
                                <a class="dropdown-item account-dropdown-item" href="{{ route('rating.index') }}">
                                    <i class="bi bi-star me-1"></i> Penilaian
                                </a>
                            </li>
                            <li class="my-2">
                                <a class="dropdown-item account-dropdown-item" href="{{ route('comment.index') }}">
                                    <i class="bi bi-chat-left-text me-1"></i> Komentar
                                </a>
                            </li>
                            <li class="my-2">
                                <a class="dropdown-item account-dropdown-item" href="{{ route('promo.index') }}">
                                    <i class="bi bi-percent me-1"></i> Voucher Promo saya
                                </a>
                            </li>
                            <li class="my-2">
                                <form action="/logout" method="post">
                                    @csrf
                                    <button class="dropdown-item account-dropdown-item">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </div>
            @else
                <div class="navbar-nav ms-auto navbar-signup-login">
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
<nav class="navbar navbar-expand-lg mb-4 pt-0 pb-0 fixed-top d-none d-lg-block navbar-top">
    <div class="container-fluid my-0">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="https://www.saranaprimalestari.com"><i
                        class="bi bi-globe"></i> Official
                    Sites</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://wa.me/625113269593"><i class="bi bi-chat-dots"></i> Customer
                    Care</a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#"><i class="bi bi-truck"></i> Tracking
                    Pengiriman</a>
            </li>
        </ul>
    </div>
</nav>
