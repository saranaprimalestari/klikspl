@extends('layouts.main')

@section('container')
    {{-- {{ dd($userCartItems) }} --}}
    <div class="container-fluid breadcrumb-products">
        {{ Breadcrumbs::render('cart') }}
    </div>
    <div class="container my-5">
        @if (count($userCartItems) > 0)
            <div class="row mt-5">
                <div class="col-12">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show alert-success-cart" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
                <div class="d-flex">
                    <div class="select-all-delete me-3">
                        <input class="form-check-input cart-items-select-all-checkbox" type="checkbox" value=""
                            id="flexCheckDefault">
                        Pilih Semua
                    </div>
                    <div class="delete-all-btn">
                        <a href="" class="text-decoration-none text-dark cart-items-delete-all">
                            <i class="far fa-trash-alt"></i> Hapus
                        </a>
                    </div>
                </div>
            </div>
            <div class="carts mt-4">
                <div class="col-12">
                    <table class="table table-hover table-borderless table-responsive w-100 text-center">
                        <tr class="cart-items-table-header">
                            <th>
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            </th>
                            <th>Produk</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th>Subtotal Produk</th>
                            <th>Aksi</th>
                        </tr>
                        @foreach ($userCartItems as $cart)
                            <tr class="h-100">
                                <td class="align-middle">
                                    {{-- <div class="d-flex align-items-center w-100"> --}}
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    {{-- </div> --}}
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('product.show', $cart->product->slug) }}" class="text-decoration-none text-dark">
                                    {{-- <a href="{{ route('cartitems.show', $cart) }}" class="text-decoration-none text-dark"> --}}
                                        <div class="d-flex align-items-center my-5">
                                            <img id="main-image" class="cart-items-img"
                                                src="https://source.unsplash.com/400x400?product-1" class="img-fluid"
                                                alt="..." width="60">
                                            <div class="cart-items-product-info text-start ms-2 ">
                                                <p class="text-truncate cart-items-product-name m-0 fw-bold">
                                                    {{ $cart->product->name }}
                                                </p>
                                                <p class="text-truncate cart-items-product-name">
                                                    Varian: {{ $cart->productvariant->variant_name }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                                <td class="w-25 align-middle">
                                    <p class="cart-items-price">
                                        <input type="hidden" name="price-cart-items-val-{{ $cart->id }}"
                                            class="price-cart-items-val-{{ $cart->id }}"
                                            value="{{ isset($cart->productVariant) ? $cart->productVariant->price : $cart->product->price }}">
                                        @if (isset($cart->productVariant))
                                            Rp{{ price_format_rupiah($cart->productVariant->price) }}
                                        @else
                                            Rp{{ price_format_rupiah($cart->product->price) }}
                                        @endif
                                    </p>
                                </td>
                                <td class="w-25 align-middle">
                                    <div class="ms-2">
                                        <div class="input-group inline-group-qty-cart-items ms-1">
                                            <div class="input-group-prepend">
                                                <button type="button"
                                                    class="btn btn-minus-qty-cart-items shadow-none cart-items-minus-btn">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input class="form-control qty-cart-items cart-items-quantity shadow-none"
                                                min="0" name="quantity" id="quantity" value="{{ $cart->quantity }}"
                                                type="number" min="1"
                                                max="{{ isset($cart->productVariant) ? $cart->productVariant->stock : $cart->product->stock }}"
                                                onkeydown="return false">
                                            <div class="input-group-append">
                                                <button type="button"
                                                    class="btn btn-plus-qty-cart-items shadow-none cart-items-plus-btn">
                                                    <i class="fa fa-plus"></i>
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
                                        </div>
                                    </div>
                                    <div class="order-qty mt-1 cart-items-stock">
                                        stok tersedia
                                        <p class="fw-bold d-inline order-qty mx-1">
                                            {{ isset($cart->productVariant) ? $cart->productVariant->stock : $cart->product->stock }}
                                        </p>
                                        unit
                                    </div>
                                </td>
                                <td class="w-25  align-middle">
                                    <input type="hidden" name="subtotal-cart-items-val-{{ $cart->id }}"
                                        class="subtotal-cart-items-val-{{ $cart->id }}"
                                        value="{{ price_format_rupiah($cart->subtotal) }}">
                                    <p class="subtotal-cart-items-{{ $cart->id }} text-danger cart-items-subtotal">
                                        Rp{{ price_format_rupiah($cart->subtotal) }}
                                    </p>
                                    {{-- <p class="subtotal-cart-items-{{ $cart->id }}"></p> --}}
                                </td>
                                <td class="w-25 align-middle">
                                    <div class="delete-btn">
                                        <form action="{{ route('cart.destroy', $cart) }}" method="post"
                                            class="d-inline">
                                            @method('delete')
                                            @csrf
                                            {{-- <button class="badge bg-danger border-0"
                                                onclick="return confirm('Hapus item dari keranjang?')"><span
                                                    data-feather="x-circle">s</span></button> --}}
                                            <button type="submit" class="btn shadow-none cart-items-delete-btn"><i
                                                    class="far fa-trash-alt"></i> Hapus</button>
                                        </form>
                                        {{-- <a href="" class="text-decoration-none text-dark ">
                                            <i class="far fa-trash-alt"></i> Hapus
                                        </a> --}}
                                    </div>
                                    {{-- {{ dd($cart) }} --}}
                                </td>
                            </tr>
                        @endforeach
                    </table>
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
        $(document).ready(function() {

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
                        });
                    },
                    dataType: "json"
                });
            }

            //increase or decreate qty in cartitems 
            $('.btn-plus-qty-cart-items, .btn-minus-qty-cart-items').on('click', function(e) {
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

                if (input.is('input')) {
                    console.log('val ' + input.val());
                    console.log('max ' + input.attr('max'));
                    if (parseInt(input.val()) > parseInt(input.attr('max'))) {
                        input.val(input.attr('max'))
                        update_qty(csrfToken, cartId, input.val(), price);
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
                        input[0][isNegative ? 'stepDown' : 'stepUp']()
                        update_qty(csrfToken, cartId, input.val(), price);
                        console.log('input val: ' + input.val());
                        console.log(updateSubtotal(input.val(), $('.price-cart-items-val-' + cartId)
                            .val()));
                        var subtotalNew = (updateSubtotal(input.val(), $('.price-cart-items-val-' +
                            cartId).val()));

                        // $('.subtotal-cart-items-' + cartId).html(formatRupiah(subtotalNew, "Rp"));

                    } else if (parseInt(input.val()) == parseInt(input.attr('max'))) {
                        if (isPositive) {
                            plus.prop('disabled', true);
                            input[0][isNegative ? 'stepDown' : 'stepUp']()
                        } else if (isNegative) {
                            console.log('val negative ' + input.val());
                            input[0][isNegative ? 'stepDown' : '']()
                            update_qty(csrfToken, cartId, input.val(), price);
                        }
                    }
                    if (parseInt(input.val()) == 0) {
                        console.log('val1 ' + input.val());
                        console.log('max1 ' + input.attr('max'));
                        input.val('1')
                        minus.prop('disabled', true);
                    }
                }
            });

            // $('.btn-minus-qty-cart-items').on('click', function(e) {
            //     const isNegative = $(e.target).closest('.btn-minus-qty-cart-items').is(
            //         '.btn-minus-qty-cart-items');
            //     const input = $(e.target).closest('.input-group').find('input');
            //     const minus = $(e.target).closest('.input-group').find($('.btn-minus-qty-cart-items'));
            //     const plus = $(e.target).closest('.input-group').find($('.btn-plus-qty-cart-items'));
            //     var csrfToken = $(e.target).closest('.input-group').find($("input[name='csrf_token']"))
            //         .val();
            //     var cartId = $(e.target).closest('.input-group').find($("input[name='cart-id']")).val();
            //     var productVariantId = $(e.target).closest('.input-group').find($(
            //         "input[name='product-variant-id']")).val();
            //     var qty = $(e.target).closest('.input-group').find('input').val();
            //     minus.prop('disabled', false);
            //     if (input.is('input')) {
            //         if (input.val() > 0) {
            //             minus.prop('disabled', false);
            //             plus.prop('disabled', false);
            //             input[0]['stepDown']()
            //         }
            //         if (input.val() == 0) {
            //             input[0]['stepUp']()
            //             minus.prop('disabled', true);
            //         }
            //     }

            // });
            // $('.btn-plus-qty-cart-items').on('click', function(e) {
            //     const isPositive = $(e.target).closest('.btn-plus-qty-cart-items').is(
            //         '.btn-minus-qty-cart-items');
            //     const input = $(e.target).closest('.input-group').find('input');
            //     const plus = $(e.target).closest('.input-group').find($('.btn-plus-qty-cart-items'));
            //     const minus = $(e.target).closest('.input-group').find($('.btn-minus-qty-cart-items'));
            //     var csrfToken = $(e.target).closest('.input-group').find($("input[name='csrf_token']"))
            //         .val();
            //     var cartId = $(e.target).closest('.input-group').find($("input[name='cart-id']")).val();
            //     var productVariantId = $(e.target).closest('.input-group').find($(
            //         "input[name='product-variant-id']")).val();
            //     var qty = $(e.target).closest('.input-group').find('input').val();
            //     if (input.is('input')) {
            //         if (parseInt(input.val()) < parseInt(input.attr('max'))) {
            //             minus.prop('disabled', false);
            //             plus.prop('disabled', false);
            //             input[0]['stepUp']()
            //         } else if (parseInt(input.val()) == parseInt(input.attr('max'))) {
            //             plus.prop('disabled', true);
            //         }
            //         if (input.val() == 0) {
            //             input[0]['stepUp']()
            //             plus.prop('disabled', true);
            //         }
            //     }
            // });
        });
    </script>
@endsection
