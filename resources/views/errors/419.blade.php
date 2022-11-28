{{-- @extends('errors::minimal')

@section('title', __('Halaman Kedaluwarsa Silakan Kembali ke Halaman Sebelumnya dan coba refresh halaman'))
@section('code', '419')
@section('message', __('Halaman Kedaluwarsa Silakan Kembali ke Halaman Sebelumnya dan coba refresh halaman')) --}}
@extends('layouts.library')
@section('container')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 text-center mt-3">
            <img class="w-100" src="{{ asset('/assets/419.png') }}" alt="">
            <h5 class="text-red-klikspl">Halaman Kedaluwarsa Silakan Kembali ke Halaman Sebelumnya dan coba refresh halaman</h5>
        </div>
    </div>      
@endsection
