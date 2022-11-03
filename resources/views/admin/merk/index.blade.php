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
        <h1 class="h2">Merk</h1>
        <a class="btn btn-danger fs-14 add-merk-btn" data-bs-toggle="modal" data-bs-target="#merkModal">
            <i class="bi bi-plus-lg"></i> Tambah Merk
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
    {{-- {{ dd($merks) }} --}}
    <div class="modal fade" id="merkModal" tabindex="-1" aria-labelledby="merkModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-radius-1-5rem fs-14">
                <form class="merk-form" action="{{ route('adminmerk.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="exampleModalLabel">Tambahkan Kategori Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="my-3 row">
                            <label for="MerkImage" class="col-sm-4 col-md-4 col-form-label fw-600">
                                <p class="fw-600 m-0">
                                    Logo Merk
                                </p>
                                <p class="text-grey fs-12 m-0">
                                    Ukuran Maks 2MB, format .jpg, .jpeg, .png
                                </p>
                            </label>
                            <div class="col-sm-8 col-md-8">
                                <input type="file"
                                    class="form-control fs-14 @error('image') is-invalid @enderror" id="MerkImage"
                                    name="image" placeholder="Ketikkan nama merk" value="{{ old('image') }}">
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="my-3 row">
                            <label for="MerkName" class="col-sm-4 col-md-4 col-form-label fw-600">Nama Merk</label>
                            <div class="col-sm-8 col-md-8">
                                <input required type="text"
                                    class="form-control fs-14 @error('name') is-invalid @enderror" id="MerkName"
                                    name="name" placeholder="Ketikkan nama merk" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="my-3 row">
                            <label for="MerkSlug" class="col-sm-4 col-md-4 col-form-label fw-600">
                                <p class="fw-600 m-0">
                                    Slug Merk
                                </p>
                                <p class="text-grey fs-12 m-0">Slug akan otomatis terisi mengikuti nama merk yang diketikan
                                </p>
                            </label>
                            <div class="col-sm-8 col-md-8">
                                <input required type="text"
                                    class="form-control fs-14 @error('slug') is-invalid @enderror bg-white" id="MerkSlug"
                                    name="slug" placeholder="Slug Merk" value="{{ old('slug') }}" readonly required>
                                @error('slug')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
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

    <div class="modal fade" id="deleteMerkModal" tabindex="-1" aria-labelledby="deleteMerkModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-radius-1-5rem fs-14">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <form class="merk-form-delete" action="" method="post">
                        @csrf
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus Merk</h5>
                        <div class="my-3">
                            Apakah yakin akan menghapus Merk
                            <strong>
                                <div class="deleted-merk">
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
                <table id="merk"
                    class="table hover fs-14 nowrap table-borderless table-hover cell-border order-column"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th class="min-mobile">No</th>
                            <th class="min-mobile">Kategori</th>
                            <th class="not-mobile">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($merks as $merk)
                            <tr class="py-5">
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{-- <div class="d-flex"> --}}
                                    <div class="">
                                        <div class="d-flex">
                                            {{-- {{ isset($merk->image) }} --}}
                                            @if (!empty($merk->image))
                                                <img id="main-image" class=""
                                                    src="{{ asset($merk->image) }}" class="img-fluid" alt="..."
                                                    width="12%" height="12%">
                                            @else
                                                {{-- <img id="main-image" class=""
                                                    src="https://source.unsplash.com/400x400?product-1" class="img-fluid"
                                                    alt="..." width="60"> --}}
                                            @endif
                                            <div class="">
                                                <p class="ps-2 m-0 fw-500">
                                                    {{ $merk->name }}
                                                </p>
                                                <p class="ps-2 m-0 fs-11">
                                                    {{ $merk->product->count() }} produk
                                                </p>
                                            </div>
                                        </div>
                                        <input type="hidden" name="merk_name_{{ $merk->id }}"
                                            value="{{ $merk->name }}">
                                        <input type="hidden" name="merk_slug_{{ $merk->id }}"
                                            value="{{ $merk->slug }}">
                                    </div>
                                    {{-- </div> --}}
                                </td>
                                <td>
                                    <a type="button" class="link-dark text-decoration-none mx-1 edit-merk "
                                        id="merk-{{ $merk->id }}" title="Edit merk" data-bs-toggle="modal"
                                        data-bs-target="#merkModal" data-bs-toggle="tooltip" data-bs-placement="bottom">
                                        <i class="bi bi-pen"></i>
                                    </a>
                                    {{-- <a href="#" class="link-dark text-decoration-none mx-1" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Notifikasi Stok | status:">
                                        <i class="bi bi-bell"></i>
                                    </a> --}}
                                    @if (!count($merk->product))
                                        <a type="button" class="link-dark text-decoration-none mx-1 delete-merk"
                                            id="merk-{{ $merk->id }}"
                                            title="Hapus merk | hanya dapat dilakukan ketika merk tidak terdapat produk yang terkait"
                                            data-bs-toggle="modal" data-bs-target="#deleteMerkModal"
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
        const merk_name = document.querySelector('#MerkName');
        const merk_slug = document.querySelector('#MerkSlug');
        merk_name.addEventListener('keyup', function() {
            fetch('/administrator/adminmerk/checkSlug?name=' + merk_name.value)
                .then(response => response.json())
                .then(data => merk_slug.value = data.slug);
        });

        $(document).ready(function() {
            $('.add-merk-btn').on('click', function() {
                console.log('a clicked');
                $('input[name="name"]').val('');
                $('input[name="slug"]').val('');
            });
            $('body').on('click', '.edit-merk', function(e) {
                console.log(e.currentTarget.id);
                console.log('edit clicked');
                var targetId = e.currentTarget.id;
                var merkId = targetId.replace(/[^\d.]/g, '');
                console.log(merkId);
                var route = "{{ route('adminmerk.update', ':merkId') }}";
                route = route.replace(':merkId', merkId);
                // var route = "http://klikspl.test/administrator/adminmerk/" + merkId;
                console.log(route);
                $('.merk-form').attr('action', route);
                $('input[name="name"]').val($('input[name="merk_name_' + merkId + '"]').val());
                $('input[name="slug"]').val($('input[name="merk_slug_' + merkId + '"]').val());
                $('.merk-form').append('<input name="_method" type="hidden" value="PUT">');
                $('.merk-form').append('<input name="merk_id" type="hidden" value="' + merkId +
                    '">');
            });
            $('body').on('click', '.delete-merk', function(e) {
                console.log(e.currentTarget.id);
                console.log('delete clicked');
                var targetId = e.currentTarget.id;
                var merkId = targetId.replace(/[^\d.]/g, '');
                console.log(merkId);
                var route = "{{ route('adminmerk.update', ':merkId') }}";
                route = route.replace(':merkId', merkId);
                // var route = "http://klikspl.test/administrator/paymentmethod/" + merkId;
                console.log(route);
                $('.deleted-merk').text($('input[name="merk_name_' + merkId + '"]').val());
                $('.merk-form-delete').attr('action', route);
                $('input[name="name"]').val($('input[name="merk_name_' + merkId + '"]').val());
                $('input[name="slug"]').val($('input[name="merk_slug_' + merkId + '"]').val());
                $('.merk-form-delete').append('<input name="_method" type="hidden" value="DELETE">');
                $('.merk-form-delete').append('<input name="merk_id" type="hidden" value="' +
                    merkId +
                    '">');
            });
            // $('#product').DataTable({
            //     // select: true
            //     fixedHeader: true,
            // });
            var table = $('#merk').DataTable({
                // fixedHeader: true,
                responsive: true,
                // lengthChange: false,
                // buttons: ['colvis'],
                columnDefs: [{
                        "targets": 0, // your case first column
                        // "className": "text-center",
                        "width": "4%"
                    },
                    {
                        "targets": 1,
                        // "className": "text-center",
                        // "width": "4%"
                    },
                    {
                        "targets": 2,
                        // "className": "text-center",
                        "width": "6%"
                    },
                    // {
                    //     "targets": 3,
                    //     "className": "text-center",
                    //     // "width": "4%"
                    // },
                    // {
                    //     "targets": 4,
                    //     "className": "text-center",
                    //     "width": "18%"
                    // },
                    // {
                    //     "targets": 5,
                    //     "className": "text-center",
                    //     "width": "8%"
                    // }
                ],
            });

            // table.buttons().container().appendTo('#product_wrapper .col-md-6:eq(0)');

            // new $.fn.dataTable.FixedHeader( table );
        });
    </script>
@endsection
