@extends('admin.layouts.main')
@section('container')
    {{-- {{ print_r(session()->all()) }} --}}
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
    <h5 class="mb-4">
        <a href="{{ route('promovoucher.index') }}" class="text-decoration-none link-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        Ubah Promo Banner
    </h5>
    <form action="{{ route('promobanner.update', $promoBanner) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="container p-0 mb-4">
            <div class="card promo-banner-image-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 pb-0 border-0">
                    <div class="header">
                        <h5 class="m-0">Foto Promo</h5>
                    </div>
                </div>
                <div class="card-body p-4 pt-2 create-promo-banner-image">
                    <div class="row pt-1">
                        <label for="" class="col-md-3 col-6 col-form-label promo-banner-image-label">
                            <p class="fw-600 m-0">
                                Ubah Foto Promo
                            </p>
                            <p class="text-grey fs-12 m-0">Format Gambar (.jpg, .jpeg, .png), ukuran maksimal 2MB
                            </p>
                        </label>
                        <div class="col-md-9 col-6">
                            <div class="row mb-3">
                                <div class="col-md-12 col-12">
                                    <input required type="hidden" name="admin_id" value="{{ auth()->guard('adminMiddle')->user()->id }}">
                                    <input class="form-control form-control-sm promo-banner-image-class mb-3" id="promoBannerImage" type="file" name="promoBannerImage">
                                    <input required type="hidden" id="promoBannerImageUpload" class="promoBannerImageUpload" name="promoBannerImageUpload">
                                    {{-- <input required class="form-control form-control-sm promo-banner-image-class" id="promoBannerImageTemp"
                                        type="file" name="promoBannerImageTemp"> --}}
                                    <div id="imageSource"></div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <img class="img-preview img-fluid">
                                    <div class="show-before-upload"></div>
                                </div>
                            </div>
                            <div id="new_promoBanner_img"></div>
                            <input required type="hidden" value="0" id="total_promoBanner_img">
                        </div>
                    </div>
                    <div class="row pt-1">
                        <div class="col-md-3 col-12">
                            <p class="fs-14 fw-600 mb-2">
                                Diupload
                            </p>
                            <img class="w-100" src="{{ asset($promoBanner->image) }}" alt="">
                        </div>
                    </div>
                    <div class="col-sm-5">
                        {{-- <img class="img-fluid mt-3" id="img-preview" src="" alt="" style="max-width: 800px; max-height: 400px;"> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="container p-0 mb-4">
            <div class="card promoBanner-info-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Informasi Promo</h5>
                        <p class="text-grey fs-13 m-0">Isikan nama, ID, kategori, dan merk Promo</p>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-3 row">
                        <label for="promoBannerName" class="col-sm-3 col-form-label fw-600">Nama Promo</label>
                        <div class="col-sm-9">
                            <input required type="text" class="form-control fs-14 @error('name') is-invalid @enderror"
                                id="promoBannerName" name="name" placeholder="Ketikkan nama Promo"
                                value="{{ !is_null($promoBanner->name) ? (!is_null(old('name')) ? old('name') : $promoBanner->name) : (!is_null(old('name')) ? old('name') : $promoBanner->name) }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label for="promoBannerStartPeriod" class="col-sm-3 col-form-label fw-600">Tanggal/Jam mulai Promo</label>
                        <div class="col-sm-9">
                            <input required type="datetime-local" class="form-control fs-14 @error('start_period') is-invalid @enderror"
                                id="promoBannerStartPeriod" name="start_period" placeholder="Ketikkan nama Promo"
                                value="{{ !is_null($promoBanner->start_period) ? (!is_null(old('start_period')) ? old('start_period') : $promoBanner->start_period) : (!is_null(old('start_period')) ? old('start_period') : $promoBanner->start_period) }}">
                            @error('start_period')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="promoBannerEndPeriod" class="col-sm-3 col-form-label fw-600">Tanggal/Jam akhir Promo</label>
                        <div class="col-sm-9">
                            <input required type="datetime-local" class="form-control fs-14 @error('end_period') is-invalid @enderror"
                                id="promoBannerEndPeriod" name="end_period" placeholder="Ketikkan nama Promo"
                                value="{{ !is_null($promoBanner->end_period) ? (!is_null(old('end_period')) ? old('end_period') : $promoBanner->end_period) : (!is_null(old('end_period')) ? old('end_period') : $promoBanner->end_period) }}">
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

        <div class="container product-activation-container p-0 mb-4">
            <div class="card product-activation-card border-0 border-radius-1-5rem fs-14">
                <div class="card-header bg-transparent p-4 border-0">
                    <div class="header">
                        <h5 class="m-0">Status Promo</h5>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    {{-- <form action="{{ route('adminproduct.store') }}" method="post" enctype="multipart/form-data">
                        @csrf --}}
                    <div class="mb-3 row">
                        <label for="promoBannerStatus" class="col-sm-3 col-form-label">
                            <p class="fw-600 m-0">
                                Status Promo
                            </p>
                            <p class="text-grey fs-12 m-0">
                                Jika status promo Aktif maka pembeli dapat melihat promo ini
                            </p>
                        </label>
                        <div class="col-sm-9 py-1">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="promoBannerStatus"
                                    {{ ($promoBanner->is_active) ? 'checked' : '' }} name="is_active" value="1">
                                <label class="form-check-label" for="promoBannerStatus">
                                    <div class="promoBanner-status">
                                        Aktif
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- <button type="submit">Submit</button> --}}
                    {{-- </form> --}}
                </div>
            </div>
        </div>

        @if (auth()->guard('adminMiddle')->user()->admin_type == 1)
            <div class="container product-company-container p-0 mb-4">
                <div class="card product-company-card border-0 border-radius-1-5rem fs-14">
                    <div class="card-header bg-transparent p-4 border-0">
                        <div class="header">
                            <h5 class="m-0">Perusahaan</h5>
                            <p class="text-grey fs-13 m-0">Pilih perusahaan dimana produk akan ditampilkan</p>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="mb-3 row">
                            <label for="productCompany" class="col-sm-3 col-form-label fw-600">Perusahaan</label>
                            <div class="col-sm-9">
                                <select required
                                    class="form-control shadow-none admin-product-company form-select shadow-none fs-14 @error('company_id') is-invalid @enderror"
                                    name="company_id" required>
                                    <option value="" class="fs-14">Pilih Perusahaan
                                    </option>
                                    @foreach ($companies as $company)
                                        <option class="fs-14" value="{{ $company->id }}" {{ $promoBanner->company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <input type="hidden" name="company_id" value="{{ auth()->guard('adminMiddle')->user()->company_id }}">
        @endif

        <div class="container p-0 mb-5 pb-5">
            <div class="row">
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-danger fs-14  ">
                        <i class="far fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="upload-promoBanner-img-modal" data-bs-backdrop="static" data-bs-keyboard="false"
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
                            id="upload-promo-banner-image">Tambahkan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        // promoBannerStartPeriod.min = '2022-09-07T15:06';
        // promoBannerEndPeriod.min = new Date().toISOString();


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

        function handleData() {
            console.log('onsubmit');
            var form_data = new FormData(document.querySelector("form"));
            console.log(form_data);
            if (!form_data.has("langs[]")) {
                document.getElementById("chk_option_error").style.visibility = "visible";
                return false;
            } else {
                document.getElementById("chk_option_error").style.visibility = "hidden";
                return true;
            }

        }

        function handleData() {
            var form_data = new FormData(document.querySelector("form"));

            if (!form_data.has("langs[]")) {
                document.getElementById("chk_option_error").style.visibility = "visible";
            } else {
                document.getElementById("chk_option_error").style.visibility = "hidden";
            }
            return false;
        }

        $(window).on('load', function() {
            console.log($('#promoBannerStatus').prop("checked"));
            if ($('#promoBannerStatus').prop("checked") == true) {
                $('.promoBanner-status').text('Aktif');
                $('input[name="is_active"]').val(1);
            } else {
                $('.promoBanner-status').text('Tidak Aktif');
                $('input[name="is_active"]').val(0);
            }
        });

        $(document).ready(function() {
            // console.log(sender);
            // $.each(sender, function(key, value) {
            //     console.log(value['id']);
            //     console.log(value['name']);
            //     console.log(value['address']);
            //     console.log(value['city']['name']);
            //     console.log(value['province']['name']);
            //     console.log(value['postal_code']);
            //     console.log(value['telp_no']);
            // });

            $('#promoBannerStatus').on('change.bootstrapSwitch', function(e) {
                console.log(e.target.checked);
            });

            $("#promoBannerStatus").add().on('change', function() {
                if ($(this).prop("checked") == true) {
                    $('.promoBanner-status').text('Aktif');
                    $('input[name="is_active"]').val(1);
                } else {
                    $('.promoBanner-status').text('Tidak Aktif');
                    $('input[name="is_active"]').val(0);
                }
            });

            // const variant_name = document.querySelector('#variantName');
            // const variant_slug = document.querySelector('#variantSlug');
            // console.log(variant_name.value);
            // variant_name.addEventListener('change', function() {
            //     fetch('/administrator/adminpromoBanner/checkSlug?name=' + variant_name.value)
            //         .then(response => response.json())
            //         .then(data => variant_slug.value = data.slug);
            // })

            var $modal = $('#upload-promoBanner-img-modal');
            // console.log($modal);
            var image = document.getElementById('image-on-modal');
            console.log(image);
            var cropper;
            $("body").on("change", ".promo-banner-image-class", function(e) {
                console.log(e);
                var files = e.target.files;
                console.log(files);
                var targetId = e.currentTarget.id;
                window.imageId = targetId.replace(/[^\d.]/g, '');

                var clone = $(this).clone();
                clone.attr("name", "promoBannerImageTemp").attr("id",
                    "promoBannerImageTemp").addClass('d-none');
                $('#imageSource_' + imageId).html(clone);

                console.log(imageId);

                if (files.length == 0) {
                    console.log('undefined');
                    $('.img-preview-' + imageId).attr("src", "");
                    $('.show-before-upload-' + imageId).html("");
                    $('#imageSource_' + imageId).html("");
                    $('#promoBannerImageUpload_' + imageId).val("");
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
                    $('input[name="promoBannerImage"]').val('');
                    return false;
                }
                if (fileSize > allowedSize) {
                    alert('Ukuran foto maksimal 2MB');
                    $('input[name="promoBannerImage"]').val('');
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
            $("body").on("click", ".preview-promo-banner-image-button", function(e) {
                console.log(e.target.id);
                var targetId = e.currentTarget.id;
                window.imageId = targetId.replace(/[^\d.]/g, '');

                console.log(imageId);
                console.log(document.getElementById('promoBannerImageTemp_' + imageId).files);
                var files = document.getElementById('promoBannerImageTemp_' + imageId).files;

                // var files = e.target.files;
                // var targetId = e.currentTarget.id;
                // window.imageId = targetId.replace(/[^\d.]/g, '');

                // var clone = $(this).clone();
                // clone.attr("name","promoBannerImageTemp["+0+"]").addClass('d-none');
                // $('#imageSource').html(clone);

                // console.log(imageId);
                if (files.length == 0) {
                    console.log('undefined');
                    $('.img-preview').attr("src", "");
                    $('.show-before-upload').html("");
                    $('#imageSource').html("");
                    $('#promoBannerImageUpload').val("");
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
                    aspectRatio: 2 / 1,
                    viewMode: 3,
                    preview: '.preview-img-user'
                });
            }).on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
            });
            $("#upload-promo-banner-image").click(function() {
                console.log('upload-promo-banner-image clicked');
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
                        $('.img-preview').attr('src', base64data);
                        console.log(admin_id);
                        $('.show-before-upload').html(
                            ' <button type="button" class="fs-14 btn btn-outline-danger mt-3" id="delete-preview-promo-banner-image"><i class="bi bi-trash3"></i> Hapus Foto </button>' + 
                            '<button type="button" class="mx-1 fs-14 btn btn-danger preview-promo-banner-image-button mt-3" data-bs-toggle="modal" id="preview-modal-promo-banner-image-' +
                            imageId +
                            '" data-bs-target="#upload-promoBanner-img-modal">Lihat Foto </button>'
                        );
                        $('.promoBannerImageUpload').val(base64data);
                        $modal.modal('toggle');
                        // $.ajax({
                        //     type: "POST",
                        //     dataType: "json",
                        //     url: "profile-image-upload",
                        //     data: {
                        //         'admin_id': admin_id,
                        //         '_token': $('meta[name="csrf-token"]').attr('content'),
                        //         'profile_image': base64data
                        //     },
                        //     success: function(data) {
                        //         console.log(data);
                        //         $modal.modal('hide');
                        //         alert(data['success']);
                        //         window.location.reload();
                        //     }
                        // });
                    }
                });
            });
            $("body").on("click", "#delete-preview-promo-banner-image", function(e) {
                $('input[name="promoBannerImage"]').val('');
                console.log($('input[name="promoBannerImage"]').val());
                $('.show-before-upload').html('');
                $('.img-preview').attr('src','');
            });
        });
    </script>
@endsection
