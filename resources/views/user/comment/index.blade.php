@extends('user.layout')
@section('account')
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
    <h5 class="mb-4">
        Komentar Produk
    </h5>
    <div class="card mb-3 order-card fs-14">
        <div class="card-body p-4">
            <div class="container p-0 mb-3">
                <div class="row align-items-center">
                    <div class="col-md-2 col-4 fw-600">
                        Cari Komentar
                    </div>
                    <div class="col-md-10 col-8">
                        <div class="input-group me-3">
                            <div class="input-group fs-14">
                                <input type="text"
                                    class="form-control border-radius-075rem fs-14 shadow-none border-end-0"
                                    id="searchKeyword" placeholder="Cari komentar..." aria-label="Cari komentar..."
                                    aria-describedby="search-order" name="search">
                                <span class="input-group-text border-radius-075rem fs-14 bg-white border-start-0"
                                    id="search-order"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (count($productComments) > 0)
                @foreach ($productComments as $comment)
                    {{-- @if ($comment->deadline_to_comment >= \Carbon\Carbon::now()->format('Y-m-d')) --}}
                    <div class="card mb-4 order-card-item box-shadow ">
                        <div
                            class="card-body p-4 {{ $comment->order_item_status === 'expired' ? 'btn disabled text-start' : '' }}">
                            <div class="mb-2 fs-13">
                                <span class="">No Invoice:
                                </span>
                                @if (is_null($comment->order->invoice_no))
                                    Belum terbit
                                @else
                                    <span class="fw-600">
                                        {{ $comment->order->invoice_no }}
                                    </span>
                                @endif
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-md-12">
                                    <div class="card my-3 border-radius-075rem">
                                        <div class="card-body px-4">
                                            <div class="row align-items-center">
                                                <div class="col-md-1 col-4 text-end">
                                                    @if (!is_null($comment->product->productimage->first()))
                                                        <img src="{{ asset('/storage/' . $comment->product->productimage[0]->name) }}"
                                                            class="w-100 border-radius-5px" alt="">
                                                    @endif
                                                </div>
                                                <div class="col-md-10 col-8 ps-0">
                                                    <div class="order-items-product-info text-start">
                                                        <div class="text-truncate order-items-product-name">
                                                            {{ $comment->product->name }}
                                                        </div>
                                                        <div
                                                            class="text-truncate order-items-product-variant text-grey fs-13">
                                                            Varian:
                                                            {{ !is_null($comment->productvariant) ? $comment->productvariant->variant_name : 'Tidak ada Varian' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-3 border-radius-075rem">
                                        <div class="card-body px-4">
                                            <p class="comment-text mb-1">
                                                @for ($i = 0; $i < $comment->star; $i++)
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                @endfor
                                                @for ($i = 0; $i < 5 - $comment->star; $i++)
                                                    <i class="bi bi-star text-warning"></i>
                                                @endfor
                                            </p>
                                            <h5 class="comment-text">{{ $comment->user->username }}
                                                <small class="text-muted comment-text fw-light ms-1">
                                                    <i>Diposting
                                                        {{ $comment->created_at->diffForHumans() }}
                                                    </i>
                                                </small>
                                            </h5>
                                            <div class="comment-text mb-2">
                                                {!! $comment->comment !!}
                                            </div>
                                            @if (!is_null($comment->comment_image) && !empty($comment->comment_image) && isset($comment->comment_image))
                                                <img src="{{ asset($comment->comment_image) }}" class=""
                                                    alt="" width="20%">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex align-items-center fs-13">
                                <div class="col-md-12 col-12 text-end my-2">
                                    @if ($comment->is_edit != 1)
                                        @if ($comment->deadline_to_comment >= \Carbon\Carbon::now()->format('Y-m-d'))
                                            <a href="{{ route('comment.edit', $comment) }}"
                                                class="text-decoration-none btn btn-outline-danger fs-14">
                                                <i class="far fa-edit"></i> Ubah
                                            </a>
                                        @else
                                            <a href="{{ route('comment.show', $comment) }}"
                                                class="text-decoration-none btn btn-outline-danger fs-14">
                                                <i class="bi bi-star"></i> Lihat Komentar
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('comment.show', $comment) }}"
                                            class="text-decoration-none btn btn-outline-danger fs-14">
                                            <i class="far fa-star"></i> Lihat Komentar
                                        </a>
                                    @endif
                                    {{-- <a href="{{ route('rating.show', $comment) }}" class="text-decoration-none btn btn-outline-danger fs-14 ms-1">
                                    <i class="far fa-trash-alt"></i> Hapus
                                </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- @endif --}}
                @endforeach
                
            @else
                <div class="text-center notification-empty">
                    <img class="my-4 cart-items-logo" src="/assets/footer-logo.png" width="300" alt="">
                    <p>
                        Tidak ada produk yang belum anda nilai saat ini, yuk cari produk menarik dan pesan sekarang
                    </p>
                </div>
            @endif
        </div>
    </div>
    <script>
        $(window).focus(function() {
            window.location.reload();
        });
        $(document).ready(function() {
            window.orders = {!! json_encode($productComments) !!};
            console.log(orders);

            $('#searchKeyword').on("keyup", function() {
                // $('.filter-btn').on("click", function() {
                // var search = $(this).val().toLowerCase();
                var search = $('input[name="search"]').val().toLowerCase();
                console.log(search);
                $(".order-card-item").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(search) > -1);
                    // });
                });
            });

            $('body').on('click', '.confirm-order-button', function(e) {
                $('.orderproduct-confirm-modal').empty();
                console.log(e.currentTarget.id);
                console.log('confirm order clicked');
                var targetId = e.currentTarget.id;
                var orderId = targetId.replace(/[^\d.]/g, '');
                var base_url = window.location.origin;
                console.log(orderId);
                $('input[name="orderId"]').val(orderId);
                $.each(orders, function(id, order) {
                    if (order['id'] == orderId) {
                        console.log(order['invoice_no']);
                        $('.invoice-no-modal').text(order['invoice_no']);
                        console.log(order['id']);
                        $.each(order['orderitem'], function(id, orderItem) {
                            console.log(orderItem['id']);
                            console.log(orderItem['orderproduct']);
                            console.log(orderItem['orderproduct']['orderproductimage'][0][
                                'name'
                            ]);
                            $('.orderproduct-confirm-modal').append(
                                '<div class="row my-3 align-items-center"><div class="col-md-2 col-4 text-end"><img src="' +
                                base_url + '/' + orderItem['orderproduct'][
                                    'orderproductimage'
                                ][0]['name'] +
                                '" class="w-100 border-radius-5px" alt=""></div><div class="col-md-10 col-8 ps-0"><div class="order-items-product-info text-start"><div class="text-truncate order-items-product-name">' +
                                orderItem['orderproduct']['name'] +
                                '</div><div class="text-truncate order-items-product-variant text-grey"> Varian: ' +
                                ((orderItem['orderproduct']['variant_name'] == null) ?
                                    'Tidak ada varian' : orderItem['orderproduct'][
                                        'variant_name'
                                    ]) + '</div></div></div></div>'
                            );

                            $('.orderitem-total-payment-confirm-modal-ammount').text(
                                formatRupiah((parseInt(order['courier_price']) +
                                    parseInt(order['total_price']) + parseInt(order[
                                        'unique_code'])), "Rp"));
                        });
                    }
                });
                var route = "{{ route('confirm.order', ':orderId') }}";
                route = route.replace(':orderId', orderId);
                // var route = "http://klikspl.test/administrator/promobanner/" + promoBannerId;
                console.log(route);
                console.log(base_url);
                console.log(($('input[name="promo_banner_image_' + orderId + '"]').val()));
                $('.deleted-promo-banner').text($('input[name="promo_banner_name_' + orderId + '"]').val());
                $('.deleted-promo-banner-image').attr('src', base_url + '/' + ($(
                    'input[name="promo_banner_image_' +
                    orderId + '"]').val()));
                $('.promo-banner-form-delete').attr('action', route);
                $('.promo-banner-form-delete').append(
                    '<input name="_method" type="hidden" value="DELETE">');
                $('.promo-banner-form-delete').append('<input name="merk_id" type="hidden" value="' +
                    orderId +
                    '">');
            });

        });
    </script>
@endsection
