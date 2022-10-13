@section('manual-js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        // if (performance.navigation.type == 2) {
        //     location.reload(true);
        // }

        $(window).bind("pageshow", function(event) {
            if (event.originalEvent.persisted) {
                window.location.reload();
            }
        });

        function Copy(TextToCopy) {
            var TempText = document.createElement("input");
            TempText.value = TextToCopy;
            document.body.appendChild(TempText);
            TempText.select();

            document.execCommand("copy");
            document.body.removeChild(TempText);

            alert("Berhasil Menyalin URL: " + TempText.value);
        }

        function change_image(image, i, all) {
            for (let index = 1; index < all + 1; index++) {
                document.getElementById('thumbnail-img-' + index).style.border = 'none';
                // console.log("idx thumbnail-img-" + index);
            }
            // console.log('i = ', i);
            var container = document.getElementById("main-image");
            // console.log("thumbnail-img-" + i);
            document.getElementById('thumbnail-img-' + i).style.border = '1px solid #db162f';
            container.src = image.src;
        }

        //show modal imate in product detail
        $(function() {
            $('#main-image').on('click', function() {
                $('.imagepreview').attr('src', $(this).attr('src'));
                $('#imagemodal').modal('show');
            });
        });

        //smoothscroll to div
        function goToByScroll(id) {
            $('html,body').animate({
                scrollTop: $("#" + id).offset().top
            }, 'slow');
        }

        //increase or decreate qty in product detail 
        $('.btn-plus-qty-product-detail, .btn-minus-qty-product-detail').on('click', function(e) {
            const isNegative = $(e.target).closest('.btn-minus-qty-product-detail').is(
                '.btn-minus-qty-product-detail');
            const input = $(e.target).closest('.input-group').find('input');
            if (input.is('input')) {
                console.log('val ' + $(".qty-product-detail").val());
                console.log('max ' + $(".qty-product-detail").attr('max'));
                if (input.val() > 0 && input.val() < input.attr('max')) {
                    // console.log('if')
                    input[0][isNegative ? 'stepDown' : 'stepUp']()
                    $(".btn-minus-qty-product-detail").prop('disabled', false);
                    $(".btn-plus-qty-product-detail").prop('disabled', false);
                } else if (input.val() == input.attr('max')) {
                    // console.log('max')
                    input[0][isNegative ? 'stepDown' : 'stepUp']()
                    $(".btn-plus-qty-product-detail").prop('disabled', true);
                }
                if (input.val() == 0) {
                    input.val('1')
                    $(".btn-minus-qty-product-detail").prop('disabled', true);
                }
                console.log('input val' + input.val());
                console.log('product id : ' + $('input[name="product_id"]').val());
                console.log('product variant id : ' + $('input[name="product_variant_id"]:checked').val());
                console.log('quantity : ' + $('input[name="quantity"]').val());
                console.log('product variant id : ' + $('input[name="variantPriceNoFormat-' + variant_id + '"]')
                    .val());
                console.log('subtotal : ' + parseInt($('input[name="quantity"]').val()) * ($(
                    'input[name="variantPriceNoFormat-' + variant_id + '"]').val()));
                $('input[name="subtotal"]').val(parseInt($('input[name="quantity"]').val()) * ($(
                    'input[name="variantPriceNoFormat-' + variant_id + '"]').val()));
            }
        });

        $('input[name="product_variant_id"]').click(function() {
            variant_id = $('input[name="product_variant_id"]:checked').val();
            price = $('input[name="variantPrice-' + variant_id + '"]').val();
            console.log('product id : ' + $('input[name="product_id"]').val());
            console.log('product variant id : ' + $('input[name="product_variant_id"]:checked').val());
            console.log('quantity : ' + $('input[name="quantity"]').val());
            console.log('product variant price : ' + $('input[name="variantPriceNoFormat-' + variant_id + '"]')
            .val());
            console.log('subtotal : ' + parseInt($('input[name="quantity"]').val()) * ($(
                'input[name="variantPriceNoFormat-' + variant_id + '"]').val()));
            // console.log($('input[name="variantSlug-' + variant_id + '"]').val())
            // console.log($('input[name="variantPrice-' + variant_id + '"]').val())
            $('.price-span').text(price);
            $('input[name="subtotal"]').val(parseInt($('input[name="quantity"]').val()) * ($(
                'input[name="variantPriceNoFormat-' + variant_id + '"]').val()));

        });

        // shipment payment check
        $(document).ready(function() {
            //active select2
            $(".provinsi-asal , .kota-asal, .destination-province, .destination-city, .courier-choices").select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),
                selectionCssClass: 'select2--small',
                dropdownCssClass: 'select2--small'
            });
            //ajax select kota asal
            $('select[name="province_origin"]').on('change', function() {
                let provinceId = $(this).val();
                if (provinceId) {
                    jQuery.ajax({
                        url: '/cities/' + provinceId,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            $('select[name="city_origin"]').empty();
                            $('select[name="city_origin"]').append(
                                '<option value="">-- pilih kota asal --</option>');
                            $.each(response, function(key, value) {
                                $('select[name="city_origin"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });
                        },
                    });
                } else {
                    $('select[name="city_origin"]').append(
                        '<option value="">-- Pilih kota asal --</option>');
                }
            });
            //ajax select kota tujuan
            $('select[name="province_destination"]').on('change', function() {
                let provinceId = $(this).val();
                console.log(provinceId);
                if (provinceId) {
                    jQuery.ajax({
                        url: '/cities/' + provinceId,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            $('select[name="city_destination"]').empty();
                            $('select[name="city_destination"]').append(
                                '<option value="">Pilih kota tujuan</option>');
                            $('select[name="courier"]').html(
                                '<option value="">Pilihan kurir</option>');
                            $.each(response, function(key, value) {
                                $('select[name="city_destination"]').append(
                                    '<option class="destination-city-option" value="' +
                                    value.city_id + '">' + value.type + ' ' + value
                                    .name + '</option>');
                            });
                        },
                    });
                } else {
                    $('select[name="city_destination"]').append(
                        '<option class="destination-city-option" value="">Pilih kota tujuan</option>');
                }
            });
            //ajax check ongkir
            let isProcessing = false;
            $('select[name=city_destination]').change(function(e) {
                // e.preventDefault();
                let token = $('input[name="csrf-token"]').val();
                console.log('token ' + token);
                let city_origin = '36';
                console.log('city origin ' + city_origin);
                // let city_origin = $('select[name=city_origin]').val();
                let city_destination = $('select[name=city_destination]').val();
                console.log('city destination ' + city_destination);
                // let courier = $('select[name=courier]').val();
                let courier = 'all';
                console.log('courier ' + courier);
                let weight = $('#weight').val();
                console.log('weight ' + weight);

                $('select[name="courier"]').html('<option value="">Memuat data kurir...</option>');

                if (isProcessing) {
                    return;
                }

                isProcessing = true;
                jQuery.ajax({
                    url: "/ongkir",
                    data: {
                        _token: token,
                        city_origin: city_origin,
                        city_destination: city_destination,
                        courier: courier,
                        weight: weight,
                    },
                    dataType: "JSON",
                    type: "POST",
                    success: function(response) {
                        isProcessing = false;
                        if (response) {
                            console.log(response);
                            if (response.length > 1) {
                                $('#ongkir').empty();
                                // $('.ongkir').addClass('d-block');
                                $('select[name="courier"]').empty();
                                $('select[name="courier"]').append(
                                    '<option value="">Pilihan Kurir yang tersedia</option>');
                                for (let index = 0; index < response.length; index++) {
                                    $.each(response[index][0]['costs'], function(key, value) {
                                        $('select[name="courier"]').append(
                                            '<option class="courier-option" value="' +
                                            response[index][0].code + '">' +
                                            response[index][0].code.toUpperCase() +
                                            ' : <span class="fw-bold">' + value
                                            .service +
                                            '</span> - Rp<span class="courier-cost">' +
                                            value.cost[0].value + '</span> (' +
                                            value.cost[0].etd + ' hari)' +
                                            '</option>');
                                    });
                                }
                            } else {
                                $('#ongkir').empty();
                                // $('.ongkir').addClass('d-block');
                                $.each(response[0]['costs'], function(key, value) {
                                    $('#ongkir').append('<li class="list-group-item">' +
                                        response[0].code.toUpperCase() +
                                        ' : <strong>' + value.service +
                                        '</strong> - Rp. <span class="courier-cost">' +
                                        value.cost[0].value + '</span> (' + value
                                        .cost[0].etd + ' hari)</li>')
                                });
                            }
                        }
                    }
                });

            });

            var addToCartForm = document.getElementById('add-to-cart-form');
            $('#add-to-cart-btn').click(function() {
                addToCartForm.submit();
            });

            $(".alert-success-cart").fadeTo(2000, 1000).fadeOut(1000, function() {
                $(".alert-success-cart").fadeOut(2000);
            });
        });
        // $(document).ready(function() {
        //     $('#add-to-cart-btn').click(function(e) {
        //         e.preventDefault();
        //         console.log($('select[name="city_destination"]').find(":selected").text());
        //         console.log($('select[name="courier"]').find(":selected").text());
        //         console.log($('select[name="courier"]').find(":selected").children(".courier-cost").text());
        //         if ($('input[name="none_variant"]').val()) {
        //             console.log('no variant');
        //         } else {
        //             console.log($('input[name="variant"]:checked').val());
        //         }
        //     });
        // });

        function formatRupiah(value, prefix) {
            var number_string = value.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                mod = split[0].length % 3,
                rupiah = split[0].substr(0, mod),
                thousand = split[0].substr(mod).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka thousand
            if (thousand) {
                separator = mod ? "." : "";
                rupiah += separator + thousand.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp" + rupiah : "";
        }


        $(document).ready(function() {

            $('.cart-items-select-all-checkbox').click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $("input:checkbox[name='cart-items-check']").add('.cart-items-select-all-checkbox').change(function() {
                var cart_id = [];
                $.each($("input:checkbox[name='cart-items-check']"), function() {
                    var isChecked = $(this).is(':checked');
                    if (isChecked) {
                        cart_id.push($(this).val());
                        console.log('cart id : ' + cart_id);
                        $('input[name="ids[' + $(this).val() + ']"]').val($(this).val())
                        console.log('input id  : ids[' + $(this).val() + ']: ' + $(
                            'input[name="ids[' + $(this).val() + ']"]').val());
                    } else if (!isChecked) {
                        $('input[name="ids[' + $(this).val() + ']"]').val('')
                        console.log('input id zero  : ids[' + $(this).val() + ']: ' + $(
                            'input[name="ids[' + $(this).val() + ']"]').val());
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
                    console.log(cart_id);
                    subtotal.push(parseInt($('input[name="subtotal-cart-items-val-noformat-' + $(
                            this)
                        .val() + '"]').val()));
                    // console.log($('input[name="subtotal-cart-items-val-noformat-'+cart_id+'"]').val());
                    console.log(subtotal);
                });
                subtotal.forEach(x => {
                    total_price += x;
                });
                console.log('total price: ' + total_price);
                $('.cart-items-total-val').html(formatRupiah(total_price, "Rp"));
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
                    checkout_cart(cartId);
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
                            var subtotalNew = (updateSubtotal(input.val(), $('.price-cart-items-val-' + cartId)
                                .val()));


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
                    checkout_cart(cartId);
                });
        });
    </script>
@endsection
