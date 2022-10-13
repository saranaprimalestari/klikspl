<div class="text-truncate">
    <form action="{{ route('product') }}" method="GET">
        @if (request('keyword'))
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            @if (request('merk'))
                <input type="hidden" name="merk" value="{{ request('merk') }}">
            @endif
            @if (request('sortby'))
                <input type="hidden" name="sortby" value="{{ request('sortby') }}">
            @endif
            <input type="hidden" name="keyword" value="">
            <button type="submit" class="btn product-reset-filter mx-1 text-truncate products-clear-filter-btn shadow-none mb-3">
                <i class="bi bi-x-lg"></i> {{ request('keyword') }}
            </button>
            {{-- <a href="{{ route('product') }}"
                class="text-decoration-none btn btn-outline-dark product-reset-filter mx-1 w-25 text-truncate">
                <i class="bi bi-x-lg"></i> {{ request('keyword') }}
            </a> --}}
        @endif
    </form>
</div>
<div class="text-truncate">

    <form action="{{ route('product') }}" method="GET">
        @if (request('category'))
            @if (request('keyword'))
                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
            @endif
            @if (request('merk'))
                <input type="hidden" name="merk" value="{{ request('merk') }}">
            @endif
            @if (request('sortby'))
                <input type="hidden" name="sortby" value="{{ request('sortby') }}">
            @endif
            <button type="submit" class="btn product-reset-filter mx-1 text-truncate products-clear-filter-btn shadow-none mb-3">
                <i class="bi bi-x-lg"></i> {{ request('category') }}
            </button>
            {{-- <a href="{{ route('product') }}"
            class="text-decoration-none btn btn-outline-dark product-reset-filter mx-1 w-25 text-truncate">
            <i class="bi bi-x-lg"></i> {{ request('keyword') }}
        </a> --}}
        @endif
    </form>
</div>
<div class="text-truncate">

    <form action="{{ route('product') }}" method="GET">

        @if (request('merk'))
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            @if (request('keyword'))
                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
            @endif
            @if (request('sortby'))
                <input type="hidden" name="sortby" value="{{ request('sortby') }}">
            @endif
            <button type="submit" class="btn product-reset-filter mx-1 text-truncate products-clear-filter-btn shadow-none mb-3">
                <i class="bi bi-x-lg"></i> {{ request('merk') }}
            </button>
            {{-- <a href="{{ route('product') }}"
            class="text-decoration-none btn btn-outline-dark product-reset-filter mx-1 w-25 text-truncate">
            <i class="bi bi-x-lg"></i> {{ request('keyword') }}
        </a> --}}
        @endif

    </form>
</div>
