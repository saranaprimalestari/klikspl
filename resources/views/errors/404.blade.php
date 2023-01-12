{{-- @extends('errors::minimal')

@section('title', __('Halaman Tidak Ditemukan'))
@section('code', '404')
@section('message', __('Halaman Tidak Ditemukan')) --}}

{{-- @extends('errors::minimal') --}}
@extends('layouts.library')
@section('container')
    {{-- {{ print_r() }} --}}
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 text-center mt-3">
            {{-- <h1>404</h1>
            <h2>Halaman yang anda cari tidak ditemukan</h2> --}}
            {{-- <img class="w-100" src="{{ asset('/assets/404.1.gif') }}" alt=""> --}}
            <img class="w-100" src="{{ asset('/assets/404.3.png') }}" alt="">
            <h5 class="text-red-klikspl">Halaman yang anda cari tidak ditemukan</h5>
            {{-- <a href="{{ url()->previous() }}" class="text-decoration-none btn btn-danger fs-14 py-2 px-3 border-radius-075rem">Kembali ke halaman sebelumnya</a> --}}
        </div>
    </div>      
@endsection
