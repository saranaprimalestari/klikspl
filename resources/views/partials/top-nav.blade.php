<nav
    class="navbar navbar-expand navbar-light bg-white shadow-sm p-0 py-3 mb-5 bg-body rounded fixed-top d-block d-lg-none">
    <div class="container-fluid">
        <a class="navbar-brand d-none d-sm-block" href="/"> <img class="w-auto" src="/assets/logotype2.svg"
                alt=""> </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-lg-0">

                <li class="nav-item navbar-dropdown dropdown mx-1 d-none d-md-block">
                    <a class="nav-link dropdown-toggle navbar-category" href="/partialCategories"
                        id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                                @foreach ($partialCategories as $category)
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
                                @foreach ($partialMerks as $merk)
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
                            <input type="search" class="form-control search-input-top-nav shadow-none"
                                placeholder="Cari produk..." aria-label="" aria-describedby="" name="keyword"
                                value="{{ request('keyword') }}">
                            <div class="input-group-append">
                                <button class="btn btn-danger search-submit-top-nav shadow-none" type="submit">
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
                        <ul class="dropdown-menu cart-dropdown-mobile cart-dropdown-logged-in-mobile">
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
                                                            {{-- <img src="https://source.unsplash.com/400x400?product-2"
                                                                alt="" width="40"> --}}
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
                                            <img class="cart-img" src="/assets/klikspl-logo.png" alt=""
                                                width="100">
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
                        <ul class="dropdown-menu notification-dropdown-mobile notification-dropdown-logged-in-mobile">
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
                                                <a class="dropdown-item my-2 notification-dropdown-item"
                                                    href="{{ route('notifications.show', $notification) }}">
                                                    <div class="row align-items-center">
                                                        <div class="col-2">
                                                            {{-- <i class="bi bi-box"></i>&nbsp; --}}
                                                            {{-- <img src="https://source.unsplash.com/350x350?notification"
                                                                alt="" width="40"> --}}
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
                                            <img class="cart-img" src="/assets/klikspl-logo.png" alt=""
                                                width="100">
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
                            <li></li>
                            <div class="nofitication-no-auth pt-3 justify-content-center text-center rounded-3 px-3">
                                <i class="bi bi-bell fs-1 text-secondary"></i>
                                <p class="text-muted pt-1 px-1">
                                    Tidak ada notifikasi untuk anda saat ini, masuk untuk melihat notifikasi di akun
                                    membership anda.
                                </p>
                            </div>
                        </ul>
                    @endauth
                </li>
                <li class="nav-item mx-1 navbar-dropdown dropdown d-none d-md-block">
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
                <li class="nav-item mx-1 navbar-dropdown dropdown d-none d-md-block">
                    <a class="nav-link dropdown-toggle navbar-chat" href="{{ route('notifications.index') }}">
                        <i class="bi bi-chat-dots"></i>
                        @auth
                            @if (count($userChats) > 0)
                                <span class="position-absolute top-5 start-100 translate-middle badge  bg-danger">
                                    {{ count($userChats['userChatGroupped']) }}
                                    <span class="visually-hidden">Chat</span>
                                </span>
                            @endif
                        @endauth
                    </a>
                    @auth
                        <ul class="dropdown-menu notification-dropdown-mobile notification-dropdown-logged-in-mobile">
                            <div class="">
                                <div class="d-flex fixed-top bg-transparent p-3">
                                    <div class="">
                                        Chat ({{ count($userChats['userChatGroupped']) }})
                                    </div>
                                    <div class="mx-3 ms-auto">
                                        <a href="{{ route('order.index') }}"
                                            class="text-decoration-none text-danger fw-bold">Lihat Semua</a>
                                    </div>
                                </div>
                                <div class="nav-chat-items mt-5">
                                    @if (count($userChats['userChatGroupped']) > 0)
                                    @foreach ($userChats['userChatGroupped'] as $chat)
                                        {{-- @foreach ($chats as $chat) --}}
                                        <li>
                                            <a class="dropdown-item my-2 chat-dropdown-item" href="{{ (!is_null($chat->last()->chat->order_id) ? route('order.show', $chat->last()->chat->order) : ((!is_null($chat->last()->chat->product_id)) ? route('product.show',$chat->last()->chat->product->slug) : '') ) }}">
                                                <div class="row align-items-center">
                                                    <div class="col-2">
                                                        @if (!is_null($chat->last()->chat->order_id))
                                                            @if (isset($chat->last()->chat->order))
                                                                @if (Storage::exists($chat->last()->chat->order->orderitem[0]->orderproduct->orderproductimage[0]->name))
                                                                    <img class="img-fluid w-100 border-radius-05rem"
                                                                        src="{{ asset('/storage/' . $chat->last()->chat->order->orderitem[0]->orderproduct->orderproductimage[0]->name) }}"
                                                                        alt="" width="40">
                                                                @endif
                                                            @else
                                                                <img class="img-fluid w-100 border-radius-05rem cart-items-logo"
                                                                    src="{{ asset('/assets/klikspl-logo.png') }}"
                                                                    alt="" width="20">
                                                            @endif
                                                        @elseif(!is_null($chat->last()->chat->product_id))
                                                            @if (count($chat->last()->chat->product->productimage) > 0)
                                                                @if (Storage::exists($chat->last()->chat->product->productimage[0]->name))
                                                                    <img class="img-fluid w-100 border-radius-05rem"
                                                                        src="{{ asset('/storage/' . $chat->last()->chat->product->productimage[0]->name) }}"
                                                                        alt="" width="40">
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div class="col-10 ps-0 text-truncate" data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom"
                                                        title="{{ is_null($chat->last()->chat->invoice_no) ? 'No.Invoice belum terbit' : $chat->last()->chat->invoice_no }}">
                                                        <div class="fw-600 m-0 text-truncate">
                                                            @if (!is_null($chat->last()->chat->order_id))
                                                                Pesanan
                                                                [
                                                                {{ !empty($chat->last()->chat->order->invoice_no) ? $chat->last()->chat->order->invoice_no : '(Kedaluwarsa)' }}
                                                                ]
                                                            @elseif(!is_null($chat->last()->chat->product_id))
                                                                Tanya Produk
                                                                [
                                                                {{ !empty($chat->last()->chat->product) ? $chat->last()->chat->product->name : '' }}
                                                                ]
                                                            @endif
                                                        </div>
                                                        <div class="fs-12 notification-description-navbar">
                                                            {{ $chat->last()->chat_message }}
                                                        </div>
                                                        <div class="fs-12 text-secondary">
                                                            {{ \Carbon\Carbon::parse($chat->last()->chat->created_at)->isoFormat('D MMM Y, HH:mm') }}
                                                            WIB
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        {{-- @endforeach --}}
                                    @endforeach
                                @else
                                        <div class="chat-no-auth pt-3 justify-content-center text-center rounded-3 px-3">
                                            <img class="chat-img" src="{{ asset('/assets/klikspl-logo.png') }}"
                                                alt="" width="100">
                                            <p class="text-muted py-3 px-2">
                                                Anda tidak memiliki obrolan saat ini, mulai obrolan dengan ADMIN KLIKSPL dengan bertanya tentang produk / pesanan anda
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </ul>
                    @else
                        <ul class="dropdown-menu notification-dropdown">
                            <li></li>
                            <div class="nofitication-no-auth pt-3 justify-content-center text-center rounded-3 px-3">
                                <i class="bi bi-bell fs-1 text-secondary"></i>
                                <p class="text-muted pt-1 px-1">
                                    Masuk/daftar membership untuk melihat obrolan anda.
                                </p>
                            </div>
                        </ul>
                    @endauth
                </li>
                <li class="nav-item mx-1 navbar-dropdown d-block d-md-none">
                    <button class="btn nav-link btn-show-pop-up-user shadow-none">
                        <i class="bi bi-list"></i>
                    </button>
                </li>
            </ul>

            @auth
                <div class="navbar-nav ms-auto navbar-account d-none d-md-block">
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
                <div class="navbar-nav ms-auto navbar-signup-login d-none d-md-flex">
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
<div class="mt-5 pt-4 fixed-top pop-up-user d-none d-lg-none">
    <div class="card pop-up-user-card">
        <div class="card-body">
            <ul class="list-unstyled">
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
                        @foreach ($partialMerks as $merk)
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
            @auth
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

                    <li class="my-2">
                        <form action="/logout" method="post">
                            @csrf
                            <button class="dropdown-item account-dropdown-item">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            @else
                <ul class="list-unstyled">
                    <li class="">
                        <a class="btn btn-toggle align-items-center shadow-none ps-3 py-2 {{ isset($active) ? ($active == 'login' ? 'active-menu' : '') : '' }}"
                            href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                        </a>
                    </li>

                    <li class="">
                        <a class="btn btn-toggle align-items-center shadow-none ps-3 py-2 {{ isset($active) ? ($active == 'register' ? 'active-menu' : '') : '' }}"
                            href="{{ route('register') }}">
                            <i class="bi bi-box-arrow-right me-2"></i>Daftar
                        </a>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.btn-show-pop-up-user').on('click', function(e) {
            if ($('.pop-up-user').hasClass('d-none')) {
                $('.pop-up-user').removeClass('d-none');
                $('.pop-up-user').addClass('d-block');
            } else {
                $('.pop-up-user').removeClass('d-block');
                $('.pop-up-user').addClass('d-none');
            }
        })
    });
</script>
