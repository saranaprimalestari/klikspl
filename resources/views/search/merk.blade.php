<h5 class="fs-6">Merk</h5>
<ul class="list-group list-group-flush">
    <form action="{{ route('product') }}" method="GET">
        <li class="list-group-item border-0 products-category-li p-0 ps-1">
            @if (request('keyword'))
                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
            @endif
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            @if (request('sortby'))
                <input type="hidden" name="sortby" value="{{ request('sortby') }}">
            @endif
            <input type="hidden" name="merk" value="">
            <button type="submit"
                class="btn p-0 text-dark text-decoration-none shadow-none category-left-side {{ request('merk') == '' ? 'fw-bold' : '' }}">Semua
                Merk
            </button>
        </li>
    </form>
    @foreach ($merks as $merk)
        <form action="{{ route('product') }}" method="GET">
            <li class="list-group-item border-0 products-category-li p-0 ps-1">
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
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if (request('sortby'))
                    <input type="hidden" name="sortby" value="{{ request('sortby') }}">
                @endif
                <input type="hidden" name="merk" value="{{ $merk->slug }}">
                <button type="submit"
                    class="text-start btn p-0 text-dark text-decoration-none shadow-none category-left-side {{ $merk->slug == request('merk') ? 'fw-bold' : '' }}">
                    {{ $merk->name }}
                </button>
            </li>
        </form>
    @endforeach
</ul>
