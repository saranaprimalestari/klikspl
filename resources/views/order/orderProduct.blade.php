@extends('layouts.main')

@section('container')
    <div class="container-fluid breadcrumb-products fs-14 text-truncate">
        {{ Breadcrumbs::render('product.show', $orderProduct) }}
    </div>

    <div class="container my-md-5 my-2 p-0">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show alert-success-cart" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session()->has('failed'))
            <div class="alert alert-danger alert-dismissible fade show alert-success-cart" role="alert">
                {{ session('failed') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="alert alert-danger" role="alert">
            Data produk yang ditampilkan sesuai tanggal pemesanan produk, lihat tampilan produk terkini
            <a href="{{ route('product.show', $product->slug) }}" class=" m-1 btn btn-danger fs-12">Lihat Produk</a>
        </div>
        <div class="row d-flex">
            <div class="col-md-5 col-12">
                @if (count($orderProduct->orderProductImage) > 0)
                    <div class="product-main-img mb-3">
                        @if (count($orderProduct->orderProductimage) > 0)
                            @if (Storage::exists($orderProduct->orderProductimage[0]->name))
                                <img id="main-image"
                                    src="{{ asset('/storage/' . $orderProduct->orderProductimage[0]->name) }}"
                                    class="product-detail-img" alt="Foto Produk" width="100%">
                            @else
                                <img id="main-image" src="https://source.unsplash.com/400x400?product-1"
                                    class="product-detail-img" alt="Foto Produk" width="100%">
                            @endif
                        @else
                            <img id="main-image" src="https://source.unsplash.com/400x400?product-1"
                                class="product-detail-img" alt="Foto Produk" width="100%">
                        @endif
                    </div>
                    <div class="thumbnail">
                        @foreach ($orderProduct->orderProductImage as $orderProductImg)
                            @if (Storage::exists($orderProductImg->name))
                                <img role="button" class="product-detail-img me-1 mb-2"
                                    id="thumbnail-img-{{ $loop->iteration }}"
                                    src="{{ asset('/storage/' . $orderProductImg->name) }}" width="60"
                                    onclick="change_image(this,{{ $loop->iteration }},{{ $loop->count }})">
                            @else
                                <img role="button" class="product-detail-img me-1 mb-2"
                                    id="thumbnail-img-{{ $loop->iteration }}"
                                    src="https://source.unsplash.com/400x400?product-{{ $loop->iteration }}" width="60"
                                    onclick="change_image(this,{{ $loop->iteration }},{{ $loop->count }})">
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="product-main-img mb-3">
                        <img id="main-image" class="product-detail-img" src="https://source.unsplash.com/400x400?product-1"
                            class="img-fluid" alt="..." width="100%">
                    </div>
                    <div class="share mt-3">
                        <h6>Bagikan &nbsp;
                            <a target="_blank"
                                href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&amp;src=sdkpreparse"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Bagikan ke Facebook"><i
                                    class="bi bi-facebook me-1"></i></a>
                            <a href="" class="pe-auto" onclick="Copy('{{ url()->current() }}')"><i
                                    class="bi bi-clipboard me-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Salin URL"></i></a>
                        </h6>
                    </div>
                @endif
                <div class="modal fade" id="imagemodal" tabindex="-1" aria-labelledby="imagePreviewModal"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content imagePreviewModal">
                            <div class="modal-header border-bottom-0">
                                <p class="modal-title" id="imagePreviewModal">{{ $orderProduct->name }}</p>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                                            <a id="imagePreviewLink" class="imagepreviewLink w-100">
                                                <img id="imagePreview" src="" class="imagepreview w-100">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="thumbnail my-2 thumbnails-modal">
                                            @foreach ($orderProduct->orderProductImage as $orderProductImg)
                                                @if (Storage::exists($orderProductImg->name))
                                                    <a href="{{ asset('/storage/' . $orderProductImg->name) }}"
                                                        data-standard="{{ asset('/storage/' . $orderProductImg->name) }}">
                                                        <img role="button" class="product-detail-img me-1 mb-2"
                                                            id="thumbnail-img-modal-{{ $loop->iteration }}"
                                                            src="{{ asset('/storage/' . $orderProductImg->name) }}"
                                                            width="60"
                                                            onclick="change_image_modal(this,{{ $loop->iteration }},{{ $loop->count }})">
                                                    </a>
                                                @else
                                                    <img role="button" class="product-detail-img me-1 mb-2"
                                                        id="thumbnail-img-modal-{{ $loop->iteration }}"
                                                        src="https://source.unsplash.com/400x400?product-{{ $loop->iteration }}"
                                                        width="60"
                                                        onclick="change_image_modal(this,{{ $loop->iteration }},{{ $loop->count }})">
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="commentImageModal" tabindex="-1" aria-labelledby="commentImageModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-transparent border-0">
                            <div class="modal-header border-0">
                                <h5 class="modal-title" id="commentImageModalLabel"></h5>
                                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img id="commentImagePreview" src="" class="commentImagePreview w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-12">
                <div class="product-info">
                    <h5 class="fs-6">{{ $orderProduct->name }}</h5>
                    <div class="d-flex">
                        <p class="m-0">
                        </p>
                    </div>
                </div>

                <div class="product-price my-md-4 my-lg-4">
                    <h4 class="product-price-text">
                        Rp
                        <span class="price-span" id="price-span">
                            {{ price_format_rupiah($orderProduct->price) }}
                        </span>
                    </h4>
                </div>
                <div class="variant mt-3">
                    @if (!is_null($orderProduct->variant_name))
                        <p class="fw-bold m-0 ">Varian</p>
                        <p class="m-0">{{ $orderProduct->variant_name }}</p>
                        <div class="product_variant_ids_error"></div>
                    @endif
                </div>
                <input type="hidden" name="subtotal" value="">


            </div>
            <div class="col-md-12 mt-md-5 mt-lg-5 mt-4">
                <h5 class="mb-2">Spesifikasi Produk</h5>
                <div class="product-spec">
                    <ul class="m-0">

                        <li>
                            <span>
                                Stock :
                            </span>
                            <span>
                                {{ $stock }}
                            </span>
                        </li>
                        <li>
                            <span>
                                Berat :
                            </span>
                            <span>
                                {{ $orderProduct->weight / 1000 }}kg
                            </span>
                        </li>
                    </ul>
                    {!! $orderProduct->specification !!}
                </div>
            </div>

            <div class="col-md-12 mt-md-5 mt-lg-5 mt-4">
                <h5 class="mb-2">Deskripsi Produk</h5>
                <div class="product-description">
                    {!! $orderProduct->description !!}
                </div>
            </div>
        </div>
    </div>
    <script>
        try {
            $(document).ready(function() {
                var $easyzoom = $('.easyzoom').easyZoom();
                var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');
                console.log($easyzoom);
                console.log(api1);
                $('.thumbnails-modal').on('click', 'a', function(e) {
                    var $this = $(this);
                    e.preventDefault();
                    api1.swap($this.data('standard'), $this.attr('href'));
                })
            });
        } catch (err) {
            location.reload();
        }
        // $(window).focus(function() {
        //     window.location.reload();
        // });
    </script>
@endsection
