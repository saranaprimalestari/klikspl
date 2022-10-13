@extends('layouts.library')
@section('container')
<div class="container p-0">
    <div class="row">
        <div class="col-12 p-0">
            <img src="{{ asset('/storage/' . $img) }}" class="w-100 border-radius-5px" alt="">
        </div>
    </div>
</div>
@endsection