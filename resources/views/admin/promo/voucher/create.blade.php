@extends('admin.layouts.main')
@section('container')
    @if (session()->has('addPromoVoucherSuccess'))
        <div class="alert alert-success alert-dismissible fade show alert-notification" role="alert">
            {{ session('addPromoVoucherSuccess') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session()->has('addPromoVoucherFailed'))
        <div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">
            {{ session('addPromoVoucherFailed') }}
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
    <h5 class="mb-4">
        <a href="{{ route('promovoucher.index') }}" class="text-decoration-none link-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        Tambah Promo Voucher Baru
    </h5>
    <form action="{{ route('promovoucher.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="container p-0 mb-4">
            <div class="card promoVoucher-info-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Informasi Promo</h5>
                        <p class="text-grey fs-13 m-0">Isikan nama, ID, kategori, dan merk Promo</p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-3 row">
                        <div class="col-sm-3 pb-0">
                            <p class="fw-600 m-0">
                                Perusahaan
                            </p>
                            {{-- <p class="text-grey fs-12 m-0">
                                *tidak ditampilkan di halaman pembeli
                            </p> --}}
                        </div>
                        <div class="col-sm-9">
                            @if (auth()->guard('adminMiddle')->user()->admin_type == 1)
                                <select required
                                    class="form-control shadow-none admin-product-company form-select shadow-none fs-14 @error('company_id') is-invalid @enderror"
                                    name="company_id" required>
                                    <option value="" class="fs-14">Pilih Perusahaan
                                    </option>
                                    @foreach ($companies as $company)
                                        <option class="fs-14" value="{{ $company->id }}">
                                            {{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            @else
                                <p class="m-0">
                                    {{ auth()->guard('adminMiddle')->user()->company->name }}
                                </p>
                                <input type="hidden" name="company_id" value="{{ auth()->guard('adminMiddle')->user()->company_id }}">
                            @endif
                            {{-- <input required type="text" class="form-control fs-14 bg-white @error('name') is-invalid @enderror" id="promoVoucherName" name="company" value="{{ auth()->guard('adminMiddle')->user()->company->name }}" disabled readonly> --}}
                            @error('company_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="promoVoucherName" class="col-sm-3 col-form-label pb-0">
                            <p class="fw-600 m-0">
                                Nama Promo
                            </p>
                            {{-- <p class="text-grey fs-12 m-0">
                                *tidak ditampilkan di halaman pembeli
                            </p> --}}
                        </label>
                        <div class="col-sm-9">
                            <input required type="text" class="form-control fs-14 @error('name') is-invalid @enderror"
                                id="promoVoucherName" name="name" placeholder="Ketikkan nama promo"
                                value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label for="promoVoucherSlug" class="col-sm-3 col-form-label pb-0">
                            <p class="fw-600 m-0">
                                Slug Promo
                            </p>
                            {{-- <p class="text-grey fs-12 m-0">
                                *tidak ditampilkan di halaman pembeli
                            </p> --}}
                        </label>
                        <div class="col-sm-9">
                            <input required type="text" class="bg-white form-control fs-14 @error('slug') is-invalid @enderror"
                                id="promoVoucherSlug" name="slug"
                                value="{{ old('slug') }}" readonly>
                            @error('slug')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="promoVoucherCode" class="col-sm-3 col-form-label pb-0">
                            <p class="fw-600 m-0">
                                Kode Promo
                            </p>
                            <p class="text-grey fs-12 m-0">
                                *Harus Unik! Terdiri dari huruf Kapital A-Z dan angka 0-9, Max 12 karakter
                            </p>
                        </label>
                        <div class="col-sm-9">
                            <input required type="text" class="form-control fs-14  @error('code') is-invalid @enderror"
                                id="promoVoucherCode" name="code" id="promo_voucher_code" maxlength="12"
                                placeholder="Contoh: SPL63" value="{{ old('code') }}">
                            @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="fs-12 mt-1">
                                <span class="promo-voucher-code-span-maxlength"></span>
                                <span class="promo-voucher-code-span-notif"></span>
                                <span class="promo-voucher-code-span-code-check"></span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label for="promoVoucherStartPeriod" class="col-sm-3 col-form-label fw-600">Periode Promo</label>
                        <div class="col-sm-4">
                            <input required type="datetime-local"
                                class="form-control fs-14 @error('start_period') is-invalid @enderror"
                                id="promoVoucherStartPeriod" name="start_period" placeholder="Ketikkan nama Promo"
                                value="{{ old('start_period') }}" min="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-DD') }}">
                            @error('start_period')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-1 p-0 text-center">
                            <i class="bi bi-dash-lg"></i><i class="bi bi-dash-lg"></i><i class="bi bi-dash-lg"></i>
                        </div>

                        <div class="col-sm-4">
                            <input required type="datetime-local"
                                class="form-control fs-14 @error('end_period') is-invalid @enderror"
                                id="promoVoucherEndPeriod" name="end_period" placeholder="Ketikkan nama Promo"
                                value="{{ old('end_period') }}"
                                min="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-DDTHH:mm') }}">
                            @error('end_period')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container p-0 mb-4">
            <div class="card promoVoucher-info-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Detail Promo</h5>
                        <p class="text-grey fs-13 m-0">Isikan Jenis/Tipe, diskon, min.transaksi, kuota, dan deskripsi/ S&K
                            promo</p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-3 row">
                        <label for="promoVoucherPromoType" class="col-sm-3 col-form-label pb-0">
                            <p class="fw-600 m-0">
                                Jenis/Tipe Promo
                            </p>
                        </label>
                        <div class="col-sm-9">
                            <select id="promoVoucherPromoType"
                                class="form-control shadow-none promo-type form-select shadow-none @error('promo_type_id') is-invalid @enderror"
                                name="promo_type_id" required>
                                <option value="">Pilih Jenis/Tipe Promo Voucher
                                </option>
                                @foreach ($promoTypes as $promoType)
                                    <option value="{{ $promoType->id }}">
                                        {{ $promoType->name }}</option>
                                @endforeach
                            </select>
                            @error('promo_type_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="promoVoucherDiscount" class="col-sm-3 col-form-label pb-0">
                            <p class="fw-600 m-0">
                                Diskon
                            </p>
                            <p class="text-grey fs-12 m-0">
                                *nominal/besar diskon
                            </p>
                        </label>
                        <div class="col-sm-9">
                            <input required type="number"
                                class="form-control fs-14 @error('discount') is-invalid @enderror"
                                id="promoVoucherDiscount" name="discount" placeholder="Ketikkan nominal/besar diskon"
                                value="{{ old('discount') }}">
                            @error('discount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="promoVoucherMinTransaction" class="col-sm-3 col-form-label pb-0">
                            <p class="fw-600 m-0">
                                Min. Transaksi
                            </p>
                        </label>
                        <div class="col-sm-9">
                            <input required type="number"
                                class="form-control fs-14 @error('min_transaction') is-invalid @enderror"
                                id="promoVoucherMinTransaction" name="min_transaction"
                                placeholder="Ketikkan nominal min. transaksi, contoh: 10000"
                                value="{{ old('min_transaction') }}">
                            @error('min_transaction')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="promoVoucherQuota" class="col-sm-3 col-form-label pb-0">
                            <p class="fw-600 m-0">
                                Kuota Promo
                            </p>
                            <p class="text-grey fs-12 m-0">
                                *batas pemakaian promo
                            </p>
                        </label>
                        <div class="col-sm-9">
                            <input required type="number" class="form-control fs-14 @error('quota') is-invalid @enderror"
                                id="promoVoucherQuota" name="quota"
                                placeholder="Masukkan batas pemakaian promo voucher, contoh: 5"
                                value="{{ old('quota') }}">
                            @error('quota')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="promoVoucherDescription" class="col-sm-3 col-form-label pb-0">
                            <p class="fw-600 m-0">
                                Deskripsi Promo
                            </p>
                            <p class="text-grey fs-12 m-0">
                                *Deskripsi / Syarat dan ketentuan promo
                            </p>
                        </label>
                        <div class="col-sm-9">
                            <input id="promoVoucherDescription" type="hidden" name="description"
                                value="{{ old('description') }}">
                            <trix-editor input="promoVoucherDescription"></trix-editor>
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container product-activation-container p-0 mb-4">
            <div class="card product-activation-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Metode Pembayaran</h5>
                        <p class="text-grey fs-13 m-0">Metode pembayaran yang dapat digunakan pada promo</p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    @foreach ($paymentMethods as $paymentMethod)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $paymentMethod->id }}"
                                id="paymentMethod-{{ $paymentMethod->id }}" name="paymentMethod[]">
                            <label class="form-check-label" for="paymentMethod-{{ $paymentMethod->id }}">
                                <div class="row align-items-center">
                                    @if (!empty($paymentMethod->logo))
                                        <div class="col-md-1 col-2 pe-0">
                                            <img class="w-100" src=" {{ asset($paymentMethod->logo) }}" alt="">
                                        </div>
                                        <div class="col-md-11 col-10">
                                            {{ $paymentMethod->type }}
                                            {{ $paymentMethod->name }}
                                        </div>
                                    @else
                                        <div class="col-12">
                                            {{ $paymentMethod->type }}
                                            {{ $paymentMethod->name }}
                                        </div>
                                    @endif
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="container product-activation-container p-0 mb-4">
            <div class="card product-activation-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Status Promo</h5>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-3 row">
                        <label for="promoVoucherStatus" class="col-sm-3 col-form-label">
                            <p class="fw-600 m-0">
                                Status Promo
                            </p>
                            <p class="text-grey fs-12 m-0">
                                Jika status promo Aktif maka pembeli dapat melihat promo ini
                            </p>
                        </label>
                        <div class="col-sm-9 py-1">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="promoVoucherStatus"
                                    checked name="is_active" value="1">
                                <label class="form-check-label" for="promoVoucherStatus">
                                    <div class="promoVoucher-status">
                                        Aktif
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container promo-product-container p-0 mb-4">
            <div class="card promo-product-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Produk Promo</h5>
                        <p class="text-grey fs-13 m-0">Pilih produk yang dapat menggunakan promo ini</p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-3 row">
                        <label for="promoVoucherProducts" class="col-sm-3 col-form-label">
                            <p class="fw-600 m-0">
                                Pilih Produk
                            </p>
                        </label>
                        <div class="col-sm-9 py-1">
                            <div class="mb-2">
                                <select id="promoVoucherProducts"
                                    class="form-control shadow-none promo-voucher-product form-select shadow-none @error('product_promos') is-invalid @enderror"
                                    name="product_promos[]" {{-- multiple="multiple"  --}} required>
                                    {{-- <option value="">Pilih produk</option> --}}
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }}</option>
                                    @endforeach
                                </select>
                                @error('product_promos')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="check_product_input d-none">
                                <input class="form-check-input" type="checkbox" value="all"
                                    id="chechkbox_product_promos" name="all_product_promos">
                                <label class="form-check-label" for="chechkbox_product_promos">Pilih
                                    semua</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container p-0 mb-4">
            <div class="card promo-Voucher-image-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 pb-0 border-0">
                    <div class="header">
                        <h5 class="m-0">Foto Promo</h5>
                    </div>
                </div>
                <div class="card-body p-4 pt-2 create-promo-Voucher-image">
                    <div class="row pt-1">
                        <label for="" class="col-md-3 col-6 col-form-label promo-Voucher-image-label">
                            <p class="fw-600 m-0">
                                Tambahkan Foto Promo
                            </p>
                            <p class="text-grey fs-12 m-0">Format Gambar (.jpg, .jpeg, .png), ukuran maksimal 2MB,
                                Cantumkan
                            </p>
                        </label>
                        <div class="col-md-9 col-6">
                            <div class="row mb-3">
                                <div class="col-md-12 col-12">
                                    <input required type="hidden" name="admin_id"
                                        value="{{ auth()->guard('adminMiddle')->user()->id }}">
                                    <input class="form-control form-control-sm promo-Voucher-image-class mb-3"
                                        id="promoVoucherImage_0" type="file" name="promoVoucherImage">
                                    <input required type="hidden" id="promoVoucherImageUpload_0"
                                        class="promoVoucherImageUpload_0" name="promoVoucherImageUpload">
                                    {{-- <input required class="form-control form-control-sm promo-Voucher-image-class" id="promoVoucherImageTemp_0"
                                        type="file" name="promoVoucherImageTemp"> --}}
                                    <div id="imageSource_0"></div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <img class="img-preview-0 img-fluid">
                                    <div class="show-before-upload-0"></div>
                                </div>
                            </div>
                            <div id="new_promoVoucher_img"></div>
                            <input required type="hidden" value="0" id="total_promoVoucher_img">
                        </div>
                    </div>
                    <div class="col-sm-5">
                        {{-- <img class="img-fluid mt-3" id="img-preview" src="" alt="" style="max-width: 800px; max-height: 400px;"> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="container p-0 mb-5 pb-5">
            <div class="row">
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-danger fs-14  ">
                        <i class="bi bi-plus-lg"></i> Tambahkan Promo
                    </button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="upload-promoVoucher-img-modal" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="previewImgUserModal" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content border-radius-1-5rem">
                    <div class="modal-header p-4 border-0">
                        <h5 class="modal-title" id="previewImgUserModal">Upload Foto Promo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <!--  default image where we will set the src via jquery-->
                                    <img id="image-on-modal" class="img-user">
                                </div>
                                <div class="col-md-4">
                                    <div class="preview-img-user"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-4 border-0">
                        <button type="button" class="btn btn-secondary fs-14" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger fs-14"
                            id="upload-promo-Voucher-image">Tambahkan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        // promoVoucherStartPeriod.min = '2022-09-07T15:06';
        // promoVoucherEndPeriod.min = new Date().toISOString();

        var maxLength = function() {
            var demos = function() {
                $('#kt_maxlength_3').maxlength({
                    alwaysShow: true,
                    threshold: 5,
                    warningClass: "label label-danger label-rounded label-inline",
                    limitReachedClass: "label label-primary label-rounded label-inline"
                });
            }
            return {
                // public functions
                init: function() {
                    demos();
                }
            };
        }();

        function previewImage(img, imgPreview) {
            // mengambil sumber image dari input required dengan id image
            const image = document.querySelector(img);
            console.log(img);
            // mengambil tag img dari class img-preview
            const imagePreview = document.querySelector(imgPreview);

            // mengubah style tampilan image menjadi block
            imagePreview.style.display = 'block';

            // perintah untuk mengambil data gambar
            const oFReader = new FileReader();
            // mengambil dari const image
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(OFREvent) {
                imagePreview.src = OFREvent.target.result;
            }
        }

        function onlyLettersAndNumbers(code) {
            return /^(?=.*[0-9])(?=.*[A-Z])([A-Z0-9]+)$/.test(code);
        }

        $(window).on('load', function() {
            console.log($('meta[name="csrf-token"]').attr('content'));
            console.log($('#promoVoucherStatus').prop("checked"));
            if ($('#promoVoucherStatus').prop("checked") == true) {
                $('.promoVoucher-status').text('Aktif');
                $('input[name="is_active"]').val(1);
            } else {
                $('.promoVoucher-status').text('Tidak Aktif');
                $('input[name="is_active"]').val(0);
            }
        });

        $(document).ready(function() {
            $('select[name="promo_type_id"]').on('change', function() {
                console.log('asdasd');
                selectedPromoTypeId = $('select[name="promo_type_id"]').find(":selected").val();
                if (selectedPromoTypeId == 3 || selectedPromoTypeId == 4) {
                    console.log($('select[name="promo_type_id"]').find(":selected").val());
                    $('#chechkbox_product_promos').prop("checked", true);
                    // $('#chechkbox_product_promos').prop("disabled", true);
                    $('.promo-voucher-product').attr("disabled", true);
                    if (!$(".promo-product-container").hasClass("d-none")) {
                        $(".promo-product-container").addClass("d-none");
                    }
                } else {
                    $('#chechkbox_product_promos').prop("checked", false);
                    // $('#chechkbox_product_promos').prop("disabled", false);
                    $('.promo-voucher-product').attr("disabled", false);
                    if ($(".promo-product-container").hasClass("d-none")) {
                        $(".promo-product-container").removeClass("d-none");
                    }
                }
            });
            const promo_name = document.querySelector('#promoVoucherName');
            const promo_slug = document.querySelector('#promoVoucherSlug');
            promo_name.addEventListener('change', function() {
                fetch('/administrator/promovoucher/checkSlug?name=' + promo_name.value)
                    .then(response => response.json())
                    .then(data => promo_slug.value = data.slug);
            });

            function promoCodeCheck(csrfToken, codeCheck) {
                $.ajax({
                    url: "{{ url('/administrator/promovoucher/promocodecheck') }}",
                    type: 'post',
                    data: {
                        _token: csrfToken,
                        code: codeCheck,
                    },
                    success: function(response) {
                        console.log(response['result']);
                        if (response.result) {
                            console.log(true);
                            $('.promo-voucher-code-span-code-check').text(
                                '| Kode promo sudah digunakan sebelumnya!');
                            $('.promo-voucher-code-span-code-check').addClass('text-danger');
                            $('input[name="code"]').addClass('is-invalid');
                        } else {
                            console.log(false);
                            if ($('input[name="code"]').hasClass('is-invalid')) {
                                $('input[name="code"]').removeClass('is-invalid');
                            }
                            $('.promo-voucher-code-span-code-check').empty();
                        }
                        // $('.alert-notification-wrapper').append(
                        //     '<div class="alert alert-success alert-dismissible fade show alert-notification-adminproduct" id="alert-notification-adminproduct" role="alert">Berhasil memperbarui status produk<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                        // );

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // $('.alert-notification-wrapper').append(
                        //     '<div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">Gagal memperbarui status produk. (' +
                        //     jqXHR.status + ' ' + errorThrown +
                        //     ')<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                        // );
                    },
                    dataType: "json",

                });
                $(document).ajaxStop(function() {
                    $(".alert-notification-adminproduct").fadeTo(5000, 1000).fadeOut(1000,
                        function() {
                            $(".alert-notification-adminproduct").fadeOut(5000);
                            $(this).remove();
                        });
                });
            }

            $(document).on('change', '[name="all_product_promos"]', function() {
                if ($(this).prop("checked") == true) {
                    $('.promo-voucher-product').attr("disabled", true);
                    $('.promo-voucher-product').val("");
                    $('.promo-voucher-product').trigger("change");
                } else {
                    $('.promo-voucher-product').removeAttr("disabled");
                }
            });

            (function($) {
                $.fn.inputFilter = function(callback, errMsg) {
                    return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout",
                        function(e) {
                            if (callback(this.value)) {
                                // Accepted value
                                if (["keydown", "mousedown", "focusout"].indexOf(e.type) >= 0) {
                                    $(this).removeClass("input-error");
                                    this.setCustomValidity("");
                                }
                                this.oldValue = this.value;
                                this.oldSelectionStart = this.selectionStart;
                                this.oldSelectionEnd = this.selectionEnd;
                            } else if (this.hasOwnProperty("oldValue")) {
                                // Rejected value - restore the previous one
                                $(this).addClass("input-error");
                                this.setCustomValidity(errMsg);
                                this.reportValidity();
                                this.value = this.oldValue;
                                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                            } else {
                                // Rejected value - nothing to restore
                                this.value = "";
                            }
                        });
                };
            }(jQuery));

            $('input[name="code"]').on('keyup', function() {
                var maxLength = ($(this).attr('maxlength'));
                var inputLength = $(this).val().length;
                $('.promo-voucher-code-span-maxlength').text('(' + inputLength + '/' + maxLength + ')');
                console.log($(this).val());
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                promoCodeCheck(csrf_token, $(this).val());
                var check = onlyLettersAndNumbers($(this).val());
                if (check) {
                    console.log(check);
                    if ($(this).hasClass('is-invalid')) {
                        $(this).removeClass('is-invalid');
                    }
                    $('.promo-voucher-code-span-notif').empty();

                } else {
                    console.log(check);
                    $('.promo-voucher-code-span-notif').text(
                        'Hanya boleh diisi dengan Huruf kapital A-Z dan angka 0-9');
                    $('.promo-voucher-code-span-notif').addClass('text-danger');
                    $(this).addClass('is-invalid');
                }
            });
            // $('input[name="code"]').inputFilter(function(value) {
            //     return /^[a-zA-Z0-9]*$/.test(value);
            // }, "Harus Terdiri dari huruf dan angka");

            // $('input[name="code"]').on('change', function() {
            //     var check = onlyLettersAndNumbers($(this).val());
            //     if (check) {
            //         console.log(check);
            //         if ($(this).hasClass('is-invalid')) {
            //             $(this).removeClass('is-invalid');
            //             $('.promo-voucher-code-span-notif').text('');
            //         }

            //     } else {
            //         console.log(check);
            //         $('.promo-voucher-code-span-notif').text(
            //             'Hanya boleh diisi dengan Huruf kapital A-Z dan angka 0-9');
            //         $('.promo-voucher-code-span-notif').addClass('text-danger');
            //         $(this).addClass('is-invalid');
            //     }
            // });

            $('#promoVoucherStatus').on('change.bootstrapSwitch', function(e) {
                console.log(e.target.checked);
            });

            $("#promoVoucherStatus").add().on('change', function() {
                if ($(this).prop("checked") == true) {
                    $('.promoVoucher-status').text('Aktif');
                    $('input[name="is_active"]').val(1);
                } else {
                    $('.promoVoucher-status').text('Tidak Aktif');
                    $('input[name="is_active"]').val(0);
                }
            });

            var $modal = $('#upload-promoVoucher-img-modal');
            // console.log($modal);
            var image = document.getElementById('image-on-modal');
            console.log(image);
            var cropper;
            $("body").on("change", ".promo-Voucher-image-class", function(e) {
                console.log(e);
                var files = e.target.files;
                console.log(files);
                var targetId = e.currentTarget.id;
                window.imageId = targetId.replace(/[^\d.]/g, '');

                var clone = $(this).clone();
                clone.attr("name", "promoVoucherImageTemp").attr("id",
                    "promoVoucherImageTemp_" +
                    imageId).addClass('d-none');
                $('#imageSource_' + imageId).html(clone);

                console.log(imageId);

                if (files.length == 0) {
                    console.log('undefined');
                    $('.img-preview-' + imageId).attr("src", "");
                    $('.show-before-upload-' + imageId).html("");
                    $('#imageSource_' + imageId).html("");
                    $('#promoVoucherImageUpload_' + imageId).val("");
                }
                var done = function(url) {
                    console.log(url);
                    image.src = url;
                    console.log(files[0]['name']);
                    $modal.modal('show');
                };
                if (files.length != 0) {
                    var reader;
                    var file;
                    var url;
                    var filePath = files[0]['name'];
                    var fileSize = files[0].size;
                    console.log(files[0].size);
                }
                // Allowing file type

                var allowedExtensions =
                    /(\.jpg|\.jpeg|\.png)$/i;
                var allowedSize = 2100000;

                if (!allowedExtensions.exec(filePath)) {
                    alert('Format file tidak sesuai! Gunakan gambar dengan format (.jpg, .jpeg, .png)');
                    $('input[name="promoVoucherImage[' + imageId + ']"]').val('');
                    return false;
                }
                if (fileSize > allowedSize) {
                    alert('Ukuran foto maksimal 2MB');
                    $('input[name="promoVoucherImage[' + imageId + ']"]').val('');
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

            });
            $("body").on("click", ".preview-promo-Voucher-image-button", function(e) {
                console.log(e.target.id);
                var targetId = e.currentTarget.id;
                window.imageId = targetId.replace(/[^\d.]/g, '');

                console.log(imageId);
                console.log(document.getElementById('promoVoucherImageTemp_' + imageId).files);
                var files = document.getElementById('promoVoucherImageTemp_' + imageId).files;

                if (files.length == 0) {
                    console.log('undefined');
                    $('.img-preview-' + imageId).attr("src", "");
                    $('.show-before-upload-' + imageId).html("");
                    $('#imageSource_' + imageId).html("");
                    $('#promoVoucherImageUpload_' + imageId).val("");
                }
                var done = function(url) {
                    console.log(url);
                    image.src = url;
                    console.log(files[0]['name']);
                    $modal.modal('show');
                };
                if (files.length != 0) {
                    var reader;
                    var file;
                    var url;
                    var filePath = files[0]['name'];
                    var fileSize = files[0].size;
                    console.log(files[0].size);
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
            });

            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1 / 1,
                    viewMode: 3,
                    preview: '.preview-img-user'
                });
            }).on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
            });
            $("#upload-promo-Voucher-image").click(function() {
                console.log('upload-promo-Voucher-image clicked');
                canvas = cropper.getCroppedCanvas({
                    width: 1200,
                    height: 600,
                });
                canvas.toBlob(function(blob) {
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        var base64data = reader.result;
                        var admin_id = $('input[name="admin_id"]').val();
                        console.log($('meta[name="csrf-token"]').attr('content'));
                        console.log(base64data);
                        $('.img-preview-' + imageId).attr('src', base64data);
                        console.log(admin_id);
                        $('.show-before-upload-' + imageId).html(
                            ' <button type="button" class="fs-14 btn btn-danger preview-promo-Voucher-image-button mt-3" data-bs-toggle="modal" id="preview-modal-promo-Voucher-image-' +
                            imageId +
                            '" data-bs-target="#upload-promoVoucher-img-modal">Lihat Foto </button>'
                        );
                        $('.promoVoucherImageUpload_' + imageId).val(base64data);
                        $modal.modal('toggle');
                    }
                });
            });

        });
        
    </script>
@endsection
