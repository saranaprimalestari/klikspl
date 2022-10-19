// $(window).focus(function() {
//     window.location.reload();
// });

// $(window).blur(function() {
//     window.location.reload();
// });

function reloadFunction() {
    window.location.reload();
}

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

    alert("Berhasil Menyalin : " + TempText.value);
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

function change_image_modal(image, i, all) {
    for (let index = 1; index < all + 1; index++) {
        document.getElementById('thumbnail-img-modal-' + index).style.border = 'none';
        // console.log("idx thumbnail-img-" + index);
    }
    // console.log('i = ', i);
    var container = document.getElementById("imagePreview");
    var containerLink = document.getElementById("imagePreviewLink");
    // console.log("thumbnail-img-" + i);
    document.getElementById('thumbnail-img-modal-' + i).style.border = '1px solid #db162f';
    container.src = image.src;
    containerLink.href = image.src;

}

//show modal imate in product detail
$(function() {
    $('#main-image').on('click', function() {
        $('.imagepreview').attr('src', $(this).attr('src'));
        $('.imagepreviewLink').attr('href', $(this).attr('src'));
        $('#imagemodal').modal('show');
    });

});

//smoothscroll to div
function goToByScroll(id) {
    $('html,body').animate({ scrollTop: $("#" + id).offset().top }, 'slow');
}


//increase or decreate qty in product detail 
$('.btn-plus-qty-product-detail, .btn-minus-qty-product-detail').on('click', function(e) {
    const isNegative = $(e.target).closest('.btn-minus-qty-product-detail').is('.btn-minus-qty-product-detail');
    const input = $(e.target).closest('.input-group').find('input');
    if (input.is('input')) {
        console.log('val ' + input.val());
        console.log('max ' + input.attr('max'));
        if (input.val() > 0 || input.val() < input.attr('max')) {
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
                // console.log('0')
            $(".btn-minus-qty-product-detail").prop('disabled', true);
        }
        // console.log('out')
        if ($('input[name="product_variant_ids"]').val() == 0) {

            console.log('product variant id 0 : ' + $('input[name="product_variant_ids"]').val());
            console.log('input val' + input.val());
            console.log('product id : ' + $('input[name="product_id"]').val());
            console.log('quantity : ' + $('input[name="quantity_product"]').val());
            console.log('price : ' + $('input[name="product_price"]').val());
            console.log('subtotal : ' + parseInt($('input[name="quantity_product"]').val()) * ($('input[name="product_price"]').val()));

            $('input[name="product_variant_id"').val($('input[name="product_variant_ids"]').val());
            $('input[name="quantity"]').val($('input[name="quantity_product"]').val());
            $('input[name="subtotal"]').val(parseInt($('input[name="quantity_product"]').val()) * ($('input[name="product_price"]').val()));

        } else if (typeof $('input[name="product_variant_ids"]:checked').val() !== "undefined") {

            console.log('product variant id s: ' + $('input[name="product_variant_ids"]:checked').val());
            console.log('product variant id : ' + $('input[name="product_variant_ids"]:checked').val());
            console.log('input val' + input.val());
            console.log('product id : ' + $('input[name="product_id"]').val());
            console.log('quantity : ' + $('input[name="quantity_product"]').val());
            console.log('product variant id : ' + $('input[name="variantPriceNoFormat-' + variant_id + '"]').val());
            console.log('subtotal : ' + parseInt($('input[name="quantity"]').val()) * ($('input[name="variantPriceNoFormat-' + variant_id + '"]').val()));
            $('input[name="quantity"]').val($('input[name="quantity_product"]').val());
            $('input[name="subtotal"]').val(parseInt($('input[name="quantity_product"]').val()) * ($('input[name="variantPriceNoFormat-' + variant_id + '"]').val()));

        } else if (typeof $('input[name="product_variant_ids"]:checked').val() === "undefined") {
            $('.product_variant_ids_error').html('<p class="text-danger no_variant_selected">Pilih varian produk terlebih dahulu</p>')

        }
        // $('input[name="product_variant_id"').val(variant_id);
        // $('input[name="weight"').val(weight);
        // $('input[name="quantity_product"').attr({ "max": stock });
        // $('input[name="quantity_product"').val(1);
        // $('input[name="quantity"').val($('input[name="quantity_product"').val());
        // $('input[name="subtotal"]').val(parseInt($('input[name="quantity_product"]').val()) * ($('input[name="variantPriceNoFormat-' + variant_id + '"]').val()));
    }
});

$('input[name="product_variant_ids"]').click(function() {
    $('.product_variant_ids_error').empty();
    $('.invalid-feedback').empty();
    console.log($('input[name="product_variant_ids"]:checked').val());
    variant_id = $('input[name="product_variant_ids"]:checked').val();
    price = $('input[name="variantPrice-' + variant_id + '"]').val();
    weight = $('input[name="variantWeight-' + variant_id + '"]').val();
    stock = $('input[name="variantStock-' + variant_id + '"]').val();
    // console.log('--variant id click');
    // sender_address_name = $('input[name="sender_address_name-' + variant_id + '"]').val();
    // sender_address_id = $('input[name="sender_address_id-' + variant_id + '"]').val();

    var originId = $('input[name^="senderAddressId-' + variant_id + '"]').map(function(idx, elem) {
        return $(elem).val();
    }).get();

    console.log('origin : ' + originId);

    var originName = $('input[name^="senderAddressName-' + variant_id + '"]').map(function(idx, elem) {
        return $(elem).val();
    }).get();

    console.log('origin : ' + originName);

    var originAddress = $('input[name^="senderAddresses-' + variant_id + '"]').map(function(idx, elem) {
        return $(elem).val();
    }).get();

    console.log('origin : ' + originAddress);

    var originCity = $('input[name^="senderAddressCity-' + variant_id + '"]').map(function(idx, elem) {
        return $(elem).val();
    }).get();

    console.log('origin : ' + originCity);

    var originCityId = $('input[name^="senderAddressCityId-' + variant_id + '"]').map(function(idx, elem) {
        return $(elem).val();
    }).get();

    console.log('origin : ' + originCityId);

    // console.log('sender adddress name : ' + sender_address_name);
    // console.log('sender adddress id : ' + sender_address_id);
    console.log('product id  : ' + variant_id);
    console.log('weight : ' + weight);
    console.log('stock : ' + stock);
    console.log('product variant id : ' + $('input[name="product_variant_ids"]:checked').val());
    console.log('quantity : ' + $('input[name="quantity_product"]').val());
    console.log('product variant price : ' + $('input[name="variantPriceNoFormat-' + variant_id + '"]').val());
    console.log('subtotal : ' + parseInt($('input[name="quantity_product"]').val()) * ($('input[name="variantPriceNoFormat-' + variant_id + '"]').val()));
    // console.log($('input[name="variantSlug-' + variant_id + '"]').val())
    // console.log($('input[name="variantPrice-' + variant_id + '"]').val())
    $('.price-span').text(price);
    if (stock <= 0) {
        $('.order-qty-stock').text(0);
    } else {
        $('.order-qty-stock').text(stock);
    }
    $('input[name="product_variant_id"').val(variant_id);
    $('input[name="weight"').val(weight);
    $('input[name="quantity_product"').attr({ "max": stock });
    $('input[name="quantity_product"').val(1);
    $('input[name="quantity"').val($('input[name="quantity_product"').val());
    $('input[name="subtotal"]').val(parseInt($('input[name="quantity_product"]').val()) * ($('input[name="variantPriceNoFormat-' + variant_id + '"]').val()));
    $(".sender-address").html('').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        selectionCssClass: 'select2--small',
        dropdownCssClass: 'select2--small',
        data: [{ id: '', text: '' }]
    });
    $(".sender-address").append(new Option('Pilih alamat pengirim', 0, false, true)).trigger('change');
    // $(".sender-address").append(new Option($('input[name="sender_address_name-' + variant_id + '"]').val(), 1, false, false)).trigger('change');
    $.each(originId, function(idx, value) {
        $(".sender-address").append(new Option(originCity[idx] + ' - ( ' + originAddress[idx] + ')', originId[idx], false, false)).trigger('change');
    });
});

// shipment payment check
$(document).ready(function() {
    //active select2
    $(".provinsi-asal , .kota-asal, .origin-province, .origin-city, .destination-province, .destination-city, .courier-choices , .user-address").select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        selectionCssClass: 'select2--small',
        dropdownCssClass: 'select2--small',
        dropdownParent: $('#shipmentCourierModal')
    });

    $(".city-origin-select, .address-province, .address-city, .postal-code, .address-province-edit, .address-city-edit, .postal-code-edit,.admin-product-category,.admin-product-merk, .sender-address, .promo-type, .promo-voucher-product").select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        selectionCssClass: 'select2--small',
        dropdownCssClass: 'select2--small',
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
                    $('select[name="city_origin_on_modal"]').empty();
                    $('select[name="city_origin_on_modal"]').append('<option value="">Pilih kota asal</option>');
                    // $('select[name="courier"]').html('<option value="">Pilihan kurir</option>');
                    $.each(response, function(key, value) {
                        $('select[name="city_origin_on_modal"]').append('<option class="origin-city-option" value="' + value.city_id + '">' + value.type + ' ' + value.name + '</option>');
                    });
                },
            });
        } else {
            $('select[name="city_origin"]').append('<option value="">-- Pilih kota asal --</option>');
        }
    });
    //ajax select kota tujuan
    $('select[name="province_destination"]').add('select[name="province_ids"]').on('change', function() {
        let provinceId = $(this).val();
        console.log(provinceId);
        if (provinceId) {
            jQuery.ajax({
                url: '/cities/' + provinceId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    $('select[name="city_destination"]').empty();
                    $('select[name="city_destination"]').append('<option value="">Pilih kota tujuan</option>');
                    $('select[name="courier"]').html('<option value="">Pilihan kurir</option>');
                    $.each(response, function(key, value) {
                        $('select[name="city_destination"]').append('<option class="destination-city-option" value="' + value.city_id + '">' + value.type + ' ' + value.name + '</option>');
                    });
                    $('select[name="city_ids"]').empty();
                    $('select[name="city_ids"]').append('<option value="">Pilih kota</option>');
                    $.each(response, function(key, value) {
                        $('select[name="city_ids"]').append('<option class="destination-city-option" value="' + value.city_id + '">' + value.type + ' ' + value.name + '</option>');
                        $('select[name="city_ids"]').on('change', function() {
                            let cityId = ($('select[name="city_ids"]').find(":selected").val());
                            console.log(cityId);
                            if (cityId == value.city_id) {
                                console.log(value.city_id);
                                $('select[name="postal_code"]').empty();
                                $('select[name="postal_code"]').append('<option value="">Pilih Kode Pos, Jika tidak ada yang sesuai silakan lewati kolom ini</option>');
                                $('select[name="postal_code"]').append('<option class="destination-city-option" value="' + value.postal_code + '">' + value.postal_code + '</option>');
                            }
                        });
                    });
                },
            });
        } else {
            $('select[name="city_destination"]').append('<option class="destination-city-option" value="">Pilih kota tujuan</option>');
        }
    });

    if ($('input[name="province_id_edit"]').val() != null || $('input[name="city_id_edit"]').val() != null || $('input[name="postal_code_edit"]').val() != null) {

        let province_id_edit = $('input[name="province_id_edit"]').val();
        let city_id_edit = $('input[name="city_id_edit"]').val();
        let postal_code_edit = $('input[name="postal_code_edit"]').val();
        console.log($('input[name="province_id_edit"]').val());
        $(window).on('load', function() {
            jQuery.ajax({
                url: '/cities/' + province_id_edit,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    console.log($('input[name="city_id_edit"]').val());
                    $('select[name="city_destination"]').empty();
                    $('select[name="city_destination"]').append('<option value="">Pilih kota tujuan</option>');
                    $('select[name="courier"]').html('<option value="">Pilihan kurir</option>');
                    $.each(response, function(key, value) {
                        $('select[name="city_destination"]').append('<option class="destination-city-option" value="' + value.city_id + '">' + value.type + ' ' + value.name + '</option>');
                    });
                    $('select[name="city_ids"]').empty();
                    $('select[name="city_ids"]').append('<option value="">Pilih kota</option>');
                    $.each(response, function(key, value) {
                        console.log(value.city_id);
                        $('select[name="city_ids"]').append('<option class="destination-city-option" value="' + value.city_id + '">' + value.type + ' ' + value.name + '</option>');
                        if (city_id_edit == value.city_id) {
                            $('select[name="postal_code"]').empty();
                            $('select[name="postal_code"]').append('<option value="">Pilih Kode Pos, Jika tidak ada yang sesuai silakan lewati kolom ini</option>');
                            $('select[name="postal_code"]').append('<option class="destination-city-option" value="' + value.postal_code + '">' + value.postal_code + '</option>');
                            $('[name="postal_code"]').val($('input[name="postal_code_edit"]').val());
                        }
                    });
                    $('[name="city_ids"]').val($('input[name="city_id_edit"]').val());
                    // $('[name="postal_code"]').val($('input[name="postal_code_edit"]').val());
                },
            });
        });
        $('[name="province_ids"]').val($('input[name="province_id_edit"]').val());
        console.log($('[name="province_ids"]').val($('input[name="province_id_edit"]').val()));
        $('[name="city_ids"]').val($('input[name="city_id_edit"]').val());
        $('[name="postal_code"]').val($('input[name="postal_code_edit"]').val());
    }
    // $('#address-province-edit').select2('val', '13');
    //ajax check ongkir
    let isProcessing = false;
    $('select[name=city_destination]').change(function(e) {
        // e.preventDefault();
        let token = $('input[name="csrf-token"]').val();
        console.log('token ' + token);
        let city_origin = $('select[name=city_origin_on_modal]').val();;
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
                        $('select[name="courier"]').append('<option value="">Pilihan Kurir yang tersedia</option>');
                        for (let index = 0; index < response.length; index++) {
                            $.each(response[index][0]['costs'], function(key, value) {
                                $('select[name="courier"]').append('<option class="courier-option" value="' + response[index][0].code + '">' + response[index][0].code.toUpperCase() + ' : ' + value.service + ' - Rp' + value.cost[0].value + ' (' + value.cost[0].etd + ' hari)' + '</option>');
                            });
                        }
                    } else {
                        $('#ongkir').empty();
                        // $('.ongkir').addClass('d-block');
                        $.each(response[0]['costs'], function(key, value) {
                            $('#ongkir').append('<li class="list-group-item">' + response[0].code.toUpperCase() + ' : <strong>' + value.service + '</strong> - Rp. <span class="courier-cost">' + value.cost[0].value + '</span> (' + value.cost[0].etd + ' hari)</li>')
                        });
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('select[name="courier"]').html('<option value="">Gagal memuat data ongkir, coba lagi nanti ya</option>');
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
    $(".alert-notification").fadeTo(5000, 1000).fadeOut(1000, function() {
        $(".alert-notification").fadeOut(5000);
    });


    $.fn.shipment_cost_checkout = function(token, city_origin, city_destination, courier, weight) {
        $('.courier-choice').empty();
        $('select[name="sender_city_id"]').prop('disabled', true);
        $('.courier-choice').append(
            '<div class="card mb-3 checkout-courier-card"><div class="card-body p-4"><div class="d-flex align-items-center courier-choice-text"><p class="m-0 checkout-courier-loading-text">Memuat data...</p><div class="spinner-border ms-auto checkout-courier-loading" role="status" aria-hidden="true"></div></div></div></div>'
        );
        $('.courier-modal-body').empty();
        // console.log(city_origin);
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
                if (response) {
                    console.log(response);
                    if (response.length > 1) {
                        $('select[name="sender_city_id"]').prop('disabled', false);
                        $('.courier-choice').empty();
                        $('.courier-choice').append(
                            '<div class="card mb-3 checkout-courier-card"><div class="card-body p-4"><button type="button" class="btn w-100 shadow-none text-start p-0 d-flex align-items-center" data-bs-toggle="modal"data-bs-target="#courierModal"><p class="m-0 checkout-courier-able-text ">Pilihan Kurir yang tersedia</p><i class="bi bi-arrow-right-circle ms-auto"></i></button></div></div>'
                        );
                        for (let index = 0; index < response.length; index++) {
                            $.each(response[index][0]['costs'], function(key, value) {
                                console.log(response[index][0].code);
                                if (response[index][0].code != 'pos') {
                                    $('.courier-modal-body').append(
                                        '<div class="card mb-3 checkout-courier-card-items"><div class="card-body p-4"><div class="form-check d-flex align-items-center justify-content-between"><input class="form-check-input checkout-courier-input shadow-none" type="radio" name="checkout-courier-input" id="courier-' +
                                        response[index][0].code + '-' + key +
                                        '" value="' +
                                        response[index][0].code + '-' + key +
                                        '"><label class="form-check-label checkout-courier-label w-100" for="courier-' +
                                        response[index][0].code + '-' + key + '"><div class="row d-flex align-items-center"><div class="col-md-10 col-12 text-start"><div class="checkout-courier-label m-0"><p class="m-0 d-inline-block modal-courier-type pe-1 fw-bold">' +
                                        response[index][0].code.toUpperCase() +
                                        '</p><p class="m-0 d-inline-block modal-courier-package fw-bold">' + value.service + ' (' + value.description + ')' +
                                        '</p><p class="m-0">Akan tiba dalam ' + value.cost[0].etd.replace(' HARI', '') + ' hari dari pengiriman</p></div></div><div class="col-md-2 col-12"><p class="m-0 text-danger my-2 fw-bold"><span class="courier-cost">' + formatRupiah(value.cost[0].value, "Rp") + '</span></p></div></div><input type="hidden" name="courier-name-' +
                                        response[index][0].code + '-' + key +
                                        '" value="' + response[index][0].code.toUpperCase() + '"><input type="hidden" name="courier-service-' +
                                        response[index][0].code + '-' + key +
                                        '" value="' + value.service + ' (' + value.description + ')' + '"><input type="hidden" name="courier-etd-' +
                                        response[index][0].code + '-' + key +
                                        '" value="' + value.cost[0].etd.replace(' HARI', '') + '"><input type="hidden" name="courier-price-' +
                                        response[index][0].code + '-' + key +
                                        '" value="' + value.cost[0].value + '"></label></div></div></div>'
                                    );
                                }
                            });
                        }
                    } else {
                        $('.courier-choice').empty();
                        // $('.ongkir').addClass('d-block');
                        $.each(response[0]['costs'], function(key, value) {
                            $('#ongkir').append('<li class="list-group-item">' +
                                response[0]
                                .code.toUpperCase() + ' : <strong>' + value
                                .service +
                                '</strong> - Rp. <span class="courier-cost">' +
                                value
                                .cost[0].value + '</span> (' + value.cost[0]
                                .etd.replace(' HARI', '') +
                                ' hari)</li>')
                        });
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('.courier-choice').empty();
                $('.courier-choice').append(
                    '<div class="card mb-3 checkout-courier-card"><div class="card-body p-4"> <div class="d-flex align-items-center"> <p class="m-0 checkout-courier-loading-text"> Gagal memuat data ongkir, pastikan <strong class="text-danger">alamat pengiriman sudah sudah benar</strong> dan <strong class="text-danger">berat total pemesanan tidak lebih dari 30kg</strong>. </p></div></div></div>'
                );
            }
        });
    }
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
    var number_string = value.toString().replace(/[^,\d]/g, ""),
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

function previewImage() {
    const image = document.querySelector('#profileImage');
    const imagepreview = document.querySelector('.user-account-profile-img');
    console.log(image);
    console.log(imagepreview);
    imagepreview.style.display = 'block';

    const oFReader = new FileReader();

    oFReader.readAsDataURL(image.files[0]);

    oFReader.onload = function(OFREvent) {
        imagepreview.src = OFREvent.target.result;
    }
}


var $modal = $('#upload-img-user-modal');
// console.log($modal);
var image = document.getElementById('image-user');
var cropper;
$("body").on("change", ".user-account-profile-img-file", function(e) {
    var files = e.target.files;
    var done = function(url) {
        image.src = url;
        console.log(files[0]['name']);
        $modal.modal('show');
    };
    var reader;
    var file;
    var url;
    var filePath = files[0]['name'];
    var fileSize = files[0].size;
    console.log(files[0].size);
    // Allowing file type

    var allowedExtensions =
        /(\.jpg|\.jpeg|\.png)$/i;
    var allowedSize = 2100000;

    if (!allowedExtensions.exec(filePath)) {
        alert('Format file tidak sesuai! Gunakan gambar dengan format (.jpg, .jpeg, .png)');
        return false;
    }
    if (fileSize > allowedSize) {
        alert('Ukuran foto maksimal 2MB');
        return false;
    }
    if (files && files.length > 0) {
        file = files[0];
        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function(e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
    $('.show-before-upload').html(' <button type="button" class="btn btn-danger preview-profile-image-button" data-bs-toggle="modal" data-bs-target="#upload-img-user-modal">Lihat Foto </button>');
});
$modal.on('shown.bs.modal', function() {
    cropper = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 3,
        preview: '.preview-img-user'
    });
}).on('hidden.bs.modal', function() {
    cropper.destroy();
    cropper = null;
});
$("#upload-profile-img").click(function() {
    canvas = cropper.getCroppedCanvas({
        width: 500,
        height: 500,
    });
    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function() {
            var base64data = reader.result;
            var user_id = $('input[name="user_id"]').val();
            console.log($('meta[name="csrf-token"]').attr('content'));
            console.log(base64data);
            console.log(user_id);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "profile-image-upload",
                data: {
                    'user_id': user_id,
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'profile_image': base64data
                },
                success: function(data) {
                    console.log(data);
                    $modal.modal('hide');
                    alert(data['success']);
                    window.location.reload();
                }
            });
        }
    });
})