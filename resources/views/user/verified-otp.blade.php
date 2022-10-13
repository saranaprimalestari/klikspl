@extends('user.layout')
@section('account')
    <div class="card mb-3 profile-card">
        <div class="card-body p-4">
            {{-- <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ url()->previous() }}" class="text-decoration-none link-dark">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div> --}}
            <h5 class="mb-4">
                {{ $act == 'add' ? 'Tambahkan' : ($act == 'update' ? 'Ubah' : '') }}
                {{ $type }}
            </h5>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <h5 class="text-center">
                        {{ ucfirst(strtolower($type)) }}
                        berhasil diverifikasi,
                        {{ $act == 'add' ? 'berhasil menambahkan' : ($act == 'update' ? 'silakan mengubah' : '') }}
                        {{ strtolower($type) }}
                    </h5>
                    <div class="card mb-5 border-radius-075rem box-shadows border-0">
                        <div class="card-body p-5">
                            <div class="header mb-4">
                                <div class="row">
                                    <div class="col-12">

                                    </div>
                                </div>
                                <div>
                                    <span class="d-flex justify-content-center">
                                    </span>
                                </div>
                                @if ($type == 'Email')
                                @else
                                @endif
                                <a href="{{ $act == 'add' ? route($route) : route($updateRoute) }}"
                                    class="btn btn-danger text-decoration-none w-100 mt-3 register-button">{{ $act == 'add' ? 'Selesai' : ($act == 'update' ? 'Lanjutkan' : '') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
