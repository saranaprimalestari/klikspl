<h5 class="fs-6">Kategori</h5>
<ul class="list-group list-group-flush">
    <form action="{{ route('product') }}" method="GET">
        <li class="list-group-item border-0 products-category-li p-0 ps-1">
            @if (request('keyword'))
                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
            @endif
            @if (request('merk'))
                <input type="hidden" name="merk" value="{{ request('merk') }}">
            @endif
            @if (request('sortby'))
                <input type="hidden" name="sortby" value="{{ request('sortby') }}">
            @endif
            <input type="hidden" name="category" value="">
            <button type="submit"
                class="btn p-0 text-dark text-decoration-none shadow-none category-left-side {{ request('category') == '' ? 'fw-bold' : '' }}">Semua
                kategori
            </button>
        </li>
    </form>
    @foreach ($categories as $category)
        <form action="{{ route('product') }}" method="GET">
            <li class="list-group-item border-0 products-category-li p-0 ps-1">
                {{-- <a class="text-dark text-decoration-none category-left-side"
                                        href="/category/{{ $category->slug }}">
                                        {{ $category->name }}
                                    </a> --}}
                {{-- <a class="text-dark text-decoration-none category-left-side {{ $category->slug == request('category') ? 'fw-bold' : '' }}"
                                            href="/products?category={{ $category->slug }}">
                                            {{ $category->name }}
                                        </a> --}}
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
                    class="btn p-0 text-dark text-decoration-none shadow-none category-left-side {{ $category->slug == request('category') ? 'fw-bold' : '' }}">
                    {{ $category->name }}
                </button>
            </li>
        </form>
    @endforeach
</ul>
