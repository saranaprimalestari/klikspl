<div class="dropdown">
    <form action="{{ route('product') }}" method="GET">
        @if (request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        @if (request('merk'))
            <input type="hidden" name="merk" value="{{ request('merk') }}">
        @endif
        @if (request('keyword'))
            <input type="hidden" name="keyword" value="{{ request('keyword') }}">
        @endif
        <button class="btn w-100 shadow-none product-sortby-btn" type="button" id="dropdownMenuButton1"
            data-bs-toggle="dropdown" aria-expanded="false">
            <div class="d-flex">
                <div class="w-100 text-start">
                    @if (request('sortby'))
                        {{ request('sortby') }}
                    @else
                        Terbaru
                    @endif
                </div>
                <div class="flex-shrink-1">
                    <i class="bi bi-chevron-down"></i>
                </div>
            </div>
        </button>
        <ul class="dropdown-menu w-100 product-sortby-menu" aria-labelledby="dropdownMenuButton1">
            <li>
                <input type="submit" class="dropdown-item" name="sortby" value="Terbaru">
            </li>
            <li>
                <input type="submit" class="dropdown-item" name="sortby" value="Terbaik">
            </li>
            <li>
                <input type="submit" class="dropdown-item" name="sortby" value="Terlaris">
            </li>
            <li>
                <input type="submit" class="dropdown-item" name="sortby" value="Dilihat Terbanyak">
            </li>
            <li>
                <input type="submit" class="dropdown-item" name="sortby" value="Harga Terendah">
            </li>
            <li>
                <input type="submit" class="dropdown-item" name="sortby" value="Harga Tertinggi">
            </li>
        </ul>
    </form>
</div>
