<nav id="sidebarMenu"
    class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse pt-md-5 pt-3 px-1 overflow-auto fs-14">
    <div class="position-sticky pt-md-5 pt-1">
        <ul class="nav flex-column mb-5">
            <li class="nav-item">
                <a class="nav-link {{ isset($active) ? ($active == 'dashboard' ? 'active' : '') : '' }}"
                    aria-current="page" href="{{ route('admin.home') }}">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
            </li>
            @if (auth()->guard('adminMiddle')->user()->admin_type == 1)
                <li class="nav-item">
                    <a class="nav-link {{ isset($active) ? ($active == 'management' ? 'active' : '') : '' }}"
                        href="{{ route('management.index') }}">
                        <i class="bi bi-people"></i> Manajemen Admin
                    </a>
                </li>
            @endif
            {{-- <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{ route('admin.test') }}">
                    <i class="bi bi-house-door"></i> Test
                </a>
            </li> --}}
            @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                auth()->guard('adminMiddle')->user()->admin_type == 2 ||
                auth()->guard('adminMiddle')->user()->admin_type == 4)
                <li class="nav-item">
                    <a class="btn btn-toggle align-items-center shadow-none user-button-menu-collapse accordion-button py-2 ps-3 fs-14"
                        data-bs-toggle="collapse" href="#product-collapse" role="button" aria-expanded="false"
                        aria-controls="product-collapse">
                        <i class="bi bi-archive"></i>&nbsp;Produk
                    </a>
                    <div class="collapse show" id="product-collapse" style="">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small nav">
                            <li class="nav-item w-100">
                                <a href="{{ route('adminproduct.index') }}"
                                    class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'adminproduct' ? 'active' : '') : '' }}">Produk
                                    Saya</a>
                            </li>
                            @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                                auth()->guard('adminMiddle')->user()->admin_type == 2)
                                <li class="nav-item w-100">
                                    <a href="{{ route('adminproduct.create') }}"
                                        class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'add-product' ? 'active' : '') : '' }}">Tambah
                                        Produk </a>
                                </li>
                                <li class="nav-item w-100">
                                    <a href="{{ route('admin.product.out.stock') }}"
                                        class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'outstock' ? 'active' : '') : '' }}">Stok
                                        habis </a>
                                </li>
                                <li class="nav-item w-100">
                                    <a href="{{ route('admincategory.index') }}"
                                        class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'category' ? 'active' : '') : '' }}">Kategori
                                    </a>
                                </li>
                                <li class="nav-item w-100">
                                    <a href="{{ route('adminmerk.index') }}"
                                        class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'merk' ? 'active' : '') : '' }}">Merk
                                    </a>
                                </li>
                                <li class="nav-item w-100">
                                    <a href="{{ route('productcomment.index') }}"
                                        class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'product-comment' ? 'active' : '') : '' }}">
                                        Komentar Pembeli
                                    </a>
                                </li>
                                <li class="nav-item w-100">
                                    <a href="{{ route('my.comment.index') }}"
                                        class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'product-comment-replied' ? 'active' : '') : '' }}">
                                        Komentar saya
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif
            <li class="nav-item">
                <a class="btn btn-toggle align-items-center shadow-none user-button-menu-collapse accordion-button py-2 ps-3 fs-14"
                    data-bs-toggle="collapse" href="#order-collapse" role="button" aria-expanded="false"
                    aria-controls="order-collapse">
                    <i class="bi bi-cart"></i>&nbsp;Pesanan
                </a>
                <div class="collapse show" id="order-collapse" style="">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small nav">
                        @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                            auth()->guard('adminMiddle')->user()->admin_type == 2)
                            <li class="nav-item w-100">
                                <a href="{{ route('adminorder.index') }}"
                                    class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($status) ? ($status == '' ? 'active' : '') : '' }}">Semua</a>
                            </li>
                            <li class="nav-item w-100">
                                <form class="status-form" action="{{ route('adminorder.index') }}" method="GET">
                                    <input type="hidden" name="status" value="aktif">
                                    <input type="submit"
                                        class="text-decoration-none shadow-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link border-0 bg-transparent {{ isset($status) ? ($status == 'aktif' ? 'active' : '') : '' }}"
                                        value="Aktif">
                                </form>
                            </li>
                            {{-- <a href="{{ route('adminorder.index') }}"
                            class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($status) ? ($status == 'belum bayar' ? 'active-menu border-danger' : '') : '' }}">Menunggu
                            Pembayaran</a> --}}
                            <li class="nav-item w-100">
                                <form class="status-form" action="{{ route('adminorder.index') }}" method="GET">
                                    <input type="hidden" name="status" value="belum bayar">
                                    {{-- @if (request('date_start'))
                                    <input type="hidden" name="date_start" value="{{ request('date_start') }}">
                                @endif
                                @if (request('date_end'))
                                    <input type="hidden" name="date_end" value="{{ request('date_end') }}">
                                @endif --}}
                                    <input type="submit"
                                        class="text-decoration-none shadow-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link border-0 bg-transparent {{ isset($status) ? ($status == 'belum bayar' ? 'active' : '') : '' }}"
                                        value="Menunggu Pembayaran">
                                    {{-- Menunggu Pembayaran --}}
                                    {{-- </input> --}}
                                </form>
                            </li>
                        @endif
                        @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                            auth()->guard('adminMiddle')->user()->admin_type == 2 ||
                            auth()->guard('adminMiddle')->user()->admin_type == 3)
                            <li class="nav-item w-100">
                                <form class="status-form" action="{{ route('adminorder.index') }}" method="GET">
                                    {{-- @if (request('date_start'))
                                    <input type="hidden" name="date_start" value="{{ request('date_start') }}">
                                @endif
                                @if (request('date_end'))
                                    <input type="hidden" name="date_end" value="{{ request('date_end') }}">
                                @endif --}}
                                    <input type="hidden" name="status" value="pesanan dibayarkan">
                                    <input type="submit"
                                        class="text-decoration-none shadow-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link border-0 bg-transparent {{ isset($status) ? ($status == 'pesanan dibayarkan' ? 'active' : '') : '' }}"
                                        value="Konfirmasi Pembayaran">
                                    {{-- Konfirmasi Pembayaran
                                </input> --}}
                                </form>
                            </li>
                        @endif
                        @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                            auth()->guard('adminMiddle')->user()->admin_type == 2 ||
                            auth()->guard('adminMiddle')->user()->admin_type == 4)
                            <li class="nav-item w-100">
                                <form class="status-form" action="{{ route('adminorder.index') }}" method="GET">
                                    <input type="hidden" name="status" value="pembayaran dikonfirmasi">
                                    <input type="submit"
                                        class="text-decoration-none shadow-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link border-0 bg-transparent {{ isset($status) ? ($status == 'pembayaran dikonfirmasi' ? 'active' : '') : '' }}"
                                        value="Perlu Diproses">
                                </form>
                            </li>

                            {{-- <li class="nav-item w-100">
                            <a href="{{ route('adminorder.index') }}"
                                class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'order' ? 'active' : '') : '' }}">Konfirmasi
                                Pembayaran</a>
                            </li> --}}
                            <li class="nav-item w-100">
                                <form class="status-form" action="{{ route('adminorder.index') }}" method="GET">
                                    <input type="hidden" name="status" value="pesanan disiapkan">
                                    {{-- @if (request('date_start'))
                                    <input type="hidden" name="date_start" value="{{ request('date_start') }}">
                                @endif
                                @if (request('date_end'))
                                    <input type="hidden" name="date_end" value="{{ request('date_end') }}">
                                @endif --}}
                                    <input type="submit"
                                        class="text-decoration-none shadow-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link border-0 bg-transparent {{ isset($status) ? ($status == 'pesanan disiapkan' ? 'active' : '') : '' }}"
                                        value="Siap Dikirim">
                                    {{-- Siap Dikirim
                                </input> --}}
                                </form>
                            </li>

                            {{-- <li class="nav-item w-100">
                            <a href="{{ route('adminorder.index') }}"
                                class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'order' ? 'active' : '') : '' }}">Siap Dikirim</a>
                            </li> --}}
                            <li class="nav-item w-100">
                                <form class="status-form" action="{{ route('adminorder.index') }}" method="GET">
                                    <input type="hidden" name="status" value="pesanan dikirim">
                                    {{-- @if (request('date_start'))
                                    <input type="hidden" name="date_start" value="{{ request('date_start') }}">
                                @endif
                                @if (request('date_end'))
                                    <input type="hidden" name="date_end" value="{{ request('date_end') }}">
                                @endif --}}
                                    <input type="submit"
                                        class="text-decoration-none shadow-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link border-0 bg-transparent {{ isset($status) ? ($status == 'pesanan dikirim' ? 'active' : '') : '' }}"
                                        value="Dalam Pengiriman">
                                    {{-- Dalam Pengiriman
                                </input> --}}
                                </form>
                            </li>

                            {{-- <li class="nav-item w-100">
                            <a href="{{ route('adminorder.index') }}"
                                class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'order' ? 'active' : '') : '' }}">Dalam
                                Pengiriman</a>
                            </li> --}}
                            @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                                auth()->guard('adminMiddle')->user()->admin_type == 2)
                                <li class="nav-item w-100">
                                    <form class="status-form" action="{{ route('adminorder.index') }}"
                                        method="GET">
                                        <input type="hidden" name="status" value="sampai tujuan">
                                        {{-- @if (request('date_start'))
                                    <input type="hidden" name="date_start" value="{{ request('date_start') }}">
                                @endif
                                @if (request('date_end'))
                                    <input type="hidden" name="date_end" value="{{ request('date_end') }}">
                                @endif --}}
                                        <input type="submit"
                                            class="text-decoration-none shadow-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link border-0 bg-transparent {{ isset($status) ? ($status == 'sampai tujuan' ? 'active' : '') : '' }}"
                                            value="Sampai Tujuan">
                                        {{-- Selesai
                                </input> --}}
                                    </form>
                                </li>

                                <li class="nav-item w-100">
                                    <form class="status-form" action="{{ route('adminorder.index') }}"
                                        method="GET">
                                        <input type="hidden" name="status" value="selesai">
                                        <input type="submit"
                                            class="text-decoration-none shadow-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link border-0 bg-transparent {{ isset($status) ? ($status == 'selesai' ? 'active' : '') : '' }}"
                                            value="Selesai">
                                    </form>
                                </li>

                                {{-- <li class="nav-item w-100">
                            <a href="{{ route('adminorder.index') }}"
                                class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'order' ? 'active' : '') : '' }}">Selesai</a>
                            </li> --}}
                                <li class="nav-item w-100">
                                    <form class="status-form" action="{{ route('adminorder.index') }}"
                                        method="GET">
                                        <input type="hidden" name="status" value="pengajuan pembatalan">
                                        <input type="submit"
                                            class="text-decoration-none shadow-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link border-0 bg-transparent {{ isset($status) ? ($status == 'pengajuan pembatalan' ? 'active' : '') : '' }}"
                                            value="pengajuan pembatalan">
                                    </form>
                                </li>
                                <li class="nav-item w-100">
                                    <form class="status-form" action="{{ route('adminorder.index') }}"
                                        method="GET">
                                        <input type="hidden" name="status" value="expired">
                                        {{-- @if (request('date_start'))
                                    <input type="hidden" name="date_start" value="{{ request('date_start') }}">
                                @endif
                                @if (request('date_end'))
                                    <input type="hidden" name="date_end" value="{{ request('date_end') }}">
                                @endif --}}
                                        <input type="submit"
                                            class="text-decoration-none shadow-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link border-0 bg-transparent {{ isset($status) ? ($status == 'expired' ? 'active' : '') : '' }}"
                                            value="Dibatalkan">
                                        {{-- Dibatalkan
                                </input> --}}
                                    </form>
                                </li>
                            @endif
                        @endif

                    </ul>
                </div>
            </li>
            @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                auth()->guard('adminMiddle')->user()->admin_type == 2)
                <li class="nav-item">
                    <a class="btn btn-toggle align-items-center shadow-none user-button-menu-collapse accordion-button py-2 ps-3 fs-14"
                        data-bs-toggle="collapse" href="#promo-collapse" role="button" aria-expanded="false"
                        aria-controls="promo-collapse">
                        <i class="bi bi-percent"></i>&nbsp;Promo
                    </a>
                    <div class="collapse show" id="promo-collapse" style="">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small nav">
                            <li class="nav-item w-100">
                                <a href="{{ route('promovoucher.index') }}"
                                    class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'promo-voucher' ? 'active' : '') : '' }}">
                                    Voucher
                                </a>
                            </li>
                            {{-- <li class="nav-item w-100">
                                <a href="{{ route('adminproduct.index') }}"
                                    class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'promo' ? 'active' : '') : '' }}">
                                    Produk
                                </a>
                            </li> --}}
                            <li class="nav-item w-100">
                                <a href="{{ route('promobanner.index') }}"
                                    class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'promo-banner' ? 'active' : '') : '' }}">
                                    Banner
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                auth()->guard('adminMiddle')->user()->admin_type == 2 ||
                auth()->guard('adminMiddle')->user()->admin_type == 3)
                <li class="nav-item">
                    <a class="btn btn-toggle align-items-center shadow-none user-button-menu-collapse accordion-button py-2 ps-3 fs-14"
                        data-bs-toggle="collapse" href="#finance-collapse" role="button" aria-expanded="false"
                        aria-controls="finance-collapse">
                        <i class="bi bi-wallet"></i>&nbsp;Keuangan
                    </a>
                    <div class="collapse show" id="finance-collapse" style="">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small nav">
                            <li class="nav-item w-100">
                                <a href="{{ route('admin.income') }}"
                                    class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'income' ? 'active' : '') : '' }}">
                                    Penghasilan Saya
                                </a>
                            </li>
                            <li class="nav-item w-100">
                                <a href="{{ route('paymentmethod.index') }}"
                                    class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'payment-method' ? 'active' : '') : '' }}">
                                    Metode Pembayaran
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link {{ isset($active) ? ($active == 'notifications' ? 'active' : '') : '' }}"
                    href="{{ route('adminnotifications.index') }}">
                    <i class="bi bi-bell"></i> Notifikasi
                </a>
            </li>
            @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                auth()->guard('adminMiddle')->user()->admin_type == 2)
                <li class="nav-item">
                    <a class="nav-link {{ isset($active) ? ($active == 'senderAddress' ? 'active' : '') : '' }}"
                        href="{{ route('senderaddress.index') }}">
                        <i class="bi bi-geo-alt"></i> Alamat Pengiriman
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-graph-up"></i> Statistik
                    </a>
                </li>
            @endif
            <li class="nav-item d-block d-sm-none">
                <a class="btn btn-toggle align-items-center shadow-none user-button-menu-collapse accordion-button py-2 ps-3 fs-14"
                    data-bs-toggle="collapse" href="#profile-collapse" role="button" aria-expanded="false"
                    aria-controls="profile-collapse">
                    <i class="far fa-user-circle me-1"></i>&nbsp;Profil
                </a>
                <div class="collapse show" id="profile-collapse" style="">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small nav">
                        <li class="nav-item w-100">
                            <a href="{{ route('adminproduct.index') }}"
                                class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'finance' ? 'active' : '') : '' }}">
                                Profil Saya
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="{{ route('paymentmethod.index') }}"
                                class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex nav-link {{ isset($active) ? ($active == 'payment-method' ? 'active' : '') : '' }}">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
