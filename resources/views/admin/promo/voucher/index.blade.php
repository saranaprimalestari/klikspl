@extends('admin.layouts.main')
@section('container')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show alert-notification" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session()->has('failed'))
        <div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">
            {{ session('failed') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        {!! implode(
            '',
            $errors->all(
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">:message<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
            ),
        ) !!}
    @endif
    <div class="alert-notification-wrapper" id="alert-notification-wrapper">
    </div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2 m-0">Promo Voucher</h1>
        <a class="btn btn-danger fs-14 add-payment-method-btn" href="{{ route('promovoucher.create') }}">
            <i class="bi bi-plus-lg"></i> Tambah Baru
        </a>
    </div>
    <div class="container p-0 mb-5">
        <div class="card admin-card-dashboard border-radius-1-5rem fs-14">
            <div class="card-body p-5 pt-4">
                <div class="d-flex overflow-auto">
                    <div class="status-form">
                        <a href="{{ route('promovoucher.index') }}"
                            class="btn link-dark bg-white text-decoration-none shadow-none fs-13 me-2 my-1 shadow-none border-radius-075rem border {{ !is_null(session()->get('status')) ? (session()->get('status') == '' ? 'border-danger text-danger' : '') : '' }}">
                            Semua
                        </a>
                    </div>
                    <form class="status-form" action="{{ route('promovoucher.index') }}" method="GET">
                        <input type="hidden" name="status" value="aktif">
                        <button type="submit"
                            class="btn text-dark bg-white text-decoration-none shadow-none fs-13   me-2 my-1 shadow-none border-radius-075rem border {{ !is_null(session()->get('status')) ? (session()->get('status') == 'aktif' ? 'active-menu border-danger text-danger' : '') : '' }}">
                            Aktif
                        </button>
                    </form>
                    <form class="status-form" action="{{ route('promovoucher.index') }}" method="GET">
                        <input type="hidden" name="status" value="tidak aktif">
                        <button type="submit"
                            class="btn text-dark bg-white text-decoration-none shadow-none fs-13   me-2 my-1 shadow-none border-radius-075rem border {{ !is_null(session()->get('status')) ? (session()->get('status') == 'tidak aktif' ? 'active-menu border-danger text-danger' : '') : '' }}">
                            Tidak Aktif
                        </button>
                    </form>
                    <form class="status-form" action="{{ route('promovoucher.index') }}" method="GET">
                        <input type="hidden" name="status" value="akan datang">
                        <button type="submit"
                            class="btn text-dark bg-white text-decoration-none shadow-none fs-13   me-2 my-1 shadow-none border-radius-075rem border {{ !is_null(session()->get('status')) ? (session()->get('status') == 'akan datang' ? 'active-menu border-danger text-danger' : '') : '' }}">
                            Akan Datang
                        </button>
                    </form>
                    <form class="status-form" action="{{ route('promovoucher.index') }}" method="GET">
                        <input type="hidden" name="status" value="sudah berakhir">
                        <button type="submit"
                            class="btn text-dark bg-white text-decoration-none shadow-none fs-13   me-2 my-1 shadow-none border-radius-075rem border {{ !is_null(session()->get('status')) ? (session()->get('status') == 'sudah berakhir' ? 'active-menu border-danger text-danger' : '') : '' }}">
                            Sudah Berakhir
                        </button>
                    </form>
                </div>
                <table id="promo" class="table hover fs-12 nowrap table-borderless table-hover cell-border order-column"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th class="min-mobile">No</th>
                            <th class="min-mobile">Nama Promo</th>
                            @if (auth()->guard('adminMiddle')->user()->admin_type == 1)
                                <th class="min-mobile">Company</th>
                            @endif
                            {{-- <th class="not-mobile">Kode</th>
                            <th class="not-mobile">Jenis Promo</th> --}}
                            <th class="not-mobile">Tgl Mulai</th>
                            <th class="not-mobile">Tgl Akhir</th>
                            <th class="not-mobile">Min Transaksi</th>
                            <th class="not-mobile">Diskon</th>
                            <th class="not-mobile">Kuota</th>
                            <th class="not-mobile">Status</th>
                            <th class="not-mobile">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($promos as $promo)
                            <tr class="py-5">
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div>
                                            @if (!empty($promo->image))
                                                @if ($promo->image)
                                                    <img id="main-image"
                                                        class="border-radius-05rem promo-voucher-image-{{ $promo->id }} {{ $promo->is_active ? '' : 'grayscale-filter' }}"
                                                        src="{{ asset($promo->image) }}" class="img-fluid" alt="..."
                                                        width="60">
                                                @else
                                                    <img id="main-image"
                                                        class="border-radius-05rem promo-voucher-image-{{ $promo->id }} {{ $promo->is_active ? '' : 'grayscale-filter' }}"
                                                        src="https://source.unsplash.com/400x400?promo-voucher-1"
                                                        class="img-fluid" alt="..." width="60">
                                                @endif
                                            @else
                                                <img id="main-image"
                                                    class="border-radius-05rem promo-voucher-image-{{ $promo->id }} {{ $promo->is_active ? '' : 'grayscale-filter' }}"
                                                    src="{{ asset('assets/voucher.png') }}" class="img-fluid"
                                                    alt="..." width="60">
                                            @endif
                                        </div>
                                        <div class="ps-2">
                                            <p class="m-0 fw-600">
                                                {{ $promo->name }}
                                            </p>
                                            <p class="m-0">
                                                Kode : {{ $promo->code }}
                                            </p>
                                            <p class="m-0">
                                                Jenis Promo : {{ $promo->promotype->name }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <input type="hidden" name="promo_voucher_name_{{ $promo->id }}"
                                    value="{{ $promo->name }}">
                                <input type="hidden" name="promo_voucher_image_{{ $promo->id }}"
                                    value="{{ $promo->image }}">
                                {{-- <td>
                                    {{ $promo->code }}
                                </td>
                                <td>
                                    {{ $promo->promotype->name }}
                                </td> --}}
                                @if (auth()->guard('adminMiddle')->user()->admin_type == 1)
                                    <td>
                                        {{ $promo->company->name }}
                                    </td>    
                                @endif
                                <td>
                                    {{ \Carbon\Carbon::parse($promo->start_period)->isoFormat('D MMM Y, HH:mm') }} WIB
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($promo->end_period)->isoFormat('D MMM Y, HH:mm') }} WIB
                                </td>
                                <td>
                                    Rp{{ price_format_rupiah($promo->min_transaction) }}
                                </td>
                                <td>
                                    @if ($promo->promo_type_id == 1)
                                        {{ $promo->discount }}%
                                    @else
                                        Rp{{ price_format_rupiah($promo->discount) }}
                                    @endif
                                </td>
                                <td>
                                    {{ $promo->quota }}
                                </td>
                                <td>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input promo-voucher-status" type="checkbox"
                                            role="switch" id="status-{{ $promo->id }}"
                                            {{ $promo->is_active == 1 ? 'checked' : '' }} name="isActive">
                                        <label class="form-check-label fs-14 statusLabel-{{ $promo->id }}"
                                            for="status-{{ $promo->id }}">
                                            {{ $promo->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                        </label>
                                    </div>
                                    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                                </td>
                                <td>
                                    @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                                        auth()->guard('adminMiddle')->user()->admin_type == 2)
                                        <a href="{{ route('promovoucher.edit', $promo) }}"
                                            class="link-dark text-decoration-none mx-1" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Edit Promo Voucher">
                                            <i class="bi bi-pen"></i>
                                        </a>
                                        {{-- <a href="{{ route('promovoucher.show', $promo) }}"
                                            class="link-dark text-decoration-none mx-1" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Detail Promo Voucher">
                                            <i class="bi bi-info-circle"></i>
                                        </a> --}}
                                        <a type="button" class="link-dark text-decoration-none mx-1 delete-promo-voucher"
                                            id="Voucher-{{ $promo->id }}" title="Hapus Promo Voucher"
                                            data-bs-toggle="modal" data-bs-target="#deletePromoVoucherModal"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                                            <i class="bi bi-trash3"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deletePromoVoucherModal" tabindex="-1" aria-labelledby="deletePromoVoucherModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-radius-1-5rem fs-14">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <form class="promo-voucher-form-delete" action="" method="post">
                        @csrf
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus Promo voucher</h5>
                        <div class="my-3">
                            <p class="mb-2">
                                Apakah yakin akan menghapus Promo voucher
                            </p>
                            <div class="row justify-content-center">
                                <div class="col-md-4 col-12 mb-2 deleted-promo-voucher-image">
                                </div>
                                <div class="col-12 ps-md-0">
                                    <strong>
                                        <div class="deleted-promo-voucher">
                                        </div>
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary fs-14" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger fs-14">Hapus</button>
                    </form>
                </div>
                <div class="modal-footer border-0">
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('body').on('click', '.delete-promo-voucher', function(e) {
                console.log(e.currentTarget.id);
                console.log('delete clicked');
                var targetId = e.currentTarget.id;
                var promoVoucherId = targetId.replace(/[^\d.]/g, '');
                var base_url = window.location.origin;
                console.log(promoVoucherId);
                var route = "{{ route('promovoucher.destroy', ':promoVoucherId') }}";
                route = route.replace(':promoVoucherId', promoVoucherId);
                // var route = "http://klikspl.test/administrator/promovoucher/" + promoVoucherId;
                console.log(route);
                console.log(base_url);
                console.log(($('input[name="promo_voucher_image_' + promoVoucherId + '"]').val()));
                if(($('input[name="promo_voucher_image_' + promoVoucherId + '"]').val())){
                    $('.deleted-promo-voucher-image').html('<img src="'+base_url + '/' + ($(
                    'input[name="promo_voucher_image_' + promoVoucherId + '"]').val())+'" class="img-fluid w-100 border-radius-05rem" alt="...">');
                    // $('.deleted-promo-voucher-image').attr('src', base_url + '/' + ($(
                    // 'input[name="promo_voucher_image_' + promoVoucherId + '"]').val()));
                }else{
                    $('.deleted-promo-voucher-image').empty();

                }
                $('.deleted-promo-voucher').text($('input[name="promo_voucher_name_' + promoVoucherId +
                        '"]')
                    .val());
                $('.promo-voucher-form-delete').attr('action', route);
                $('.promo-voucher-form-delete').append(
                    '<input name="_method" type="hidden" value="DELETE">');
                $('.promo-voucher-form-delete').append('<input name="merk_id" type="hidden" value="' +
                    promoVoucherId +
                    '">');
            });

            $('#promo').DataTable({
                responsive: true,
                aLengthMenu: [
                    [10, 25, 50, 100, 200, -1],
                    [10, 25, 50, 100, 200, "All"]
                ],
                iDisplayLength: 10
            });
            $('body').on('change', '.promo-voucher-status', function(e) {
                var id = e.currentTarget.id.replace('status-', '');
                var token = $('input[name="csrf_token"]').val();
                console.log(id);
                console.log(token);
                if (e.currentTarget.checked) {
                    updateStatus(token, id, 1);
                } else {
                    updateStatus(token, id, 0);
                }
            });

            function updateStatus(csrfToken, senderAddressId, data) {
                $.ajax({
                    url: "{{ url('/administrator/promovoucher/updatestatus') }}",
                    type: 'post',
                    data: {
                        _token: csrfToken,
                        id: senderAddressId,
                        status: data,
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 1) {
                            console.log('ini aktif');
                            $('.statusLabel-' + response.id).text('Aktif');
                            if ($(".promo-voucher-image-" + response.id).hasClass("grayscale-filter")) {
                                $(".promo-voucher-image-" + response.id).removeClass(
                                    "grayscale-filter");
                            }
                        } else {
                            console.log(response);
                            $('.statusLabel-' + response.id).text('Tidak Aktif');
                            if (!$(".promo-voucher-image-" + response.id).hasClass(
                                    "grayscale-filter")) {
                                console.log('unactive');
                                $(".promo-voucher-image-" + response.id).addClass("grayscale-filter");
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
        });
    </script>
@endsection
