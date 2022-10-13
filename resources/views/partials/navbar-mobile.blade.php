<nav class="navbar navbar-expand navbar-light bg-white shadow-sm p-3 mb-5 bg-body rounded fixed-top d-block d-sm-none">
    <div class="container-fluid">
        <a class="navbar-brand d-none d-sm-block" href="/"> <img class="w-auto" src="assets/logotype2.svg" alt=""> </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            {{-- <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ $active === 'Home' ? 'active' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active === 'About' ? 'active' : '' }}" href="/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active === 'posts' ? 'active' : '' }}" href="/posts">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active === 'categories' ? 'active' : '' }}" href="/categories">Category</a>
                </li>
            </ul> --}}
            {{-- <form class="d-flex" action="/posts">
					<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-light" type="submit">Search</button>
				</form> --}}
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 p-0">
                <li class="nav-item mx-auto d-none d-sm-block">
                    <div class="btn-group">
                        <button type="button" class="btn btn-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                          Kategori
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="#">Action</a></li>
                          <li><a class="dropdown-item" href="#">Another action</a></li>
                          <li><a class="dropdown-item" href="#">Something else here</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item" href="#">Separated link</a></li>
                        </ul>
                      </div>
                </li>
                <li class="nav-item">
                    <form action="/posts">
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if (request('author'))
                            <input type="hidden" name="author" value="{{ request('author') }}">
                        @endif
                        <div class="input-group me-3">
                            <input type="text" class="form-control search-input" placeholder="Search ..." name="search"
                                value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary search-submit" type="submit">
                                {{-- <i class="fas fa-search"></i> --}}
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </li>
            </ul>
            @auth
                <div class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome back, {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/dashboard "><i
                                        class="bi bi-layout-text-window-reverse"></i> My Dashboard</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="/logout" method="post">
                                    @csrf
                                    <button class="dropdown-item">
                                        <i class="bi bi-box-arrow-in-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </div>
            @else
                <div class="navbar-nav ms-auto d-none d-sm-block">
                    <div class="nav-item">
                        <a href="/login" class="nav-link"><i class="fa fa-sign-in-alt"></i> Daftar Membership </a>
                    </div>
                    <div class="nav-item">
                        <a href="/login" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> Masuk </a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>
