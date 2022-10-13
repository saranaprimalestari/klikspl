@extends('admin.layouts.main')
@section('container')
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
    <div class="alert-notification-wrapper">
    </div>
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h5 class="m-0">Alamat Pengiriman</h5>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('senderaddress.create') }}" class="btn btn-danger fs-13 py-2 px-3">
                <p class="m-0">
                    <i class="bi bi-plus-lg"></i> Tambah Alamat Pengiriman
                </p>
            </a>
        </div>
    </div>
    @if (count($senderAddresses) > 0)
        @foreach ($senderAddresses as $address)
            <div class="card mb-4 sender-address-{{ $address->id }} border-radius-1-5rem border-0 fs-14">
                <div class="card-body p-0 p-4">
                    <div class="row">
                        <div class="col-md-10 col-10 ">
                            <p class="m-0 fw-600">
                                {{ $address->name }}
                            </p>
                            <p class="m-0 ">
                                {{ $address->telp_no }}
                            </p>
                            <p class="m-0 ">
                                {{ $address->address }}
                            </p>
                            {{-- <div class="-city">
                                    <span class="m-0 me-1 ">
                                        {{ $address->city->name }},
                                    </span>
                                    <span class="m-0 -province me-1">
                                        {{ $address->province->name }},
                                    </span>
                                    <span class="m-0 -postalcode">
                                        {{ $address->city->postal_code }}
                                    </span>
                                </div> --}}
                            <div class="input-data">
                                <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="senderAddress-{{ $address->id }}" value="{{ $address->id }}">
                                <input class="city-origin" type="hidden" name="cityOrigin" value="35">
                                <input class="city-destination" type="hidden" name="cityDestination"
                                    value="{{ $address->city->city_id }}">
                            </div>
                            <div class=" mt-2 d-flex align-items-center">
                                {{-- @if ($address->is_active != 1)
                                    <form action="{{ route('senderaddress.change.active') }}" method="post">
                                        @csrf
                                        <input class="address-id" type="hidden" name="addressId"
                                            value="{{ $address->id }}">
                                        <input class="user-id" type="hidden" name="userId"
                                            value="{{ auth()->user()->id }}">
                                        <button type="submit"
                                            class="btn m-0 p-0 text-decoration-none text-danger -change-link shadow-none"
                                            href="#editAddressModal" data-bs-toggle="modal" role="button">
                                            Pilih Alamat
                                        </button>
                                    </form>
                                    <span class="text-secondary mx-1"> | </span>
                                @endif --}}
                                {{-- <a class="text-decoration-none text-danger -change-link"
                                        href="{{ route('senderaddress.edit', $address) }}" role="button">
                                        Edit Alamat
                                    </a> --}}
                                {{-- @if ($address->is_active != 1) --}}
                                {{-- <span class="text-secondary mx-1"> | </span>
                                        <form action="{{ route('senderaddress.destroy', $address) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"
                                                class="btn m-0 p-0 text-decoration-none shadow-none text-danger -change-link"
                                                href="#editAddressModal" data-bs-toggle="modal" role="button">
                                                Hapus
                                            </button>
                                        </form> --}}
                                {{-- @endif --}}
                            </div>
                        </div>
                        <div class="col-md-2 col-2 d-flex align-items-center justify-content-center -active flex-wrap">
                            <p class="m-0 fs-14">
                                Status Alamat
                            </p>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input senderAddress-status" type="checkbox" role="switch"
                                    id="status-{{ $address->id }}" {{ $address->is_active == 1 ? 'checked' : '' }}
                                    name="isActive">
                                <label class="form-check-label fs-14 statusLabel-{{ $address->id }}"
                                    for="status-{{ $address->id }}">
                                    {{ $address->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- </label> --}}
                    <div class="d-flex justify-content-end">
                        <div class="row">
                            <div class="col-12">
                                <div class=" mt-2 d-flex align-items-center">
                                    <a class="text-decoration-none text-danger"
                                        href="{{ route('senderaddress.edit', $address) }}" role="button">
                                        Edit Alamat
                                    </a>
                                    {{-- @if ($address->is_active != 1) --}}
                                    <span class="text-secondary mx-1"> | </span>
                                    <form action="{{ route('senderaddress.destroy', $address) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                            class="btn m-0 p-0 text-decoration-none shadow-none text-danger fs-14"
                                            href="#editAddressModal" data-bs-toggle="modal" role="button">
                                            Hapus
                                        </button>
                                    </form>
                                    {{-- @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center notification-empty">
            <img class="my-4 cart-items-logo" src="/assets/footer-logo.png" width="300" alt="">
            <p>
                Alamat Pengiriman belum ditambahkan,
                <a href="{{ route('senderaddress.index') }}" class="text-decoration-none fw-bold login-link">
                    Tambahkan Alamat Pengiriman
                </a>
            </p>
        </div>
    @endif
    <script>
        $(document).ready(function() {
            $('body').on('change', '.senderAddress-status', function(e) {
                var id = e.currentTarget.id.replace('status-', '');
                var token = $('input[name="csrf_token"]').val();
                if (e.currentTarget.checked) {
                    update_status(token, id, 1);
                } else {
                    update_status(token, id, 0);
                }
            });
        });

        function update_status(csrfToken, senderAddressId, data) {
            $.ajax({
                url: "{{ url('/admin/senderaddress/updatestatus') }}",
                type: 'post',
                data: {
                    _token: csrfToken,
                    id: senderAddressId,
                    status: data,
                },
                success: function(response) {
                    console.log(response);
                    if (response.status) {
                        $('.statusLabel-' + response.id).text('Aktif');
                    } else {
                        $('.statusLabel-' + response.id).text('Tidak Aktif');
                    }
                    $('.alert-notification-wrapper').append(
                        '<div class="alert alert-success alert-dismissible fade show alert-notification" role="alert">Berhasil memperbarui status alamat pengiriman<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                    );

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('.alert-notification-wrapper').append(
                        '<div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">Gagal memperbarui status alamat pengiriman. (' +
                        jqXHR.status + ' ' + errorThrown +
                        ')<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                    );
                },
                dataType: "json",

            });
            // $(document).ajaxStop(function() {
            //     window.location.reload();
            // });
        }
    </script>
@endsection
