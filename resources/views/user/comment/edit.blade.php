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
            <form class="edit-comment-form" action="{{ route('comment.update',$comment) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <input type="hidden" name="id" id="" value="{{ $comment->id }}">
                <input type="hidden" name="user_id" id="" value="{{ $comment->user_id }}">
                <input type="hidden" name="product_id" id="" value="{{ $comment->product_id }}">
                <input type="hidden" name="product_variant_id" id="" value="{{ $comment->product_variant_id }}">
                <input type="hidden" name="order_id" id="" value="{{ $comment->order_id }}">
                <input type="hidden" name="comment_date" id="" value="{{ date('Y-m-d') }}">
                <div class="card mb-4 border-radius-075rem box-shadow">
                    <div class="card-body p-4">
                        <div class="mb-2 fs-13">
                            <span class="">No Invoice:
                            </span>
                            <span class="fw-600">
                                {{ $comment->order->invoice_no }}
                            </span>
                        </div>
                        <div class="row d-flex align-items-center">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-md-2 col-4 text-end">
                                        @if (!is_null($comment->product->productimage->first()))
                                            {{-- {{ $comment->product->productimage->first()->name }} --}}
                                            <img src="{{ asset('/storage/' . $comment->product->productimage->first()->name) }}"
                                                class="w-100 border-radius-5px" alt="">
                                        @endif
                                    </div>
                                    <div class="col-md-10 col-8 ps-0">
                                        <div class="order-items-product-info text-start">
                                            <div class="text-truncate order-items-product-name">
                                                {{ $comment->product->name }}
                                            </div>
                                            <div class="text-truncate order-items-product-variant text-grey fs-13">
                                                Varian:
                                                {{ !is_null($comment->product->variant_name) ? $comment->product->variant_name : 'Tidak ada Varian' }}
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
                        {{-- <p class="mb-3 fs-14 fw-bold">Beri Nilai Produk</p> --}}
                        <p class="mb-3 fs-14 fw-600">Beri Bintang Produk</p>
                        <div class="rating-css">
                            <div class="star-icon">
                                <input type="radio" value="1" name="star" id="rating1"
                                    {{ $comment->star == 1 ? 'checked' : '' }}>
                                <label for="rating1" class="bi bi-star-fill"></label>
                                <input type="radio" value="2" name="star" id="rating2"
                                    {{ $comment->star == 2 ? 'checked' : '' }}>
                                <label for="rating2" class="bi bi-star-fill"></label>
                                <input type="radio" value="3" name="star" id="rating3"
                                    {{ $comment->star == 3 ? 'checked' : '' }}>
                                <label for="rating3" class="bi bi-star-fill"></label>
                                <input type="radio" value="4" name="star" id="rating4"
                                    {{ $comment->star == 4 ? 'checked' : '' }}>
                                <label for="rating4" class="bi bi-star-fill"></label>
                                <input type="radio" value="5" name="star" id="rating5"
                                    {{ $comment->star == 5 ? 'checked' : '' }}>
                                <label for="rating5" class="bi bi-star-fill"></label>
                            </div>
                        </div>
                        <div class="my-3 fs-14">
                            <label for="commentTextArea" class="form-label fw-600">Tambahkan Komentar</label>
                            <textarea class="form-control fs-14" id="commentTextArea" rows="4" name="comment">{{ $comment->comment }}</textarea>
                        </div>
                        <div class="my-3 fs-14">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="d-flex align-items-start flex-column">
                                        <label for="commentImage" class="form-label fw-600 mb-0">
                                            {{ !empty($comment->comment_image) ? 'Ubah Foto Komentar' : 'Tambahkan Foto' }}
                                        </label>
                                        @if (!empty($comment->comment_image))
                                            <p class="text-grey fs-12">
                                                Mengubah foto komentar akan menghapus foto yang sudah diupload sebelumnya
                                            </p>
                                        @endif
                                        <div class="btn user-account-profile-img-btn btn-secondary">
                                            <i class="bi bi-camera"></i> Pilih Foto
                                            <input class="add-file-photo" type="file" name="comment_image"
                                                id="commentImage" onchange="previewImageComment()">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <img class="img-preview w-100">
                                </div>
                            </div>
                        </div>
                        @if (!empty($comment->comment_image))
                            <div class="my-3 fs-14">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="fw-600">Foto yang di upload</div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <img class="img-preview w-100" src="{{ asset($comment->comment_image) }}">
                                    </div>
                                </div>
                            </div>
                        @endif
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
            $('.edit-comment-form').submit(function(e) {
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
