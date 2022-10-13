@extends('layouts.main')

@section('container')

    {{-- {{ dd($userCartItems) }} --}}
    {{-- {{ print_r(session()->all()) }} --}}
    {{-- {{ dd(session()->all()) }} --}}
    <div class="container-fluid breadcrumb-products">
        {{ Breadcrumbs::render('cart') }}
    </div>
    <div class="container my-5">
        <div class="col-12">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show alert-success-cart" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('failed'))
                <div class="alert alert-danger alert-dismissible fade show alert-success-cart" role="alert">
                    {{ session('failed') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        {{-- <div class="row my-3">
            <div class="col-12">
                <a href="{{ url()->previous() }}" class="text-decoration-none link-dark">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div> --}}

        @if (count($userCartItems) > 0)
            <div class="row mt-3">
                <div class="d-flex">
                    <div class="select-all-delete me-3 d-flex align-items-center">
                        <input class="form-check-input cart-items-select-all-checkbox shadow-none m-0" type="checkbox"
                            value="" id="selectAllCheckbox">
                        <label class="ms-1 cart-items-select-all-text" for="selectAllCheckbox">
                            Pilih Semua
                        </label>
                    </div>
                    <div class="delete-all-btn">
                        @php
                            $cart_ids = [];
                            foreach ($userCartItems as $carts) {
                                array_push($cart_ids, $carts->id);
                            }
                        @endphp
                        <form action="{{ route('cart.destroyall') }}" method="post" class="d-inline">
                            {{-- @method('delete') --}}
                            @csrf
                            @foreach ($userCartItems as $carts)
                                <input type="hidden" name="ids[{{ $carts->id }}]" value="">
                                {{-- <input type="hidden" name="ids[{{ $carts->id }}]" value="{{ $carts->id }}"> --}}
                                {{-- <input type="hidden" name="ids[]" value="{{ $carts->id }}"> --}}
                            @endforeach
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <button type="submit"
                                class="btn shadow-none text-decoration-none text-dark cart-items-delete-all">
                                <i class="far fa-trash-alt"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="carts mt-4 mb-5">
                <div class="row">
                    <div class="col-md-8 col-12">
                        @foreach ($userCartItems as $cart)
                            <div class="card mb-3 cart-items-card">
                                <div class="card-body py-4">
                                    <div class="row d-flex align-items-center justify-content-center text-center">
                                        <div class="col-md-1 col-2 pe-0 d-flex justify-content-center align-items-center">
                                            {{-- @if (session()->has('success') && $cart->id == session('cartitems')->id) --}}
                                            {{-- <input class="form-check-input cart-items-check shadow-none m-0"
                                                    type="checkbox" name="cart-items-check" value="{{ $cart->id }}"
                                                    id="cart-check-{{ $cart->id }}" checked> --}}
                                            {{-- @else --}}
                                            @if (!is_null($cart->productvariant))
                                                @if (!empty($cart->productvariant->stock))
                                                    <input class="form-check-input cart-items-check shadow-none m-0"
                                                        type="checkbox" name="cart-items-check" value="{{ $cart->id }}"
                                                        id="cart-check-{{ $cart->id }}">
                                                @endif
                                            @else
                                                @if (!empty($cart->product->stock))
                                                    <input class="form-check-input cart-items-check shadow-none m-0"
                                                        type="checkbox" name="cart-items-check" value="{{ $cart->id }}"
                                                        id="cart-check-{{ $cart->id }}">
                                                @endif
                                            @endif
                                            {{-- @endif --}}
                                            {{-- <label for="cart-check-{{ $cart->id }}">{{ $cart->id }}</label> --}}
                                        </div>
                                        <div class="col-md-1 col-3">
                                            <a href="{{ route('product.show', $cart->product) }}"
                                                class="text-decoration-none text-dark">
                                                @if (count($cart->product->productimage) > 0)
                                                    @if (Storage::exists($cart->product->productimage[0]->name))
                                                        <img class="cart-items-img"
                                                            src="{{ asset('/storage/' . $cart->product->productimage[0]->name) }}"
                                                            alt="" width="60">
                                                    @else
                                                        <img class="cart-items-img"
                                                            src="https://source.unsplash.com/400x400?product--{{ $loop->iteration }}"
                                                            alt="" width="60">
                                                    @endif
                                                @else
                                                    <img class="cart-items-img"
                                                        src="https://source.unsplash.com/400x400?product--{{ $loop->iteration }}"
                                                        alt="" width="60">
                                                @endif
                                                {{-- <img id="main-image" class="cart-items-img"
                                                    src="https://source.unsplash.com/400x400?product-1" class="img-fluid"
                                                    alt="..." width="60"> --}}
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-7 ps-3">
                                            <a href="{{ route('product.show', $cart->product) }}"
                                                class="text-decoration-none text-dark">
                                                <div class="cart-items-product-info text-start ms-2 ">
                                                    <p class="text-truncate cart-items-product-name m-0"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="{{ $cart->product->name }}">
                                                        {{ $cart->product->name }}
                                                    </p>
                                                    <p class="text-truncate cart-items-product-variant fs-13">
                                                        Varian:
                                                        @if (!is_null($cart->productvariant))
                                                            {{ $cart->productvariant->variant_name }}
                                                        @else
                                                            Tidak ada varian
                                                        @endif
                                                    </p>
                                                    <p class="text-truncate cart-items-product-variant fs-13">
                                                        Berat Produk:
                                                        @if (!is_null($cart->productvariant))
                                                            {{ $cart->productvariant->weight }}
                                                        @else
                                                            {{ $cart->product->weight }}
                                                        @endif
                                                        (gr)
                                                    </p>
                                                    <p class="cart-items-price fs-13">
                                                        <input type="hidden"
                                                            name="price-cart-items-val-{{ $cart->id }}"
                                                            class="price-cart-items-val-{{ $cart->id }}"
                                                            value="{{ isset($cart->productVariant) ? $cart->productVariant->price : $cart->product->price }}">
                                                        @if (isset($cart->productVariant))
                                                            Rp{{ price_format_rupiah($cart->productVariant->price) }}
                                                        @else
                                                            Rp{{ price_format_rupiah($cart->product->price) }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-3 col-6 my-3">
                                            <div class="ms-2">
                                                <div class="input-group inline-group-qty-cart-items ms-1">
                                                    <div class="input-group-prepend">
                                                        <button type="button"
                                                            class="btn {{ !is_null($cart->productvariant) ? (empty($cart->productvariant->stock) ? 'disabled' : '') : (empty($cart->product->stock) ? 'disabled' : '') }} btn-minus-qty-cart-items shadow-none cart-items-minus-btn">
                                                            <i class="bi bi-dash-lg"></i>
                                                        </button>
                                                    </div>
                                                    <input
                                                        class="form-control qty-cart-items cart-items-quantity shadow-none"
                                                        min="0" name="quantity" id="quantity"
                                                        value="{{ $cart->quantity }}" type="number" min="1"
                                                        max="{{ isset($cart->productVariant) ? $cart->productVariant->stock : $cart->product->stock }}"
                                                        onkeydown="return false"
                                                        {{ !is_null($cart->productvariant) ? (empty($cart->productvariant->stock) ? 'disabled' : '') : (empty($cart->product->stock) ? 'disabled' : '') }}>
                                                    <div class="input-group-append">
                                                        <button type="button"
                                                            class="btn {{ !is_null($cart->productvariant) ? (empty($cart->productvariant->stock) ? 'disabled' : '') : (empty($cart->product->stock) ? 'disabled' : '') }} btn-plus-qty-cart-items shadow-none cart-items-plus-btn">
                                                            <i class="bi bi-plus-lg"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="_method" value="put">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="cart-id" value="{{ $cart->id }}">
                                                    <input type="hidden" name="product-id"
                                                        value="prod id: {{ $cart->product_id }}">
                                                    <input type="hidden" name="product-variant-id"
                                                        value="{{ $cart->product_variant_id }}">

                                                    <input type="hidden" name="sender-address-id"
                                                        value="{{ $cart->sender_address_id }}">

                                                    <input type="hidden" name="quantity-cart-{{ $cart->id }}"
                                                        value="{{ $cart->quantity }}">
                                                    <input type="hidden" name="quantity-item-{{ $cart->id }}"
                                                        value="{{ isset($cart->productVariant) ? $cart->productVariant->stock : $cart->product->stock }}">
                                                </div>
                                            </div>
                                            <div class="order-qty mt-1 cart-items-stock">
                                                Stok tersedia
                                                <p
                                                    class="fw-bold d-inline order-qty mx-1 cart-items-stock-{{ $cart->id }}">
                                                    {{ isset($cart->productVariant) ? $cart->productVariant->stock : $cart->product->stock }}
                                                </p>
                                                unit
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-4 my-3">
                                            <input type="hidden" name="subtotal-cart-items-val-{{ $cart->id }}"
                                                class="subtotal-cart-items-val-{{ $cart->id }}"
                                                value="{{ price_format_rupiah($cart->subtotal) }}">
                                            <input type="hidden"
                                                name="subtotal-cart-items-val-noformat-{{ $cart->id }}"
                                                class="subtotal-cart-items-val-noformat-{{ $cart->id }}"
                                                value="{{ $cart->subtotal }}">
                                            <p class="cart-items-subtotal">
                                                Subtotal
                                            </p>
                                            <p class="subtotal-cart-items-{{ $cart->id }} text-danger cart-items-subtotal"
                                                id="subtotal-cart-items-single">
                                                Rp{{ price_format_rupiah($cart->subtotal) }}
                                            </p>
                                        </div>
                                        <div class="col-md-1 col-2 my-3">
                                            <div class="delete-btn">
                                                <form action="{{ route('cart.destroy', $cart) }}" method="post"
                                                    class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn shadow-none cart-items-delete-btn">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        @if (!is_null($cart->productvariant))
                                            @if (empty($cart->productvariant->stock))
                                                <p class="text-danger fs-12 text-start ps-md-5 ms-md-5 pt-md-2 mb-0">
                                                    Saat ini stock produk sedang kosong, kamu bisa memesan jika stock
                                                    kembali ada.
                                                </p>
                                            @endif
                                        @else
                                            @if (empty($cart->product->stock))
                                                <p class="text-danger fs-12 text-start ps-md-5 ms-md-5 pt-md-2 mb-0">
                                                    Stock produk ini sedang kosong, kamu tidak bisa checkout saat ini
                                                </p>
                                            @endif
                                        @endif
                                        <p
                                            class="text-danger fs-12 text-start ps-md-5 ms-md-5 pt-md-2 mb-0 notification-{{ $cart->id }}">
                                        </p>
                                    </div>
                                    <div class="row d-flex">
                                        {{-- <div class="col-md-1">
                                        </div> --}}
                                        <div class="col-md-6 col-12">
                                            <div class="fs-13 text-grey m-0 sender-address-div">
                                                <p class="fs-13 text-grey m-0 ps-2">
                                                    Pilih alamat pengiriman
                                                </p>
                                                <select
                                                    class="form-select sender-address form-select-sm shadow-none fs-13 border-0" aria-label="" name="city_origin_cartitems_{{ $cart->id }}" required id="{{ $cart->id }}">
                                                    <option selected="true" value="" disabled="disabled">
                                                        Pilih alamat pengirim
                                                    </option>
        
                                                    @if (isset($cart->productvariant))
                                                        @foreach ($cart->productvariant->productorigin as $origin)
                                                            @if ($origin->senderaddress->is_active == 1)
                                                                <option value="{{ $origin->senderaddress->id }}"
                                                                    {{ $origin->senderaddress->id == $cart->sender_address_id ? 'selected' : '' }}>
                                                                    {{ $origin->city->name == 'Kotawaringin Timur' ? $origin->city->name . ' (Sampit)' : $origin->city->name }} - ({{ $origin->senderaddress->address }})
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @foreach ($cart->product->productorigin as $origin)
                                                            @if ($origin->senderaddress->is_active == 1)
                                                                <option value="{{ $origin->senderaddress->id }}"
                                                                    {{ $origin->senderaddress->id == $cart->sender_address_id ? 'selected' : '' }}>
                                                                    {{ $origin->city->name == 'Kotawaringin Timur' ? $origin->city->name . ' (Sampit)' : $origin->city->name }} - ({{ $origin->senderaddress->address }})
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <input type="hidden" name="cart_id" id="" value="{{ $cart->id }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-md-4 col-12 cart-items-div-checkout d-none d-sm-block">
                        <div class="card mb-3 cart-items-card-checkout sticky-md-top">
                            <div class="card-body p-4">
                                <form action="{{ route('cart.checkout') }}" method="POST">
                                    @csrf
                                    @foreach ($userCartItems as $carts)
                                        <input type="hidden" name="ids[{{ $carts->id }}]" value="">
                                        {{-- <input type="hidden" name="ids[]" value="{{ $carts->id }}"> --}}
                                    @endforeach
                                    <h5 class="cart-items-checkout-header mt-1 mb-4">Ringkasan Pesanan</h5>
                                    <div class="row">
                                        <div class="col-7 cart-items-total-text pe-0">
                                            Total Harga
                                        </div>
                                        <div class="col-5 cart-items-total-val text-end">
                                        </div>
                                    </div>
                                    <div class="my-4 border border-1 border-bottom cart-items-checkout-divider">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="cart-items-checkout-total-all-text mt-1 mb-4">Total harga</p>
                                        </div>
                                        <div class="col-6 cart-items-total-all-val text-end fw-bold">
                                        </div>
                                        <input type="hidden" name="total_price" value="">
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-block checkout-button shadow-none">
                                            Checkout
                                            <span class="cart-items-checkout-span">(0)</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="fixed-bottom d-block d-sm-none p-0 mb-5">
                        <div class="col-12 cart-items-div-checkout">
                            <div class="card cart-items-card-checkout sticky-md-top">
                                <div class="card-body p-4">
                                    <a href="#" class="btn active d-block pt-0 expand-cart-bill shadow-none"
                                        role="button" data-bs-toggle="button" aria-pressed="true">
                                        Detail <i class="bi bi-chevron-up mx-2 expand-cart-bill-chevron"></i>
                                    </a>

                                    <form class="cart-bill-form d-none" action="{{ route('cart.checkout') }}"
                                        method="POST">
                                        @csrf
                                        @foreach ($userCartItems as $carts)
                                            <input type="hidden" name="ids[{{ $carts->id }}]" value="">
                                        @endforeach
                                        <h5 class="cart-items-checkout-header mt-1 mb-4">Ringkasan Pesanan</h5>
                                        <div class="row">
                                            <div class="col-7 cart-items-total-text pe-0">
                                                Total Harga
                                            </div>
                                            <div class="col-5 cart-items-total-val-xs text-end">
                                            </div>
                                        </div>
                                        <div class="my-4 border border-1 border-bottom cart-items-checkout-divider">
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="cart-items-checkout-total-all-text mt-1 mb-4">Total harga</p>
                                            </div>
                                            <div class="col-6 cart-items-total-all-val text-end fw-bold">
                                            </div>
                                            <input type="hidden" name="total_price" value="">
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-block checkout-button">
                                                Checkout
                                                <span class="cart-items-checkout-span">(0)</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center cart-items-empty">
                <img class="my-4 cart-items-logo" src="/assets/footer-logo.png" width="300" alt="">
                <p>
                    Keranjang belanjamu kosong, yuk cari produk dan tambahkan ke keranjang
                </p>
            </div>
        @endif
    </div>
    <script>
        // $(window).focus(function() {
        //     window.location.reload();
        // });
        $(document).ready(function() {
            $('.cart-items-select-all-checkbox').click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
                console.log($('input:checkbox').not(this).prop('checked', this.checked));
            });
            console.log('a');
            console.log($('.cart-items-select-all-checkbox'));

            $("input:checkbox[name='cart-items-check']").add('.cart-items-select-all-checkbox').change(function() {
                var cart_id = [];
                console.log('click checkbox');

                $.each($("input:checkbox[name='cart-items-check']"), function() {
                    var isChecked = $(this).is(':checked');
                    if (isChecked) {
                        cart_id.push($(this).val());
                        console.log('cart id : ' + cart_id);
                        $('input[name="ids[' + $(this).val() + ']"]').val($(this).val())
                        console.log('input id  : ids[' + $(this).val() + ']: ' + $(
                            'input[name="ids[' + $(this).val() + ']"]').val());
                        console.log('stock : ' + $('.cart-items-stock-val').text());
                    } else if (!isChecked) {
                        $('input[name="ids[' + $(this).val() + ']"]').val('')
                        console.log('input id zero  : ids[' + $(this).val() + ']: ' + $(
                            'input[name="ids[' + $(this).val() + ']"]').val());
                        var quantity_cart = $('input[name="quantity-cart-' + $(this).val() + '"]')
                            .val();
                        var quantity_item = $('input[name="quantity-item-' + $(this).val() + '"]')
                            .val();
                        console.log('cart id if : ' + $(this).val());
                        console.log('quantity cart if : ' + quantity_cart);
                        console.log('quantity item if : ' + quantity_item);
                        if (parseInt(quantity_cart) > parseInt(quantity_item)) {
                            $('.checkout-button').removeClass('disabled');
                            // console.log('melebihi stock yang ada');
                        }
                    }
                });
            });

            function checkout_cart(id) {
                var input = $('input[id="cart-check-' + id + '"]')
                var cart_id = [];
                var subtotal = [];
                var total_price = 0;
                $.each($("input:checkbox[name='cart-items-check']:checked"), function() {
                    cart_id.push($(this).val());
                    console.log('cart id inside function checkout cart : ' + cart_id);
                    var quantity_cart = $('input[name="quantity-cart-' + $(this).val() + '"]').val();
                    var quantity_item = $('input[name="quantity-item-' + $(this).val() + '"]').val();

                    if (parseInt(quantity_cart) > parseInt(quantity_item)) {
                        $('.checkout-button').addClass('disabled');
                        $('.notification-' + $(this).val()).text(
                            'Jumlah pesanan melebihi stock yang tersedia!');
                    }

                    subtotal.push(parseInt($('input[name="subtotal-cart-items-val-noformat-' + $(
                            this)
                        .val() + '"]').val()));
                    console.log($('.cart-items-stock-' + $(this).val()).text());
                    // console.log($('input[name="subtotal-cart-items-val-noformat-'+cart_id+'"]').val());
                    console.log(subtotal);
                });
                subtotal.forEach(x => {
                    total_price += x;
                });
                if (!$("#checkboxID").is(":checked")) {
                    // do something if the checkbox is NOT checked
                }
                console.log('total price: ' + total_price);
                $('.cart-items-total-val').html(formatRupiah(total_price, "Rp"));
                $('.cart-items-total-val-xs').html(formatRupiah(total_price, "Rp"));
                $('.cart-items-total-text').html("<span>Total Harga (" + cart_id.length + ") Barang</span>");
                $('.cart-items-checkout-span').html("(" + cart_id.length + ")");
                $('input[name="total_price"]').val(total_price);
                $('.cart-items-total-all-val').html($('.cart-items-total-val').text());
            }

            $('input[name="product_variant_id"]').click(function() {
                variant_id = $('input[name="product_variant_id"]:checked').val();
                price = $('input[name="variantPrice-' + variant_id + '"]').val();
                console.log('product id : ' + $('input[name="product_id"]').val());
                console.log('product variant id : ' + $('input[name="product_variant_id"]:checked').val());
                console.log('quantity : ' + $('input[name="quantity"]').val());
                console.log('product variant price : ' + $('input[name="variantPriceNoFormat-' +
                    variant_id + '"]').val());
                console.log('subtotal : ' + parseInt($('input[name="quantity"]').val()) * ($(
                    'input[name="variantPriceNoFormat-' + variant_id + '"]').val()));
                // console.log($('input[name="variantSlug-' + variant_id + '"]').val())
                // console.log($('input[name="variantPrice-' + variant_id + '"]').val())
                $('.price-span').text(price);
                $('input[name="subtotal"]').val(parseInt($('input[name="quantity"]').val()) * ($(
                    'input[name="variantPriceNoFormat-' + variant_id + '"]').val()));
            });

            function updateSubtotal(qty, subtotal) {
                var qtys = parseInt(qty);
                var subtotals = parseInt(subtotal);
                return qtys * subtotals;
            }

            function formatRupiah(value, prefix) {
                var number_string = value.toString(),
                    split = number_string.split(","),
                    mod = split[0].length % 3,
                    rupiah = split[0].substr(0, mod),
                    thousand = split[0].substr(mod).match(/\d{3}/gi);

                // add (.) if the value was in thousand
                if (thousand) {
                    separator = mod ? "." : "";
                    rupiah += separator + thousand.join(".");
                }

                rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
                return prefix == undefined ? rupiah : rupiah ? "Rp" + rupiah : "";
            }

            // console.log($('input[name="quantity"]').val());
            // console.log($('.subtotal-cart-items').text());
            // console.log(updateSubtotal($('input[name="quantity"]').val(),$('.subtotal-cart-items').val()));

            function update_qty(csrfToken, cartId, qty, price) {
                $.ajax({
                    url: "{{ url('/updatequantity') }}",
                    type: 'post',
                    data: {
                        _token: csrfToken,
                        id: cartId,
                        quantity: qty,
                        subtotal: price,
                    },
                    success: function(response) {
                        $.each(response, function(key, value) {
                            console.log(value.subtotal);
                            $('.subtotal-cart-items-' + value.id).html(formatRupiah(value
                                .subtotal, "Rp"));
                            $('.subtotal-cart-items-val-noformat-' + value.id).val(value
                                .subtotal)
                            checkout_cart(cartId);
                        });

                    },
                    dataType: "json"
                });
                $(document).ajaxStop(function() {
                    window.location.reload();
                });
            }

            //increase or decreate qty in cartitems 
            $('.btn-plus-qty-cart-items, .btn-minus-qty-cart-items').add("input:checkbox[name='cart-items-check']")
                .add('.cart-items-select-all-checkbox')
                .on('click', function(e) {
                    const isNegative = $(e.target).closest('.btn-minus-qty-cart-items').is(
                        '.btn-minus-qty-cart-items');
                    const isPositive = $(e.target).closest('.btn-plus-qty-cart-items').is(
                        '.btn-plus-qty-cart-items');
                    const input = $(e.target).closest('.input-group').find('input');
                    const minus = $(e.target).closest('.input-group').find($(".btn-minus-qty-cart-items"));
                    const plus = $(e.target).closest('.input-group').find($(".btn-plus-qty-cart-items"));
                    var csrfToken = $(e.target).closest('.input-group').find($("input[name='csrf_token']"))
                        .val();
                    var cartId = $(e.target).closest('.input-group').find($("input[name='cart-id']")).val();
                    var productVariantId = $(e.target).closest('.input-group').find($(
                        "input[name='product-variant-id']")).val();
                    var qty = $(e.target).closest('.input-group').find('input').val();
                    var price = $('.price-cart-items-val-' + cartId).val();
                    console.log('subtotal: ' + price);
                    console.log('val input ' + input.val());
                    if (input.is('input')) {
                        console.log('val ' + input.val());
                        console.log('max ' + input.attr('max'));

                        if (isNegative) {
                            input[0][isNegative ? 'stepDown' : 'stepUp']();
                            update_qty(csrfToken, cartId, input.val(), price);

                        }
                        if (isPositive) {
                            input[0][isPositive ? 'stepUp' : 'stepDown']();
                            update_qty(csrfToken, cartId, input.val(), price);
                        }

                        if (parseInt(input.val()) > parseInt(input.attr('max'))) {
                            input.val(input.attr('max'))
                            // update_qty(csrfToken, cartId, input.val(), price);

                        }
                        if (parseInt(input.val()) == 1 && isNegative) {
                            console.log('val1 ' + input.val());
                            console.log('max1 ' + input.attr('max'));
                            // input.val('1')
                            minus.prop('disabled', true);
                            return false;
                        }
                        if (parseInt(input.val()) > 0 && parseInt(input.val()) < parseInt(input.attr('max'))) {
                            console.log('val2 ' + input.val());
                            console.log('max2 ' + input.attr('max'));
                            console.log($('.price-cart-items-val-' + cartId).val());
                            // console.log('if')
                            minus.prop('disabled', false);
                            plus.prop('disabled', false);
                            // input[0][isNegative ? 'stepDown' : 'stepUp']()
                            // update_qty(csrfToken, cartId, input.val(), price);
                            console.log('input val: ' + input.val());
                            console.log(updateSubtotal(input.val(), $('.price-cart-items-val-' + cartId)
                                .val()));
                            var subtotalNew = (updateSubtotal(input.val(), $('.price-cart-items-val-' + cartId)
                                .val()));


                            // $('.subtotal-cart-items-' + cartId).html(formatRupiah(subtotalNew, "Rp"));

                        } else if (parseInt(input.val()) == parseInt(input.attr('max'))) {
                            if (isPositive) {
                                plus.prop('disabled', true);
                                // input[0][isNegative ? 'stepDown' : 'stepUp']()
                            } else if (isNegative) {
                                console.log('val negative ' + input.val());
                                // input[0][isNegative ? 'stepDown' : '']()
                                // update_qty(csrfToken, cartId, input.val(), price);

                            }
                        }
                        if (parseInt(input.val()) == 0) {
                            console.log('val1 ' + input.val());
                            console.log('max1 ' + input.attr('max'));
                            input.val('1')
                            minus.prop('disabled', true);
                        }
                        if (parseInt(input.val()) == parseInt(input.attr('max'))) {
                            console.log('val1 MAX ' + input.val());
                            console.log('max1 MAX ' + input.attr('max'));
                            plus.prop('disabled', true);
                        }
                    }
                    console.log($('.cart-items-stock-' + cartId).text());
                    checkout_cart(cartId);
                });

            $('.expand-cart-bill').click(function() {
                console.log($('.cart-bill-form'));
                if ($('.cart-bill-form').hasClass("d-none")) {
                    $('.cart-bill-form').removeClass("d-none");
                } else {
                    $('.cart-bill-form').addClass('d-none');
                }
                if ($('.expand-cart-bill-chevron').hasClass("bi-chevron-up")) {
                    $('.expand-cart-bill-chevron').removeClass("bi-chevron-up");
                    $('.expand-cart-bill-chevron').addClass("bi-chevron-down");
                    console.log($('.expand-cart-bill-chevron'));
                } else if ($('.expand-cart-bill-chevron').hasClass("bi-chevron-down")) {
                    $('.expand-cart-bill-chevron').removeClass("bi-chevron-down");
                    $('.expand-cart-bill-chevron').addClass("bi-chevron-up");
                    console.log($('.expand-cart-bill-chevron'));
                }
            });
            // $('[name="city_origin_cartitems"]').val(1);
            $('.sender-address').on('change', function(e) {
                // console.log($(this)[0].id);
                var cartId = $(e.target).closest('.sender-address-div').find($("input[name='cart_id']")).val();
                console.log(cartId);
                var sender_address_id = ($("select[name='city_origin_cartitems_"+cartId+"']").val());
                console.log(sender_address_id);
                var csrfToken = $("input[name='csrf_token']").val();
                console.log(csrfToken);
                $.ajax({
                    url: "{{ url('/updatesenderaddress') }}",
                    type: 'post',
                    data: {
                        _token: csrfToken,
                        id: cartId,
                        senderAddressId : sender_address_id,
                    },
                    success: function(response) {
                        console.log(response);
                        // $.each(response, function(key, value) {
                        //     console.log(value.subtotal);
                        //     $('.subtotal-cart-items-' + value.id).html(formatRupiah(value
                        //         .subtotal, "Rp"));
                        //     $('.subtotal-cart-items-val-noformat-' + value.id).val(value
                        //         .subtotal)
                        //     checkout_cart(cartId);
                        // });

                    },
                    dataType: "json"
                });
                // $(document).ajaxStop(function() {
                //     window.location.reload();
                // });
                // $.each($("select[name='city_origin_cartitems']"), function() {
                //     console.log($(this)[0]);
                //     // $.each($(this), function(idx, val){
                //     //     console.log($(this)[0]);
                //     // });
                // });
                var senderAddressId = ($('select[name="city_origin_cartitems"]').find(":selected").val());
                var cartId = $(".inline-group-qty-cart-items").find($("input[name='cart-id']")).val();
                // console.log(senderAddressId);
                // console.log(cartId);
                $('input[name="sender_address_id"]').val(senderAddressId);
                console.log('sender address id : '+$('select[name="city_origin_cartitems_'+cartId+'"]').val());
            });
        });
    </script>
@endsection
