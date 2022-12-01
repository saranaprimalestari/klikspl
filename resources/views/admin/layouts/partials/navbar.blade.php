<nav class="navbar navbar-expand-lg shadow-sm p-3 mb-5 bg-body rounded fixed-top navbar-light">
    <div class="container-fluid fs-14">
        <a class="navbar-brand me-auto" href="{{ route('admin.home') }}">
            <img class="w-auto" src=" {{ asset('/assets/admin-logotype.svg') }}" alt="">
        </a>
        <ul class="navbar-nav mb-2 mb-lg-0 d-none d-sm-block">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#" data-bs-toggle="tooltip"
                    data-bs-placement="bottom" title="Refresh Halaman" onclick="reloadFunction()">
                    <i class="bi bi-arrow-clockwise"></i>
                    {{-- <i class="fas fa-sync-alt"></i> --}}
                </a>
            </li>
        </ul>
        <ul class="navbar-nav mb-2 mb-lg-0 d-none d-sm-block fs-14">
            <li class="nav-item dropdown">
                <a class="fs-14 nav-link link-dark color-red-klikspl-hover" id="notification-navbar-dropdown"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell"></i>
                    {{-- @auth --}}
                    @if (count($adminNotifications) > 0)
                        <span class="position-absolute top-5 start-100 translate-middle badge bg-danger">
                            {{ count($adminNotifications) }}
                            <span class="visually-hidden">Notifications</span>
                        </span>
                    @endif
                    {{-- @endauth --}}
                </a>
                @if (Auth::guard('adminMiddle')->user())
                    <ul class="dropdown-menu dropdown-menu-end admin-notification-dropdown"
                        aria-labelledby="notification-navbar-dropdown">
                        <div class="">
                            <div class="mx-3 my-2">
                                <div class="d-flex">
                                    <div class="fs-14">
                                        Notifikasi ({{ count($adminNotifications) }})
                                    </div>
                                    <a href="{{ route('adminnotifications.index') }}"
                                        class="fs-14 text-decoration-none text-danger fw-bold ms-auto">Lihat Semua Notifikasi</a>
                                </div>
                            </div>
                            <div class="nav-notification-items mt-1">
                                @foreach ($adminNotifications as $notification)
                                {{-- @if (auth()->guard('adminMiddle')->user()->admin_type == '1' || )
                                    
                                @endif --}}
                                    <li>
                                        <a class="dropdown-item my-2 admin-notification-dropdown-item fs-14"
                                            href="{{ route('adminnotifications.show', $notification) }}">
                                            <div class="row align-items-center">
                                                <div class="col-2">
                                                    @if (File::exists(public_path($notification->image)))
                                                        <img src="{{ asset($notification->image) }}"
                                                            class="img-fluid w-100 border-radius-05rem" alt="...">
                                                    @endif
                                                </div>
                                                <div class="col-10 ps-0 admin-notification-dropdown-text">
                                                    <div class="fw-600 m-0">
                                                        {{ $notification->excerpt }}
                                                    </div>
                                                    <div class="fs-12 admin-notification-description-navbar"> 
                                                        {!! $notification->description !!}
                                                    </div>
                                                    <div class="fs-12 text-secondary">
                                                        {{ \Carbon\Carbon::parse($notification->created_at)->isoFormat('D MMM Y, HH:mm') }}
                                                        WIB
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
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
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>
