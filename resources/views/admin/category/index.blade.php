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
    @if ($errors->any())
        {!! implode(
            '',
            $errors->all(
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">:message<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
            ),
        ) !!}
    @endif
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2">Kategori Produk</h1>
        <a class="btn btn-danger fs-14 add-category-btn" data-bs-toggle="modal" data-bs-target="#categoryModal">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
        </a>
    </div>

    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-radius-1-5rem fs-14">
                <form class="category-form" action="{{ route('admincategory.store') }}" method="post">
                    @csrf
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="exampleModalLabel">Tambahkan Kategori Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="my-3 row">
                            <label for="CategoryName" class="col-sm-4 col-md-4 col-form-label fw-600">Nama Kategori</label>
                            <div class="col-sm-8 col-md-8">
                                <input required type="text"
                                    class="form-control fs-14 @error('name') is-invalid @enderror" id="CategoryName"
                                    name="name" placeholder="Ketikkan nama kategori" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="my-3 row">
                            <label for="CategorySlug" class="col-sm-4 col-md-4 col-form-label fw-600">
                                <p class="fw-600 m-0">
                                    Slug Kategori
                                </p>
                                <p class="text-grey fs-12 m-0">Slug akan otomatis terisi mengikuti nama kategori yang
                                    diketikan
                                </p>
                            </label>
                            <div class="col-sm-8 col-md-8">
                                <input required type="text"
                                    class="form-control fs-14 @error('slug') is-invalid @enderror bg-white"
                                    id="CategorySlug" name="slug" placeholder="Slug Kategori" value="{{ old('slug') }}"
                                    readonly>
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

    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-radius-1-5rem fs-14">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <form class="category-form-delete" action="" method="post">
                        @csrf
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus Kategori</h5>
                        <div class="my-3">
                            Apakah yakin akan menghapus Kategori produk
                            <strong>
                                <div class="deleted-category">
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
                <table id="category" class="table hover fs-14 nowrap table-borderless table-hover cell-border order-column"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th class="min-mobile">No</th>
                            <th class="min-mobile">Kategori</th>
                            {{-- <th class="min-mobile">Detail</th>
                            <th class="not-mobile">Stok</th>
                            <th class="not-mobile">Status</th>
                            <th class="not-mobile">Harga</th> --}}
                            <th class="not-mobile">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr class="py-5">
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{-- <div class="d-flex"> --}}
                                    <div class="">
                                        <p class="ps-2 m-0 fw-500">
                                            {{ $category->name }}
                                        </p>
                                        {{-- <p class="ps-2 m-0">
                                                ID: {{ $category->product_code }}
                                            </p> --}}
                                        <p class="ps-2 m-0 fs-11">
                                            {{-- @if (count($category->product)) --}}
                                            {{ $category->product->count() }} produk
                                            {{-- @endif --}}
                                        </p>
                                        <input type="hidden" name="category_name_{{ $category->id }}"
                                            value="{{ $category->name }}">
                                        <input type="hidden" name="category_slug_{{ $category->id }}"
                                            value="{{ $category->slug }}">
                                    </div>
                                    {{-- </div> --}}
                                </td>
                                {{-- <td>
                                    <div class="d-inline-flex">
                                        <div class="m-0 mx-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="Dilihat sebanyak {{ $category->view }} kali">
                                            <i class="bi bi-eye"></i>
                                            {{ $category->view }}
                                        </div>
                                        <div class="m-0 mx-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="Terjual sebanyak {{ $category->sold }} item">
                                            <i class="bi bi-cart"></i>
                                            {{ $category->sold }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if (count($category->productvariant))
                                        {{ $category->productvariant->sum('stock') }}
                                    @else
                                        {{ $category->stock }}
                                    @endif
                                </td>
                                <td>
                                    {{ $category->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </td>
                                <td>
                                    @if (count($category->productvariant) == 1)
                                        Rp{{ price_format_rupiah($category->productvariant->sortBy('price')->first()->price) }}
                                    @elseif (count($category->productvariant) > 1)
                                        Rp{{ price_format_rupiah($category->productvariant->sortBy('price')->first()->price) }}
                                        -
                                        {{ price_format_rupiah($category->productvariant->sortBy('price')->last()->price) }}
                                    @else
                                        Rp{{ price_format_rupiah($category->price) }}
                                    @endif
                                </td> --}}
                                <td>
                                    <a type="button" class="link-dark text-decoration-none mx-1 edit-category "
                                        id="category-{{ $category->id }}" title="Edit kategori" data-bs-toggle="modal"
                                        data-bs-target="#categoryModal" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom">
                                        <i class="bi bi-pen"></i>
                                    </a>
                                    {{-- <a href="#" class="link-dark text-decoration-none mx-1" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Notifikasi Stok | status:">
                                        <i class="bi bi-bell"></i>
                                    </a> --}}
                                    @if (!count($category->product))
                                        <a type="button" class="link-dark text-decoration-none mx-1 delete-category"
                                            id="category-{{ $category->id }}" title="Edit kategori"
                                            data-bs-toggle="modal" data-bs-target="#deleteCategoryModal"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                                            <i class="bi bi-trash3"></i>
                                        </a>
                                        {{-- <form class="d-inline-block" action="{{ route('admincategory.destroy', $category) }}" method="post">
                                            @method('Delete')
                                            @csrf
                                            <button type="submit" class="btn m-0 p-0 link-dark text-decoration-none mx-1"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Hapus Kategori| Selama kategori tidak ada digunakan untuk produk maka kategori baru bisa dihapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form> --}}
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
        const category_name = document.querySelector('#CategoryName');
        const category_slug = document.querySelector('#CategorySlug');

        category_name.addEventListener('keyup', function() {
            fetch('/administrator/admincategory/checkSlug?name=' + category_name.value)
                .then(response => response.json())
                .then(data => category_slug.value = data.slug);
        });

        $(document).ready(function() {
            $('.add-category-btn').on('click', function() {
                console.log('a clicked');
                $('input[name="name"]').val('');
                $('input[name="slug"]').val('');
            });
            $('body').on('click', '.edit-category', function(e) {
                console.log(e.currentTarget.id);
                console.log('edit clicked');
                var targetId = e.currentTarget.id;
                var categoryId = targetId.replace(/[^\d.]/g, '');
                console.log(categoryId);
                var route = "{{ route('admincategory.update', ':categoryId') }}";
                route = route.replace(':categoryId', categoryId);
                // location.href = route;
                // var route = "http://klikspl.test/administrator/admincategory/" + categoryId;
                console.log(route);
                $('.category-form').attr('action', route);
                $('input[name="name"]').val($('input[name="category_name_' + categoryId + '"]').val());
                $('input[name="slug"]').val($('input[name="category_slug_' + categoryId + '"]').val());
                $('.category-form').append('<input name="_method" type="hidden" value="PUT">');
                $('.category-form').append('<input name="category_id" type="hidden" value="' + categoryId +
                    '">');
            });
            $('body').on('click', '.delete-category', function(e) {
                console.log(e.currentTarget.id);
                console.log('delete clicked');
                var targetId = e.currentTarget.id;
                var categoryId = targetId.replace(/[^\d.]/g, '');
                console.log(categoryId);
                var route = "{{ route('admincategory.destroy', ':categoryId') }}";
                route = route.replace(':categoryId', categoryId);
                // var route = "http://klikspl.test/administrator/admincategory/" + categoryId;
                console.log(route);
                $('.deleted-category').text($('input[name="category_name_' + categoryId + '"]').val());
                $('.category-form-delete').attr('action', route);
                $('input[name="name"]').val($('input[name="category_name_' + categoryId + '"]').val());
                $('input[name="slug"]').val($('input[name="category_slug_' + categoryId + '"]').val());
                $('.category-form-delete').append('<input name="_method" type="hidden" value="DELETE">');
                $('.category-form-delete').append('<input name="category_id" type="hidden" value="' +
                    categoryId +
                    '">');
            });
            // $('#product').DataTable({
            //     // select: true
            //     fixedHeader: true,
            // });
            var table = $('#category').DataTable({
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
