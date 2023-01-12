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
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">
            <p><strong>Gagal Menyelesaikan transaksi</strong></p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h5 class="mb-4">
        Penilaian Produk
    </h5>
    <div class="card mb-3 border-radius-075rem fs-14">
        <div class="card-body p-4">
            <form class="add-rating-form" action="{{ route('rating.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="" value="{{ $orderItem->id }}">
                <input type="hidden" name="user_id" id="" value="{{ $orderItem->user_id }}">
                <input type="hidden" name="product_id" id="" value="{{ $orderItem->product_id }}">
                <input type="hidden" name="product_variant_id" id="" value="{{ $orderItem->product_variant_id }}">
                <input type="hidden" name="order_id" id="" value="{{ $orderItem->order_id }}">
                <input type="hidden" name="comment_date" id="" value="{{ date('Y-m-d') }}">
                <div class="card mb-4 border-radius-075rem box-shadow">
                    <div class="card-body p-4">
                        <div class="mb-2 fs-13">
                            <span class="">No Invoice:
                            </span>
                            <span class="fw-600">
                                {{ $orderItem->order->invoice_no }}
                            </span>
                        </div>
                        <div class="row d-flex align-items-center">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-md-2 col-4 text-end">
                                        @if (!is_null($orderItem->orderproduct->orderproductimage->first()))
                                            {{-- {{ $orderItem->orderproduct->orderproductimage->first()->name }} --}}
                                            <img src="{{ asset('/storage/' . $orderItem->orderproduct->orderproductimage->first()->name) }}"
                                                class="w-100 border-radius-5px" alt="">
                                        @endif
                                    </div>
                                    <div class="col-md-10 col-8 ps-0">
                                        <div class="order-items-product-info text-start">
                                            <div class="text-truncate order-items-product-name">
                                                {{ $orderItem->orderproduct->name }}
                                            </div>
                                            <div class="text-truncate order-items-product-variant text-grey fs-13">
                                                Varian:
                                                {{ !is_null($orderItem->orderproduct->variant_name) ? $orderItem->orderproduct->variant_name : 'Tidak ada Varian' }}
                                            </div>
                                            <div class="text-truncate text-grey text-start fs-13">
                                                Jumlah:
                                                {{ $orderItem->quantity }} item
                                                {{-- {{ $orderItem->quantity }} x Rp{{ price_format_rupiah($orderItem->price) }} --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 border-radius-075rem box-shadow">
                    <div class="card-body p-4">
                        <p class="mb-3 fs-14 fw-bold">Beri Nilai Produk</p>
                        <p class="mb-3 fs-14">Beri Bintang Produk</p>
                        <div class="rating-css">
                            <div class="star-icon">
                                <input type="radio" value="1" name="star" checked id="rating1">
                                <label for="rating1" class="bi bi-star-fill"></label>
                                <input type="radio" value="2" name="star" id="rating2">
                                <label for="rating2" class="bi bi-star-fill"></label>
                                <input type="radio" value="3" name="star" id="rating3">
                                <label for="rating3" class="bi bi-star-fill"></label>
                                <input type="radio" value="4" name="star" id="rating4">
                                <label for="rating4" class="bi bi-star-fill"></label>
                                <input type="radio" value="5" name="star" id="rating5">
                                <label for="rating5" class="bi bi-star-fill"></label>
                            </div>
                        </div>
                        <div class="my-3 fs-14">
                            <label for="commentTextArea" class="form-label">Tambahkan Komentar</label>
                            <textarea class="form-control fs-14" id="commentTextArea" rows="6" name="comment"></textarea>
                        </div>
                        <div class="my-3 fs-14">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="d-flex align-items-start flex-column">
                                        <label for="commentImage" class="form-label">Tambahkan Foto</label>
                                        <div class="d-flex">
                                            <div class="btn user-account-profile-img-btn btn-secondary">
                                                <i class="bi bi-camera"></i> Pilih Foto
                                                <input class="add-file-photo" type="file" name="comment_image"
                                                    id="commentImage">
                                            </div>
                                            <div class="del-img"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <img class="img-preview w-100">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-danger fs-14 submit-button">
                            <i class="bi bi-send"></i> Kirim
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function previewImageComment() {
            // mengambil sumber image dari input dengan id image
            const image = document.querySelector('#commentImage');

            // mengambil tag img dari class img-preview
            const imgPreview = document.querySelector('.img-preview');

            // mengubah style tampilan image menjadi block
            imgPreview.style.display = 'block';

            // perintah untuk mengambil data gambar
            const oFReader = new FileReader();
            // mengambil dari const image
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(OFREvent) {
                imgPreview.src = OFREvent.target.result;
            }
        }
        $(document).ready(function() {
            $('.add-file-photo').on('change', function(e) {
                var files = e.target.files;
                var done = function(url) {
                    image.src = url;
                    console.log(files[0]['name']);
                    $modal.modal('show');
                };
                console.log(files['length']);
                if (files['length']) {
                    var reader;
                    var file;
                    var url;
                    var filePath = files[0]['name'];
                    var fileSize = files[0].size;
                    console.log(files[0].size);

                    var allowedExtensions =
                        /(\.jpg|\.jpeg|\.png)$/i;
                    var allowedSize = 2100000;

                    if (!allowedExtensions.exec(filePath)) {
                        alert('Format file tidak sesuai! Gunakan gambar dengan format (.jpg, .jpeg, .png)');
                        return false;
                    } else if (fileSize > allowedSize) {
                        alert('Ukuran foto maksimal 2MB');
                        return false;
                    } else if (files && files.length > 0) {
                        previewImageComment();
                    }
                    console.log($('.img-preview'));
                    $('.del-img').html(
                        '<button type="button" class="btn btn-danger fs-14 mx-2 delete-rating-image"><i class="bi bi-trash3"></i> Hapus Foto</button>'
                        );
                } else {
                    $('.img-preview').removeAttr('src');
                    console.log($('.img-preview'));
                }
                // Allowing file type
            });

            $('body').on('click','.delete-rating-image', function() {
                console.log('delete-rating-image on click');
                $('.img-preview').removeAttr('src');
                $('.add-file-photo').val('');
                $(this).remove();
            });

            $('.add-rating-form').submit(function(e) {
                console.log(e);
                $('.submit-button').append(
                    '<span class="ms-2 spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                );
                $('.submit-button').attr('disabled', true);

                // e.preventDefault();
            });
        });
    </script>
@endsection
