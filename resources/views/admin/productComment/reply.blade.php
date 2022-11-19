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
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">
            <p><strong>Gagal</strong></p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-md-3 pt-5 mb-1">
        <h4 class="m-0">
            <a href="{{ route('productcomment.index') }}" class="text-decoration-none link-dark">
                <i class="bi bi-arrow-left"></i>
            </a>
            Penilaian Produk
        </h4>
    </div>
    <div class="card mb-3 border-radius-1-5rem fs-14">
        <div class="card-body p-4">
            <form action="{{ route('productcomment.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="" value="{{ $comment->id }}">
                <input type="hidden" name="admin_id" id="" value="{{ auth()->guard('adminMiddle')->user()->id }}">
                <input type="hidden" name="product_id" id="" value="{{ $comment->product_id }}">
                <input type="hidden" name="product_variant_id" id="" value="{{ $comment->product_variant_id }}">
                <input type="hidden" name="order_id" id="" value="{{ $comment->order_id }}">
                <input type="hidden" name="comment_date" id="" value="{{ date('Y-m-d') }}">
                <div class="card mb-4 border-radius-1-5rem">
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
                                    <div class="col-md-1 col-4 text-end">
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
                                                {{ !is_null($comment->productvariant) ? $comment->productvariant->variant_name : 'Tidak ada Varian' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 border-radius-1-5rem">
                    <div class="card-body p-4">
                        {{-- <p class="mb-3 fs-14 fw-bold">Beri Nilai Produk</p> --}}
                        <p class="fs-14 fw-600 m-0 mb-1">Bintang Produk</p>
                        <p class="comment-text m-0 mb-1">
                            @for ($i = 0; $i < $comment->star; $i++)
                                <i class="bi bi-star-fill text-warning"></i>
                            @endfor
                            @for ($i = 0; $i < 5 - $comment->star; $i++)
                                <i class="bi bi-star text-warning"></i>
                            @endfor
                        </p>
                        <div class="my-3 fs-14">
                            <p class="fw-600 m-0 mb-1">
                                Komentar
                            </p>
                            <p class=" m-0 mb-1">
                                {{ $comment->comment }}
                            </p>
                        </div>
                        @if (!empty($comment->comment_image))
                            <div class="my-3 fs-14">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="fw-600">Foto yang di upload</div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <img class="img-preview w-100" src="{{ asset($comment->comment_image) }}">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card mb-4 border-radius-1-5rem fs-14">
                    <div class="card-body p-4">
                        <label for="commentTextArea" class="form-label fw-600">Berikan Komentar</label>
                        <textarea class="form-control fs-14" id="commentTextArea" rows="4" name="comment" required
                            placeholder="Ketikkan komentar disini...">Terima kasih atas kepercayaannya berbelanja di KLIKSPL.com 😊🙏</textarea>
                        <div class="row mt-3">
                            <div class="fw-600 mb-2">Saran Komentar</div>
                            <div class="col-md-6 col-12 mb-2">
                                <a href="#commentTextArea"
                                    class="card text-decoration-none text-dark comment-suggestion border-radius-1-5rem fs-14">
                                    <div class="card-body px-3 py-1 text-truncate">
                                        Terima kasih atas kepercayaannya berbelanja di KLIKSPL.com 😊🙏
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <a href="#commentTextArea"
                                    class="card text-decoration-none text-dark comment-suggestion border-radius-1-5rem fs-14">
                                    <div class="card-body px-3 py-1 text-truncate">
                                        Mohon maaf atas kekurangan dari pelayanan serta produk yang kami jual🙏. Untuk
                                        tindak lanjutnya kami akan menghubungi anda lewat nomor telepon dan atau email,
                                        pastikan nomor telepon dan email anda masih aktif dan valid🙏.
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-danger fs-14">
                            <i class="bi bi-send"></i> Kirim
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.comment-suggestion').on('click', function(e) {
                console.log(e);
                $('#commentTextArea').text(e.target.innerText);
            });
        });
    </script>
@endsection
