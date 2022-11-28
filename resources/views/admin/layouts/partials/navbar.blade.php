<nav class="navbar navbar-expand-lg shadow-sm p-3 mb-5 bg-body rounded fixed-top navbar-light">
    <div class="container-fluid fs-14">
        <a class="navbar-brand me-auto" href="{{ route('admin.home') }}">
            <img class="w-auto" src=" {{ asset('/assets/admin-logotype.svg') }}" alt="">
        </a>
        <ul class="navbar-nav mb-2 mb-lg-0 d-none d-sm-block">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Refresh Halaman" onclick="reloadFunction()">
                    <i class="bi bi-arrow-clockwise"></i>
                    {{-- <i class="fas fa-sync-alt"></i> --}}
                </a>
              </li>
        </ul>
        <ul class="navbar-nav mb-2 mb-lg-0 d-none d-sm-block fs-14">
            <li class="nav-item dropdown">
                <a class="fs-14 nav-link dropdown-toggle link-dark color-red-klikspl-hover" id="notification-navbar-dropdown"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell"></i>
                    {{-- @auth --}}
                    {{-- @if (count($userNotifications) > 0) --}}
                    <span class="position-absolute top-5 start-100 translate-middle badge bg-danger">
                        1
                        <span class="visually-hidden">Notifications</span>
                    </span>
                    {{-- @endif --}}
                    {{-- @endauth --}}
                </a>
                @if (Auth::guard('adminMiddle')->user())
                    <ul class="dropdown-menu dropdown-menu-end admin-notification-dropdown" aria-labelledby="notification-navbar-dropdown">
                        <div class="">
                            {{-- <div class="d-flex fixed-top bg-white p-3"> --}}
                            <div class="">
                                {{-- {{ dd($userNotifications) }} --}}
                                {{-- Notifikasi({{ count($userNotifications) }}) --}}
                            </div>
                            <div class="mx-3 my-2">
                                <a href="{{ route('notifications.index') }}"
                                    class="fs-14 text-decoration-none text-danger fw-bold">Lihat Semua
                                    Notifikasi</a>
                            </div>
                            {{-- </div> --}}
                            {{-- {{ dd($userCartItems) }} --}}
                            <div class="nav-notification-items mt-1">
                                <li><a class="fs-14 dropdown-item" href="#">Action</a></li>
                                <li><a class="fs-14 dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="fs-14 dropdown-item" href="#">Something else here</a></li>
                            </div>
                        </div>
                    </ul>
                @endif
            </li>
        </ul>
        <div class="navbar-nav navbar-account d-none d-sm-block">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mx-1 nav-acc link-dark" href="#" id="navbarDropdown"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="far fa-user-circle"></i>
                    @if (isset(auth()->guard('adminMiddle')->user()->username))
                        {{ auth()->guard('adminMiddle')->user()->username }}
                    @else
                        {{ route('admin.logout') }}
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li class="my-2">
                        <a class="dropdown-item account-dropdown-item" href="{{ route('adminprofile.index') }}">
                            <i class="far fa-user-circle me-1"></i> Akun saya
                        </a>
                    </li>
                    <li class="my-2">
                        <form action="{{ route('admin.logout') }}" method="post">
                            @csrf
                            <button class="dropdown-item account-dropdown-item">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </div>
        <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>
