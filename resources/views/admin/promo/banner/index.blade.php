@extends('admin.layouts.main')
@section('container')
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
    {{ \Carbon\Carbon::now()->addDays(30); }}
    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $promoBanners[0]->created_at)->addDays(30) }}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2 m-0">Promo Banner</h1>
        <a class="btn btn-danger fs-14 add-payment-method-btn" href="{{ route('promobanner.create') }}">
            <i class="bi bi-plus-lg"></i> Tambah Baru
        </a>
    </div>
    <div class=" mb-3 d-flex overflow-auto pb-2">
        <div class="status-form">
            <a href="{{ route('promobanner.index') }}"
                class="btn link-dark bg-white text-decoration-none shadow-none fs-13 me-2 my-1 shadow-none border-radius-075rem {{ !is_null(session()->get('status')) ? (session()->get('status') == '' ? 'border-danger text-danger' : '') : '' }}">
                Semua
            </a>
        </div>
        <form class="status-form" action="{{ route('promobanner.index') }}" method="GET">
            <input type="hidden" name="status" value="aktif">
            <button type="submit"
                class="btn text-dark bg-white text-decoration-none shadow-none fs-13   me-2 my-1 shadow-none border-radius-075rem {{ !is_null(session()->get('status')) ? (session()->get('status') == 'aktif' ? 'active-menu border-danger text-danger' : '') : '' }}">
                Aktif
            </button>
        </form>
        <form class="status-form" action="{{ route('promobanner.index') }}" method="GET">
            <input type="hidden" name="status" value="tidak aktif">
            <button type="submit"
                class="btn text-dark bg-white text-decoration-none shadow-none fs-13   me-2 my-1 shadow-none border-radius-075rem {{ !is_null(session()->get('status')) ? (session()->get('status') == 'tidak aktif' ? 'active-menu border-danger text-danger' : '') : '' }}">
                Tidak Aktif
            </button>
        </form>
        <form class="status-form" action="{{ route('promobanner.index') }}" method="GET">
            <input type="hidden" name="status" value="akan datang">
            <button type="submit"
                class="btn text-dark bg-white text-decoration-none shadow-none fs-13   me-2 my-1 shadow-none border-radius-075rem {{ !is_null(session()->get('status')) ? (session()->get('status') == 'akan datang' ? 'active-menu border-danger text-danger' : '') : '' }}">
                Akan Datang
            </button>
        </form>
        <form class="status-form" action="{{ route('promobanner.index') }}" method="GET">
            <input type="hidden" name="status" value="sudah berakhir">
            <button type="submit"
                class="btn text-dark bg-white text-decoration-none shadow-none fs-13   me-2 my-1 shadow-none border-radius-075rem {{ !is_null(session()->get('status')) ? (session()->get('status') == 'sudah berakhir' ? 'active-menu border-danger text-danger' : '') : '' }}">
                Sudah Berakhir
            </button>
        </form>
    </div>
    <div class="container p-0 mb-5">
        @foreach ($promoBanners as $promo)
            <div class="card admin-card-dashboard border-radius-1-5rem fs-14 mb-3">
                @if (auth()->guard('adminMiddle')->user()->admin_type == 1)
                    <div class="card-header bg-transparent px-4 pt-4 pb-0 border-0">
                        <div class="fw-600">
                            {{ $promo->company->name }}
                        </div>
                    </div>
                @endif
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-12">
                            @if ($promo->end_period < \Carbon\Carbon::now())
                                <div class="alert alert-danger p-0 px-3 py-2 fs-12" role="alert">
                                    Promo telah berakhir | Tanggal akhir promo sudah melewati dari hari ini
                                </div>
                            @endif
                        </div>
                        <div class="col-md-3 col-12">
                            <a href="{{ route('promobanner.edit', $promo) }}" class="text-dark text-decoration-none">

                                @if (Storage::exists($promo->image))
                                    <img src="{{ asset('/storage/'.$promo->image) }}"
                                        class="img-fluid w-100 border-radius-075rem {{ $promo->is_active ? '' : 'grayscale-filter' }} promo_banner_image_{{ $promo->id }}"
                                        alt="...">
                                @else
                                    <img src="{{ asset('assets/voucher.png') }}"
                                        class="img-fluid w-100 border-radius-075rem promo_banner_image_{{ $promo->id }}"
                                        alt="...">
                                @endif
                            </a>
                        </div>
                        <div class="col-md-6 col-12 my-2">
                            <a href="{{ route('promobanner.edit', $promo) }}" class="text-dark text-decoration-none">
                                <h5 class="m-0 fw-600 pb-1">
                                    {{ $promo->name }}
                                </h5>
                                <table>
                                    <tr>
                                        <td>
                                            Status banner
                                        </td>
                                        <td class="px-1">
                                            :
                                        </td>
                                        <td>
                                            {{ $promo->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Berlaku mulai
                                        </td>
                                        <td class="px-1">
                                            :
                                        </td>
                                        <td>
                                            <div class="d-none d-sm-block">
                                                {{ \Carbon\Carbon::parse($promo->start_period)->isoFormat('D MMMM Y, HH:mm') }}
                                                WIB
                                            </div>
                                            <div class="d-block d-sm-none">
                                                {{ \Carbon\Carbon::parse($promo->start_period)->isoFormat('D MMM Y, HH:mm') }}
                                                WIB
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Berlaku sampai
                                        </td>
                                        <td class="px-1">
                                            :
                                        </td>
                                        <td>
                                            <div class="d-none d-sm-block">
                                                {{ \Carbon\Carbon::parse($promo->end_period)->isoFormat('D MMMM Y, HH:mm') }}
                                                WIB
                                            </div>
                                            <div class="d-block d-sm-none">
                                                {{ \Carbon\Carbon::parse($promo->end_period)->isoFormat('D MMM Y, HH:mm') }}
                                                WIB
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </a>
                            <input type="hidden" name="promo_banner_name_{{ $promo->id }}"
                                value="{{ $promo->name }}">
                            <input type="hidden" name="promo_banner_image_{{ $promo->id }}"
                                value="{{ $promo->image }}">
                        </div>
                        {{-- <div class="col-md-1 col-12 text-end">
                            <p class="m-0 fs-14 fw-600">Status</p>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input promo-banner-status" type="checkbox" role="switch"
                                    id="status-{{ $promo->id }}" {{ $promo->is_active == 1 ? 'checked' : '' }}
                                    name="isActive">
                                <label class="form-check-label fs-14 statusLabel-{{ $promo->id }}"
                                    for="status-{{ $promo->id }}">
                                    {{ $promo->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                </label>
                            </div>
                            <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                        </div> --}}
                        <div class="col-md-3 col-12 text-end">
                            <a href="{{ route('promobanner.edit', $promo) }}" class="link-dark text-decoration-none mx-1"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Promo Banner">
                                <i class="bi bi-pen"></i>
                            </a>
                            <a type="button" class="link-dark text-decoration-none mx-1 delete-promo-banner"
                                id="banner-{{ $promo->id }}" title="Hapus Promo Banner" data-bs-toggle="modal"
                                data-bs-target="#deletePromoBannerModal" data-bs-toggle="tooltip"
                                data-bs-placement="bottom">
                                <i class="bi bi-trash3"></i>
                            </a>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="modal fade" id="deletePromoBannerModal" tabindex="-1" aria-labelledby="deletePromoBannerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-radius-1-5rem fs-14">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <form class="promo-banner-form-delete" action="" method="post">
                        @csrf
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus Promo Banner</h5>
                        <div class="my-3">
                            <p class="mb-2">
                                Apakah yakin akan menghapus Promo Banner
                            </p>
                            <div class="row justify-content-center">
                                <div class="col-md-4 col-12 mb-2">
                                    <img src=""
                                        class="img-fluid w-100 border-radius-05rem deleted-promo-banner-image"
                                        alt="...">
                                </div>
                                <div class="col-12 ps-md-0">
                                    <strong>
                                        <div class="deleted-promo-banner">
                                        </div>
                                    </strong>
                                </div>
                            </div>
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
    <script>
        $('body').on('click', '.delete-promo-banner', function(e) {
            console.log(e.currentTarget.id);
            console.log('delete clicked');
            var targetId = e.currentTarget.id;
            var promoBannerId = targetId.replace(/[^\d.]/g, '');
            var base_url = window.location.origin;
            console.log(promoBannerId);
            var route = "{{ route('promobanner.destroy', ':promoBannerId') }}";
            route = route.replace(':promoBannerId', promoBannerId);
            // var route = "http://klikspl.test/administrator/promobanner/" + promoBannerId;
            console.log(route);
            console.log(base_url);
            console.log(($('input[name="promo_banner_image_' + promoBannerId + '"]').val()));
            $('.deleted-promo-banner').text($('input[name="promo_banner_name_' + promoBannerId + '"]').val());
            $('.deleted-promo-banner-image').attr('src', base_url + '/' + ($('input[name="promo_banner_image_' +
                promoBannerId + '"]').val()));
            $('.promo-banner-form-delete').attr('action', route);
            $('.promo-banner-form-delete').append('<input name="_method" type="hidden" value="DELETE">');
            $('.promo-banner-form-delete').append('<input name="merk_id" type="hidden" value="' +
                promoBannerId +
                '">');
        });
    </script>
@endsection
