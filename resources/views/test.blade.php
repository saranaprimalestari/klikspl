<!DOCTYPE html>
<html>

<head>
    {{-- ICON WEB --}}
    <link rel="shortcut icon" href="/assets/klikspl.ico">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    {{-- Bootstrap ICON --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    {{-- Style CSS --}}
    <link rel="stylesheet" href="{{ asset('/css/admin/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/trix.css') }}">

    {{-- SELECT2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" />

    {{-- DATATABLES --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    {{-- <link rel="stylesheet" type="text/css"
         href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.4/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/sr-1.1.1/datatables.min.css" /> --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" /> --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css" /> --}}


    {{-- SCRIPT JQUERY --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/js/script.js" type="text/javascript"></script>

    {{-- cropper.js --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/2.0.0-alpha.2/cropper.min.css"
        integrity="sha512-6QxSiaKfNSQmmqwqpTNyhHErr+Bbm8u8HHSiinMEz0uimy9nu7lc/2NaXJiUJj2y4BApd5vgDjSHyLzC8nP6Ng=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/2.0.0-alpha.2/cropper.min.js"
        integrity="sha512-IlZV3863HqEgMeFLVllRjbNOoh8uVj0kgx0aYxgt4rdBABTZCl/h5MfshHD9BrnVs6Rs9yNN7kUQpzhcLkNmHw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
        integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous">
    </script>


    {{-- SCRIPT JQUERY --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    {{-- DATATABLES --}}
    {{-- <script type="text/javascript" src="{{ asset('/DataTables/datatables.min.js') }}"></script> --}}

    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    {{-- FONTAWESOME --}}
    <script src="https://kit.fontawesome.com/c4d8626996.js" crossorigin="anonymous"></script>

    <script src="/js/script.js" type="text/javascript"></script>
    <script src="/js/trix.js" type="text/javascript"></script>

    {{-- SELECT2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <meta charset=utf-8 />
    <title>DataTables - JS Bin</title>
</head>

<body>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2">Produk Saya</h1>
    </div>
    <div class="container p-0 mb-5">
        <div class="card admin-card-dashboard border-radius-1-5rem fs-13">
            <div class="card-body p-5">
                <div id="datatablestest" style="width: 100%;margin: 0 auto;">
                    <table id="example" class="display"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th class="min-mobile">No</th>
                            <th class="min-mobile">Nama Produk</th>
                            <th class="not-mobile">Detail</th>
                            <th class="not-mobile">Stok</th>
                            <th class="not-mobile">Status</th>
                            <th class="not-mobile">Harga</th>
                            <th class="not-mobile">Action</th>
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
                                                <img id="main-image" class="border-radius-05rem"
                                                    src="{{ asset('/storage/' . $product->productimage[0]->name) }}"
                                                    class="img-fluid" alt="..." width="60">
                                            @else
                                                <img id="main-image" class="border-radius-05rem"
                                                    src="https://source.unsplash.com/400x400?product-1" class="img-fluid"
                                                    alt="..." width="60">
                                            @endif
                                        @else
                                            <img id="main-image" class="border-radius-05rem"
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
                                            title="Terjual sebanyak {{ $product->sold }} item">
                                            <i class="bi bi-cart"></i>
                                            {{ $product->sold }}
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
                                    <a href="{{ route('adminproduct.edit', $product) }}"
                                        class="link-dark text-decoration-none mx-1" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Edit Produk">
                                        <i class="bi bi-pen"></i>
                                    </a>
                                    <a href="{{ route('adminproduct.show', $product) }}"
                                        class="link-dark text-decoration-none mx-1" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Detail Produk">
                                        <i class="bi bi-info-circle"></i>
                                    </a>
                                    <a href="#" class="link-dark text-decoration-none mx-1" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom"
                                        title="Notifikasi Stok | status: {{ $product->stock_notification ? 'Aktif' : 'Tidak Aktif' }} ">
                                        <i class="bi bi-{{ $product->stock_notification ? 'bell' : 'bell-slash' }}"></i>
                                    </a>
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
    </div>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
        $(document).ready(function() {
            var table = $('#product').DataTable({
                //"autoWidth" : false,

                "columns": [{
                        data: "JourID",
                        title: "JourID",
                        width: '150px'
                    },
                    {
                        data: "JourTime",
                        title: "JourTime",
                        width: '50px'
                    },
                    {
                        data: "Zust1",
                        title: "Zust1",
                        width: '30px'
                    },
                    {
                        data: "Dokname",
                        title: "Dokname",
                        width: '100px'
                    },
                    {
                        data: "Doktype",
                        title: "Doktype",
                        width: '100px'
                    },
                    {
                        data: "JourInhaltTextOnly",
                        title: "JourInhaltTextOnly",
                        width: '550px'
                    },
                    // {
                    //     data: "JourInhaltTextOnly",
                    //     title: "JourInhaltTextOnly",
                    //     width: '550px'
                    // },
                ],
                //               "paging": false,
                //     "scrollY": 400,
                "scrollX": true,

            });
        });
    </script>
</body>

</html>
