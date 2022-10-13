@extends('user.layout')
@section('account')
    <div class="card mb-3">
        <div class="card-body p-4">
            <h5>Tambahkan No.Telepon</h5>
            <form action="{{ route('profile.add.phone.post') }}" class="" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <div class="row my-4 align-items-center fs-14">
                    <label for="telp_no" class="col-sm-2 col-md-2 my-2  ">No.Telepon</label>
                    <div class="col-sm-10 col-md-10">
                        <input type="number"
                            class="form-control shadow-none border-radius-05rem py-2 px-3 fs-14 @error('telp_no') is-invalid @enderror"
                            id="telp_no" name="telp_no" required value="" autocomplete="off"
                            placeholder="contoh: 081234567890">
                        @error('telp_no')
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
