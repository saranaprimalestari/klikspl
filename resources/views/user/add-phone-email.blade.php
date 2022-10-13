@extends('user.layout')
@section('account')
    <div class="col-12">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show alert-success-cart" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('failed'))
            <div class="alert alert-danger alert-dismissible fade show alert-success-cart" role="alert">
                {{ session('failed') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show alert-success-cart" role="alert">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif --}}
    </div>
    <h5>
        {{ $act == 'add' ? 'Tambah' : ($act == 'update' ? 'Ubah' : '') }}
        {{-- {{ $type == 'email' ? 'Email' : ($type == 'phone' ? 'Nomor Telepon' : '') }} --}}
        {{ $type }}
    </h5>
    <div class="card mb-3 border-radius-075rem">
        <div class="card-body p-4">
            <form action="{{ route($route) }}" class="" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <div class="row my-4 align-items-center fs-14">
                    <label for="{{ $varName }}" class="col-sm-2 col-md-2 my-2  ">
                        {{-- {{ $type == 'email' ? 'Email' : ($type == 'phone' ? 'Nomor Telepon' : '') }} --}}
                        {{ $type }}
                    </label>
                    <div class="col-sm-10 col-md-10">
                        @if ($varName == 'email')
                            <input type="{{ $inputType }}"
                                class="form-control shadow-none border-radius-05rem py-2 px-3 fs-14 @error('{{ $varName }}') is-invalid @enderror"
                                id="{{ $varName }}" name="{{ $varName }}" required value="" autocomplete="off"
                                placeholder="{{ $type }}">
                        @elseif($varName == 'telp_no')
                            <input type="{{ $inputType }}"
                                class="form-control shadow-none border-radius-05rem py-2 px-3 fs-14 @error('{{ $varName }}') is-invalid @enderror"
                                id="{{ $varName }}" name="{{ $varName }}" required value="" autocomplete="off"
                                placeholder="{{ $type }}">
                        @endif
                        @if ($errors->any())
                            <div class="fs-12 text-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                        @error('{{ $varName }}')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button id="add-phone-btn" type="submit" class="btn btn-danger add-phone-button fs-14">Selanjutnya</button>
            </form>
        </div>
    </div>
@endsection
