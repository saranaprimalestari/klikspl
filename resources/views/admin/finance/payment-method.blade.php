@extends('admin.layouts.main')
@section('container')
    {{-- {{ print_r(session()->all()) }} --}}

    @if (session()->has('addSuccess'))
        <div class="alert alert-success alert-dismissible fade show alert-notification" role="alert">
            {{ session('addSuccess') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session()->has('addFailed'))
        <div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">
            {{ session('addFailed') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2">Metode Pembayaran</h1>
        <a class="btn btn-danger fs-14 add-payment-method-btn" data-bs-toggle="modal" data-bs-target="#paymentMethodModal">
            <i class="bi bi-plus-lg"></i> Tambah Baru
        </a>
    </div>
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

    {{-- {{ dd($paymentMethod) }} --}}
    <div class="modal fade" id="paymentMethodModal" tabindex="-1" aria-labelledby="paymentMethodModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-radius-1-5rem fs-14">
                <form class="payment-form" action="{{ route('paymentmethod.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="exampleModalLabel">Tambahkan Metode Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="my-3 row align-items-center">
                            <label for="PaymentLogo" class="col-sm-4 col-md-4 col-form-label fw-600">
                                <p class="fw-600 m-0">
                                    Logo Metode Pembayaran
                                </p>
                                <p class="text-grey fs-12 m-0">
                                    Ukuran Maks 2MB, format .jpg, .jpeg, .png
                                </p>
                            </label>
                            <div class="col-sm-8 col-md-8">
                                <input type="file" class="form-control fs-14 @error('logo') is-invalid @enderror"
                                    id="PaymentLogo" name="logo" value="{{ old('logo') }}">
                                @error('logo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="my-3 row align-items-center">
                            <label for="paymentName" class="col-sm-4 col-md-4 col-form-label fw-600">Nama Metode
                                Pembayaran</label>
                            <div class="col-sm-8 col-md-8">
                                <input required type="text"
                                    class="form-control fs-14 @error('name') is-invalid @enderror" id="paymentName"
                                    name="name" placeholder="Ketikkan nama metode pembayaran" value="{{ old('name') }}"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="my-3 row align-items-center">
                            <label for="paymentAccountName" class="col-sm-4 col-md-4 col-form-label fw-600">Nama Pemilik
                                Metode Pembayaran</label>
                            <div class="col-sm-8 col-md-8">
                                <input required type="text"
                                    class="form-control fs-14 @error('account_name') is-invalid @enderror"
                                    id="paymentAccountName" name="account_name"
                                    placeholder="Ketikkan nama pemilik metode pembayaran" value="{{ old('account_name') }}"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="my-3 row align-items-center">
                            <label for="paymentType" class="col-sm-4 col-md-4 col-form-label fw-600">
                                <p class="fw-600 m-0">
                                    Tipe Pembayaran
                                </p>
                                <p class="text-grey fs-12 m-0">
                                    Transfer Bank/Cash on Delivery/e-wallet
                                </p>
                            </label>
                            <div class="col-sm-8 col-md-8">
                                <input required type="text"
                                    class="form-control fs-14 @error('type') is-invalid @enderror bg-white" id="paymentType"
                                    name="type" placeholder="Tipe metode pembayaran" value="{{ old('type') }}"
                                    required>
                                @error('type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="my-3 row align-items-center">
                            <label for="paymentAccountNumber" class="col-sm-4 col-md-4 col-form-label fw-600">
                                <p class="fw-600 m-0">
                                    Nomor Akun
                                </p>
                                <p class="text-grey fs-12 m-0">
                                    Nomor Rekening Bank/ nomor akun e-wallet
                                </p>
                            </label>
                            <div class="col-sm-8 col-md-8">
                                <input required type="text"
                                    class="form-control fs-14 @error('account_number') is-invalid @enderror bg-white"
                                    id="paymentAccountNumber" name="account_number" placeholder="Tipe metode pembayaran"
                                    value="{{ old('account_number') }}" required>
                                @error('account_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="my-3 row align-items-center">
                            <label for="paymentCode" class="col-sm-4 col-md-4 col-form-label fw-600">
                                <p class="fw-600 m-0">
                                    Kode Metode Pembayaran
                                </p>
                                <p class="text-grey fs-12 m-0">
                                    Kode metode pembayaran
                                </p>
                            </label>
                            <div class="col-sm-8 col-md-8">
                                <input required type="text"
                                    class="form-control fs-14 @error('code') is-invalid @enderror bg-white"
                                    id="paymentCode" name="code" placeholder="kode metode pembayaran"
                                    value="{{ old('code') }}" required>
                                @error('code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="my-3 row align-items-center">
                            <label for="paymentDescription" class="col-sm-4 col-md-4 col-form-label fw-600">
                                <p class="fw-600 m-0">
                                    Deskripsi
                                </p>
                                <p class="text-grey fs-12 m-0">
                                    Penjelasan metode pembayaran
                                </p>
                            </label>
                            <div class="col-sm-8 col-md-8">
                                <input id="paymentDescription" type="hidden" name="description" value="">
                                <trix-editor input="paymentDescription" id="desc"></trix-editor>
                                @error('description')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary fs-14" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger fs-14">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletepaymentMethodModal" tabindex="-1" aria-labelledby="deletepaymentMethodModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-radius-1-5rem fs-14">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <form class="payment-form-delete" action="" method="post">
                        @csrf
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus Metode Pembayaran</h5>
                        <div class="my-3">
                            Apakah yakin akan menghapus Metode Pembayaran
                            <strong>
                                <div class="deleted-payment-method">
                                </div>
                            </strong>
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

    <div class="container p-0 mb-5">
        <div class="card admin-card-dashboard border-radius-1-5rem fs-14">
            <div class="card-body p-5 py-4">
                <table id="paymentMethod"
                    class="table hover fs-14 nowrap table-borderless table-hover cell-border order-column"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th class="min-mobile">No</th>
                            <th class="min-mobile">Rekening</th>
                            {{-- <th class="min-mobile">Nama Akun</th>
                            <th class="min-mobile">Tipe</th>
                            <th class="min-mobile">No Rekening/Akun</th>
                            <th class="min-mobile">Kode</th> --}}
                            {{-- <th class="min-mobile">Description</th> --}}
                            <th class="min-mobile">Status</th>
                            <th class="not-mobile">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paymentMethod as $payment)
                            <tr class="py-5">
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{-- @if (isset($payment->logo))
                                        <img id="main-logo" class="" src="{{ asset($payment->logo) }}"
                                            class="img-fluid" alt="..." width="10%" height="10%">
                                    @endif
                                    {{ $payment->name }} --}}
                                    {{-- <div class="d-flex"> --}}
                                    <div class="">
                                        <div class="d-flex align-items-center">
                                            @if (isset($payment->logo))
                                                <img id="payment-method-image-{{ $payment->id }}" class="img-fluid {{ ($payment->is_active) ?  '' : 'grayscale-filter'}}" src="{{ asset($payment->logo) }}" alt="..." width="6%" height="6%">
                                            @endif
                                            <div class="">
                                                <p class="ps-2 m-0 fw-500">
                                                    {{ $payment->name }} - {{ $payment->account_name }}
                                                </p>
                                                <p class="ps-2 m-0 fs-11">
                                                    {{ $payment->type }}
                                                </p>
                                                <p class="ps-2 m-0 fs-11">
                                                    {{ $payment->account_number }}
                                                </p>
                                                <p class="ps-2 m-0 fs-11">
                                                    {{ $payment->code }}
                                                </p>
                                            </div>
                                        </div>
                                        <input type="hidden" name="payment_name_{{ $payment->id }}"
                                            value="{{ $payment->name }}">
                                        <input type="hidden" name="payment_account_name_{{ $payment->id }}"
                                            value="{{ $payment->account_name }}">
                                        <input type="hidden" name="payment_type_{{ $payment->id }}"
                                            value="{{ $payment->type }}">
                                        <input type="hidden" name="payment_account_number_{{ $payment->id }}"
                                            value="{{ $payment->account_number }}">
                                        <input type="hidden" name="payment_code_{{ $payment->id }}"
                                            value="{{ $payment->code }}">
                                        <input type="hidden" name="payment_description_{{ $payment->id }}"
                                            value="{{ $payment->description }}">
                                    </div>
                                    {{-- </div> --}}
                                </td>
                                {{-- <td>
                                    {{ $payment->account_name }}
                                </td>
                                <td>
                                    {{ $payment->type }}
                                </td>
                                <td>
                                    {{ $payment->account_number }}
                                </td>
                                <td>
                                    {{ $payment->code }}
                                </td> --}}
                                {{-- <td>
                                    {!! $payment->description !!}
                                </td> --}}
                                <td>
                                    {{-- {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }} --}}
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input payment-status" type="checkbox" role="switch"
                                            id="status-{{ $payment->id }}"
                                            {{ $payment->is_active == 1 ? 'checked' : '' }} name="isActive">
                                        <label class="form-check-label fs-14 statusLabel-{{ $payment->id }}"
                                            for="status-{{ $payment->id }}">
                                            {{ $payment->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                        </label>
                                    </div>
                                    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">

                                </td>
                                <td>
                                    <a type="button" class="link-dark text-decoration-none mx-1 edit-payment-method "
                                        id="payment-method-{{ $payment->id }}" title="Edit metode pembayaran" data-bs-toggle="modal"
                                        data-bs-target="#paymentMethodModal" data-bs-toggle="tooltip" data-bs-placement="bottom">
                                        <i class="bi bi-pen"></i>
                                    </a>
                                    {{-- <a href="#" class="link-dark text-decoration-none mx-1" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Notifikasi Stok | status:">
                                        <i class="bi bi-bell"></i>
                                    </a> --}}
                                    @if (count($payment->order) < 1)
                                        <a type="button" class="link-dark text-decoration-none mx-1 delete-payment-method"
                                            id="payment-method-{{ $payment->id }}"
                                            title="Hapus metode pembayaran | hanya dapat dilakukan ketika metode pembayaran belum pernah digunakan pembeli"
                                            data-bs-toggle="modal" data-bs-target="#deletepaymentMethodModal"
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
    <script>
        $(document).ready(function() {
            console.log($('input[name="description"]').val());
            var desc = $('input[name="description"]').val('ini deksripsi dari jquery');
            console.log(desc.val());
            $('.add-payment-method-btn').on('click', function() {
                console.log('a clicked');
                $('input[name="account_name"]').val('');
                $('input[name="name"]').val('');
                $('input[name="type"]').val('');
                $('input[name="account_number"]').val('');
                $('input[name="code"]').val('');
                $('input[name="description"]').val('');
                $('#desc').val('');
            });
            $('body').on('click', '.edit-payment-method', function(e) {
                console.log(e.currentTarget.id);
                console.log('edit clicked');
                var targetId = e.currentTarget.id;
                var paymentId = targetId.replace(/[^\d.]/g, '');
                console.log(paymentId);
                console.log($('input[name="payment_description_' + paymentId + '"]').val());
                var route = "{{  route('paymentmethod.update',':paymentId')  }}";
                route = route.replace(':paymentId', paymentId);
                // var route = "http://klikspl.test/admin/paymentmethod/" + paymentId;
                console.log(route);
                $('.payment-form').attr('action', route);
                $('input[name="name"]').val($('input[name="payment_name_' + paymentId + '"]').val());
                $('input[name="account_name"]').val($('input[name="payment_account_name_' + paymentId +
                    '"]').val());
                $('input[name="type"]').val($('input[name="payment_type_' + paymentId + '"]').val());
                $('input[name="account_number"]').val($('input[name="payment_account_number_' + paymentId +
                    '"]').val());
                $('input[name="code"]').val($('input[name="payment_code_' + paymentId + '"]').val());
                $('input[name="description"]').val($('input[name="payment_description_' + paymentId + '"]')
                    .val());
                $('#desc').val($('input[name="payment_description_' + paymentId + '"]').val());
                $('.payment-form').append('<input name="_method" type="hidden" value="PUT">');
                $('.payment-form').append('<input name="payment_id" type="hidden" value="' + paymentId +
                    '">');
                    
                // console.log($('input[name="description"]').val());
                // console.log($('#desc').val($('input[name="payment_description_' + paymentId + '"]').val()));
            });
            $('body').on('click', '.delete-payment-method', function(e) {
                console.log(e.currentTarget.id);
                console.log('delete clicked');
                var targetId = e.currentTarget.id;
                var paymentId = targetId.replace(/[^\d.]/g, '');
                console.log(paymentId);
                var route = "{{ route('paymentmethod.destroy', ':paymentId') }}";
                route = route.replace(':paymentId', paymentId);
                // var route = "http://klikspl.test/admin/paymentmethod/" + paymentId;
                console.log(route);
                $('.deleted-payment-method').text($('input[name="payment_name_' + paymentId + '"]').val()+' - '+$('input[name="payment_account_name_' + paymentId +
                    '"]').val());
                $('.payment-form-delete').attr('action', route);
              
                $('.payment-form-delete').append('<input name="_method" type="hidden" value="DELETE">');
                $('.payment-form-delete').append('<input name="payment_id" type="hidden" value="' + paymentId +
                    '">');
            });
            // $('#product').DataTable({
            //     // select: true
            //     fixedHeader: true,
            // });
            var table = $('#paymentMethod').DataTable({
                // // fixedHeader: true,
                // responsive: true,
                // // lengthChange: false,
                // // buttons: ['colvis'],
                // columnDefs: [{
                //         "targets": 0, // your case first column
                //         // "className": "text-center",
                //         "width": "4%"
                //     },
                //     {
                //         "targets": 1,
                //         // "className": "text-center",
                //         // "width": "4%"
                //     },
                //     {
                //         "targets": 2,
                //         // "className": "text-center",
                //         "width": "6%"
                //     },
                //     // {
                //     //     "targets": 3,
                //     //     "className": "text-center",
                //     //     // "width": "4%"
                //     // },
                //     // {
                //     //     "targets": 4,
                //     //     "className": "text-center",
                //     //     "width": "18%"
                //     // },
                //     // {
                //     //     "targets": 5,
                //     //     "className": "text-center",
                //     //     "width": "8%"
                //     // }
                // ],
            });

            // table.buttons().container().appendTo('#product_wrapper .col-md-6:eq(0)');

            // new $.fn.dataTable.FixedHeader( table );

            $('body').on('change', '.payment-status', function(e) {
                var id = e.currentTarget.id.replace('status-', '');
                var token = $('input[name="csrf_token"]').val();
                console.log(id);
                console.log(token);
                console.log(e.currentTarget.id);
                if (e.currentTarget.checked) {
                    updateStatus(token, id, 1);
                } else {
                    updateStatus(token, id, 0);
                }
            });

            function updateStatus(csrfToken, senderAddressId, data) {
                $.ajax({
                    url: "{{ url('/administrator/paymentmethod/updatestatus') }}",
                    type: 'post',
                    data: {
                        _token: csrfToken,
                        id: senderAddressId,
                        status: data,
                    },
                    success: function(response) {
                        if (response.status) {
                            $('.statusLabel-' + response.id).text('Aktif');
                            if ($("#payment-method-image-" + response.id).hasClass("grayscale-filter")) {
                                $("#payment-method-image-" + response.id).removeClass("grayscale-filter");
                            }
                        } else {
                            $('.statusLabel-' + response.id).text('Tidak Aktif');
                            if (!$("#payment-method-image-" + response.id).hasClass("grayscale-filter")) {
                                $("#payment-method-image-" + response.id).addClass("grayscale-filter");
                            }
                        }
                        $('.alert-notification-wrapper').append(
                            '<div class="alert alert-success alert-dismissible fade show alert-notification-payment-method" id="alert-notification-payment-method" role="alert">Berhasil memperbarui status metode pembayaran<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                        );

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('.alert-notification-wrapper').append(
                            '<div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">Gagal memperbarui status metode pembayaran. (' +
                            jqXHR.status + ' ' + errorThrown +
                            ')<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                        );
                    },
                    dataType: "json",

                });
                $(document).ajaxStop(function() {
                    // window.location.reload();
                    $(".alert-notification-payment-method").fadeTo(5000, 1000).fadeOut(1000,
                        function() {
                            $(".alert-notification-payment-method").fadeOut(5000);
                            $(this).remove();
                        });
                });
            }
        });
    </script>
@endsection
