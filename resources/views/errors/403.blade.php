{{-- @extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden')) --}}

@extends('layouts.library')

@section('container')
    {{-- {{ print_r() }} --}}
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 text-center mt-3">
            {{-- <h1>404</h1>
            <h2>Halaman yang anda cari tidak ditemukan</h2> --}}
            {{-- <img class="footer-logo w-100" src="{{ asset('/assets/403.2.gif') }}" alt=""> --}}
            <img class="footer-logo w-100" src="{{ asset('/assets/403.png') }}" alt="">
            <h5 class="mt-3 text-red-klikspl">Kamu tidak memilki hak akses halaman ini</h5>
            {{-- <a href="{{ url()->previous() }}" class="text-decoration-none btn btn-danger fs-14 py-2 px-3 border-radius-075rem">Kembali ke halaman sebelumnya</a> --}}
        </div>
    </div>      
@endsection
