@extends('admin.layouts.main')
@section('container')
<div class="container p-0 mb-5">
    <div class="card admin-card-dashboard border-radius-1-5rem fs-14">
        <div class="card-body p-5 pt-4">
            <table id="product" class="table hover fs-14 nowrap table-borderless table-hover cell-border order-column"
                style="width:100%">
                <thead>
                    <tr>
                        <th class="min-mobile">No</th>
                        <th class="min-mobile">Nama Produk</th>
                        <th class="min-mobile">ID Produk</th>
                        @if (auth()->guard('adminMiddle')->user()->admin_type == 1)
                            <th class="min-mobile">Perusahaan</th>
                        @endif
                        <th class="not-mobile">Detail</th>
                        <th class="not-mobile">Stok</th>
                        @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                            auth()->guard('adminMiddle')->user()->admin_type == 2)
                            <th class="not-mobile">Status</th>
                        @endif
                        <th class="not-mobile">Harga</th>
                        <th class="not-mobile">Aksi</th>
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
                                            <img id="main-image"
                                                class="border-radius-05rem product-image-{{ $product->id }} {{ $product->is_active ? '' : 'grayscale-filter' }}"
                                                src="{{ asset('/storage/' . $product->productimage[0]->name) }}"
                                                class="img-fluid" alt="..." width="60">
                                        @else
                                            <img id="main-image"
                                                class="border-radius-05rem product-image-{{ $product->id }} {{ $product->is_active ? '' : 'grayscale-filter' }}"
                                                src="https://source.unsplash.com/400x400?product-1" class="img-fluid"
                                                alt="..." width="60">
                                        @endif
                                    @else
                                        <img id="main-image"
                                            class="border-radius-05rem product-image-{{ $product->id }} {{ $product->is_active ? '' : 'grayscale-filter' }}"
                                            src="https://source.unsplash.com/400x400?product-1" class="img-fluid"
                                            alt="..." width="60">
                                    @endif
                                    <div class="">
                                        <p class="ps-2 m-0">
                                            {{ $product->name }}
                                        </p>
                                        {{-- <p class="ps-2 m-0 fs-11">
                                            ID: {{ $product->product_code }}
                                        </p> --}}
                                        <p class="ps-2 m-0 fs-11">
                                            @if (count($product->productvariant))
                                                {{ count($product->productvariant) }} varian
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="ps-2 m-0 fs-11">
                                    {{ $product->product_code }}
                                </p>
                            </td>
                            @if (auth()->guard('adminMiddle')->user()->admin_type == 1)
                                <td>
                                    {{ $product->company->name }}
                                </td>
                            @endif
                            <td>
                                <div class="d-inline-flex">
                                    <div class="m-0 mx-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        title="Dilihat sebanyak {{ $product->view }} kali">
                                        <i class="bi bi-eye"></i>
                                        {{ $product->view }}
                                    </div>
                                    <div class="m-0 mx-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        title="Terjual sebanyak {{ count($product->productvariant) > 0 ? $product->productvariant->sum('sold') : $product->sold }} item">
                                        <i class="bi bi-cart"></i>
                                        {{ count($product->productvariant) > 0 ? $product->productvariant->sum('sold') : $product->sold }}
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
                            @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                                auth()->guard('adminMiddle')->user()->admin_type == 2)
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
                            @endif
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
                                @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                                    auth()->guard('adminMiddle')->user()->admin_type == 2)
                                    <a href="{{ route('adminproduct.edit', $product) }}"
                                        class="link-dark text-decoration-none mx-1" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Edit Produk">
                                        <i class="bi bi-pen"></i>
                                    </a>
                                @endif
                                <a href="{{ route('adminproduct.show', $product) }}"
                                    class="link-dark text-decoration-none mx-1" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="Detail Produk">
                                    <i class="bi bi-info-circle"></i>
                                </a>
                                @if (auth()->guard('adminMiddle')->user()->admin_type == 1 ||
                                    auth()->guard('adminMiddle')->user()->admin_type == 2)
                                    <button
                                        class="btn p-0 link-dark text-decoration-none mx-1 product-stock-notification shadow-none"
                                        id="stock-notification-{{ $product->id }}" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom"
                                        title="Notifikasi Stok | status: {{ $product->stock_notification ? 'Aktif' : 'Tidak Aktif' }} ">
                                        <i id="icon-stock-notification-{{ $product->id }}"
                                            class="bi bi-{{ $product->stock_notification ? 'bell' : 'bell-slash' }}">
                                        </i>
                                    </button>
                                    <input type="hidden" class="input-stock-notification-{{ $product->id }}"
                                        name="stock_notification" value="{{ $product->stock_notification }}">
                                @endif

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
    <script>
        $(document).ready(function() {
            var table = $('#product').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });

            table.buttons().container()
                .appendTo('#product_wrapper .col-md-6:eq(0)');
                
        });
    </script>
@endsection