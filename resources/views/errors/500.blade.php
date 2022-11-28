{{-- @extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error')) --}}

@extends('layouts.library')
@section('container')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 text-center mt-3">
            <img class="footer-logo w-100" src="{{ asset('/assets/500.png') }}" alt="">
            <h5 class="text-red-klikspl">Terjadi kesalahan pada server</h5>
        </div>
    </div>      
@endsection
