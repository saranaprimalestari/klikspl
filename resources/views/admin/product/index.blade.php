@extends('admin.layouts.main')
@section('container')
    {{-- {{ dd($products) }} --}}
    <div class="alert-notification-wrapper" id="alert-notification-wrapper">
    </div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2">Produk Saya</h1>
    </div>
    <div class="container p-0 mb-5">
        <div class="card admin-card-dashboard border-radius-1-5rem fs-14">
            <div class="card-body p-5 pt-4">
                <table id="product" class="table hover fs-14 nowrap table-borderless table-hover cell-border order-column"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th class="min-mobile">No</th>
                            <th class="min-mobile">Nama Produk</th>
                            <th class="not-mobile">Detail</th>
                            <th class="not-mobile">Stok</th>
                            @if (auth()->guard('adminMiddle')->user()->admin_type == 2)
                                <th class="not-mobile">Status</th>
                            @endif
                            <th class="not-mobile">Harga</th>
                            <th class="not-mobile">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="py-5">
                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <div class="d-flex">
                                        @if (count($product->productimage) > 0)
                                            @if (Storage::exists($product->productimage[0]->name))
                                                <img id="main-image"
                                                    class="border-radius-05rem product-image-{{ $product->id }} {{ $product->is_active ? '' : 'grayscale-filter' }}"
                                                    src="{{ asset('/storage/' . $product->productimage[0]->name) }}"
                                                    class="img-fluid" alt="..." width="60">
                                            @else
                                                <img id="main-image"
                                                    class="border-radius-05rem product-image-{{ $product->id }} {{ $product->is_active ? '' : 'grayscale-filter' }}"
                                                    src="https://source.unsplash.com/400x400?product-1" class="img-fluid"
                                                    alt="..." width="60">
                                            @endif
                                        @else
                                            <img id="main-image"
                                                class="border-radius-05rem product-image-{{ $product->id }} {{ $product->is_active ? '' : 'grayscale-filter' }}"
                                                src="https://source.unsplash.com/400x400?product-1" class="img-fluid"
                                                alt="..." width="60">
                                        @endif
                                        <div class="">
                                            <p class="ps-2 m-0">
                                                {{ $product->name }}
                                            </p>
                                            <p class="ps-2 m-0 fs-11">
                                                ID: {{ $product->product_code }}
                                            </p>
                                            <p class="ps-2 m-0 fs-11">
                                                @if (count($product->productvariant))
                                                    {{ count($product->productvariant) }} varian
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex">
                                        <div class="m-0 mx-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="Dilihat sebanyak {{ $product->view }} kali">
                                            <i class="bi bi-eye"></i>
                                            {{ $product->view }}
                                        </div>
                                        <div class="m-0 mx-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="Terjual sebanyak {{ count($product->productvariant) > 0 ? $product->productvariant->sum('sold') : $product->sold }} item">
                                            <i class="bi bi-cart"></i>
                                            {{ count($product->productvariant) > 0 ? $product->productvariant->sum('sold') : $product->sold }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if (count($product->productvariant))
                                        {{ $product->productvariant->sum('stock') }}
                                    @else
                                        {{ $product->stock }}
                                    @endif
                                </td>
                                @if (auth()->guard('adminMiddle')->user()->admin_type == 2)
                                    <td>
                                        {{-- {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }} --}}
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input product-status" type="checkbox" role="switch"
                                                id="status-{{ $product->id }}"
                                                {{ $product->is_active == 1 ? 'checked' : '' }} name="isActive">
                                            <label class="form-check-label fs-14 statusLabel-{{ $product->id }}"
                                                for="status-{{ $product->id }}">
                                                {{ $product->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                            </label>
                                        </div>
                                        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                                    </td>
                                @endif
                                <td>
                                    @if (count($product->productvariant) == 1)
                                        Rp{{ price_format_rupiah($product->productvariant->sortBy('price')->first()->price) }}
                                    @elseif (count($product->productvariant) > 1)
                                        Rp{{ price_format_rupiah($product->productvariant->sortBy('price')->first()->price) }}
                                        -
                                        {{ price_format_rupiah($product->productvariant->sortBy('price')->last()->price) }}
                                    @else
                                        Rp{{ price_format_rupiah($product->price) }}
                                    @endif
                                </td>
                                <td>
                                    @if (auth()->guard('adminMiddle')->user()->admin_type == 2)
                                        <a href="{{ route('adminproduct.edit', $product) }}"
                                            class="link-dark text-decoration-none mx-1" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Edit Produk">
                                            <i class="bi bi-pen"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('adminproduct.show', $product) }}"
                                        class="link-dark text-decoration-none mx-1" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Detail Produk">
                                        <i class="bi bi-info-circle"></i>
                                    </a>
                                    @if (auth()->guard('adminMiddle')->user()->admin_type == 2)
                                        <button
                                            class="btn p-0 link-dark text-decoration-none mx-1 product-stock-notification shadow-none"
                                            id="stock-notification-{{ $product->id }}" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom"
                                            title="Notifikasi Stok | status: {{ $product->stock_notification ? 'Aktif' : 'Tidak Aktif' }} ">
                                            <i id="icon-stock-notification-{{ $product->id }}"
                                                class="bi bi-{{ $product->stock_notification ? 'bell' : 'bell-slash' }}">
                                            </i>
                                        </button>
                                        <input type="hidden" class="input-stock-notification-{{ $product->id }}"
                                            name="stock_notification" value="{{ $product->stock_notification }}">
                                    @endif

                                    {{-- <a href="#" class="link-dark text-decoration-none mx-1" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Hapus Produk">
                                        <i class="bi bi-trash3"></i>
                                    </a> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            // $('#product').DataTable({
            //     // select: true
            //     fixedHeader: true,
            // });
            $('#product').DataTable({
                responsive: true,
                aLengthMenu: [
                    [10, 25, 50, 100, 200, -1],
                    [10, 25, 50, 100, 200, "All"]
                ],
                iDisplayLength: 10
            });
            // var table = $('#product').DataTable({
            //     // fixedHeader: true,
            //     responsive: true,
            //     // lengthChange: false,
            //     // buttons: ['colvis'],
            //     columnDefs: [
            //         // {
            //         //     "targets": 0, // your case first column
            //         //     "className": "text-center",
            //         //     // "width": "4%"
            //         // },
            //         //     "targets": 5,
            //         //     "className": "text-center",
            //         //     "width": "8%"
            //         // }
            //     ],
            // });

            // table.buttons().container().appendTo('#product_wrapper .col-md-6:eq(0)');

            // new $.fn.dataTable.FixedHeader( table );

            $('body').on('change', '.product-status', function(e) {
                var id = e.currentTarget.id.replace(/[^\d.]/g, '');
                var token = $('input[name="csrf_token"]').val();
                console.log(id);
                console.log(token);
                if (e.currentTarget.checked) {
                    updateStatus(token, id, 1);
                } else {
                    updateStatus(token, id, 0);
                }
            });

            $('body').on('click', '.product-stock-notification', function(e) {
                var id = e.currentTarget.id.replace(/[^\d.]/g, '');
                var token = $('input[name="csrf_token"]').val();
                console.log(id);
                console.log(token);
                var value = $('.input-stock-notification-' + id).val();
                console.log(value);
                if (value == 1) {
                    updateStockNotification(token, id, 0);
                    console.log('aktif -> nonaktif');
                } else {
                    updateStockNotification(token, id, 1);
                    console.log('nonaktif -> aktif');

                }
                // if (e.currentTarget.checked) {
                //     updateStockNotification(token, id, 1);
                // } else {
                //     updateStockNotification(token, id, 0);
                // }
            });

            function updateStatus(csrfToken, productId, data) {
                $.ajax({
                    url: "{!! route('admin.product.update.status') !!}",
                    type: 'post',
                    data: {
                        _token: csrfToken,
                        id: productId,
                        status: data,
                    },
                    success: function(response) {
                        if (response.status) {
                            $('.statusLabel-' + response.id).text('Aktif');
                            if ($(".product-image-" + response.id).hasClass("grayscale-filter")) {
                                $(".product-image-" + response.id).removeClass("grayscale-filter");
                            }
                        } else {
                            $('.statusLabel-' + response.id).text('Tidak Aktif');
                            if (!$(".product-image-" + response.id).hasClass("grayscale-filter")) {
                                console.log('unactive');
                                $(".product-image-" + response.id).addClass("grayscale-filter");
                            }
                        }
                        // var alertSuccess = document.createElement('div');
                        // alertSuccess.className =
                        //     "alert alert-success alert-dismissible fade show alert-notification-adminproduct";
                        // alertSuccess.setAttribute('role', 'alert');
                        // alertSuccess.setAttribute('id', 'alert-notification-adminproduct');

                        // alertSuccess.innerHTML =
                        //     'Berhasil memperbarui status produk<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';

                        // document.getElementById('alert-notification-wrapper').appendChild(alertSuccess);
                        $('.alert-notification-wrapper').append(
                            '<div class="alert alert-success alert-dismissible fade show alert-notification-adminproduct" id="alert-notification-adminproduct" role="alert">Berhasil memperbarui status produk<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                        );

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('.alert-notification-wrapper').append(
                            '<div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">Gagal memperbarui status produk. (' +
                            jqXHR.status + ' ' + errorThrown +
                            ')<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                        );
                    },
                    dataType: "json",

                });
                $(document).ajaxStop(function() {
                    // window.location.reload();
                    $(".alert-notification-adminproduct").fadeTo(5000, 1000).fadeOut(1000,
                        function() {
                            $(".alert-notification-adminproduct").fadeOut(5000);
                            $(this).remove();
                        });
                });
            }

            function updateStockNotification(csrfToken, productId, data) {
                console.log(csrfToken);
                console.log(productId);
                console.log(data);
                $.ajax({
                    url: "{!! route('admin.product.update.status.notification') !!}",
                    type: 'post',
                    data: {
                        _token: csrfToken,
                        id: productId,
                        status: data,
                    },
                    success: function(response) {
                        console.log(response);
                        // var icon = $('#icon-stock-notification-' + id);
                        // console.log(value);
                        // console.log(icon);

                        if (response.status == 1) {
                            console.log('berhasil update jadi aktif');
                            if ($("#icon-stock-notification-" + response.id).hasClass("bi-bell-slash")) {
                                $("#icon-stock-notification-" + response.id).removeClass("bi-bell-slash");
                                $("#icon-stock-notification-" + response.id).addClass("bi-bell");
                            }
                            $('.input-stock-notification-' + response.id).val(response.status);
                        } else {
                            console.log('berhasil update jadi nonaktif');
                            if ($("#icon-stock-notification-" + response.id).hasClass("bi-bell")) {
                                console.log('unactive');
                                $("#icon-stock-notification-" + response.id).removeClass("bi-bell");
                                $("#icon-stock-notification-" + response.id).addClass("bi-bell-slash");
                            }
                            $('.input-stock-notification-' + response.id).val(response.status);
                        }
                        $('.alert-notification-wrapper').append(
                            '<div class="alert alert-success alert-dismissible fade show alert-notification-adminproduct" id="alert-notification-adminproduct" role="alert">Berhasil memperbarui status notifikasi stock produk<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                        );

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('.alert-notification-wrapper').append(
                            '<div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">Gagal memperbarui status produk. (' +
                            jqXHR.status + ' ' + errorThrown +
                            ')<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                        );
                    },
                    dataType: "json",

                });
                $(document).ajaxStop(function() {
                    // window.location.reload();
                    $(".alert-notification-adminproduct").fadeTo(5000, 1000).fadeOut(1000,
                        function() {
                            $(".alert-notification-adminproduct").fadeOut(5000);
                            $(this).remove();
                        });
                });
            }
        });
    </script>
@endsection
