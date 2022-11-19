<div class="row">
    <div class="col-md-3">
        <p class="m-0 shipping-text pt-1 fw-bold">
            Alamat
        </p>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <p class="m-0 shipping-text pt-1">
            Alamat
        </p>
    </div>
    <div class="col-md-5 ps-0">
        <select class="form-control user-address form-select form-select-sm shadow-none border-0" name="user-address">
            <option class="p-2" disabled selected>Pilih alamat yang tersimpan
            </option>
            @foreach (auth()->user()->useraddress as $address)
                <option class="p-2" value="{{ $address->id }}" {{ $address->is_active == 1 ? 'selected' : '' }}>
                    {{ $address->address }}
                </option>
                {{-- <input type="text"> --}}
            @endforeach
            <input type="hidden" name="address_province" value="{{ $address->province_ids }}">
            <input type="hidden" name="address_city" value="{{ $address->city_ids }}">
            {{-- <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option> --}}
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <p class="m-0 shipping-text pt-1 fw-bold">
            Cek Ongkir
        </p>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <p class="m-0 shipping-text pt-1">
            Pengiriman ke
        </p>
    </div>
    <div class="col-md-5 ps-0">
        <div class="form-group mb-2">
            {{-- <label class="font-weight-bold">PROVINSI TUJUAN</label> --}}
            <select class="form-control destination-province form-select form-select-sm shadow-none"
                name="province_destination">
                <option value="0">Pilih provinsi tujuan</option>
                @foreach ($provinces as $provinceId => $value)
                    <option value="{{ $provinceId }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-2">
            {{-- <label class="font-weight-bold">KOTA / KABUPATEN TUJUAN</label> --}}
            <select class="form-control destination-city form-select form-select-sm" name="city_destination">
                <option value="">Pilih kota tujuan</option>
            </select>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-3">
        <p class="shipping-text">
            Ongkos Kirim
        </p>
    </div>
    <div class="col-md-5 ps-0">
        <div class="d-grid">
            <div class="form-group mb-2">
                {{-- <label class="font-weight-bold">PROVINSI TUJUAN</label> --}}
                <select class="form-control courier-choices form-select form-select-sm shadow-none" name="courier">
                    <option value="0">Pilihan Kurir</option>
                </select>
            </div>
        </div>
    </div>
</div>

@php
$variantsids[] = $variant->id;
$variantsweights[$variant->id] = $variant->weight;

foreach (auth()->user()->useraddress as $address) {
    if ($address->is_active == 1) {
        $cityaddress = $address->city->city_id;
    }
}
@endphp
<input type="text" name="variantsid" value="{{ $variant->id }}">
<input type="text" name="variantsweight" value="{{ $variant->weight }}">
<input type="text" name="cityorigins" value="{{ $from_city->city_id }}">
@foreach (auth()->user()->useraddress as $address)
    @if ($address->is_active == 1)
        <input type="text" name="variantscity" value="{{ $address->city->city_id }}">
    @endif
@endforeach
{{ print_r($variantsids) }}
{{ print_r($variantsweights) }}
{{ print_r($cityaddress) }}

<div class="modal-ongkir row d-flex align-items-center mb-3">
    <div class="col-1 pe-0 text-center">
        <i class="bi bi-circle-fill"></i>
    </div>
    <div class="col-8">
        <p class="m-0 d-inline-block modal-courier-type pe-1">' +
            response[index][0].code.toUpperCase() +
            '
        </p>
        <p class="m-0 d-inline-block modal-courier-package">' +
            value.service +
            '
        </p>
        <p class="m-0 modal-courier-etd"> Estimasi ' +
            value.cost[0].etd +
            ' hari
        </p>
    </div>
    <div class="col-3">
        <p class="text-end m-0 modal-courier-price">' +
            formatRupiah(value.cost[0].value, "Rp") +
            '
        </p>
    </div>
</div>

<button class="btn mb-3 checkout-courier-button w-100 p-4 " data-bs-toggle="modal" data-bs-target="#courierModal">
    <div class="row d-flex align-items-center">
        <div class="col-md-10 col-12 text-start">
            <div class="checkout-courier-label m-0">
                <p class="fs-5 m-0">' +
                    courier.toUpperCase() + '</p><span class="fw-bold">' + service +
                    '</span>
                <p class="m-0">Akan tiba dalam ' + etd +
                    ' hari dari pengiriman</p>
            </div>
        </div>
        <div class="col-md-2 col-12">
            <p class="m-0 text-danger checkout-courier-cost text-start my-2 fw-bold"><span
                    class="checkout-courier-cost">' +
                    formatRupiah(price, "Rp") +
                    '</span></p>
        </div>
    </div>
    <input type="hidden" name="courier-name"
        value="' +
                        courier.toUpperCase() +
                        '">
    <input type="hidden" name="courier-service" value="' + service +
                        '">
    <input type="hidden" name="courier-etd" value="' + etd +
                        '">
    <input type="hidden" name="courier-price" value="' + price +
                        '">
    </label>
    </div>
</button>

<div class="card mb-3 checkout-courier-card-items">
    <div class="card-body p-4">
        <div class="form-check d-flex align-items-center justify-content-between"><input
                class="form-check-input checkout-courier-input shadow-none" type="radio" name="checkout-courier-input"
                id="courier-' +response[index][0].code + '-' + key +'"
                value="' +response[index][0].code + '-' + key +'">
            <label class="form-check-label checkout-courier-label w-100"
                for="courier-' +response[index][0].code + '-' + key + '">
                <div class="row d-flex align-items-center">
                    <div class="col-md-10 col-12 text-start">
                        <div class="checkout-courier-label m-0">
                            <p class="fs-5 m-0">' + response[index][0].code.toUpperCase() + '</p><span
                                class="fw-bold">' + value.service + '</span>
                            <p class="m-0">Akan tiba dalam ' + value.cost[0].etd + ' hari dari pengiriman</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-12">
                        <p class="m-0 text-danger my-2 fw-bold"><span class="courier-cost">' +
                                formatRupiah(value.cost[0].value, "Rp") + '</span></p>
                    </div>
                </div>
                <input type="hidden" name="courier-name-' +response[index][0].code + '-' + key +'"
                    value="' + response[index][0].code.toUpperCase() + '"><input type="hidden"
                    name="courier-service-' +response[index][0].code + '-' + key +'" value="' + value.service + '">
                <input type="hidden" name="courier-etd-' +response[index][0].code + '-' + key +'"
                    value="' + value.cost[0].etd + '">
                <input type="hidden" name="courier-price-' +response[index][0].code + '-' + key +'"
                    value="' + value.cost[0].value + '">
            </label>
        </div>
    </div>
</div>


upload image

nama folder : post-images

folder storage->app->folder

file storage laravel

config/filesystems.php


searching



<ul class="list-unstyled">
    <li class="mb-2">
        <a class="btn btn-toggle align-items-center shadow-none user-button-menu-collapse ps-3"
            data-bs-toggle="collapse" href="#account-collapse" role="button" aria-expanded="false"
            aria-controls="account-collapse">
            <i class="far fa-user-circle me-1"></i> Akun Saya
        </a>
        {{-- <button class="btn btn-toggle align-items-center shadow-none" data-bs-toggle="collapse"
            data-bs-target="#account-collapse" aria-expanded="true">
            <i class="far fa-user-circle me-1"></i> Akun Saya
        </button> --}}
        <div class="collapse show" id="account-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li>
                    <a href="#" class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex">Profil</a>
                </li>
                <li>
                    <a href="#" class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex">Kelola
                        Alamat</a>
                </li>
                <li>
                    <a href="#" class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex">Ubah
                        Password</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="mb-2">
        <a class="btn btn-toggle align-items-center shadow-none order-button-menu-collapse ps-3"
            data-bs-toggle="collapse" href="#orders-collapse" role="button" aria-expanded="false"
            aria-controls="orders-collapse">
            <i class="bi bi-bag me-1"></i> Pesanan Saya
        </a>
        {{-- <button class="btn btn-toggle align-items-center shadow-none" data-bs-toggle="collapse"
            data-bs-target="#orders-collapse" aria-expanded="true">
            <i class="bi bi-bag me-1"></i> Pesanan Saya
        </button> --}}
        <div class="collapse show" id="orders-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li>
                    <a href="#" class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex">Semua</a>
                </li>
                <li>
                    <a href="#" class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex">Dalam
                        Proses</a>
                </li>
                <li>
                    <a href="#" class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex">Selesai</a>
                </li>
                <li>
                    <a href="#"
                        class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex">Dibatalkan</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="mb-2">
        <a class="btn btn-toggle align-items-center shadow-none notification-button-menu-collapse ps-3"
            href="{{ route('notifications.index') }}">
            <i class="bi bi-bell me-1"></i> Notifikasi
        </a>
    </li>
</ul>


<div class="accordion" id="myAccordion">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button type="button" class="accordion-button collapsed shadow-none" data-bs-toggle="collapse"
                data-bs-target="#collapseOne">
                <i class="far fa-user-circle me-1"></i> Akun Saya
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse">
            <div class="card-body">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li>
                        <a href="#"
                            class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex">Profil</a>
                    </li>
                    <li>
                        <a href="#" class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex">Kelola
                            Alamat</a>
                    </li>
                    <li>
                        <a href="#" class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex">Ubah
                            Password</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
            <button type="button" class="accordion-button" data-bs-toggle="collapse"
                data-bs-target="#collapseTwo">2.
                What is Bootstrap?</button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse show">
            <div class="card-body">
                <p>Bootstrap is a sleek, intuitive, and powerful front-end framework for faster and easier web
                    development. It is a collection of CSS and HTML conventions. <a
                        href="https://www.tutorialrepublic.com/twitter-bootstrap-tutorial/" target="_blank">Learn
                        more.</a></p>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
            <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                data-bs-target="#collapseThree">3. What is CSS?</button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse">
            <div class="card-body">
                <p>CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a given
                    HTML element such as colors, backgrounds, fonts etc. <a
                        href="https://www.tutorialrepublic.com/css-tutorial/" target="_blank">Learn more.</a></p>
            </div>
        </div>
    </div>
</div>



{{-- <div class="col-12 text-center">
                                    <i class="far fa-user-circle"></i>
                                </div>
                                <div class="col-4 text-center">
                                    <div class="mb-3">
                                        <input class="form-control form-control-sm" id="formFileSm" type="file">
                                    </div>
                                </div> --}}




<div class="container">
    <h5>Upload Images</h5>
    <form method="post">
        <input type="file" name="image" class="image">
    </form>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Crop image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <!--  default image where we will set the src via jquery-->
                            <img id="image" class="img-user">
                        </div>
                        <div class="col-md-4">
                            <div class="preview-img-user"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
            </div>
        </div>
    </div>
</div>



var $modal = $('#modal');
console.log($modal);
var image = document.getElementById('image');
var cropper;
$("body").on("change", ".image", function(e) {
var files = e.target.files;
var done = function(url) {
image.src = url;
$modal.modal('show');
};
var reader;
var file;
var url;
if (files && files.length > 0) {
file = files[0];
if (URL) {
done(URL.createObjectURL(file));
} else if (FileReader) {
reader = new FileReader();
reader.onload = function(e) {
done(reader.result);
};
reader.readAsDataURL(file);
}
}
});
$modal.on('shown.bs.modal', function() {
cropper = new Cropper(image, {
aspectRatio: 1,
viewMode: 3,
preview: '.preview-img-user'
});
}).on('hidden.bs.modal', function() {
cropper.destroy();
cropper = null;
});
$("#crop").click(function() {
canvas = cropper.getCroppedCanvas({
width: 160,
height: 160,
});
canvas.toBlob(function(blob) {
url = URL.createObjectURL(blob);
var reader = new FileReader();
reader.readAsDataURL(blob);
reader.onloadend = function() {
var base64data = reader.result;
$.ajax({
type: "POST",
dataType: "json",
url: "crop-image-upload",
data: {
'_token': $('meta[name="_token"]').attr('content'),
'image': base64data
},
success: function(data) {
console.log(data);
$modal.modal('hide');
alert("Crop image successfully uploaded");
}
});
}
});
})


<form action="{{ route('profile.image.upload') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
    <input type="file" name="profile_image" class="image">
    <button type="submit" class="btn btn-danger">submit</button>
</form>
{{-- <div class="container mt-5">
        <div class="card">
            <h2 class="card-header">Laravel Cropper Js - Crop Image Before Upload - Tutsmake.com</h2>
            <div class="card-body">
                <h5 class="card-title">Please Selete Image For Cropping</h5>
                <input type="file" name="image" class="image">
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Laravel Cropper Js - Crop Image Before Upload - Tutsmake.com
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="crop">Crop</button>
                </div>
            </div>
        </div>
    </div> --}}

<div class="">
    <h4>{{ $details['title'] }}</h4>
    <p>Halo</p>
    <p>{{ $details['body'] }}</p>
    <h1 style="text-align: center">{{ $details['verification'] }}</h1>
    <div style="text-align: center; margin: 50px;">
        @if ($details['url'])
            {{-- @component('mail::button', ['url' => $details['url'], 'color' => '#db162f'])
            Masuk
        @endcomponent --}}
            <a href="https://google.com/"
                style="color: #ffffff; font-weight: 500; text-decoration: none; background-color: #db162f; padding: 10px 30px 10px 30px; border-radius: 10px; ">
                Kunjungi Link
            </a>
        @endif
    </div>
    <p>{{ $details['closing'] }}</p>

    <p>{{ $details['footer'] }}</p>
    <p>Email ini dibuat otomatis mohon untuk tidak membalas, jika membutuhkan bantuan, silakan hubungi <a
            href="wa.me/625113269593" style="color:#db162f;text-decoration: none">ADMIN KLIKSPL</a></p>
</div>


{{ $details['url'] = 'https://saranaprimalestari.com/' }}
<div class="row bg-light">
    <div class="col-8 bg-white mx-auto m-4 py-4 px-5 rounded">
        {{-- <h4>{{ $details['title'] }}</h4> --}}
        <div class="col-12 text-center pb-3">
            <img src="{{ asset('/assets/footer-logo.svg') }}" class="text-center" alt="" width="200">
        </div>
        <div>

            <h4>KLIK SPL: Pendaftaran Membership</h4>
            <p class="m-0">Halo,</p>
            {{-- <p>{{ $details['body'] }}</p> --}}
            <p>Pendaftaran membership kamu berhasil! Selamat menikmati pengalaman berbelanja di klikspl.com. Untuk masuk
                dan berbelanja klik tautan berikut:</p>
            {{-- <h1 style="text-align: center">{{ $details['verification'] }}</h1> --}}
            <div style="text-align: center; margin: 50px;">
                @if ($details['url'])
                    {{-- @component('mail::button', ['url' => $details['url'], 'color' => '#db162f']) Masuk @endcomponent --}}
                    <a href="https://google.com/"
                        style="color: #ffffff; font-weight: 500; text-decoration: none; background-color: #db162f; padding: 10px 30px 10px 30px; border-radius: 10px; ">
                        Kunjungi Link
                    </a>
                @endif
            </div>
            {{-- <p>{{ $details['closing'] }}</p> --}}
            <p>Closing section</p>

            {{-- <p>{{ $details['footer'] }}</p> --}}
            <p>footer section</p>
            <p>Email ini dibuat otomatis mohon untuk tidak membalas, jika membutuhkan bantuan, silakan hubungi <a
                    href="wa.me/625113269593" style="color:#db162f;text-decoration: none">ADMIN KLIKSPL</a></p>
        </div>
        <div class="footer col-12 text-center">
            <p class="fw-bold m-0">
                Ikuti Kami
            </p>
            <span>
                <a href="#" class="text-decoration-none text-dark">
                    <i class="bi bi-instagram"></i>
                </a>
            </span>
            <span>
                <a href="#" class="text-decoration-none text-dark">
                    <i class="bi bi-facebook"></i>
                </a>
            </span>
            <span>
                <a href="#" class="text-decoration-none text-dark">
                    <i class="bi bi-globe2"></i>
                </a>
            </span>
        </div>
    </div>
</div>


{{ date('d/m/Y', strtotime($user->birthdate)) }}
{{ date('d/m/Y', strtotime(old('birthdate'))) }}


<div class="row my-3">
    <div class="col-6">
        <div class="input-group">
            <input type="text" class="form-control shadow-none" placeholder="Cari alamat atau nama penerima..."
                aria-label="Cari alamat atau nama penerima..." aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i
                    class="bi bi-search"></i></button>
        </div>
        {{-- <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button> --}}
    </div>
    <div class="col-3 ms-auto text-end">
    </div>
</div>


<div class="fixed-bottom d-block d-sm-none">
    <div class="col-12 bg-white p-4">
        <form action="{{ route('checkout.payment') }}" onsubmit="return validateCheckout()" method="POST">
            @csrf

            @foreach ($items as $item)
                <input type="hidden" name="product-id[]" value="{{ $item->id }}">
                {{-- <input type="hidden" name="product-qty[]" value="{{ $item->quantity }}">
                        <input type="hidden" name="product-subtotal[]" value="{{ $item->subtotal }}"> --}}
            @endforeach

            @foreach ($weight as $weightItem)
                <input type="hidden" name="product-weight[]" value="{{ $weightItem }}">
            @endforeach

            <input type="hidden" name="user-id" value="{{ auth()->user()->id }}">

            <div class="input-data-shipment">

                @foreach ($userAddress as $address)
                    @if ($address->is_active == 1)
                        <input class="address-id" type="hidden" name="addressId" value="{{ $address->id }}">
                        <input class="city-origin" type="hidden" name="cityOrigin" value="35">
                        <input class="city-destination" type="hidden" name="cityDestination"
                            value="{{ $address->city->city_id }}">
                    @endif
                @endforeach

                <input type="hidden" class="courier-name-choosen" name="courier-name-choosen" value="">
                <input type="hidden" class="courier-service-choosen" name="courier-service-choosen" value="">
                <input type="hidden" class="courier-etd-choosen" name="courier-etd-choosen" value="">
                <input type="hidden" class="courier-price-choosen" name="courier-price-choosen" value="">
            </div>

            <div class="input-data-item-detail">
                <input class="csrf-token" type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                <input class="total-weight" type="hidden" name="total_weight" value="{{ array_sum($weight) }}">
                <input class="total-subtotal" type="hidden" name="total_subtotal"
                    value="{{ is_null($items[0]->id) ? $items[0]->subtotal : $items->sum('subtotal') }}">
                <input class="courier" type="hidden" name="courier" value="all">
            </div>

            <h5 class="cart-items-checkout-header cart-items-checkout-header mt-1 mb-4">
                Ringkasan
                Pesanan</h5>
            <div class="row mb-2">
                <div class="col-7 checkout-items-total-text cart-items-total-text pe-0">
                    Total Harga ({{ count($items) }}) Produk
                </div>
                <div class="col-5 cart-items-total-val text-end">
                    Rp{{ price_format_rupiah(is_null($items[0]->id) ? $items[0]->subtotal : $items->sum('subtotal')) }}
                    {{-- Rp{{ price_format_rupiah($items['subtotal']) }} --}}
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-7 checkout-shipment-total-text cart-items-total-text pe-0">
                </div>
                <div class="col-5 checkout-shipment-total-val cart-items-total-val text-end">
                </div>
            </div>
            <div class="my-4 border border-1 border-bottom cart-items-checkout-divider">
            </div>
            <div class="row">
                <div class="col-6">
                    <p class="checkout-total-all-text cart-items-checkout-total-all-text mt-1 mb-4">
                        Total harga</p>
                </div>
                <div class="col-6 checkout-total-all-val cart-items-total-all-val text-end fw-bold">
                </div>
                <input type="hidden" name="checkout_total_price" value="">
            </div>
            <div class="d-grid">
                <button type="button" class="btn btn-block checkout-button show-payment-modal-button shadow-none"
                    data-bs-toggle="modal" data-bs-target="#paymentModal">
                    Pilih Metode Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>


$('.no-modal').on('click', function() {
console.log('aaa');
});
$('#myModal').on('shown.bs.modal', function(e) {
var button = e.relatedTarget;
if ($(button).hasClass('no-modal')) {
e.stopPropagation();
}
});
$(document).ready(function() {
$('#myModal').on('show.bs.modal', function(e) {
console.log('hi');
var button = e.relatedTarget;
console.log($(button).hasClass('no-modal'));
if ($(button).hasClass('no-modal')) {
e.preventDefault();
}
});
});

$(document).on('show.bs.modal', '#myModal', function() {
alert('hi');
});

let courierName = $('input[name="courier-name-choosen"]').val();
let courierService = $('input[name="courier-service-choosen"]').val();
let courierETD = $('input[name="courier-etd-choosen"]').val();
let courierPrice = $('input[name="courier-price-choosen"]').val();
$('#paymentModal').on('show.bs.modal', function(e) {
var button = e.relatedTarget;
if ($(button).hasClass('show-payment-modal-button')) {
e.preventDefault();
}
});

href="/products?category={{ $category->slug }}"

@if (request('keyword') or request('category') or request('merk') or request('sortby'))
    <a href="{{ route('product') }}" class="text-decoration-none btn btn-outline-dark product-reset-filter mx-1">
        <i class="bi bi-filter"></i> Reset Filter
    </a>
@endif

@if (request('category'))
    @if (request('keyword'))
        <input type="hidden" name="keyword" value="{{ request('keyword') }}">
    @endif
    @if (request('merk'))
        <input type="hidden" name="merk" value="{{ request('merk') }}">
    @endif
    @if (request('sortby'))
        <input type="hidden" name="sortby" value="{{ request('sortby') }}">
    @endif
    <input type="hidden" name="category" value="">
    <button type="submit"
        class="text-decoration-none btn btn-outline-dark product-reset-filter mx-1 w-25 text-truncate">
        <i class="bi bi-x-lg"></i> {{ request('category') }}
    </button>
    {{-- <a href="{{ route('product') }}"
        class="text-decoration-none btn btn-outline-dark product-reset-filter mx-1 text-truncate w-25">
        <i class="bi bi-x-lg"></i> {{ request('category') }}
    </a> --}}
@endif
@if (request('merk'))
    <a href="{{ route('product') }}"
        class="text-decoration-none btn btn-outline-dark product-reset-filter mx-1 text-truncate w-25">
        <i class="bi bi-x-lg"></i> {{ request('merk') }}
    </a>
@endif

<div class="dropdown">
    <form action="{{ route('product') }}" method="GET">
        @if (request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        @if (request('merk'))
            <input type="hidden" name="merk" value="{{ request('merk') }}">
        @endif
        @if (request('keyword'))
            <input type="hidden" name="keyword" value="{{ request('keyword') }}">
        @endif
        <button class="btn w-100 shadow-none product-sortby-btn" type="button" id="dropdownMenuButton1"
            data-bs-toggle="dropdown" aria-expanded="false">
            <div class="d-flex">
                <div class="w-100 text-start">
                    Terbaru
                </div>
                <div class="flex-shrink-1">
                    <i class="bi bi-chevron-down"></i>
                </div>
            </div>
        </button>
        <ul class="dropdown-menu w-100 product-sortby-menu" aria-labelledby="dropdownMenuButton1">
            <li>
                <input type="hidden" name="sortby" value="latest">
                <button class="dropdown-item" type="submit">
                    Terbaru
                </button>
                {{-- <a href="/products?sortby=latest" class="dropdown-item" href="#">Terbaru</a> --}}
            </li>
            <li>
                <input type="hidden" name="sortby" value="star">
                <button class="dropdown-item" type="submit">
                    Terbaik
                </button>
                {{-- <a href="/products?sortby=star" class="dropdown-item" href="#">Terbaik</a> --}}
            </li>
            <li>
                <input type="hidden" name="sortby" value="bestseller">
                <button class="dropdown-item" type="submit">
                    Terlaris
                </button>
                {{-- <a href="/products?sortby=bestSeller" class="dropdown-item" href="#">Terlaris</a> --}}
            </li>
            <li>
                <input type="hidden" name="sortby" value="mostview">
                <button class="dropdown-item" type="submit">
                    Terbanyak dilihat
                </button>
                {{-- <a href="/products?sortby=view" class="dropdown-item" href="#">Dilihat Terbanyak</a> --}}
            </li>
            <li>
                <input type="hidden" name="sortby" value="pricelow">
                <button class="dropdown-item" type="submit">
                    Harga Terendah
                </button>
                {{-- <a href="/products?sortby=priceLow" class="dropdown-item" href="#">Harga Terendah</a> --}}
            </li>
            <li>
                <input type="hidden" name="sortby" value="pricehigh">
                <button class="dropdown-item" type="submit">
                    harga Tertinggi
                </button>
                {{-- <a href="/products?sortby=priceHigh" class="dropdown-item" href="#">Harga Tertinggi</a> --}}
            </li>
        </ul>
    </form>
</div>

<a class="text-decoration-none text-danger checkout-shipment-address-change-link changeAddress-a"
    href="#editAddressModal" data-bs-toggle="modal" id="changeAddress">
    Edit Alamat
</a>

<div class="form-check py-1">
    <input class="form-check-input paymentMethods shadow-none" type="radio" name="paymentMethods"
        id="paymentMethods-tf-cimb" value="cimb" required>
    <label class="form-check-label" for="paymentMethods-tf-cimb">
        Transfer Bank (CIMB Niaga)
    </label>
</div>

<div class="form-check py-1">
    <input class="form-check-input paymentMethods shadow-none" type="radio" name="paymentMethods"
        id="paymentMethods-tf-bni">
    <label class="form-check-label" for="paymentMethods-tf-bni">
        Transfer Bank (BNI)
    </label>
</div>

<div class="form-check py-1">
    <input class="form-check-input paymentMethods shadow-none" type="radio" name="paymentMethods"
        id="paymentMethods-tf-bri">
    <label class="form-check-label" for="paymentMethods-tf-bri">
        Transfer Bank (BRI)
    </label>
</div>

<div class="form-check py-1">
    <input class="form-check-input paymentMethods shadow-none" type="radio" name="paymentMethods"
        id="paymentMethods-tf-mandiri">
    <label class="form-check-label" for="paymentMethods-tf-mandiri">
        Transfer Bank (Mandiri)
    </label>
</div>

<div class="form-check py-1">
    <input class="form-check-input paymentMethods shadow-none" type="radio" name="paymentMethods"
        id="paymentMethods-tf-bca">
    <label class="form-check-label" for="paymentMethods-tf-bca">
        Transfer Bank (BCA)
    </label>
</div>

<div class="form-check py-1">
    <input class="form-check-input paymentMethods shadow-none" type="radio" name="paymentMethods"
        id="paymentMethods-cod">
    <label class="form-check-label" for="paymentMethods-cod">
        Bayar di Tempat (COD)
    </label>
</div>

<script>
    $('.ubahAlamat').each(function() {
        $(this).on("click", function() {
            console.log('a on click');
            console.log($(this).attr('id'));
        });
    });
    $('.ubahAlamat').click(function(e) {
        console.log('a click');
    });
</script>


// $('.show-payment-modal-button').bind("click", function(e) {
// e.preventDefault();
// if ($('input[name="courier-name-choosen"]').val() == '' || $(
// 'input[name="courier-service-choosen"]').val() == '' || $(
// 'input[name="courier-etd-choosen"]').val() == '' || $(
// 'input[name="courier-price-choosen"]').val() == '') {
// $('.courier-error-text').text('Pilih kurir pengirim terlebih dahulu');
// $('#paymentModal').modal('toggle');
// } else {
// $('#paymentModal').modal('toggle');
// }
// });

// dd($request);
print_r($request->product_ids);
echo "<br>";
print_r($request->cart_ids);
echo "<br>";
$userAddress = UserAddress::where([['user_id', '=', $request->user_id], ['is_active', '=', '1']])->first();

$orderAddress = OrderAddress::firstOrCreate(
[
'user_id' => $userAddress->user_id,
'name' => $userAddress->name,
'address' => $userAddress->address,
'district' => $userAddress->district,
'city_ids' => $userAddress->city_ids,
'province_ids' => $userAddress->province_ids,
'postal_code' => $userAddress->postal_code,
'telp_no' => $userAddress->telp_no,
]
);
$orderAddressId = $orderAddress->id;
echo $orderAddressId;
// dd($request->checkout_total_price);
// dd($request);
$unique_code = mt_rand(000, 999);
$estimation_day = substr($request->estimation, -1);
$estimation_date = date('Y-m-d', strtotime(date("Y-m-d") . ' ' . $estimation_day . ' days'));

$request->merge([
'order_address_id' => $orderAddressId,
'unique_code' => $unique_code,
'estimation_day' => $estimation_day,
'estimation_date' => $estimation_date,
'total_price' => $request->checkout_total_prices,
'order_status' => 'belum bayar',
'retur' => '0',
]);

$validatedData = $request->validate([
'user_id' => 'required',
'order_address_id' => 'required',
'courier' => 'required',
'courier_package_type' => 'required',
'estimation_day' => 'required',
'estimation_date' => 'required',
'courier_price' => 'required',
'total_price' => 'required',
'order_status' => 'nullable',
'retur' => 'nullable',
'unique_code' => 'required',
'payment_method_id' => 'required ',
]);
$order = Order::create($validatedData);
$order->save();
$orderId = $order->id;

// dd($orderId);

$items = CartItem::whereIn('id', $request->cart_ids)->with('product','productvariant')->get()->sortByDesc('created_at');
// dd($items);
// $request->session()->put(['order_product' => $items]);
// dd(session()->get('order_product'));
$idx=0;
foreach ($items as $key => $value) {
$idx = $idx+=1;
$orderProduct = [
'name' => $value->product->name,
'specification' => $value->product->specification,
'description' => $value->product->description,
'excerpt' => $value->product->excerpt,
'slug' => $value->product->slug,
'product_code' => $value->product->product_code,
'product_category' => $value->product->productCategory->name,
'product_merk' => $value->product->productMerk->name,
];

echo "- <strong>ID Produk : </strong>" . $value->product->id;
echo "<br>";
echo "- <strong>Nama Produk : </strong>" . $value->product->name;
echo "<br>";
echo "- <strong>Spesifikasi Produk : </strong>" . $value->product->specification;
echo "<br>";
echo "- <strong>Deskripsi Produk : </strong>" . $value->product->description;
echo "<br>";
echo "- <strong>excerpt Produk : </strong>" . $value->product->excerpt;
echo "<br>";
echo "- <strong>slug Produk : </strong>" . $value->product->slug;
echo "<br>";
echo "- <strong>Kode Produk : </strong>" . $value->product->product_code;
echo "<br>";
echo "- <strong>Kategori Produk : </strong>" . $value->product->productCategory->name;
echo "<br>";
echo "- <strong>Merk Produk : </strong>" . $value->product->productMerk->name;
echo "<br>";
echo "- <strong>ID Promo Produk : </strong>" . $value->product->promo_id;
echo "<br>";
echo "- <strong>Merk Produk : </strong>" . $value->product->productMerk->name;
echo "<br>";

$promo = Promo::where('id','=',$value->product->promo_id)->first();
$orderProduct['promo_name'] = $promo->name;
$orderProduct['promo_discount'] = $promo->discount;
echo "- <strong>***PROMO*** : </strong>";
echo "<br>";
echo "- <strong>Promo Name Produk : </strong>" . $promo->name;
echo "<br>";
echo "- <strong>Promo discount Produk : </strong>" . $promo->discount;
echo "<br>";
if ($value->product_variant_id == 0) {
echo "<br>";
echo "- <strong>variant Produk 0 : </strong>" . $value->product->price;
} else {
// $orderProduct = [
// 'variant_name' => $value->productvariant->variant_name,
// 'variant_value' => $value->productvariant->variant_value,
// 'variant_code' => $value->productvariant->variant_code,
// 'stock' => $value->productvariant->stock,
// 'weight' => $value->productvariant->weight,
// 'price' => $value->productvariant->price,
// ];
$orderProduct['variant_name'] = $value->productvariant->variant_name;
$orderProduct['variant_value'] = $value->productvariant->variant_name;
$orderProduct['variant_code'] = $value->productvariant->variant_code;
$orderProduct['stock'] = $value->productvariant->stock;
$orderProduct['weight'] = $value->productvariant->weight;
$orderProduct['price'] = $value->productvariant->price;
echo "<br>";
echo "- <strong>nama variant Produk ".$value->productvariant->id." : </strong>" . $value->productvariant->variant_name;
echo "<br>";
echo "- <strong>value variant Produk ".$value->productvariant->id." : </strong>" .
$value->productvariant->variant_value;
echo "<br>";
echo "- <strong>kode variant Produk ".$value->productvariant->id." : </strong>" . $value->productvariant->variant_code;
echo "<br>";
echo "- <strong>stock variant Produk ".$value->productvariant->id." : </strong>" . $value->productvariant->stock;
echo "<br>";
echo "- <strong>berat variant Produk ".$value->productvariant->id." : </strong>" . $value->productvariant->weight;
echo "<br>";
echo "- <strong>harga variant Produk ".$value->productvariant->id." : </strong>" . $value->productvariant->price;
}
$orderProducts = OrderProduct::firstOrCreate($orderProduct);
$orderProductId = $orderProducts->id;
$orderProductIds[] = $orderProducts->id;
// echo "<br>";
print_r($orderProduct);
echo "<br><br><br><br>";
// echo $value->product->name;
// echo "<br><br>";
// echo $value->product->specification;
// echo "<br><br>";
// echo $value->product->description;
// echo "<br><br>";
// echo $value->product->excerpt;
// echo "<br><br>";
// echo $value->product->slug;
// echo "<br><br>";
// echo $value->product->product_code;
// echo "<br><br>";
// // echo $value->product->product_category_id->name;
// echo "<br><br>";
// echo $value->product->specification;
// echo "<br><br>";
// echo $value->product->specification;
// echo "<br><br>";
// echo $value->product->specification;
// echo "<br><br>";
// echo $value->product->specification;
// echo "<br><br>";
// echo $value->product->specification;
// echo "<br><br>";
// echo $value->product->specification;
// echo "<br><br>";
// echo $value->product->specification;
// echo "<br><br>";
// echo $value->product->specification;
echo "<br>---------------------<br>";
$data = [
'order_id' => $orderId,
'user_id' => $request->user_id,
'product_id' => $value->product_id,
'product_variant_id' => $value->product_variant_id,
'order_product_id' => $orderProductId,
'quantity' => $value->quantity,
'total_price_item' => $value->subtotal,
'order_item_status' => 'belum bayar',
'retur' => '0',
];

if ($value->product_variant_id == 0) {
$data['price'] = $value->product->price;
} else {
$data['price'] = $value->productvariant->price;
}

$orderItems = OrderItem::create($data);
}

foreach ($request->cart_ids as $ids) {
$deleteCartItem = CartItem::where('id',$ids)->delete();
}

// $products = Product::whereIn('id',
$request->product_ids)->with('productvariant','promo')->get()->sortByDesc('created_at');
// foreach ($products as $key => $value) {

// $orderProduct['promo_name'] = $value->promo->name;
// $orderProduct['promo_discount'] = $value->promo->discount;
// // $promo = OrderProduct::where('id', '=', $orderProductIds)->update([
// // 'promo_name' => $orderProduct['promo_name'],
// // 'promo_discount' => $orderProduct['promo_discount']
// // ]);

// echo "<br>";
// echo "- <strong>ID Produk Promo : </strong>" . $value->id;
// echo "<br>";
// echo "- <strong>ID Promo Produk : </strong>" . $value->promo->id;
// echo "<br>";
// echo "- <strong>Nama Promo Produk : </strong>" . $value->promo->name;
// echo "<br>";
// echo "- <strong>Diskon Promo Produk : </strong>" . $value->promo->discount;
// echo "<br>";
// print_r($orderProduct);
// echo "<br>";

// // echo "- <strong>Nama Produk : </strong>" . $value->name;
// // echo "<br>";
// // echo "- <strong>Spesifikasi Produk : </strong>" . $value->specification;
// // echo "<br>";
// // echo "- <strong>Deskripsi Produk : </strong>" . $value->description;
// // echo "<br>";
// // echo "- <strong>excerpt Produk : </strong>" . $value->excerpt;
// // echo "<br>";
// // echo "- <strong>slug Produk : </strong>" . $value->slug;
// // echo "<br>";
// // echo "- <strong>Kode Produk : </strong>" . $value->product_code;
// // echo "<br>";
// // echo "- <strong>Kategori Produk : </strong>" . $value->productCategory->name;
// // echo "<br>";
// // echo "- <strong>Merk Produk : </strong>" . $value->productMerk->name;
// // echo "<br>";
// // if ($value->product_variant_id == 0) {
// // echo "<br>";
// // echo "- <strong>variant Produk 0 : </strong>" . $value->price;
// // } else {
// // echo "<br>";
// // echo "- <strong>nama variant Produk ".$value->productvariant->id." : </strong>" .
$value->productvariant->variant_name;
// // echo "<br>";
// // echo "- <strong>value variant Produk ".$value->productvariant->id." : </strong>" .
$value->productvariant->variant_value;
// // echo "<br>";
// // echo "- <strong>kode variant Produk ".$value->productvariant->id." : </strong>" .
$value->productvariant->variant_code;
// // echo "<br>";
// // echo "- <strong>stock variant Produk ".$value->productvariant->id." : </strong>" . $value->productvariant->stock;
// // echo "<br>";
// // echo "- <strong>berat variant Produk ".$value->productvariant->id." : </strong>" . $value->productvariant->weight;
// // echo "<br>";
// // echo "- <strong>harga variant Produk ".$value->productvariant->id." : </strong>" . $value->productvariant->price;
// // }
// }
// echo "<br><br><br><br>";
// // echo "- <strong>Nama Produk : </strong>".$value->name;
// // echo "<br>";
// // echo "- <strong>Spesifikasi Produk : </strong>".$value->specification;
// // echo "<br>";
// // echo "- <strong>Deskripsi Produk : </strong>".$value->description;
// // echo "<br>";
// // echo "- <strong>excerpt Produk : </strong>".$value->excerpt;
// // echo "<br>";
// // echo "- <strong>slug Produk : </strong>".$value->slug;
// // echo "<br>";
// // echo "- <strong>Kode Produk : </strong>".$value->product_code;
// // echo "<br>";
// // echo "- <strong>Kategori Produk : </strong>".$value->productCategory->name;
// // echo "<br>";
// // echo "- <strong>Merk Produk : </strong>".$value->productMerk->name;
// // echo "<br>";
// // echo "- <strong>variant Produk : </strong>".$value->productvariant;
// // echo "<br><br><br><br>";
// }

// print_r($orderItemsIds);
<button class="btn mb-3 checkout-courier-button w-100 p-4 " data-bs-toggle="modal" data-bs-target="#courierModal">
    <div class="row d-flex align-items-center">
        <div class="col-md-10 col-12 text-start">
            <div class="checkout-courier-label m-0">
                <p class="m-0 d-inline-block modal-courier-type pe-1 fw-bold">' +
                    courier.toUpperCase() +
                    '</p>
                <p class="m-0 d-inline-block modal-courier-package fw-bold">' +
                    service +
                    '</p>
                <p class="m-0">Akan tiba dalam ' + etd.replace(' HARI', '') +
                    ' hari dari pengiriman</p>
            </div>
        </div>
        <div class="col-md-2 col-12">
            <p class="m-0 text-danger checkout-courier-cost text-start my-2 fw-bold"><span
                    class="checkout-courier-cost">' +
                    formatRupiah(price, "Rp") +
                    '</span></p>
        </div>
    </div><input type="hidden" name="courier-name"
        value="' +
            courier.toUpperCase() +
            '"><input type="hidden" name="courier-service"
        value="' + service +
            '"><input type="hidden" name="courier-etd"
        value="' + etd +
            '"><input type="hidden" name="courier-price"
        value="' + price +
            '"></div>
</button>

<div class="order-courier-payment mb-4 box-shadows">
    <div class="card border-radius-075rem fs-14">
        <div class="card-header bg-transparent py-3">
            <p class="m-0 fw-bold">Kurir Pengirim</p>
        </div>
        <div class="card-body p-4">
            @foreach ($orders as $order)
                <div class="row d-flex align-items-center">
                    <div class="col-md-9 col-8 text-start">
                        <div class="checkout-courier-label m-0">
                            <p class="m-0 d-inline-block modal-courier-type pe-1 fw-bold">
                                {{ $order->courier }}
                            </p>
                            <p class="m-0 d-inline-block modal-courier-package fw-bold">
                                {{ $order->courier_package_type }}
                            </p>
                            <p class="m-0">
                                Perkiraan tiba dalam {{ $order->estimation_day }} hari /
                                {{ \Carbon\Carbon::parse($order->estimation_date)->isoFormat('dddd,D MMMM Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-4 text-end">
                        <p class="m-0 text-danger checkout-courier-cost my-2 fw-bold">
                            <span class="checkout-courier-cost">
                                Rp{{ price_format_rupiah($order->courier_price) }}
                            </span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row">
    {{-- <div class="col-md-1 col-1">
                                                    span class="me-1">
                                                    </span>
                                                </div> --}}
    <div class="col-md-3 col-6">
        <i class="bi bi-record-circle"></i>
        <span>
            {{ \Carbon\Carbon::parse($statusDetail->status_date)->isoFormat('D MMMM Y, HH:mm') }}
            WIB
        </span>
    </div>
    {{-- <div class="col-md-1 col-1">
                                                </div> --}}
    <div class="col-md-9 col-6">
        <span class="mx-1">
            <i class="bi bi-dash-lg"></i>
        </span>
        <span class="d-inline-block">
            <div class="{{ $loop->first ? 'text-danger' : '' }}">
                {{ $statusDetail->status }}
            </div>
            <div class="fs-12">
                {{ $statusDetail->status_detail }}
            </div>
        </span>
    </div>
</div>


{{-- <div class="card-header bg-transparent py-3 fw-bold">
                            
                            Status Pesanan<p class="m-0 fw-bold">{{ $order->order_status }}</p>
                        </div> --}}

let date = new Date(Date.UTC(2022, 05, 24, 15, 0, 0));

console.log('Given IST datetime: ' + date);

let intlDateObj = new Intl.DateTimeFormat('en-US', {
timeZone: "Asia/Jakarta"
});

let usaTime = intlDateObj.format(date);
console.log('USA date: ' + usaTime);

const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
console.log(timezone);

let wibTimeZone =new Date("{{ $orders[0]->payment_due_date }}").toLocaleString("en-US", {timeZone: "Asia/Jakarta"});
console.log('WIB datetime: ' + wibTimeZone);
var nowWITA = new Date().toLocaleString("en-US", {timeZone: "Asia/Jakarta"});
var nowWIB = nowWITA.getTime();
console.log('WITA datetime: ' + nowWIB);

{{-- detail - detail pesanan --}}
<div class="row d-none d-sm-block">
    <div class="col-md-12 mb-2 d-flex">
        <span class="me-1">
            <i class="bi bi-record-circle"></i>
        </span>
        <span>
            {{ \Carbon\Carbon::parse($statusDetail->status_date)->isoFormat('D MMMM Y, HH:mm') }}
            WIB
        </span>
        <span class="mx-1">
            <i class="bi bi-dash-lg"></i>
        </span>
        <span class="d-inline-block">
            <div class="{{ $loop->first ? 'text-danger' : '' }} fw-500">
                {{ $statusDetail->status }}
            </div>
            <div class="fs-12 text-grey">
                {{ $statusDetail->status_detail }}
            </div>
        </span>
        <span class="">
        </span>
    </div>
</div>

{{-- buy-now.blade --}}
@extends('layouts.main')
@section('container')
    <script type="text/javascript">
        function disableBack() {
            window.history.forward();
        }
        setTimeout("disableBack()", 0);
        window.onunload = function() {
            null
        };
    </script>
    <div class="container-fluid breadcrumb-products">
        {{ Breadcrumbs::render('buy.now') }}
    </div>
    {{-- {{ print_r(session()->all()) }} --}}
    {{-- {{ dd($userAddress) }} --}}
    {{-- {{ dd($itemBuyNow) }} --}}
    {{-- {{ is_null($itemBuyNow[0]->id) ? 'null' : $itemBuyNow[0]->id }} --}}
    <div class="container mb-5">
        <div class="checkout my-5">

            <div class="row my-3">
                <div class="col-12">
                    <a href="{{ route('cart.index') }}" class="text-decoration-none link-dark">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <div class="col-12">
                @if (session()->has('successChangeAddress'))
                    <div class="alert alert-success alert-dismissible fade show alert-success-cart" role="alert">
                        {{ session('successChangeAddress') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session()->has('failedChangeAddress'))
                    <div class="alert alert-danger alert-dismissible fade show alert-success-cart" role="alert">
                        {{ session('failedChangeAddress') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-md-8 col-12">
                    <h5 class="mb-3">Alamat Pengiriman</h5>
                    <div class="card checkout-address-card mb-4">
                        <div class="card-body p-4">
                            <div class="row d-flex align-items-center">
                                @if (count(auth()->user()->useraddress) > 0)
                                    <div class="col-md-10">
                                        {{-- <p class="m-0 mb-2 checkout-shipment-address-text">
                                        Alamat Pengiriman
                                    </p> --}}
                                        <div class="checkout-shipment-address">
                                            @foreach ($userAddress as $address)
                                                @if ($address->is_active == 1)
                                                    <p class="m-0 checkout-shipment-address-name">
                                                        {{ $address->name }}
                                                    </p>
                                                    <p class="m-0 checkout-shipment-address-phone">
                                                        {{ $address->telp_no }}
                                                    </p>
                                                    <p class="m-0 checkout-shipment-address-address">
                                                        {{ $address->address }}
                                                    </p>
                                                    <div class="checkout-shipment-address-city">
                                                        <span class="m-0 me-1 ">
                                                            {{ $address->city->name }},
                                                        </span>
                                                        <span class="m-0 checkout-shipment-address-province">
                                                            {{ $address->province->name }}
                                                        </span>
                                                        <span class="m-0 checkout-shipment-address-postalcode">
                                                            {{ !empty($address->postal_code) ? ', ' . $address->postal_code : '' }}
                                                        </span>
                                                    </div>
                                                    <div class="input-data">
                                                        <input class="city-origin" type="hidden" name="cityOrigin"
                                                            value="36">
                                                        <input class="address-id" type="hidden" name="addressId"
                                                            value="{{ $address->id }}">
                                                        <input class="city-destination" type="hidden"
                                                            name="cityDestination" value="{{ $address->city->city_id }}">
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button"
                                            class="btn shadow-none checkout-change-shipment-address p-0 py-3"
                                            data-bs-toggle="modal" data-bs-target="#addressModal">
                                            Ubah Alamat
                                        </button>
                                    </div>
                                @else
                                    <div class="col-md-12">
                                        <div class="product-no-auth-shipment-check">
                                            Kamu belum menambahkan alamat, yuk
                                            <a href="{{ route('useraddress.index') }}"
                                                class="text-decoration-none fw-bold login-link">
                                                Tambahkan Alamat
                                            </a>
                                            untuk melihat biaya ongkir ke lokasimu
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <h5 class="my-3">Produk yang dipesan</h5>
                    <div class="mb-4">
                        @foreach ($itemBuyNow as $item)
                            <div class="card mb-3 checkout-items-card">
                                <div class="card-body p-4">
                                    <div class="row d-flex align-items-center justify-content-center text-center">
                                        <div class="col-md-2 col-4 pe-0">
                                            <img class="checkout-items-img"
                                                src="https://source.unsplash.com/400x400?product-1" class="img-fluid"
                                                alt="..." width="70">
                                        </div>
                                        <div class="col-md-4 col-8 ps-0">
                                            <div class="checkout-items-product-info text-start">
                                                <p class="text-truncate checkout-items-product-name m-0">
                                                    {{ $item->product->name }}
                                                </p>
                                                <p class="text-truncate checkout-items-product-variant">
                                                    Varian:
                                                    @if (!is_null($item->productVariant))
                                                        {{ $item->productVariant->variant_name }}
                                                    @else
                                                        Tidak ada varian
                                                    @endif
                                                </p>
                                                {{-- <p class="checkout-items-price">
                                                <input type="hidden" name="price-checkout-items-val-{{ $item->id }}"
                                                    class="price-checkout-items-val-{{ $item->id }}"
                                                    value="{{ isset($item->productVariant) ? $item->productVariant->weight : $item->product->weight }}">
                                                @if (isset($item->productVariant))
                                                    {{ $item->productVariant->weight }}
                                                @else
                                                    {{ $item->product->weight }}
                                                @endif
                                                (gr)
                                            </p> --}}
                                                <p class="checkout-items-price text-truncate">
                                                    <input type="hidden"
                                                        name="price-checkout-items-val-{{ $item->id }}"
                                                        class="price-checkout-items-val-{{ $item->id }}"
                                                        value="{{ isset($item->productVariant) ? $item->productVariant->price : $item->product->price }}">
                                                    @if (isset($item->productVariant))
                                                        Rp{{ price_format_rupiah($item->productVariant->price) }}
                                                    @else
                                                        Rp{{ price_format_rupiah($item->product->price) }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-4 my-3">
                                            <p class="m-0 checkout-items-weight-text">
                                                Berat Produk
                                            </p>
                                            <p class="m-0 checkout-items-weight-val">
                                                <input type="hidden" name="price-checkout-items-val-{{ $item->id }}"
                                                    class="price-checkout-items-val-{{ $item->id }}"
                                                    value="{{ isset($item->productVariant) ? $item->productVariant->weight : $item->product->weight }}">
                                                @if (isset($item->productVariant))
                                                    {{ $item->productVariant->weight }}
                                                    @php
                                                        $weight[] = $item->productVariant->weight * $item->quantity;
                                                    @endphp
                                                @else
                                                    {{ $item->product->weight }}
                                                    @php
                                                        $weight[] = $item->product->weight * $item->quantity;
                                                    @endphp
                                                @endif
                                                (gr)
                                            </p>
                                        </div>
                                        <div class="col-md-2 col-4 my-3">
                                            <p class="m-0 checkout-items-qty-text">
                                                Jumlah
                                            </p>
                                            <p class="m-0 checkout-items-qty-val">
                                                {{ $item->quantity }}
                                            </p>
                                        </div>
                                        <div class="col-md-2 col-4 my-3">
                                            <input type="hidden" name="subtotal-cart-items-val-{{ $item->id }}"
                                                class="subtotal-cart-items-val-{{ $item->id }}"
                                                value="{{ price_format_rupiah($item->subtotal) }}">
                                            <input type="hidden"
                                                name="subtotal-cart-items-val-noformat-{{ $item->id }}"
                                                class="subtotal-cart-items-val-noformat-{{ $item->id }}"
                                                value="{{ $item->subtotal }}">
                                            <p class="cart-items-subtotal">
                                                Subtotal
                                            </p>
                                            <p class="subtotal-cart-items-{{ $item->id }} text-danger cart-items-subtotal fw-bold"
                                                id="subtotal-cart-items-single">
                                                Rp{{ price_format_rupiah($item->subtotal) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="input-data-item">
                            <input class="csrf-token" type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                            <input class="total-weight" type="hidden" name="total_weight"
                                value="{{ array_sum($weight) }}">
                            <input class="total-subtotal" type="hidden" name="total_subtotal"
                                value="{{ is_null($itemBuyNow[0]->id) ? $itemBuyNow[0]->subtotal : $itemBuyNow->sum('subtotal') }}">
                            <input class="courier" type="hidden" name="courier" value="all">
                        </div>
                    </div>
                    <h5 class="my-3">Pengiriman</h5>
                    <div class="courier-choice" id="courier-choice">
                        <div class="card mb-3 checkout-courier-card">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <p class="m-0 checkout-courier-loading-text">
                                        Memuat data...
                                    </p>
                                    <div class="spinner-border ms-auto checkout-courier-loading" role="status"
                                        aria-hidden="true"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="courier-error">
                        <p class="text-danger m-0 courier-error-text"></p>
                    </div>

                    <div class="modal fade" id="courierModal" tabindex="-1" aria-labelledby="courierModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content checkout-courier-modal">
                                <div class="modal-header border-0 p-4">
                                    <h5 class="modal-title m-0" id="courierModalLabel">Pilihan Kurir Pengirim</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4 courier-modal-body">

                                </div>
                                <div class="modal-footer border-0 p-4">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content checkout-address-modal">
                                <div class="modal-header border-0 p-4">
                                    <h5 class="modal-title m-0" id="addressModalLabel">Pilih Alamat</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="col-12 mb-3">
                                        <a href="{{ route('useraddress.create') }}" target="_blank"
                                            class="btn btn-danger profile-address-change-btn py-2 px-3">
                                            <p>
                                                <i class="bi bi-plus-lg"></i> Tambah Alamat
                                            </p>
                                        </a>
                                    </div>
                                    @foreach ($userAddress as $address)
                                        <form action="{{ route('useraddress.change.active') }}" method="post">
                                            @csrf
                                            <div
                                                class="card mb-4 checkout-address-card-change  {{ $address->is_active == 1 ? 'border border-danger' : '' }}">
                                                <div class="card-body p-0 p-4">
                                                    <div class="row">
                                                        <div class="col-md-10 checkout-shipment-address">
                                                            <p class="m-0 checkout-shipment-address-name">
                                                                {{ $address->name }}
                                                            </p>
                                                            <p class="m-0 checkout-shipment-address-phone">
                                                                {{ $address->telp_no }}
                                                            </p>
                                                            <p class="m-0 checkout-shipment-address-address">
                                                                {{ $address->address }}
                                                            </p>
                                                            <div class="checkout-shipment-address-city">
                                                                <span class="m-0 me-1 ">
                                                                    {{ $address->city->name }},
                                                                </span>
                                                                <span class="m-0 checkout-shipment-address-province me-1">
                                                                    {{ $address->province->name }},
                                                                </span>
                                                                <span class="m-0 checkout-shipment-address-postalcode">
                                                                    {{ $address->city->postal_code }}
                                                                </span>
                                                            </div>
                                                            <div class="input-data">
                                                                <input class="address-id" type="hidden" name="addressId"
                                                                    value="{{ $address->id }}">
                                                                <input class="user-id" type="hidden" name="userId"
                                                                    value="{{ auth()->user()->id }}">
                                                                <input class="city-origin" type="hidden"
                                                                    name="cityOrigin" value="36">
                                                                <input class="city-destination" type="hidden"
                                                                    name="cityDestination"
                                                                    value="{{ $address->city->city_id }}">
                                                                <input type="hidden" name="index"
                                                                    value="{{ $loop->index }}">
                                                            </div>
                                                            <div class=" mt-2 d-flex align-items-center">
                                                                @if ($address->is_active != 1)
                                                                    <button type="submit"
                                                                        class="btn m-0 p-0 text-decoration-none text-danger checkout-shipment-address-change-link shadow-none"
                                                                        data-bs-toggle="modal" role="button">
                                                                        Pilih Alamat
                                                                    </button>
                                                                    <span class="text-secondary mx-1"> | </span>
                                                                @endif
                                                                <a href="{{ route('useraddress.edit', $address) }}"
                                                                    target="_blank"
                                                                    class="ubahAlamat text-decoration-none text-danger checkout-shipment-address-change-link">Edit
                                                                    Alamat</a>
                                                            </div>
                                                        </div>
                                                        @if ($address->is_active == 1)
                                                            <div
                                                                class="col-md-2 d-flex align-items-center text-danger checkout-shipment-address-active">
                                                                <p class="m-0 my-2 fw-bold">digunakan</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    {{-- </label> --}}
                                                </div>
                                            </div>
                                        </form>
                                    @endforeach
                                </div>
                                <div class="modal-footer border-0 p-4">
                                    {{-- <button type="submit" class="btn btn-secondary checkout-shipment-address-cancel-btn p-2"
                                        data-bs-dismiss="modal">
                                        <p>
                                            Batal
                                        </p>
                                    </button>
                                    <button type="submit" class="btn btn-danger checkout-shipment-address-change-btn p-2">
                                        <p>
                                            Pilih Alamat
                                        </p>
                                    </button> --}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="paymentModal" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                        <div class="modal-content payment-method-modal">
                            <form class="payment-form" action="{{ route('order.store') }}" method="POST"
                                onSubmit="return confirm('Apakah anda yakin Data Pemesanan anda sudah benar (Alamat Pengiriman, Produk Pesanan, dan Kurir Pengiriman)?');">
                                @csrf

                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="product_id" value="{{ $itemBuyNow[0]->product_id }}">
                                <input type="hidden" name="product_variant_id"
                                    value="{{ $itemBuyNow[0]->product_variant_id }}">
                                <input type="hidden" name="quantity" value="{{ $itemBuyNow[0]->quantity }}">
                                <input type="hidden" name="subtotal" value="{{ $itemBuyNow[0]->subtotal }}">
                                {{-- 'user_id' => 'required',
                                'product_id' => 'required',
                                'product_variant_id' => 'required',
                                'quantity' => 'required',
                                'subtotal' => 'required', --}}

                                <input type="hidden" class="courier" name="courier" value="">
                                <input type="hidden" class="courier_package_type" name="courier_package_type"
                                    value="">
                                <input type="hidden" class="estimation" name="estimation" value="">
                                <input type="hidden" class="courier_price" name="courier_price" value="">

                                @foreach ($itemBuyNow as $item)
                                    {{-- <input type="hidden" name="cart_ids[{{ $carts->id }}]" value=""> --}}
                                    <input type="hidden" name="cart_ids[{{ $item->id }}]"
                                        value="{{ $item->id }}">
                                    <input type="hidden" name="product_ids[{{ $item->product->id }}]"
                                        value="{{ $item->product->id }}">
                                    {{-- <input type="hidden" name="ids[]" value="{{ $carts->id }}"> --}}
                                @endforeach

                                <div class="modal-header p-4 border-0">
                                    <h5 class="modal-title m-0" id="addressModalLabel">Pilih Metode Pembayaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-5">
                                            <div class="d-flex mb-2">
                                                <p class="m-0 fw-bold">Metode pembayaran yang tersedia</p>
                                                {{-- <a href="#"
                                                class="text-decoration-none text-danger fw-bold ms-auto text-end">Lihat
                                                Semua</a> --}}
                                            </div>
                                            @foreach ($paymentMethods as $paymentMethod)
                                                <div class="form-check py-1">
                                                    <input class="form-check-input paymentMethods shadow-none"
                                                        type="radio" name="payment_method_id"
                                                        id="paymentMethods-tf-{{ $paymentMethod->type }}-{{ $paymentMethod->name }}"
                                                        value="{{ $paymentMethod->id }}" required>
                                                    <label class="form-check-label"
                                                        for="paymentMethods-tf-{{ $paymentMethod->type }}-{{ $paymentMethod->name }}">
                                                        {{ $paymentMethod->type }} {{ $paymentMethod->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-6 col-12 mb-5">
                                            <div class="mb-2">
                                                <p class="m-0 fw-bold">Ringkasan Pembayaran</p>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="checkout-payment-total-price-text m-0">
                                                        Total Harga ({{ count($itemBuyNow) }}) Produk</p>
                                                </div>
                                                {{-- <div
                                                class="col-6 checkout-total-all-val checkout-total-all-val text-end">
                                            </div> --}}
                                                <div class="col-6 text-end checkout-payment-total-price-val">
                                                    Rp{{ price_format_rupiah(is_null($itemBuyNow[0]->id) ? $itemBuyNow[0]->subtotal : $itemBuyNow->sum('subtotal')) }}
                                                    {{-- Rp{{ price_format_rupiah($itemBuyNow['subtotal']) }} --}}
                                                </div>
                                                <input type="hidden" name="checkout_total_prices"
                                                    value="{{ is_null($itemBuyNow[0]->id) ? $itemBuyNow[0]->subtotal : $itemBuyNow->sum('subtotal') }}">
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-7 checkout-payment-weight-text">
                                                    Berat total: <span class="total-weight-checkout"></span>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-7 checkout-payment-shipment-text pe-0">
                                                </div>
                                                <div class="col-5 checkout-payment-shipment-val text-end">
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-7 checkout-payment-courier-text">
                                                </div>
                                            </div>

                                            {{-- <div class="row mb-2">
                                                <div class="col-6">
                                                    <p class="checkout-payment-unique-code-text m-0">
                                                        Kode Unik
                                                    </p>
                                                </div>
                                                <div class="col-6 checkout-payment-unique-code-val text-end">
                                                    Rp{{ $unique_code }}
                                                </div>
                                                <input type="hidden" name="checkout_unique_code"
                                                    value="{{ $unique_code }}">
                                            </div> --}}

                                            <div class="my-3 border border-1 border-bottom checkout-checkout-divider">
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="checkout-total-all-text checkout-payment-total-all-text m-0">
                                                        Total Harga</p>
                                                </div>
                                                <div class="col-6 checkout-payment-total-all-val text-end fw-bold">
                                                </div>
                                                <input type="hidden" name="checkout_payment_total_price" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 p-4">
                                    <button type="button" class="btn btn-secondary show-payment-modal-button"
                                        data-bs-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn btn-danger show-payment-modal-button">Lanjutkan
                                        Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- checkout card only on tab and desktop --}}
                <div class="col-md-4 col-12 mt-4 checkout-total-div d-none d-sm-block">
                    <div class="card mt-3 checkout-total-card sticky-md-top">
                        <div class="card-body">
                            <form action="{{ route('checkout.payment') }}" onsubmit="return validateCheckout()"
                                method="POST">
                                @csrf

                                @foreach ($itemBuyNow as $item)
                                    <input type="hidden" name="product-id[]" value="{{ $item->id }}">
                                @endforeach

                                @foreach ($weight as $weightItem)
                                    <input type="hidden" name="product-weight[]" value="{{ $weightItem }}">
                                @endforeach

                                <input type="hidden" name="user-id" value="{{ auth()->user()->id }}">

                                <div class="input-data-shipment">

                                    @foreach ($userAddress as $address)
                                        @if ($address->is_active == 1)
                                            <input class="address-id" type="hidden" name="addressId"
                                                value="{{ $address->id }}">
                                            <input class="city-origin" type="hidden" name="cityOrigin" value="36">
                                            <input class="city-destination" type="hidden" name="cityDestination"
                                                value="{{ $address->city->city_id }}">
                                        @endif
                                    @endforeach

                                    <input type="hidden" class="courier-name-choosen" name="courier-name-choosen"
                                        value="">
                                    <input type="hidden" class="courier-service-choosen" name="courier-service-choosen"
                                        value="">
                                    <input type="hidden" class="courier-etd-choosen" name="courier-etd-choosen"
                                        value="">
                                    <input type="hidden" class="courier-price-choosen" name="courier-price-choosen"
                                        value="">
                                </div>

                                <div class="input-data-item-detail">
                                    <input class="csrf-token" type="hidden" name="csrf_token"
                                        value="{{ csrf_token() }}">
                                    <input class="total-weight" type="hidden" name="total_weight"
                                        value="{{ array_sum($weight) }}">
                                    <input class="total-subtotal" type="hidden" name="total_subtotal"
                                        value="{{ is_null($itemBuyNow[0]->id) ? $itemBuyNow[0]->subtotal : $itemBuyNow->sum('subtotal') }}">
                                    <input class="courier" type="hidden" name="courier" value="all">
                                </div>

                                <h5 class="cart-items-checkout-header cart-items-checkout-header mt-1 mb-4">Ringkasan
                                    Pesanan</h5>
                                <div class="row">
                                    <div class="col-7 checkout-items-total-text cart-items-total-text pe-0">
                                        Total Harga ({{ count($itemBuyNow) }}) Produk
                                    </div>
                                    <div class="col-5 cart-items-total-val text-end">
                                        Rp{{ price_format_rupiah(is_null($itemBuyNow[0]->id) ? $itemBuyNow[0]->subtotal : $itemBuyNow->sum('subtotal')) }}
                                        {{-- Rp{{ price_format_rupiah($itemBuyNow['subtotal']) }} --}}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div
                                        class="col-7 checkout-items-text cart-items-total-text pe-0 total-weight-checkout-text">
                                        Berat total: <span class="total-weight-checkout"></span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-7 checkout-shipment-total-text cart-items-total-text pe-0">
                                    </div>
                                    <div class="col-5 checkout-shipment-total-val cart-items-total-val text-end">
                                    </div>
                                </div>
                                <div class="my-4 border border-1 border-bottom cart-items-checkout-divider">
                                </div>
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <p class="checkout-total-all-text cart-items-checkout-total-all-text m-0">
                                            Total Harga</p>
                                    </div>
                                    <div class="col-6 checkout-total-all-val cart-items-total-all-val text-end fw-bold">
                                    </div>
                                    <input type="hidden" name="checkout_total_price" value="">
                                </div>
                                <div class="d-grid">
                                    {{-- <button type="button"
                                        class="btn btn-block checkout-button show-payment-modal-button shadow-none">
                                        Pilih Metode Pembayaran
                                    </button> --}}
                                    <button type="button"
                                        class="btn btn-block checkout-button show-payment-modal-button shadow-none"
                                        data-bs-toggle="modal" data-bs-target="#paymentModal">
                                        Pilih Metode Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- checkout card only on small device / smartphone --}}
                <div class="fixed-bottom col-12 mb-5 p-0 checkout-total-div d-block d-sm-none">
                    <div class="card my-2 checkout-total-card sticky-md-top">
                        <div class="card-body">
                            <a href="#" class="btn active d-block pt-0 expand-checkout-bill shadow-none"
                                role="button" data-bs-toggle="button" aria-pressed="true">
                                Detail <i class="bi bi-chevron-up mx-2 expand-checkout-bill-chevron"></i>
                            </a>
                            <form class="checkout-bill-form d-none" action="{{ route('checkout.payment') }}"
                                onsubmit="return validateCheckout()" method="POST">
                                @csrf
                                @foreach ($itemBuyNow as $item)
                                    <input type="hidden" name="product-id[]" value="{{ $item->id }}">
                                    {{-- <input type="hidden" name="product-qty[]" value="{{ $item->quantity }}">
                                    <input type="hidden" name="product-subtotal[]" value="{{ $item->subtotal }}"> --}}
                                @endforeach

                                @foreach ($weight as $weightItem)
                                    <input type="hidden" name="product-weight[]" value="{{ $weightItem }}">
                                @endforeach

                                <input type="hidden" name="user-id" value="{{ auth()->user()->id }}">

                                <div class="input-data-shipment">

                                    @foreach ($userAddress as $address)
                                        @if ($address->is_active == 1)
                                            <input class="address-id" type="hidden" name="addressId"
                                                value="{{ $address->id }}">
                                            <input class="city-origin" type="hidden" name="cityOrigin" value="36">
                                            <input class="city-destination" type="hidden" name="cityDestination"
                                                value="{{ $address->city->city_id }}">
                                        @endif
                                    @endforeach

                                    <input type="hidden" class="courier-name-choosen" name="courier-name-choosen"
                                        value="">
                                    <input type="hidden" class="courier-service-choosen"
                                        name="courier-service-choosen" value="">
                                    <input type="hidden" class="courier-etd-choosen" name="courier-etd-choosen"
                                        value="">
                                    <input type="hidden" class="courier-price-choosen" name="courier-price-choosen"
                                        value="">
                                </div>

                                <div class="input-data-item-detail">
                                    <input class="csrf-token" type="hidden" name="csrf_token"
                                        value="{{ csrf_token() }}">
                                    <input class="total-weight" type="hidden" name="total_weight"
                                        value="{{ array_sum($weight) }}">
                                    <input class="total-subtotal" type="hidden" name="total_subtotal"
                                        value="{{ is_null($itemBuyNow[0]->id) ? $itemBuyNow[0]->subtotal : $itemBuyNow->sum('subtotal') }}">
                                    <input class="courier" type="hidden" name="courier" value="all">
                                </div>

                                <h5 class="cart-items-checkout-header cart-items-checkout-header mt-1 mb-4">Ringkasan
                                    Pesanan</h5>
                                <div class="row">
                                    <div class="col-7 checkout-items-total-text cart-items-total-text pe-0">
                                        Total Harga ({{ count($itemBuyNow) }}) Produk
                                    </div>
                                    <div class="col-5 cart-items-total-val text-end">
                                        Rp{{ price_format_rupiah(is_null($itemBuyNow[0]->id) ? $itemBuyNow[0]->subtotal : $itemBuyNow->sum('subtotal')) }}
                                        {{-- Rp{{ price_format_rupiah($itemBuyNow['subtotal']) }} --}}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div
                                        class="col-7 checkout-items-text cart-items-total-text pe-0 total-weight-checkout">
                                        Berat total: <span class="total-weight-checkout"></span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-7 checkout-shipment-total-text cart-items-total-text pe-0">
                                    </div>
                                    <div class="col-5 checkout-shipment-total-val cart-items-total-val text-end">
                                    </div>
                                </div>
                                <div class="my-4 border border-1 border-bottom cart-items-checkout-divider">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="checkout-total-all-text cart-items-checkout-total-all-text mt-1 mb-4">
                                            Total harga</p>
                                    </div>
                                    <div class="col-6 checkout-total-all-val cart-items-total-all-val text-end fw-bold">
                                    </div>
                                    <input type="hidden" name="checkout_total_price" value="">
                                </div>
                                <div class="d-grid">
                                    {{-- <button type="button"
                                        class="btn btn-block checkout-button show-payment-modal-button shadow-none">
                                        Pilih Metode Pembayaran
                                    </button> --}}
                                    <button type="button"
                                        class="btn btn-block checkout-button show-payment-modal-button shadow-none"
                                        data-bs-toggle="modal" data-bs-target="#paymentModal">
                                        Pilih Metode Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        function validateCheckout() {

            if (courierName == '' || courierService == '' || courierETD == '' || courierPrice == '') {
                $('.courier-error-text').text('Pilih kurir pengirim terlebih dahulu');
                alert('Pilih kurir pengirim terlebih dahulu');
                return false;
            }
        }

        $(window).on('load', function() {
            var token = $('.csrf-token').val();
            var city_origin = $('.city-origin').val();
            var city_destination = $('.city-destination').val();
            var weight = $('.total-weight').val();
            console.log(weight + ' g');
            $('.total-weight-checkout').text(Math.round(parseInt(weight) / 1000) + ' kg');
            // $('.total-weight-checkout').text((parseInt(weight)/1000) +' kg');
            var courier = $('.courier').val();

            console.log(token);
            console.log(city_origin);
            console.log(city_destination);
            console.log(courier);
            console.log(weight);

            $.fn.shipment_cost_checkout(token, city_origin, city_destination, courier, weight);
        });

        $(document).ready(function() {
            $('body').on('change', 'input:radio[name="checkout-courier-input"]', function() {
                var cart_id = [];
                $.each($('input:radio[name="checkout-courier-input"]:checked'), function() {

                    var courier = $('input[name="courier-name-' + $(this).val() + '"]').val();
                    var service = $('input[name="courier-service-' + $(this).val() + '"]').val();
                    var etd = $('input[name="courier-etd-' + $(this).val() + '"]').val();
                    var price = $('input[name="courier-price-' + $(this).val() + '"]').val();

                    $('.courier-choice').empty();

                    $('.courier-choice').append(
                        '<button class="btn mb-3 checkout-courier-button w-100 p-4 " data-bs-toggle="modal"data-bs-target="#courierModal"><div class="row d-flex align-items-center"><div class="col-md-10 col-12 text-start"><div class="checkout-courier-label m-0"> <p class="m-0 d-inline-block modal-courier-type pe-1 fw-bold">' +
                        courier.toUpperCase() +
                        '</p><p class="m-0 d-inline-block modal-courier-package fw-bold">' +
                        service +
                        '</p><p class="m-0">Akan tiba dalam ' + etd.replace(' HARI', '') +
                        ' hari dari pengiriman</p></div></div><div class="col-md-2 col-12"><p class="m-0 text-danger checkout-courier-cost text-start my-2 fw-bold"><span class="checkout-courier-cost">' +
                        formatRupiah(price, "Rp") +
                        '</span></p></div></div><input type="hidden" name="courier-name" value="' +
                        courier.toUpperCase() +
                        '"><input type="hidden" name="courier-service" value="' + service +
                        '"><input type="hidden" name="courier-etd" value="' + etd +
                        '"><input type="hidden" name="courier-price" value="' + price +
                        '"></div></button>'
                    );

                    $('input[name="courier-name-choosen"]').val(courier);
                    $('input[name="courier-service-choosen"]').val(service);
                    etd = etd.replace(' HARI', '');
                    $('input[name="courier-etd-choosen"]').val(etd);

                    $('input[name="courier"]').val(courier);
                    $('input[name="courier_package_type"]').val(service);
                    $('input[name="estimation"]').val(etd);
                    $('input[name="courier_price"]').val(price);
                    console.log($('input[name="courier"]').val());
                    console.log($('input[name="courier_package_type"]').val());
                    console.log($('input[name="estimation"]').val());
                    console.log($('input[name="courier_price"]').val());

                    $('.checkout-shipment-total-text').text('Total Ongkos Kirim');
                    $('.checkout-payment-shipment-text').text('Total Ongkos Kirim');
                    $('input[name="checkout_total_price"]').val(parseInt($(
                        'input[name="total_subtotal"]').val()) + parseInt(price));
                    $('.checkout-shipment-total-val').text(formatRupiah(price, "Rp"));
                    $('.checkout-payment-shipment-val').text(formatRupiah(price, "Rp"));
                    $('.checkout-total-all-val').text(formatRupiah(parseInt($(
                        'input[name="total_subtotal"]').val()) + parseInt(price), "Rp"));
                    $('.checkout-payment-total-all-val').text(formatRupiah(parseInt($(
                        'input[name="total_subtotal"]').val()) + parseInt(price), "Rp"));
                    $('#courierModal').modal('toggle');
                    $('input[name="checkout_payment_total_price"]').val(parseInt($(
                        'input[name="total_subtotal"]').val()) + parseInt(price));
                    $('.courier-error-text').empty();
                    $('.checkout-payment-courier-text').text(courier + ' ' + service + ' ' + etd +
                        ' hari')

                });
            });
            $('#paymentModal').on('show.bs.modal', function(e) {
                let courierName = $('input[name="courier"]').val();
                let courierService = $('input[name="courier_package_type"]').val();
                let courierETD = $('input[name="estimation"]').val();
                let courierPrice = $('input[name="courier_price"]').val();
                var button = e.relatedTarget;
                if ($(button).hasClass('show-payment-modal-button')) {
                    if (courierName == '' || courierService == '' || courierETD == '' || courierPrice ==
                        '') {
                        console.log($('input[name="courier-name-choosen"]').val());
                        e.preventDefault();
                        $('.courier-error-text').text('Pilih kurir pengirim terlebih dahulu');
                        alert('Pilih kurir pengirim terlebih dahulu');
                        expand();
                    }
                }
            });

            function expand() {
                console.log($('.checkout-bill-form'));
                if ($('.checkout-bill-form').hasClass("d-none")) {
                    $('.checkout-bill-form').removeClass("d-none");
                } else {
                    $('.checkout-bill-form').addClass('d-none');
                }
                if ($('.expand-checkout-bill-chevron').hasClass("bi-chevron-up")) {
                    $('.expand-checkout-bill-chevron').removeClass("bi-chevron-up");
                    $('.expand-checkout-bill-chevron').addClass("bi-chevron-down");
                    console.log($('.expand-checkout-bill-chevron'));
                } else if ($('.expand-checkout-bill-chevron').hasClass("bi-chevron-down")) {
                    $('.expand-checkout-bill-chevron').removeClass("bi-chevron-down");
                    $('.expand-checkout-bill-chevron').addClass("bi-chevron-up");
                    console.log($('.expand-checkout-bill-chevron'));
                }
            }

            $('.expand-checkout-bill').click(function() {
                expand();
            })
        });
    </script>
@endsection

{{-- @if (!is_null($order->orderitem[0]->orderproduct->orderproductimage))
                                <img src="{{ asset('/storage/' . $order->orderitem[0]->orderproduct->orderproductimage->first()->name) }}"
                                    class="w-100 border-radius-5px" alt="">
                            @endif --}}
@if (isset($order->orderitem[0]->orderproduct->orderproductimage))
    <img src="{{ asset('/storage/' . $order->orderitem[0]->orderproduct->orderproductimage->first()->name) }}"
        class="w-100 border-radius-5px" alt="">
@endif
{{-- {{ dd(($order->orderitem[0])) }} --}}
{{-- Order ID : {{ $order->id }} --}}
{{-- {{ $item->orderproduct }} --}}

{{-- layout --}}
<li class="mb-2">
    <a class="btn btn-toggle align-items-center shadow-none order-button-menu-collapse accordion-button ps-3 py-2"
        data-bs-toggle="collapse" href="#orders-collapse" role="button" aria-expanded="false"
        aria-controls="orders-collapse">
        <i class="bi bi-bag me-2"></i> Pesanan Saya
    </a>
    {{-- <button class="btn btn-toggle align-items-center shadow-none" data-bs-toggle="collapse"
        data-bs-target="#orders-collapse" aria-expanded="true">
        <i class="bi bi-bag me-1"></i> Pesanan Saya
    </button> --}}
    <div class="collapse show" id="orders-collapse" style="">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li>
                <a href="{{ route('order.index') }}"
                    class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex {{ isset($active) ? ($active == '' ? 'active-menu' : '') : '' }}">Semua</a>
            </li>
            {{-- <form action="{{ route('order.index') }}" method="GET">
                <li class="fs-14 ms-4 ps-3">
                    <input type="hidden" name="status" value="">
                    <button type="submit"
                        class="btn p-0 text-dark text-decoration-none shadow-none fs-14 {{ isset($active) ? ($active == request('status') ? 'active-menu' : '') : '' }}">
                        Semua Pesaanan
                    </button>
                </li>
            </form> --}}
            <form action="{{ route('order.index') }}" method="GET">
                <li class="fs-14 ms-4 ps-3 py-1">
                    <input type="hidden" name="status" value="belum bayar">
                    <button type="submit"
                        class="btn p-0 text-dark text-decoration-none shadow-none fs-14 {{ isset($active) ? ($active == 'belum bayar' ? 'active-menu' : '') : '' }}">
                        Belum Bayar
                    </button>
                </li>
            </form>
            <form action="{{ route('order.index') }}" method="GET">
                <li class="fs-14 ms-4 ps-3 py-1">
                    <input type="hidden" name="status" value="Pesanan Dibayarkan">
                    <button type="submit"
                        class="btn p-0 text-dark text-decoration-none shadow-none fs-14 {{ isset($active) ? ($active == 'Pesanan Dibayarkan' ? 'active-menu' : '') : '' }}">
                        Verifikasi Pembayaran
                    </button>
                </li>
            </form>
            {{-- <li>
                <a href="#"
                    class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex {{ isset($active) ? ($active == 'orderOnProcess' ? 'active-menu' : '') : '' }}">Verifikasi Pembayaran</a>
            </li> --}}
            <li>
                <a href="#"
                    class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex {{ isset($active) ? ($active == 'orderOnProcess' ? 'active-menu' : '') : '' }}">Dikemas</a>
            </li>
            <li>
                <a href="#"
                    class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex {{ isset($active) ? ($active == 'orderOnProcess' ? 'active-menu' : '') : '' }}">Dikirim</a>
            </li>
            <li>
                <a href="#"
                    class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex {{ isset($active) ? ($active == 'orderFinished' ? 'active-menu' : '') : '' }}">Selesai</a>
            </li>
            <li>
                <a href="#"
                    class="text-decoration-none link-dark ms-4 py-1 ps-3 d-inline-flex {{ isset($active) ? ($active == 'orderCancelled' ? 'active-menu' : '') : '' }}">Dibatalkan</a>
            </li>

        </ul>
    </div>
</li>

{{-- order.show --}}
// dd(($order->orderitem->pluck('id')->toArray()));
// dd(($order->orderitem->orderproduct));
foreach ($order->orderitem as $item) {
echo 'order item : ' . $item;
echo "<br>";
}
foreach ($order->orderitem as $item) {
echo 'order product id : ' . $item->orderproduct->id;
echo 'order prodid : ' . $item->order_product_id;
// dd($item->orderproduct->pluck('id'));
echo "<br>";
echo "<br>----------------------------";
echo "<br>";
$orderProductIds[] = $item->orderproduct->id;
}
$orderId = $order->id;
$orderItemIds = $order->orderitem->pluck('id')->toArray();

print_r($orderId);
echo "<br>";
print_r($orderItemIds);
echo "<br>";
print_r($orderProductIds);
echo "<br>";

print_r(session()->get('orderId'));
echo "<br>";
print_r(session()->get('orderItemIds'));
echo "<br>";
print_r(session()->get('orderProductIds'));

if ($order->order_status === 'belum bayar') {
$request->session()->put('orderIdPayment', $orderId);
$request->session()->put('orderItemIdsPayment', $orderItemIds);
$request->session()->put(['orderProductIdsPayment' => $orderProductIds]);

return redirect()->route('payment.order');
} else {
$request->session()->put('orderIdDetail', $orderId);
$request->session()->put('orderItemIdsDetail', $orderItemIds);
$request->session()->put(['orderProductIdsDetail' => $orderProductIds]);

return redirect()->route('order.detail');
}

{{-- login --}}
<div class="d-flex mb-3">
    <div class="form-check fs-13">
        <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
        <label class="form-check-label" for="rememberMe">Ingat saya</label>
    </div>
    <div class="me-auto">
        <a class="text-decoration-none text-danger login-forgot-password"
            href="{{ route('forgot.password') }}">Lupa
            password?</a>
    </div>
</div>
// public function changeEmail()
// {
// return view(
// 'user.email.change-email-send-otp',
// [
// 'title' => 'Email',
// 'active' => 'profile',
// ]
// );
// }

public function changeEmailVerifyMethod(Request $request)
{
return view('user.verify-method', [
'title' => 'Ubah Email',
'active' => 'profile',
'act' => 'change',
'email' => auth()->user()->email
]);
}

public function changeEmailSendOTP(Request $request, MailController $mailController)
{
// dd($request);
$verificationCode = random_int(100000, 999999);
$details = ['id' => '1', 'email' => $request->value, 'title' => 'KLIK SPL: Ubah Email', 'message' => 'Silakan masukkan
kode berikut untuk mengubah email kamu saat ini', 'verifCode' => $verificationCode, 'closing' => 'Kode bersifat rahasia
dan jangan sebarkan kode ini kepada siapapun, termasuk pihak KLIKSPL.', 'footer' => ''];
$detail = new Request($details);
// dd($details);
echo gettype($detail);
$request->session()->put(['verificationCode' => $verificationCode]);
$request->session()->put(['value' => $request->value]);

$this->mailController = $mailController;
$this->mailController->sendMail($detail);

return redirect()->route('profile.change.email.fill.otp');
}

public function changeEmailFillOTP(Request $request)
{
return view('user.verify-otp', [
'title' => 'Ubah Email',
'request' => $request,
'active' => 'profile',
'act' => 'change',
'email' => $request->session()->get('value'),
'verifValue' => $request->session()->get('verificationCode')
]);
}

public function changeEmailVerifyOTP(Request $request)
{
// dd($request);
if ($request->verifValue === $request->verifCode) {
$request->session()->put('email_verified', 1);
return redirect()->route('profile.change.email.verified.otp');
} else {
return back()->with(['verificationFailed' => 'Kode Verifikasi yang anda masukkan tidak sesuai']);
}
}

public function changeEmailVerified(Request $request)
{
return view('user.verified-otp', [
'title' => 'Ubah Email',
'request' => $request,
'active' => 'profile',
'act' => 'change',
'email' => $request->session()->get('value'),
'verifValue' => $request->session()->get('verificationCode')
]);
}

public function changeEmailNew(Request $request)
{
return view('user.email.change-email', [
'title' => 'Ubah Email',
'active' => 'profile',
'act' => 'change',
'email' => '',
]);
}

public function changeEmailNewPrepost(Request $request)
{
$validatedData = $request->validate(
[
'email' => 'required|unique:users,email'
],
[
'email.required' => 'Email harus diisi',
'email.unique' => 'Email yang anda masukkan sudah digunakan',
]
);
$request->session()->put('email', $validatedData['email']);

return redirect()->route('profile.change.email.new.verifyMethod');
}

public function changeEmailVerifyNewMethod(Request $request)
{
return view('user.verify-method', [
'title' => 'Ubah Email',
'active' => 'profile',
'act' => 'change',
'email' => $request->session()->get('email')
]);
}

public function changeEmail(Request $request)
{
if ($request->session()->get('email_verified')) {
return view('user.', [
'title' => 'Ubah Email',
'request' => $request
]);
} else {
return back()->with(['verificationFailed' => 'Kode Verifikasi yang anda masukkan tidak valid']);
}
}

public function addPhone()
{
return view('user.phone.add-phone', [
'title' => 'Tambah No.Telepon',
'active' => 'profile',
]);
}

public function addPhonePost(Request $request)
{
$validatedData = $request->validate(
[
'telp_no' => 'required|unique:users,telp_no|min:12|max:13|regex:/^[0][0-9]*$/'
],
[
'telp_no.required' => 'Nomor telepon harus diisi',
'telp_no.unique' => 'Nomor telepon yang kamu masukkan sudah digunakan',
'telp_no.min' => 'Nomor telepon minimal terdiri dari 12 digit',
'telp_no.max' => 'Nomor telepon maksimal terdiri dari 13 digit',
'telp_no.regex' => 'Format nomor telepon tidak valid! No telepon hanya dapat diisi dengan angka dan diawali dengan angka
0',
]
);
$request->session()->put('telp_no', $validatedData['telp_no']);

return redirect()->route('profile.add.phone.verify.method');
}

public function addPhoneVerifyMethod(Request $request)
{
$verificationCode = random_int(100000, 999999);

$request->session()->put('verificationCodeTelpNo', $verificationCode);

return view('user.verify-method', [
'title' => 'Tambah No.Telepon',
'active' => 'profile',
'act' => 'add',
'telp_no' => $request->session()->get('telp_no'),
'verificationCode' => $verificationCode,
'waVerifMessage' => 'https://wa.me/6285248466297?text=Halo+' . auth()->user()->firstname . '+' .
auth()->user()->lastname .
'%2C%0D%0ASilakan+masukkan+kode+berikut+untuk+verifikasi+nomor+telepon+yang+kamu+tambahkan%0D%0A%0D%0A%2A' .
$verificationCode .
'%2A%0D%0A%0D%0AKode+diatas+bersifat+rahasia+dan+jangan+sebarkan+kode+kepada+siapapun.%0D%0A%0D%0APesan+ini+dibuat+otomatis%2C+jika+membutuhkan+bantuan%2C+silakan+hubungi+ADMIN+KLIKSPL+dengan+link+berikut%3A%0D%0Ahttps%3A%2F%2Fwa.me%2F6285248466297'
]);
}

public function addPhoneVerifyCode(Request $request)
{
// $currentURL = URL::full();
// dd($currentURL);

dd($request->verificationCode);
// dd(session()->all());
if ($request->verificationCode == $request->session()->get('verificationCodeTelpNo') && auth()->user()->id ==
$request->id) {
$request->merge(['telp_no' => $request->value]);
// dd('verified');
if ($request->linkVerification == 1) {
return view('user.verified-otp', [
'title' => 'Tambah No.Telepon',
'request' => $request,
'active' => 'profile',
'act' => 'add',
'telp_no' => $request->session()->get('telp_no'),
'verifValue' => $request->session()->get('verificationCode')
]);
} else {
return view('user.verify-otp', [
'title' => 'Tambah No.Telepon',
'request' => $request,
'active' => 'profile',
'act' => 'add',
'telp_no' => $request->session()->get('telp_no'),
'verifValue' => $request->session()->get('verificationCode')
]);
// $validatedData = $request->validate(
// [
// 'telp_no' => 'required|unique:users|min:12|max:13|regex:/^[0][0-9]*$/'
// ],
// [
// 'telp_no.required' => 'Nomor telepon harus diisi',
// 'telp_no.unique' => 'Nomor telepon yang anda masukkan sudah digunakan',
// 'telp_no.min' => 'Nomor telepon minimal terdiri dari 12 digit',
// 'telp_no.max' => 'Nomor telepon maksimal terdiri dari 13 digit',
// 'telp_no.regex' => 'Format nomor telepon tidak valid! No telepon hanya dapat diisi dengan angka dan diawali dengan
angka 0',
// ]
// );
// $user = User::where('id', $request->id)->first();
// $user->telp_no = $validatedData['telp_no'];
// $user->save();
// if ($user->save()) {
// return redirect()->route('profile.add.phone.verified');
// }
}
} else {
return redirect()->back()->with('failed', 'Kode Verifikasi yang kamu masukkan tidak valid. Silakan kirim kirim ulang
permintaan kode OTP.');
}
}

public function addPhoneVerified(Request $request)
{
return view('user.verified-otp', [
'title' => 'Tambah No.Telepon',
'request' => $request,
'active' => 'profile',
'act' => 'add',
]);
}
public function addPhoneStore(Request $request)
{
// dd($request);
$validatedData = $request->validate(
[
'telp_no' => 'required|unique:users|min:12|max:13|regex:/^[0][0-9]*$/'
],
[
'telp_no.required' => 'Nomor telepon harus diisi',
'telp_no.unique' => 'Nomor telepon yang anda masukkan sudah digunakan',
'telp_no.min' => 'Nomor telepon minimal terdiri dari 12 digit',
'telp_no.max' => 'Nomor telepon maksimal terdiri dari 13 digit',
'telp_no.regex' => 'Format nomor telepon tidak valid! No telepon hanya dapat diisi dengan angka dan diawali dengan angka
0',
]
);
$user = User::where('id', $request->user_id)->first();
$user->telp_no = $validatedData['telp_no'];
$user->save();

// dd($user);

return redirect()->route('profile.index')->with('success', 'Berhasil menambahkan No.Telepon');
}


//user email - change
Route::name('profile.change.email')->get('/user/account/email',[userProfileController::class,'changeEmailVerifyMethod'])->middleware('auth');
Route::name('profile.change.email.post')->post('/user/account/email',[userProfileController::class,'changeEmailSendOTP'])->middleware('auth');
Route::name('profile.change.email.fill.otp')->get('/user/account/email-verify-otp',[userProfileController::class,'changeEmailFillOTP'])->middleware('auth');
Route::name('profile.change.email.verify.otp')->post('/user/account/email-verify-otp',[userProfileController::class,'changeEmailVerifyOTP'])->middleware('auth');
Route::name('profile.change.email.verified.otp')->get('/user/account/email-verified',[userProfileController::class,'changeEmailVerified'])->middleware('auth');

Route::name('profile.change.email.new')->get('/user/account/email-change',[userProfileController::class,'changeEmailNew'])->middleware('auth');
Route::name('profile.change.email.new.prepost')->post('/user/account/email-change',[userProfileController::class,'changeEmailNewPrepost'])->middleware('auth');
Route::name('profile.change.email.new.verifyMethod')->get('/user/account/email-change-verify-method',[userProfileController::class,'changeEmailVerifyNewMethod'])->middleware('auth');
Route::name('profile.change.email.new.post')->post('/user/account/email-change-change-verify-method',[userProfileController::class,'changeEmailSendOTP'])->middleware('auth');
Route::name('profile.change.email.new.fill.otp')->get('/user/account/email-change-verify-otp',[userProfileController::class,'changeEmailFillOTP'])->middleware('auth');
Route::name('profile.change.email.new.verify.otp')->post('/user/account/email-change-verify-otp',[userProfileController::class,'changeEmailVerifyOTP'])->middleware('auth');
Route::name('profile.change.email.new.verified.otp')->get('/user/account/email-change-verified',[userProfileController::class,'changeEmailVerified'])->middleware('auth');

//user phone - add
Route::name('profile.add.phone')->get('/user/account/phone',[userProfileController::class,'addPhone'])->middleware('auth');
Route::name('profile.add.phone.post')->post('/user/account/add-phone',[userProfileController::class,'addPhonePost'])->middleware('auth');
Route::name('profile.add.phone.verify.method')->get('/user/account/phone-verify',[userProfileController::class,'addPhoneVerifyMethod'])->middleware('auth');
Route::name('profile.add.phone.verify.code')->get('/user/account/phone-verify-code',[userProfileController::class,'addPhoneVerifyCode'])->middleware('auth');
Route::name('profile.add.phone.verified')->get('/user/account/phone-verified',[userProfileController::class,'addPhoneVerified'])->middleware('auth');

{{-- verify method --}}

@extends('user.layout')
@section('account')
    <div class="row">
        <div class="col-12">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show alert-success-cart mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('failed'))
                <div class="alert alert-danger alert-dismissible fade show alert-success-cart mb-4" role="alert">
                    {{ session('failed') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
    {{-- {{ dd(session()->all()) }} --}}
    <div class="card mb-3 border-radius-075rem fs-14">
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
                {{ $act == 'add' ? 'Tambahkan' : ($act == 'change' ? 'Ubah' : '') }}
                {{ isset($email) ? 'Email' : (isset($telp_no) ? 'No.Telepon' : '') }}
            </h5>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card mb-5 border-radius-075rem box-shadows border-0">
                        <div class="card-body p-5">
                            <div class="header mb-4">
                                <div class="row">
                                    <div class="col-md-12 col-12 text-center">
                                        <h5 class="">Kirim Kode OTP</h5>
                                    </div>
                                </div>
                                <div>
                                    <span class="d-flex justify-content-center">
                                    </span>
                                </div>
                                <div class="text-center">
                                    <span class="register-act-login">
                                        Kode OTP digunakan untuk verifikasi
                                        {{ isset($email) ? 'Email' : (isset($telp_no) ? 'No.Telepon' : '') }}
                                        anda.
                                    </span>
                                </div>
                            </div>
                            @if (isset($email))
                                <form
                                    action="{{ $act == 'add' ? route('profile.change.email.post') : ($act == 'change' ? route('profile.change.email.post') : '') }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="value" value="{{ auth()->user()->email }}">
                                    <button type="submit"
                                        class="text-decoration-none text-dark border-0 bg-transparent w-100 px-0">
                                        <div class="card border-radius-075rem">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-md-9 col-9 text-start">
                                                        <p class="m-0">
                                                            <strong>
                                                                kirim Email ke:
                                                            </strong>
                                                        </p>
                                                        <p class="m-0">
                                                            {{ $email }}
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="col-md-3 col-3 d-flex align-items-center justify-content-center pe-4">
                                                        @if (isset($email))
                                                            <i class="bi bi-envelope fs-1"></i>
                                                        @elseif (isset($telp_no))
                                                            <i class="bi bi-chat-left-text fs-1"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                            @elseif (isset($telp_no))
                                <form action="{{ route('profile.add.phone.verify.code') }}" method="POST"
                                    class="">
                                    @csrf
                                    <input type="hidden" name="value" value="{{ $telp_no }}">
                                    <button type="submit"
                                        class="text-decoration-none text-dark border-0 bg-transparent w-100 px-0">
                                        <div class="card border-radius-075rem mb-3 box-shadow">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-md-9 col-9 text-start">
                                                        <p class="m-0">
                                                            <strong>
                                                                Kirim SMS ke:
                                                            </strong>
                                                        </p>
                                                        <p class="m-0">
                                                            {{ $telp_no }}
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="col-md-3 col-3 d-flex align-items-center justify-content-center pe-4">
                                                        @if (isset($email))
                                                            <i class="bi bi-envelope fs-1"></i>
                                                        @elseif (isset($telp_no))
                                                            <i class="bi bi-chat-left-text fs-1"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                                <form action="{{ route('profile.add.phone.verify.code') }}" method="get"
                                    class="phone-verify-method-form">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="username" value="{{ auth()->user()->username }}">
                                    <input type="hidden" name="value" value="{{ $telp_no }}">
                                    <input type="hidden" name="verificationCode" value="{{ $verificationCode }}">
                                    <a href="https://wa.me/6285248466297?text=Halo+{{ auth()->user()->firstname }}+{{ auth()->user()->lastname }}%2C%0D%0ASilakan+masukkan+kode+berikut+untuk+verifikasi+nomor+telepon+yang+kamu+tambahkan%0D%0A%0D%0A%2A{{ $verificationCode }}%2A%0D%0A%0D%0AKode+diatas+bersifat+rahasia+dan+jangan+sebarkan+kode+kepada+siapapun.%0D%0A%0D%0Aatau+kamu+dapat+klik+link+berikut+untuk+melanjutkan+verifikasi.%0D%0A%0D%0Ahttp%3A%2F%2Fklikspl.test%2Fuser%2Faccount%2Fphone-verify-code%3F_token%3D{{ csrf_token() }}%26id%3D{{ auth()->user()->id }}%26username%3D{{ auth()->user()->username }}%26value%3D{{ $telp_no }}%26verificationCode%3D{{ $verificationCode }}%26linkVerification%3D1%0D%0A%0D%0APesan+ini+dibuat+otomatis%2C+jika+membutuhkan+bantuan%2C+silakan+hubungi+ADMIN+KLIKSPL+dengan+link+berikut%3A%0D%0Ahttps%3A%2F%2Fwa.me%2F6285248466297"
                                        target="_blank" class="text-decoration-none link-dark send-wa-otp">
                                        <div class="card border-radius-075rem box-shadow">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-md-9 col-9 text-start">
                                                        <p class="m-0">
                                                            <strong>
                                                                kirim Pesan Whatsapp ke:
                                                            </strong>
                                                        </p>
                                                        <p class="m-0">
                                                            {{ $telp_no }}
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="col-md-3 col-3 d-flex align-items-center justify-content-center pe-4">
                                                        @if (isset($email))
                                                            <i class="bi bi-envelope fs-1"></i>
                                                        @elseif (isset($telp_no))
                                                            <i class="bi bi-whatsapp fs-1"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </form>
                            @endif
                            {{-- </button> --}}
                            {{-- </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.send-wa-otp').click(function() {
                $('.phone-verify-method-form').submit();
            })
        })
    </script>
@endsection



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Dashboard Template · Bootstrap v5.1</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    {{-- Bootstrap ICON --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">


    {{-- SELECT2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" />

    {{-- SCRIPT JQUERY --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/js/script.js" type="text/javascript"></script>

    <!-- Custom styles for this template -->
    <link href="/css/dashboard.css" rel="stylesheet">
</head>

<body>



    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse overflow-auto">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file"></span>
                                Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="shopping-cart"></span>
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="users"></span>
                                Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="bar-chart-2"></span>
                                Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="layers"></span>
                                Integrations
                            </a>
                        </li>
                    </ul>

                    <h6
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Saved reports</span>
                        <a class="link-secondary" href="#" aria-label="Add a new report">
                            <span data-feather="plus-circle"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Current month
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Last quarter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Social engagement
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Year-end sale
                            </a>
                        </li>
                    </ul>
                    <h6
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Saved reports</span>
                        <a class="link-secondary" href="#" aria-label="Add a new report">
                            <span data-feather="plus-circle"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Current month
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Last quarter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Social engagement
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Year-end sale
                            </a>
                        </li>
                    </ul>
                    <h6
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Saved reports</span>
                        <a class="link-secondary" href="#" aria-label="Add a new report">
                            <span data-feather="plus-circle"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Current month
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Last quarter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Social engagement
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Year-end sale
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <span data-feather="calendar"></span>
                            This week
                        </button>
                    </div>
                </div>

                <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

                <h2>Section title</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Header</th>
                                <th scope="col">Header</th>
                                <th scope="col">Header</th>
                                <th scope="col">Header</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1,001</td>
                                <td>random</td>
                                <td>data</td>
                                <td>placeholder</td>
                                <td>text</td>
                            </tr>
                            <tr>
                                <td>1,002</td>
                                <td>placeholder</td>
                                <td>irrelevant</td>
                                <td>visual</td>
                                <td>layout</td>
                            </tr>
                            <tr>
                                <td>1,003</td>
                                <td>data</td>
                                <td>rich</td>
                                <td>dashboard</td>
                                <td>tabular</td>
                            </tr>
                            <tr>
                                <td>1,003</td>
                                <td>information</td>
                                <td>placeholder</td>
                                <td>illustrative</td>
                                <td>data</td>
                            </tr>
                            <tr>
                                <td>1,004</td>
                                <td>text</td>
                                <td>random</td>
                                <td>layout</td>
                                <td>dashboard</td>
                            </tr>
                            <tr>
                                <td>1,005</td>
                                <td>dashboard</td>
                                <td>irrelevant</td>
                                <td>text</td>
                                <td>placeholder</td>
                            </tr>
                            <tr>
                                <td>1,006</td>
                                <td>dashboard</td>
                                <td>illustrative</td>
                                <td>rich</td>
                                <td>data</td>
                            </tr>
                            <tr>
                                <td>1,007</td>
                                <td>placeholder</td>
                                <td>tabular</td>
                                <td>information</td>
                                <td>irrelevant</td>
                            </tr>
                            <tr>
                                <td>1,008</td>
                                <td>random</td>
                                <td>data</td>
                                <td>placeholder</td>
                                <td>text</td>
                            </tr>
                            <tr>
                                <td>1,009</td>
                                <td>placeholder</td>
                                <td>irrelevant</td>
                                <td>visual</td>
                                <td>layout</td>
                            </tr>
                            <tr>
                                <td>1,010</td>
                                <td>data</td>
                                <td>rich</td>
                                <td>dashboard</td>
                                <td>tabular</td>
                            </tr>
                            <tr>
                                <td>1,011</td>
                                <td>information</td>
                                <td>placeholder</td>
                                <td>illustrative</td>
                                <td>data</td>
                            </tr>
                            <tr>
                                <td>1,012</td>
                                <td>text</td>
                                <td>placeholder</td>
                                <td>layout</td>
                                <td>dashboard</td>
                            </tr>
                            <tr>
                                <td>1,013</td>
                                <td>dashboard</td>
                                <td>irrelevant</td>
                                <td>text</td>
                                <td>visual</td>
                            </tr>
                            <tr>
                                <td>1,014</td>
                                <td>dashboard</td>
                                <td>illustrative</td>
                                <td>rich</td>
                                <td>data</td>
                            </tr>
                            <tr>
                                <td>1,015</td>
                                <td>random</td>
                                <td>tabular</td>
                                <td>information</td>
                                <td>text</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
        integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous">
    </script>
    <script src="/js/dashboard.js"></script>

    {{-- SCRIPT JQUERY --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{-- SCRIPT BOOTSTRAP 5 Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    {{-- FONTAWESOME --}}
    <script src="https://kit.fontawesome.com/c4d8626996.js" crossorigin="anonymous"></script>

    <script src="/js/script.js" type="text/javascript"></script>
    @yield('config.manual-js')
    {{-- SELECT2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>

</html>

<nav class="navbar navbar-expand-lg shadow-sm p-3 mb-5 bg-body rounded fixed-top d-none d-sm-block navbar-main">
    <div class="container-fluid fs-14">
        <a class="navbar-brand" href="/">
            <img class="w-auto" src=" {{ asset('/assets/logotype2.svg') }}" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle link-dark color-red-klikspl-hover"
                        id="notification-navbar-dropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-bell"></i>
                        @auth
                            @if (count($userNotifications) > 0)
                                <span class="position-absolute top-5 start-100 translate-middle badge  bg-danger">
                                    {{ count($userNotifications) }}
                                    <span class="visually-hidden">Notifications</span>
                                </span>
                            @endif
                        @endauth
                    </a>
                    @if (Auth::guard('adminMiddle')->user())
                        <ul class="dropdown-menu" aria-labelledby="notification-navbar-dropdown">
                            <div class="">
                                <div class="d-flex fixed-top bg-white p-3">
                                    <div class="">
                                        {{-- {{ dd($userNotifications) }} --}}
                                        {{-- Notifikasi({{ count($userNotifications) }}) --}}
                                    </div>
                                    <div class="mx-3 ms-auto">
                                        <a href="{{ route('notifications.index') }}"
                                            class="text-decoration-none text-danger fw-bold">Lihat Semua
                                            Notifikasi</a>
                                    </div>
                                </div>
                                {{-- {{ dd($userCartItems) }} --}}
                                <div class="nav-notification-items mt-5">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </div>
                            </div>
                        </ul>
                    @else
                        <ul class="dropdown-menu notification-dropdown">
                            <li>
                                <div
                                    class="nofitication-no-auth pt-3 justify-content-center text-center rounded-3 px-3">
                                    <i class="bi bi-bell fs-1 text-secondary"></i>
                                    <p class="text-muted py-3 px-2">
                                        Tidak ada notifikasi untuk anda saat ini, masuk untuk melihat notifikasi di akun
                                        membership anda.
                                    </p>
                                </div>
                            </li>
                        </ul>
                    @endauth
            </li>
        </ul>

        @if (Auth::guard('adminMiddle')->user())
            <div class="navbar-nav navbar-account">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle mx-1 nav-acc link-dark" href="#"
                        id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if (!empty(auth()->user()->profile_image))
                            <img class="navbar-profile-image"
                                src="{{ asset('/storage/' . auth()->user()->profile_image) }}" alt="">
                        @else
                            <i class="far fa-user-circle"></i>
                        @endif
                        {{ auth()->guard('adminMiddle')->user()->username }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end account-dropdown"
                        aria-labelledby="navbarDropdown">
                        <li class="my-2">
                            <a class="dropdown-item account-dropdown-item"
                                href="{{ route('profile.index') }}">
                                <i class="far fa-user-circle me-1"></i> Akun saya
                            </a>
                        </li>
                        <li class="my-2">
                            <form action="{{ route('admin.logout') }}" method="post">
                                @csrf
                                <button class="dropdown-item account-dropdown-item">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </div>
        @else
            <div class="navbar-nav ms-auto navbar-signup-login">
                <div class="nav-item">
                    <a href="/login" class="p-0 px-3 py-2 mx-1 nav-link navbar-action login">
                        Masuk
                    </a>
                </div>
            </div>
        @endauth
</div>
</div>
</nav>


<div class="container-fluid">
<div class="row">
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file"></span>
                    Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="shopping-cart"></span>
                    Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="users"></span>
                    Customers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="bar-chart-2"></span>
                    Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="layers"></span>
                    Integrations
                </a>
            </li>
        </ul>

        <h6
            class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Saved reports</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <span data-feather="plus-circle"></span>
            </a>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Current month
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Last quarter
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Social engagement
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Year-end sale
                </a>
            </li>
        </ul>
    </div>
</nav>


{{-- <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top flex-md-nowrap shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Link
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
            </ul>
            <div class="navbar-nav">
                <div class="nav-item text-nowrap">
                    <a class="nav-link px-3" href="#">Sign out</a>
                </div>
            </div>
        </div>
    </nav> --}}
{{-- <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Company name</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="#">Sign out</a>
            </div>
        </div>
    </header> --}}


foreach ($order->orderitem as $orderitem) {
if (!empty($orderitem->product_variant_id)) {
echo "order product variant id : ";
echo ($orderitem->product_variant_id);
echo "</br>";
echo "order quantity : ";
echo ($orderitem->quantity);
echo "</br>";
$productVariantId = ProductVariant::where('id', '=', $orderitem->product_variant_id)->first();
// $productVariantId->stock = $productVariantId->stock - $orderitem->quantity;
// $productVariantId->save();
echo "product variant : ";
echo ($productVariantId->stock);
echo "</br>";
} else {
echo "product id : ";
echo ($orderitem->product_id);
echo "</br>";
echo "order quantity : ";
echo ($orderitem->quantity);
echo "</br>";
$product = Product::where('id', '=', $orderitem->product_id)->first();
// $product->stock = $product->stock - $orderitem->quantity;
// $product->save();
echo "product : ";
echo ($product->stock);
echo "</br>";
}
}



<style>
    * {
        box-sizing: border-box;
    }

    .img-zoom-container {
        position: relative;
    }

    .img-zoom-lens {
        position: absolute;
        border: 1px solid #d4d4d4;
        /*set the size of the lens:*/
        width: 40px;
        height: 40px;
    }

    .img-zoom-result {
        border: 1px solid #d4d4d4;
        /*set the size of the result div:*/
        width: 300px;
        height: 300px;
    }
</style>
<script>
    function imageZoom(imgID, resultID) {
        var img, lens, result, cx, cy;
        img = document.getElementById(imgID);
        result = document.getElementById(resultID);
        /*create lens:*/
        lens = document.createElement("DIV");
        lens.setAttribute("class", "img-zoom-lens");
        /*insert lens:*/
        img.parentElement.insertBefore(lens, img);
        /*calculate the ratio between result DIV and lens:*/
        cx = result.offsetWidth / lens.offsetWidth;
        cy = result.offsetHeight / lens.offsetHeight;
        /*set background properties for the result DIV:*/
        result.style.backgroundImage = "url('" + img.src + "')";
        result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
        /*execute a function when someone moves the cursor over the image, or the lens:*/
        lens.addEventListener("mousemove", moveLens);
        img.addEventListener("mousemove", moveLens);
        /*and also for touch screens:*/
        lens.addEventListener("touchmove", moveLens);
        img.addEventListener("touchmove", moveLens);

        function moveLens(e) {
            var pos, x, y;
            /*prevent any other actions that may occur when moving over the image:*/
            e.preventDefault();
            /*get the cursor's x and y positions:*/
            pos = getCursorPos(e);
            /*calculate the position of the lens:*/
            x = pos.x - (lens.offsetWidth / 2);
            y = pos.y - (lens.offsetHeight / 2);
            /*prevent the lens from being positioned outside the image:*/
            if (x > img.width - lens.offsetWidth) {
                x = img.width - lens.offsetWidth;
            }
            if (x < 0) {
                x = 0;
            }
            if (y > img.height - lens.offsetHeight) {
                y = img.height - lens.offsetHeight;
            }
            if (y < 0) {
                y = 0;
            }
            /*set the position of the lens:*/
            lens.style.left = x + "px";
            lens.style.top = y + "px";
            /*display what the lens "sees":*/
            result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
        }

        function getCursorPos(e) {
            var a, x = 0,
                y = 0;
            e = e || window.event;
            /*get the x and y positions of the image:*/
            a = img.getBoundingClientRect();
            /*calculate the cursor's x and y coordinates, relative to the image:*/
            x = e.pageX - a.left;
            y = e.pageY - a.top;
            /*consider any page scrolling:*/
            x = x - window.pageXOffset;
            y = y - window.pageYOffset;
            return {
                x: x,
                y: y
            };
        }
    }
</script>
</head>

<body>

    <h1>Image Zoom</h1>

    <p>Mouse over the image:</p>

    <div class="img-zoom-container">
    </div>
    <div class="row">
        <div class="col-md-6 col-12">
            <img id="myimage" src="{{ asset('assets/admin-footer-logo.png') }}" class="w-100">
        </div>
        <div class="col-md-6 col-12">
            <div id="myresult" class="img-zoom-result"></div>
        </div>
    </div>
    <p>The image must be placed inside a container with relative positioning.</p>
    <p>The result can be put anywhere on the page, but must have the class name "img-zoom-result".</p>
    <p>Make sure both the image and the result have IDs. These IDs are used when a javaScript initiates the zoom
        effect.</p>

    <script>
        // Initiate zoom effect:
        imageZoom("myimage", "myresult");
        imageZoom("imagePreview", "imagepreviewZoom");
    </script>


    {{-- ICON WEB --}}
    <link rel="shortcut icon" href="/assets/klikspl.ico">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
        crossorigin="anonymous">

    {{-- Bootstrap ICON --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    {{-- Style CSS --}}
    <link rel="stylesheet" href="{{ asset('/css/admin/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/trix.css') }}">

    {{-- SELECT2 --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" />

    {{-- DATATABLES --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/DataTables/datatables.min.css') }}" />
    {{-- <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.4/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/sr-1.1.1/datatables.min.css" /> --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" /> --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css" /> --}}


    {{-- SCRIPT JQUERY --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/js/script.js" type="text/javascript"></script> --}}

    {{-- cropper.js --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/2.0.0-alpha.2/cropper.min.css"
        integrity="sha512-6QxSiaKfNSQmmqwqpTNyhHErr+Bbm8u8HHSiinMEz0uimy9nu7lc/2NaXJiUJj2y4BApd5vgDjSHyLzC8nP6Ng=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/2.0.0-alpha.2/cropper.min.js"
        integrity="sha512-IlZV3863HqEgMeFLVllRjbNOoh8uVj0kgx0aYxgt4rdBABTZCl/h5MfshHD9BrnVs6Rs9yNN7kUQpzhcLkNmHw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
        integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous">
    </script>


    {{-- SCRIPT JQUERY --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    {{-- DATATABLES --}}
    {{-- <script type="text/javascript" src="{{ asset('/DataTables/datatables.min.js') }}"></script> --}}

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.4/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/sr-1.1.1/datatables.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    {{-- FONTAWESOME --}}
    <script src="https://kit.fontawesome.com/c4d8626996.js" crossorigin="anonymous"></script>

    <script src="/js/script.js" type="text/javascript"></script>
    <script src="/js/trix.js" type="text/javascript"></script>

    {{-- SELECT2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>





    @extends('admin.layouts.main')
    @section('container')
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
            <h1 class="h2">Produk Saya</h1>
        </div>
        <div class="container p-0 mb-5">
            <div class="card admin-card-dashboard border-radius-1-5rem fs-13">
                <div class="card-body p-md-5">
                    <div id="datatablestest" style="width: 100%;margin: 0 auto;">
                        <table id="product"
                            class="table table-condensed table-striped table-bordered  table-hover"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="min-mobile">No</th>
                                    <th class="min-mobile">Nama Produk</th>
                                    <th class="min-mobile">Detail</th>
                                    <th class="not-mobile">Stok</th>
                                    <th class="not-mobile">Status</th>
                                    <th class="not-mobile">Harga</th>
                                    <th class="not-mobile">Action</th>
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
                                                        <img id="main-image" class="cart-items-img"
                                                            src="{{ asset('/storage/' . $product->productimage[0]->name) }}"
                                                            class="img-fluid" alt="..." width="12%"
                                                            height="12%">
                                                    @else
                                                        <img id="main-image" class="cart-items-img"
                                                            src="https://source.unsplash.com/400x400?product-1"
                                                            class="img-fluid" alt="..." width="12%"
                                                            height="12%">
                                                    @endif
                                                @else
                                                    <img id="main-image" class="cart-items-img"
                                                        src="https://source.unsplash.com/400x400?product-1"
                                                        class="img-fluid" alt="..." width="12%"
                                                        height="12%">
                                                @endif
                                                <div class="">
                                                    <p class="ps-2 m-0">
                                                        {{ $product->name }}
                                                    </p>
                                                    <p class="ps-2 m-0">
                                                        ID: {{ $product->product_code }}
                                                    </p>
                                                    <p class="ps-2 m-0">
                                                        @if (count($product->productvariant))
                                                            {{ count($product->productvariant) }} varian
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-inline-flex">
                                                <div class="m-0 mx-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom"
                                                    title="Dilihat sebanyak {{ $product->view }} kali">
                                                    <i class="bi bi-eye"></i>
                                                    {{ $product->view }}
                                                </div>
                                                <div class="m-0 mx-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom"
                                                    title="Terjual sebanyak {{ count($product->productvariant) ? $product->productvariant->sum('sold') : $product->sold }} item">
                                                    <i class="bi bi-cart"></i>
                                                    @if (count($product->productvariant))
                                                        {{ $product->productvariant->sum('sold') }}
                                                    @else
                                                        {{ $product->sold }}
                                                    @endif
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
                                        <td>
                                            {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </td>
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
                                            <a href="#" class="link-dark text-decoration-none mx-1"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Edit Produk">
                                                <i class="bi bi-pen"></i>
                                            </a>
                                            <a href="#" class="link-dark text-decoration-none mx-1"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Notifikasi Stok status: {{ $product->stock_notification ? 'Aktif' : 'Tidak Aktif' }} | Notifikasi stok berguna untuk mengingatkan ketika stok produk tersisa 10 item ">
                                                <i
                                                    class="bi bi-{{ $product->stock_notification ? 'bell' : 'bell-slash' }}"></i>
                                            </a>
                                            <a href="#" class="link-dark text-decoration-none mx-1"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Hapus Produk">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                var table = $('#product').DataTable({
                    //"autoWidth" : false,
                    responsive: true,

                    "columns": [{
                            // data: "JourID",
                            // title: "JourID",
                            width: '20px'
                        },
                        {
                            // data: "JourTime",
                            // title: "JourTime",
                            width: '400px'
                        },
                        {
                            // data: "Zust1",
                            // title: "Zust1",
                            width: '40px'
                        },
                        {
                            // data: "Dokname",
                            // title: "Dokname",
                            width: '60px'
                        },
                        {
                            // data: "Doktype",
                            // title: "Doktype",
                            width: '60px'
                        },
                        {
                            // data: "JourInhaltTextOnly",
                            // title: "JourInhaltTextOnly",
                            width: '150px'
                        },
                        {
                            // data: "JourInhaltTextOnly",
                            // title: "JourInhaltTextOnly",
                            width: '80px'
                        },
                    ],
                    //               "paging": false,
                    //     "scrollY": 400,
                    "scrollX": true,

                });
            });
            // $(document).ready(function() {
            //     // $('#product').DataTable({
            //     //     // select: true
            //     //     fixedHeader: true,
            //     // });
            //     var table = $('#product').DataTable({
            //         //"autoWidth" : false,

            //         "columns": [{
            //                 data: "JourID",
            //                 title: "JourID",
            //                 width: '150px'
            //             },
            //             {
            //                 data: "JourTime",
            //                 title: "JourTime",
            //                 width: '50px'
            //             },
            //             {
            //                 data: "Zust1",
            //                 title: "Zust1",
            //                 width: '30px'
            //             },
            //             {
            //                 data: "Dokname",
            //                 title: "Dokname",
            //                 width: '100px'
            //             },
            //             {
            //                 data: "Doktype",
            //                 title: "Doktype",
            //                 width: '100px'
            //             },
            //             {
            //                 data: "JourInhaltTextOnly",
            //                 title: "JourInhaltTextOnly",
            //                 width: '550px'
            //             },
            //             {
            //                 data: "JourInhaltTextOnly",
            //                 title: "JourInhaltTextOnly",
            //                 width: '550px'
            //             },
            //         ],
            //         //               "paging": false,
            //         //     "scrollY": 400,
            //         "scrollX": true,

            //         // fixedHeader: true,
            //         // responsive: true,
            //         // lengthChange: false,
            //         // buttons: ['colvis'],
            //         // columnDefs: [
            //         //     // {
            //         //     //     "targets": 0, // your case first column
            //         //     //     "className": "text-center",
            //         //     //     // "width": "4%"
            //         //     // },
            //         //     {
            //         //         "className": ["text-truncate w-25 td-product-name"],
            //         //         "width": "100px",
            //         //         "targets": [1],   
            //         //     },
            //         //     // {
            //         //     //     "targets": 2,
            //         //     //     "className": "text-center",
            //         //     //     // "width": "4%"
            //         //     // },
            //         //     // {
            //         //     //     "targets": 3,
            //         //     //     "className": "text-center",
            //         //     //     // "width": "4%"
            //         //     // },
            //         //     // {
            //         //     //     "targets": 4,
            //         //     //     "className": "text-center",
            //         //     //     "width": "18%"
            //         //     // },
            //         //     // {
            //         //     //     "targets": 5,
            //         //     //     "className": "text-center",
            //         //     //     "width": "8%"
            //         //     // }
            //         // ],
            //     });

            //     // table.buttons().container().appendTo('#product_wrapper .col-md-6:eq(0)');

            //     // new $.fn.dataTable.FixedHeader( table );
            // });
        </script>
    @endsection

    @extends('admin.layouts.main')
    @section('container')
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
            <h1 class="h2">Produk Saya</h1>
        </div>
        <div class="container p-0 mb-5">
            <div class="card admin-card-dashboard border-radius-1-5rem fs-14">
                <div class="card-body p-md-5">
                    <div id="datatablesProducts" class="w-100 m-0">
                        {{-- <table id="product" class="table table-condensed table-striped table-bordered  table-hover" cellspacing="0"> --}}
                        <table id="product"
                            class="table hover fs-14 table-borderless border-0 table-hover cell-border order-column"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="min-mobile">No</th>
                                    <th class="min-mobile">Nama Produk</th>
                                    <th class="min-mobile">Detail</th>
                                    <th class="not-mobile">Stok</th>
                                    <th class="not-mobile">Status</th>
                                    <th class="not-mobile">Harga</th>
                                    <th class="not-mobile">Action</th>
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
                                                        <img id="main-image" class="cart-items-img"
                                                            src="{{ asset('/storage/' . $product->productimage[0]->name) }}"
                                                            class="img-fluid" alt="..." width="60px"
                                                            height="60px">
                                                    @else
                                                        <img id="main-image" class="cart-items-img"
                                                            src="https://source.unsplash.com/400x400?product-1"
                                                            class="img-fluid" alt="..." width="60px"
                                                            height="60px">
                                                    @endif
                                                @else
                                                    <img id="main-image" class="cart-items-img"
                                                        src="https://source.unsplash.com/400x400?product-1"
                                                        class="img-fluid" alt="..." width="60px"
                                                        height="60px">
                                                @endif
                                                <div class="">
                                                    <p class="ps-2 m-0">
                                                        {{ $product->name }}
                                                    </p>
                                                    <p class="ps-2 m-0">
                                                        ID: {{ $product->product_code }}
                                                    </p>
                                                    <p class="ps-2 m-0">
                                                        @if (count($product->productvariant))
                                                            {{ count($product->productvariant) }} varian
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-inline-flex">
                                                <div class="m-0 mx-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom"
                                                    title="Dilihat sebanyak {{ $product->view }} kali">
                                                    <i class="bi bi-eye"></i>
                                                    {{ $product->view }}
                                                </div>
                                                <div class="m-0 mx-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom"
                                                    title="Terjual sebanyak {{ count($product->productvariant) ? $product->productvariant->sum('sold') : $product->sold }} item">
                                                    <i class="bi bi-cart"></i>
                                                    @if (count($product->productvariant))
                                                        {{ $product->productvariant->sum('sold') }}
                                                    @else
                                                        {{ $product->sold }}
                                                    @endif
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
                                        <td>
                                            {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </td>
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
                                            <a href="#" class="link-dark text-decoration-none mx-1"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Edit Produk">
                                                <i class="bi bi-pen"></i>
                                            </a>
                                            <a href="#" class="link-dark text-decoration-none mx-1"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Notifikasi Stok status: {{ $product->stock_notification ? 'Aktif' : 'Tidak Aktif' }} | Notifikasi stok berguna untuk mengingatkan ketika stok produk tersisa 10 item ">
                                                <i
                                                    class="bi bi-{{ $product->stock_notification ? 'bell' : 'bell-slash' }}"></i>
                                            </a>
                                            <a href="#" class="link-dark text-decoration-none mx-1"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Hapus Produk">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                var table = $('#product').DataTable({
                    //"autoWidth" : false,
                    responsive: true,

                    "columns": [{
                            // data: "JourID",
                            // title: "JourID",
                            width: '20px'
                        },
                        {
                            // data: "JourTime",
                            // title: "JourTime",
                            width: '450px'
                        },
                        {
                            // data: "Zust1",
                            // title: "Zust1",
                            width: '60px'
                        },
                        {
                            // data: "Dokname",
                            // title: "Dokname",
                            width: '60px'
                        },
                        {
                            // data: "Doktype",
                            // title: "Doktype",
                            width: '60px'
                        },
                        {
                            // data: "JourInhaltTextOnly",
                            // title: "JourInhaltTextOnly",
                            width: '150px'
                        },
                        {
                            // data: "JourInhaltTextOnly",
                            // title: "JourInhaltTextOnly",
                            width: '80px'
                        },
                    ],
                    //               "paging": false,
                    //     "scrollY": 400,
                    "scrollX": true,

                });
            });
        </script>
    @endsection

    @extends('admin.layouts.main')
    @section('container')
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
            <h1 class="h2">Produk Saya</h1>
        </div>
        <div class="container p-0 mb-5">
            <div class="card admin-card-dashboard border-radius-1-5rem fs-13">
                <div class="card-body p-5">
                    <table id="product"
                        class="table hover fs-13 nowrap table-borderless table-hover cell-border order-column"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="min-mobile">No</th>
                                <th class="min-mobile">Nama Produk</th>
                                <th class="min-mobile">Detail</th>
                                <th class="not-mobile">Stok</th>
                                <th class="not-mobile">Status</th>
                                <th class="not-mobile">Harga</th>
                                <th class="not-mobile">Action</th>
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
                                                    <img id="main-image" class="cart-items-img"
                                                        src="{{ asset('/storage/' . $product->productimage[0]->name) }}"
                                                        class="img-fluid" alt="..." width="60">
                                                @else
                                                    <img id="main-image" class="cart-items-img"
                                                        src="https://source.unsplash.com/400x400?product-1"
                                                        class="img-fluid" alt="..." width="60">
                                                @endif
                                            @else
                                                <img id="main-image" class="cart-items-img"
                                                    src="https://source.unsplash.com/400x400?product-1"
                                                    class="img-fluid" alt="..." width="60">
                                            @endif
                                            <div class="">
                                                <p class="ps-2 m-0">
                                                    {{ $product->name }}
                                                </p>
                                                <p class="ps-2 m-0">
                                                    ID: {{ $product->product_code }}
                                                </p>
                                                <p class="ps-2 m-0">
                                                    @if (count($product->productvariant))
                                                        {{ count($product->productvariant) }} varian
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-inline-flex">
                                            <div class="m-0 mx-1" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom"
                                                title="Dilihat sebanyak {{ $product->view }} kali">
                                                <i class="bi bi-eye"></i>
                                                {{ $product->view }}
                                            </div>
                                            <div class="m-0 mx-1" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom"
                                                title="Terjual sebanyak {{ $product->sold }} item">
                                                <i class="bi bi-cart"></i>
                                                {{ $product->sold }}
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
                                    <td>
                                        {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </td>
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
                                        <a href="#" class="link-dark text-decoration-none mx-1"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="Edit Produk">
                                            <i class="bi bi-pen"></i>
                                        </a>
                                        <a href="#" class="link-dark text-decoration-none mx-1"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="Notifikasi Stok | status: {{ $product->stock_notification ? 'Aktif' : 'Tidak Aktif' }} ">
                                            <i
                                                class="bi bi-{{ $product->stock_notification ? 'bell' : 'bell-slash' }}"></i>
                                        </a>
                                        <a href="#" class="link-dark text-decoration-none mx-1"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="Hapus Produk">
                                            <i class="bi bi-trash"></i>
                                        </a>
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
                // $('#product').DataTable({
                //     // select: true
                //     fixedHeader: true,
                // });
                var table = $('#product').DataTable({
                    // fixedHeader: true,
                    responsive: true,
                    // lengthChange: false,
                    // buttons: ['colvis'],
                    columnDefs: [
                        // {
                        //     "targets": 0, // your case first column
                        //     "className": "text-center",
                        //     // "width": "4%"
                        // },
                        // {
                        //     "targets": 1,   
                        //     "className": "text-center",
                        //     // "width": "4%"
                        // },
                        // {
                        //     "targets": 2,
                        //     "className": "text-center",
                        //     // "width": "4%"
                        // },
                        // {
                        //     "targets": 3,
                        //     "className": "text-center",
                        //     // "width": "4%"
                        // },
                        // {
                        //     "targets": 4,
                        //     "className": "text-center",
                        //     "width": "18%"
                        // },
                        // {
                        //     "targets": 5,
                        //     "className": "text-center",
                        //     "width": "8%"
                        // }
                    ],
                });

                // table.buttons().container().appendTo('#product_wrapper .col-md-6:eq(0)');

                // new $.fn.dataTable.FixedHeader( table );
            });
        </script>
    @endsection

    // dd($product->productvariant);
    for ($i = 0; $i < count($product->productvariant); $i++) {
        if (isset($request->variant_id[$i])) {
        echo $product->productvariant[0]->productorigin[0]->id;
        echo "<br>";
        // $deleteVariant = ProductVariant::find($product->productvariant[$i]->id);
        // $deleteVariant->delete();
        }
        }

        // dd($request);
        // dd($product);
        if (isset($request->variant_name) || isset($request->variant_slug) || isset($request->variant_value) ||
        isset($request->variant_code) || isset($request->variant_stock) || isset($request->variant_weight) ||
        isset($request->variant_long) || isset($request->variant_width) || isset($request->variant_height) ||
        isset($request->variant_price)) {
        $validatedDataVariant = $request->validate(
        [
        'variant_name' => 'required',
        // 'variant_slug' => 'required|unique:product_variants',
        'variant_value' => 'required',
        // 'variant_code' => 'required|unique:product_variants',
        'variant_stock' => 'required|array',
        'variant_stock.*' => 'required|numeric',
        'variant_weight' => 'required|array',
        'variant_weight.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
        'variant_long' => 'required|array',
        'variant_long.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
        'variant_width' => 'required|array',
        'variant_width.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
        'variant_height' => 'required|array',
        'variant_height.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
        'variant_price' => 'required|array',
        'variant_price.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
        ],
        [
        'variant_name.required' => 'Nama produk harus diisi!',
        'variant_slug.required' => 'Slug harus diisi!',
        'variant_value.required' => 'Slug harus diisi!',
        'variant_slug.unique' => 'Slug harus unik!',
        'variant_code.required' => 'ID produk harus diisi!',
        'variant_code.unique' => 'ID produk harus unik!',
        'variant_weight.required' => 'Berat produk harus diisi',
        'variant_weight.*.regex' => 'Berat produk harus berupa angka',
        'variant_long.required' => 'Panjang produk harus diisi',
        'variant_long.*.regex' => 'Panjang produk harus berupa angka',
        'variant_width.required' => 'Lebar produk harus diisi',
        'variant_width.*.regex' => 'Lebar produk harus berupa angka',
        'variant_height.required' => 'Tinggi produk harus diisi',
        'variant_height.*.regex' => 'Tinggi produk harus berupa angka',
        'variant_price.required' => 'Harga produk harus diisi',
        'variant_price.*.regex' => 'Harga produk harus berupa angka',
        ]
        );
        // echo !empty(array_intersect($people, $criminals));
        echo "<br>";
        for ($i = 0; $i < count($request->variant_name); $i++) {
            if (isset($request->variant_id[$i])) {
            echo "1 <br>";
            echo "exists in database";
            echo "<br>";
            echo $request->variant_id[$i];
            echo "<br>";
            echo $request->variant_name[$i];
            echo "<br>";
            // echo $product->productvariant[$i]->variant_name;
            echo "<br>";

            $variantSender = ProductVariant::find($request->variant_id[$i]);
            foreach ($variantSender->productOrigin as $key => $variantOrigin) {
            echo 'variant origin : '.$variantOrigin;
            echo "<br>";
            foreach ($request->sender[$i] as $key => $sender) {
            // echo "--2 <br>";
            // echo "--" . $request->city_ids[$key];
            echo "<br>";
            echo "-- sender request id : " . $sender;
            echo "<br>";
            echo "<br>";
            if ($variantOrigin->sender_address_id == $sender) {
            echo "product origin exist";
            echo "<br>";
            echo "<br>";
            } else {
            echo "product origin NO exist";
            echo "<br>";
            echo ($variantOrigin->id);
            echo "<br>";
            echo "<br>";
            // $deleteVariantOrigin = ProductOrigin::find($variantOrigin->id)->delete();
            }
            }
            echo "<br>";
            }
            echo "<br>";
            // if($product->productvariant)
            echo "<br>";
            } else {
            echo "NO exists in database";
            echo "3 <br>";
            echo "<br>";
            echo $request->variant_name[$i];
            echo "<br>";
            foreach ($request->sender[$i] as $key => $sender) {
            echo "--4 <br>";
            echo "--" . $request->city_ids[$key];
            echo "<br>";
            echo "--" . $sender;
            echo "<br>";
            }
            echo "<br>";
            // $variant = ProductVariant::create([
            // 'product_id' => $product->id,
            // 'variant_name' => $request->variant_name[$i],
            // 'variant_slug' => $request->variant_slug[$i],
            // 'variant_value' => $request->variant_value[$i],
            // 'variant_code' => $request->variant_code[$i],
            // 'sold' => $request->sold,
            // 'stock' => $request->variant_stock[$i],
            // 'weight' => $request->variant_weight[$i],
            // 'long' => $request->variant_long[$i],
            // 'width' => $request->variant_width[$i],
            // 'height' => $request->variant_height[$i],
            // 'price' => $request->variant_price[$i],
            // 'promo_id' => $request->promo_id,
            // ]);
            foreach ($request->sender[$i] as $key => $sender) {
            // $productOrigin = ProductOrigin::create([
            // 'product_id' => $product->id,
            // 'product_variant_id' => $variant->id,
            // 'city_ids' => $request->city_ids[$key],
            // 'sender_address_id' => $sender,
            // ]);

            }
            }
            }
            for ($j = 0; $j < count($product->productvariant); $j++) {
                if (isset($request->variant_id[$j])) {
                echo $product->productvariant[0]->productorigin[0]->id;
                echo "<br>";
                // $deleteVariant = ProductVariant::find($product->productvariant[$j]->id);
                // $deleteVariant->delete();
                }
                foreach ($product->productvariant[$j]->productorigin as $key => $origin) {
                echo "origin - " . $key;
                echo "<br>";
                echo $origin->id;
                echo "<br>";
                // echo $request->sender[$i][$key];
                echo "<br>";
                echo "<br>";
                }
                echo "<br>";
                }

                echo "ada varian";
                echo '</br>';
                // $request->merge([
                // 'stock' => '0',
                // 'weight' => '0',
                // 'long' => '0',
                // 'width' => '0',
                // 'height' => '0',
                // 'price' => '0',
                // ]);

                if (!isset($request->is_active)) {
                $request->merge(['is_active' => '0']);
                echo "status tidak aktif";
                echo '</br>';
                }

                $validatedData = $request->validate(
                [
                'name' => 'required',
                'specification' => 'required',
                'description' => 'required',
                'excerpt' => 'required',
                'slug' => 'required',
                'product_code' => 'required',
                'product_category_id' => 'required',
                'product_merk_id' => 'required',
                'is_active' => 'required',
                ],
                [
                'name.required' => 'Nama produk harus diisi!',
                'specification.required' => 'Spesifikasi produk harus diisi!',
                'description.required' => 'Deskripsi produk harus diisi!',
                'excerpt.required' => 'Deskripsi singkat produk harus diisi!',
                'slug.required' => 'Slug harus diisi!',
                'product_code.required' => 'ID produk harus diisi!',
                'product_category_id.required' => 'Kategori produk harus diisi',
                'product_merk_id.required' => 'Merk produk harus diisi',
                ]
                );

                // $product->fill([
                // 'name' => $validatedData['name'],
                // 'slug' => $validatedData['slug'],
                // 'product_code' => $validatedData['product_code'],
                // 'product_category_id' => $validatedData['product_category_id'],
                // 'product_merk_id' => $validatedData['product_merk_id'],
                // 'excerpt' => $validatedData['excerpt'],
                // 'specification' => $validatedData['specification'],
                // 'description' => $validatedData['description'],
                // 'is_active' => $validatedData['is_active'],
                // ]);

                // $product->save();

                } else {
                echo "tidak ada varian";
                echo '</br>';
                }
                // $request->merge([
                // 'view' => '0',
                // 'sold' => '0',
                // 'stock_notification' => '1',
                // 'promo_id' => '0',
                // ]);


                dd($request);

                // dd($validatedData);

                // $product = Product::create($validatedData);

                print_r($product);
                echo "<br>";
                echo "<br>";

                // insert product variant
                if (isset($request->variant_name) || isset($request->variant_slug) ||
                isset($request->variant_value) || isset($request->variant_code) ||
                isset($request->variant_stock) || isset($request->variant_weight) ||
                isset($request->variant_long) || isset($request->variant_width) ||
                isset($request->variant_height) || isset($request->variant_price)) {
                $validatedDataVariant = $request->validate(
                [
                'variant_name' => 'required',
                'variant_slug' => 'required|unique:product_variants',
                'variant_value' => 'required',
                'variant_code' => 'required|unique:product_variants',
                'variant_stock' => 'required|array',
                'variant_stock.*' => 'required|numeric',
                'variant_weight' => 'required|array',
                'variant_weight.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'variant_long' => 'required|array',
                'variant_long.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'variant_width' => 'required|array',
                'variant_width.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'variant_height' => 'required|array',
                'variant_height.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'variant_price' => 'required|array',
                'variant_price.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                ],
                [
                'variant_name.required' => 'Nama produk harus diisi!',
                'variant_slug.required' => 'Slug harus diisi!',
                'variant_value.required' => 'Slug harus diisi!',
                'variant_slug.unique' => 'Slug harus unik!',
                'variant_code.required' => 'ID produk harus diisi!',
                'variant_code.unique' => 'ID produk harus unik!',
                'variant_weight.required' => 'Berat produk harus diisi',
                'variant_weight.*.regex' => 'Berat produk harus berupa angka',
                'variant_long.required' => 'Panjang produk harus diisi',
                'variant_long.*.regex' => 'Panjang produk harus berupa angka',
                'variant_width.required' => 'Lebar produk harus diisi',
                'variant_width.*.regex' => 'Lebar produk harus berupa angka',
                'variant_height.required' => 'Tinggi produk harus diisi',
                'variant_height.*.regex' => 'Tinggi produk harus berupa angka',
                'variant_price.required' => 'Harga produk harus diisi',
                'variant_price.*.regex' => 'Harga produk harus berupa angka',
                ]
                );
                for ($i = 0; $i < count($request->variant_name); $i++) {
                    $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'variant_name' => $request->variant_name[$i],
                    'variant_slug' => $request->variant_slug[$i],
                    'variant_value' => $request->variant_value[$i],
                    'variant_code' => $request->variant_code[$i],
                    'sold' => $request->sold,
                    'stock' => $request->variant_stock[$i],
                    'weight' => $request->variant_weight[$i],
                    'long' => $request->variant_long[$i],
                    'width' => $request->variant_width[$i],
                    'height' => $request->variant_height[$i],
                    'price' => $request->variant_price[$i],
                    'promo_id' => $request->promo_id,
                    ]);
                    print_r($variant);
                    echo "<br>";
                    echo "<br>";
                    foreach ($request->sender[$i] as $key => $sender) {
                    $productOrigin = ProductOrigin::create([
                    'product_id' => $product->id,
                    'product_variant_id' => $variant->id,
                    'city_ids' => $request->city_ids[$key],
                    'sender_address_id' => $sender,
                    ]);
                    }
                    echo "<br>";
                    }
                    } else {
                    // insert product origin
                    for ($i = 0; $i < count($request->sender); $i++) {
                        $productOrigin = ProductOrigin::create([
                        'product_id' => $product->id,
                        'city_ids' => $request->city_ids_single[$i],
                        'sender_address_id' => $request->sender[$i],
                        ]);
                        }
                        }

                        $admin = Admin::find($request->admin_id);
                        $loop = 0;
                        foreach ($request->productImageUpload as $productImage) {
                        $image_parts = explode(";base64,", $productImage);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];
                        $image_base64 = base64_decode($image_parts[1]);

                        // echo $productImage;
                        // print_r($image_parts);
                        // print_r($image_type);

                        $folderPathSave = 'admin/product/' . $product->id . '/';

                        $imageName = uniqid() . '-' . $loop++ . '.' . $image_type;

                        $imageFullPathSave = $folderPathSave . $imageName;

                        $save = Storage::put($imageFullPathSave, $image_base64);

                        $productImageSave = ProductImage::create([
                        'product_id' => $product->id,
                        'name' => $imageFullPathSave
                        ]);
                        }
                        // dd($validatedData);


                        // if ($request->admin_id == auth()->guard('adminMiddle')->user()->id) {
                        // echo 'admin id verified';
                        // echo '</br>';
                        // } else {
                        // abort(403);
                        // }
                        // if (!isset($request->productImageUpload) || !($request->file('productImage'))) {
                        // echo "Upload foto produk minimal satu foto";
                        // echo '</br>';
                        // }
                        // if (!isset($request->productImageUpload) || !($request->file('productImage'))) {
                        // echo "Upload foto produk minimal satu foto";
                        // echo '</br>';
                        // }
                        // dd($request);
                        if ($product || $variant && $productOrigin && $productImageSave) {
                        return redirect()->route('adminproduct.create')->with('addProductSuccess', 'Berhasil
                        menambahkan produk.');
                        } else {
                        return redirect()->back()->with('addProductFailed', 'Terdapat kesalahan saat menambahkan
                        produk , mohon pastikan semua form sudah terisi dengan benar');
                        }








                        // cek alamat pengiriman tidak boleh kosong
                        if (!isset($request->sender)) {
                        return redirect()->back()->with(['failed' => 'Alamat Pengiriman tidak boleh kosong']);
                        } else {
                        foreach ($request->variant_name as $key => $sender) {
                        if (!isset($request->sender[$key])) {
                        return redirect()->back()->with(['failed' => 'Alamat Pengiriman tidak boleh kosong']);
                        }
                        }
                        }
                        // cek apakah ada variant
                        if (isset($request->variant_name)) {
                        // validasi hasil input variant
                        $validatedDataVariant = $request->validate(
                        [
                        'variant_name' => 'required',
                        // 'variant_slug' => 'required|unique:product_variants',
                        'variant_value' => 'required',
                        // 'variant_code' => 'required|unique:product_variants',
                        'variant_stock' => 'required|array',
                        'variant_stock.*' => 'required|numeric',
                        'variant_weight' => 'required|array',
                        'variant_weight.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                        'variant_long' => 'required|array',
                        'variant_long.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                        'variant_width' => 'required|array',
                        'variant_width.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                        'variant_height' => 'required|array',
                        'variant_height.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                        'variant_price' => 'required|array',
                        'variant_price.*' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                        ],
                        [
                        'variant_name.required' => 'Nama produk harus diisi!',
                        'variant_slug.required' => 'Slug harus diisi!',
                        'variant_value.required' => 'Slug harus diisi!',
                        'variant_slug.unique' => 'Slug harus unik!',
                        'variant_code.required' => 'ID produk harus diisi!',
                        'variant_code.unique' => 'ID produk harus unik!',
                        'variant_weight.required' => 'Berat produk harus diisi',
                        'variant_weight.*.regex' => 'Berat produk harus berupa angka',
                        'variant_long.required' => 'Panjang produk harus diisi',
                        'variant_long.*.regex' => 'Panjang produk harus berupa angka',
                        'variant_width.required' => 'Lebar produk harus diisi',
                        'variant_width.*.regex' => 'Lebar produk harus berupa angka',
                        'variant_height.required' => 'Tinggi produk harus diisi',
                        'variant_height.*.regex' => 'Tinggi produk harus berupa angka',
                        'variant_price.required' => 'Harga produk harus diisi',
                        'variant_price.*.regex' => 'Harga produk harus berupa angka',
                        ]
                        );

                        // task untuk menghapus variant yang ingin dihapus
                        for ($i = 0; $i < count($product->productvariant); $i++) {
                            $deleteVariant = ProductVariant::where('product_id', $product->id)->whereNotIn('id',
                            $request->variant_id)->get();
                            // dd(count($deleteVariant));
                            if (count($deleteVariant) > 0) {
                            foreach ($deleteVariant as $key => $delete) {
                            echo 'should be delete : ' . $delete->id;
                            echo "<br>";
                            foreach ($delete->productorigin as $key => $origin) {
                            echo ' - origin should be delete : ' . $origin->id;
                            echo "<br>";
                            $origin->delete();
                            }
                            $deleteVariant->each->delete();
                            echo "<br>";
                            }
                            echo "id variant in db : ";
                            echo $deleteVariant[$i]->id;
                            echo "<br>";
                            }
                            }

                            // task untuk menambahkan variant
                            for ($i = 0; $i < count($request->variant_name); $i++) {
                                echo "variant - " . $i;
                                echo "<br>";

                                // cek apakah variant yang ada telah ada di DB dan melakukan update variant
                                if (isset($request->variant_id[$i])) {
                                $variantUpdate = ProductVariant::where('product_id', $product->id)->where('id',
                                $request->variant_id[$i])->first();

                                if ($variantUpdate) {
                                print_r($variantUpdate->id);
                                echo "<br>";
                                } else {
                                echo 'not found in db';
                                echo "<br>";
                                }

                                echo "1 <br>";
                                echo "exists in database";
                                echo "<br>";
                                echo "variant id : ";
                                echo $request->variant_id[$i];
                                echo "<br>";
                                echo "variant name : ";
                                echo $request->variant_name[$i];
                                echo "<br>";
                                echo "variant product variant name : ";
                                echo $product->productvariant[$i]->variant_name;
                                echo "<br>";

                                // query update variant
                                $updateVariant = $variantUpdate->fill([
                                'variant_name' => $request->variant_name[$i],
                                'variant_slug' => $request->variant_slug[$i],
                                'variant_value' => $request->variant_value[$i],
                                'variant_code' => $request->variant_code[$i],
                                'sold' => 0,
                                'stock' => $request->variant_stock[$i],
                                'weight' => $request->variant_weight[$i],
                                'long' => $request->variant_long[$i],
                                'width' => $request->variant_width[$i],
                                'height' => $request->variant_height[$i],
                                'price' => $request->variant_price[$i],
                                ]);

                                // task save update variant
                                $save = $updateVariant->save();

                                // jika berhasil simpan maka selanjutnya dicek apakah ada perubahan di alamat
                                pengiriman
                                if ($save) {

                                echo "variant product variant name 2 : ";
                                echo $product->productvariant[$i]->variant_name;
                                echo "<br>";
                                // echo "before update : ";
                                // print_r($variantUpdate);
                                // echo "after update : ";
                                // echo "<br>";
                                // print_r($updateVariant);
                                echo "<br>";

                                if (count($variantUpdate->productorigin) > 0) {
                                foreach ($request->sender[$i] as $key => $sender) {
                                echo "1. sender checked sub : ";
                                echo $sender;
                                echo "<br>";
                                echo " -- variant id : ";
                                echo $updateVariant->id;
                                echo "<br>";
                                echo " -- sender i : ";
                                print_r($request->sender[$i]);
                                echo "<br>";
                                print_r($request->city_ids[$i]);
                                echo "<br>";
                                $originUpdate = ProductOrigin::where('product_id',
                                $product->id)->where('product_variant_id',
                                $updateVariant->id)->whereNotIn('sender_address_id',
                                [$request->sender[$i]])->get();

                                foreach ($originUpdate as $origin) {
                                print_r($origin->sender_address_id);
                                echo "<br>";
                                echo "<br>";
                                }
                                }
                                // foreach ($variantUpdate->productorigin as $key => $origin) {
                                // echo $origin->id;
                                // echo "<br>";
                                // if (isset($request->sender[$i][$key])) {
                                // echo "id product : " . $product->id;
                                // echo "<br>";
                                // echo "id product variant : " . $variantUpdate->id;
                                // echo "<br>";
                                // echo "id request sender : " . $request->sender[$i][$key];
                                // echo "<br>";
                                // }
                                // }
                                echo "<br>";
                                } else {
                                echo "sender checked : ";
                                print_r($request->sender[$i]);
                                echo "<br>";
                                foreach ($request->sender[$i] as $key => $sender) {
                                echo "sender checked sub : ";
                                echo $sender;
                                echo "<br>";
                                print_r($request->city_ids[$i]);
                                echo "<br>";
                                $productOrigin = ProductOrigin::create([
                                'product_id' => $product->id,
                                'product_variant_id' => $updateVariant->id,
                                'city_ids' => $request->city_ids[$i],
                                'sender_address_id' => $sender,
                                ]);
                                }
                                echo "<br>";
                                }
                                }
                                echo "<br>";
                                } else {
                                echo $request->variant_name[$i];
                                echo "<br>";
                                foreach ($request->sender[$i] as $key => $sender) {
                                echo "sender : ";
                                echo $sender;
                                echo "<br>";
                                }
                                $addVariant = ProductVariant::create([
                                'product_id' => $product->id,
                                'variant_name' => $request->variant_name[$i],
                                'variant_slug' => $request->variant_slug[$i],
                                'variant_value' => $request->variant_value[$i],
                                'variant_code' => $request->variant_code[$i],
                                'sold' => 0,
                                'stock' => $request->variant_stock[$i],
                                'weight' => $request->variant_weight[$i],
                                'long' => $request->variant_long[$i],
                                'width' => $request->variant_width[$i],
                                'height' => $request->variant_height[$i],
                                'price' => $request->variant_price[$i],
                                'promo_id' => 0,
                                ]);

                                if ($addVariant) {
                                foreach ($request->sender[$i] as $key => $sender) {
                                echo "sender : ";
                                echo $sender;
                                echo "<br>";
                                $productOrigin = ProductOrigin::create([
                                'product_id' => $product->id,
                                'product_variant_id' => $addVariant->id,
                                'city_ids' => $request->city_ids[$key],
                                'sender_address_id' => $sender,
                                ]);
                                }
                                echo 'sukses menambahkan variant';
                                echo "<br>";
                                } else {
                                echo 'gagal menambahkan variant';
                                echo "<br>";
                                }
                                }
                                }
                                }

                                // if()
                                dd($request);

                                @foreach ($product->productorigin as $origin)
                                    @if ($origin->senderaddress->is_active == 1)
                                        @if (isset($origin->productvariant))
                                            <input class="my-2" type="text"
                                                name="variant_id-{{ $origin->productvariant->id }}"
                                                id="{{ $origin->productvariant->id }}"
                                                value="{{ $origin->productvariant->id }}">
                                            <input class="my-2" type="text"
                                                name="sender_address_id-{{ $origin->productvariant->id }}"
                                                id="{{ $origin->senderaddress->id }}"
                                                value="{{ $origin->senderaddress->id }}">
                                            <input class="my-2" type="text"
                                                name="sender_address_name-{{ $origin->productvariant->id }}"
                                                id="{{ $origin->senderaddress->id }}"
                                                value="{{ $origin->senderaddress->name }}">
                                            <input class="my-2" type="text"
                                                name="sender_address_city-{{ $origin->productvariant->id }}"
                                                id="{{ $origin->senderaddress->id }}"
                                                value="{{ $origin->senderaddress->city->name }}">
                                            <input class="my-2" type="text"
                                                name="city_ids-{{ $origin->productvariant->id }}"
                                                id="{{ $origin->city_ids }}"
                                                value="{{ $origin->city_ids }}">
                                        @else
                                        @endif
                                    @endif
                                    <br>
                                    <br>
                                @endforeach
                                <div class="row d-flex align-items-center text-center">
                                    <div class="col-md-2 col-1 fs-14 ps-md-4 text-start">
                                    </div>
                                    <div class="col-md-3 col-12 fs-14 ps-4 text-start">
                                        Alamat Pengirim
                                    </div>
                                    <div class="col-md-6 col-12  fs-14 ps-md-4 text-start">
                                        {{-- <p>Lokasi pengiriman yang tersedia</p> --}}
                                        <select class="form-select sender-address form-select-sm shadow-none"
                                            aria-label="" name="city_origin_cartitems" required>
                                            <option selected="true" value="" disabled="disabled">
                                                Pilih alamat
                                                pengirim
                                            </option>
                                            @foreach ($cart->product->productorigin as $origin)
                                                @if ($origin->senderaddress->is_active == 1)
                                                    @if (isset($origin->productvariant))
                                                        {{-- {{ $origin->productvariant->variant_name }}
                                                    {{ $origin->senderaddress->name }} -
                                                    {{ $origin->city->name == 'Kotawaringin Timur' ? $origin->city->name . ' (Sampit)' : $origin->city->name }}
                                                    <input type="hidden" class="variant" id="{{  $origin->productvariant->id }}" value="{{ $origin->city_ids }}"> --}}
                                                    @else
                                                        <option value="{{ $origin->senderaddress->id }}">
                                                            {{ $origin->city->name == 'Kotawaringin Timur' ? $origin->city->name . ' (Sampit)' : $origin->city->name }}
                                                            -
                                                            ({{ $origin->senderaddress->address }})
                                                        </option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="card checkout-address-card mb-4">
                                    <div class="card-body p-4">
                                        <div class="row d-flex align-items-center">
                                            @if (count(auth()->user()->useraddress) > 0)
                                                <div class="col-md-10">
                                                    {{-- <p class="m-0 mb-2 checkout-shipment-address-text">
                                        Alamat Pengiriman
                                    </p> --}}
                                                    <div class="checkout-shipment-address">
                                                        @foreach ($senderAddress as $address)
                                                            {{-- @if ($address->is_active == 1) --}}
                                                            <p class="m-0 checkout-shipment-address-name">
                                                                {{ $address->name }}
                                                            </p>
                                                            <p class="m-0 checkout-shipment-address-phone">
                                                                {{ $address->telp_no }}
                                                            </p>
                                                            <p class="m-0 checkout-shipment-address-address">
                                                                {{ $address->address }}
                                                            </p>
                                                            <div class="checkout-shipment-address-city">
                                                                <span class="m-0 me-1 ">
                                                                    {{ $address->city->name }},
                                                                </span>
                                                                <span
                                                                    class="m-0 checkout-shipment-address-province">
                                                                    {{ $address->province->name }}
                                                                </span>
                                                                <span
                                                                    class="m-0 checkout-shipment-address-postalcode">
                                                                    {{ !empty($address->postal_code) ? ', ' . $address->postal_code : '' }}
                                                                </span>
                                                            </div>
                                                            <div class="input-data">
                                                                <input class="city-origin" type="hidden"
                                                                    name="cityOrigin" value="36">
                                                                <input class="address-id" type="hidden"
                                                                    name="addressId"
                                                                    value="{{ $address->id }}">
                                                                <input class="city-destination"
                                                                    type="hidden" name="cityDestination"
                                                                    value="{{ $address->city->city_id }}">
                                                            </div>
                                                            {{-- @endif --}}
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button"
                                                        class="btn shadow-none checkout-change-shipment-address p-0 py-3"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#addressModal">
                                                        Ubah Alamat
                                                    </button>
                                                </div>
                                            @else
                                                <div class="col-md-12">
                                                    <div class="product-no-auth-shipment-check">
                                                        Kamu belum menambahkan alamat, yuk
                                                        <a href="{{ route('useraddress.index') }}"
                                                            target="_blank"
                                                            class="text-decoration-none fw-bold login-link">
                                                            Tambahkan Alamat
                                                        </a>
                                                        untuk melihat biaya ongkir ke lokasimu
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

{{-- userNotification.index  --}}

@extends('layouts.main')

@section('container')
    <div class="container-fluid breadcrumb">
        {{ Breadcrumbs::render('notification') }}
    </div>
    @if (count($notifications) > 1)
        <div class="container mb-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-9 col-12">
                    @foreach ($notifications as $notification)
                        <div class="card mb-3 notification-card">
                            <div class="card-body p-4">
                                <a href="{{ route('notifications.show', $notification) }}"
                                    class="text-dark text-decoration-none">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="heeader d-flex align-items-center">
                                                <h5 class="mt-0 notification-list-excerpt me-auto">
                                                    {{ $notification->type }}
                                                </h5>
                                                @if ($notification->is_read == 0)
                                                    <span class="ms-auto badge bg-danger">Belum dibaca</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-1 col-2">
                                            <img id="main-image" class="cart-items-img"
                                                src="https://source.unsplash.com/400x400?product-1" class="img-fluid"
                                                alt="..." width="60" height="60">
                                        </div>
                                        <div class="col-md-11">
                                            <span class="d-flex notification-list-created-at mb-1">
                                                <p class="m-0">{{ $notification->created_at }}</p>
                                                <p class="m-0 ms-1">{{ $notification->created_at->diffForHumans() }}
                                                </p>
                                            </span>
                                            <p class="notification-list-excerpt text-truncate">
                                                {{ $notification->excerpt }}
                                            </p>
                                        </div>
                                    </div>
                                    {{-- <div class="media d-flex align-items-center">
                                    <div class="img-notification me-3">
                                        <img id="main-image" class="cart-items-img"
                                        src="https://source.unsplash.com/400x400?product-1" class="img-fluid"
                                        alt="..." width="60" height="60">
                                    </div>
                                    <div class="media-body text-truncate">
                                        <h5 class="mt-0 notification-list-excerpt">{{ $notification->type }}</h5>
                                        <p class="notification-list-excerpt text-truncate">{{ $notification->excerpt }}</p>
                                        <span class="d-flex notification-list-created-at">
                                            <p>{{ $notification->created_at }}</p>
                                            <p class="ms-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </span>
                                    </div>
                                </div> --}}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="text-center cart-items-empty">
            <img class="my-4 cart-items-logo" src="/assets/footer-logo.png" width="300" alt="">
            <p>
                Tidak ada notifikasi buat kamu sekarang ini
            </p>
        </div>
    @endif
@endsection


{{-- sidebar --}}

            {{-- <div class="order-status mb-3 d-flex overflow-auto pb-2">
                <div class="status-form">
                    <a href="{{ route('adminorder.index') }}"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem bg-white {{ isset($status) ? ($status == '' ? 'active-menu border-danger' : '') : '' }}">
                        Semua
                    </a>
                </div>
                <form class="status-form" action="{{ route('adminorder.index') }}" method="GET">
                    <input type="hidden" name="status" value="belum bayar">
                    <button type="submit"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem bg-white {{ isset($status) ? ($status == 'belum bayar' ? 'active-menu border-danger' : '') : '' }}">
                        Belum&nbsp;Bayar
                    </button>
                </form>
                <form class="status-form" action="{{ route('adminorder.index') }}" method="GET">
                    <input type="hidden" name="status" value="pesanan dibayarkan">
                    <button type="submit"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem bg-white {{ isset($status) ? ($status == 'pesanan dibayarkan' ? 'active-menu border-danger' : '') : '' }}">
                        Verifikasi&nbsp;Pembayaran
                    </button>
                </form>
                <form class="status-form" action="{{ route('adminorder.index') }}" method="GET">
                    <input type="hidden" name="status" value="dikemas">
                    <button type="submit"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem bg-white {{ isset($status) ? ($status == 'dikemas' ? 'active-menu border-danger' : '') : '' }}">
                        Dikemas
                    </button>
                </form>
                <form class="status-form" action="{{ route('adminorder.index') }}" method="GET">
                    <input type="hidden" name="status" value="dikirim">
                    <button type="submit"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem bg-white {{ isset($status) ? ($status == 'dikirim' ? 'active-menu border-danger' : '') : '' }}">
                        Dikirim
                    </button>
                </form>
                <form class="status-form" action="{{ route('adminorder.index') }}" method="GET">
                    <input type="hidden" name="status" value="selesai">
                    <button type="submit"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem bg-white {{ isset($status) ? ($status == 'selesai' ? 'active-menu border-danger' : '') : '' }}">
                        Selesai
                    </button>
                </form>
                <form class="status-form" action="{{ route('adminorder.index') }}" method="GET">
                    <input type="hidden" name="status" value="expired">
                    <button type="submit"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem bg-white {{ isset($status) ? ($status == 'expired' ? 'active-menu border-danger' : '') : '' }}">
                        Dibatalkan
                    </button>
                </form> --}}
            {{-- <form class="status-form" action="{{ route('adminorder.index') }}" method="GET">
                    <input type="hidden" name="status" value="expired">
                    <button type="submit"
                        class="btn text-dark text-decoration-none shadow-none fs-13 btn-order-status btn-outline-danger me-2 my-1 shadow-none border-radius-075rem {{ isset($status) ? ($status == 'expired' ? 'active-menu border-danger' : '') : '' }}">
                        Kadaluarsa
                    </button>
                </form> --}}
            {{-- </div> --}}

            <td>
                <div class="d-flex">

                    @if (!is_null($order->orderitem[0]->orderproduct->orderproductimage->first()))
                        <img id="payment-method-image" class="img-fluid pe-2"
                            src="{{ asset('/storage/' . $order->orderitem[0]->orderproduct->orderproductimage->first()->name) }}"
                            alt="..." width="10%" height="10%">
                        {{-- <img src="{{ asset('/storage/' . $order->orderitem[0]->orderproduct->orderproductimage->first()->name) }}"
                        class="image-fluid border-radius-5px {{ $order->order_status == 'pesanan dibatalkan' || $order->order_status == 'expired' ? 'grayscale-filter' : '' }}"
                        alt="" width="10%" height="10$"> --}}
                    @endif
                    <div class="text-truncate">
                        <div class=" order-items-product-name fw-600">
                            {{ $order->orderitem[0]->orderproduct->name }}
                        </div>
                    </div>
                    {{-- <div class="text-truncate">
                    <div class=" order-items-product-name fw-600">
                        {{ $order->orderitem[0]->orderproduct->name }}
                    </div>
                    <div
                        class="text-truncate order-items-product-variant text-grey fs-12">
                        Varian:
                        {{ !is_null($order->orderitem[0]->orderproduct->variant_name) ? $order->orderitem[0]->orderproduct->variant_name : 'Tidak ada Varian' }}
                    </div>
                    <div
                        class="text-truncate order-items-product-price-qty text-grey text-end text-md-start fs-12">
                        {{ $order->orderitem[0]->quantity }} x
                        Rp{{ price_format_rupiah($order->orderitem[0]->orderproduct->price) }}
                    </div>
                </div> --}}
                </div>
            </td>  <td>
                <div class="d-flex">

                    @if (!is_null($order->orderitem[0]->orderproduct->orderproductimage->first()))
                        <img id="payment-method-image" class="img-fluid pe-2"
                            src="{{ asset('/storage/' . $order->orderitem[0]->orderproduct->orderproductimage->first()->name) }}"
                            alt="..." width="10%" height="10%">
                        {{-- <img src="{{ asset('/storage/' . $order->orderitem[0]->orderproduct->orderproductimage->first()->name) }}"
                        class="image-fluid border-radius-5px {{ $order->order_status == 'pesanan dibatalkan' || $order->order_status == 'expired' ? 'grayscale-filter' : '' }}"
                        alt="" width="10%" height="10$"> --}}
                    @endif
                    <div class="text-truncate">
                        <div class=" order-items-product-name fw-600">
                            {{ $order->orderitem[0]->orderproduct->name }}
                        </div>
                    </div>
                    {{-- <div class="text-truncate">
                    <div class=" order-items-product-name fw-600">
                        {{ $order->orderitem[0]->orderproduct->name }}
                    </div>
                    <div
                        class="text-truncate order-items-product-variant text-grey fs-12">
                        Varian:
                        {{ !is_null($order->orderitem[0]->orderproduct->variant_name) ? $order->orderitem[0]->orderproduct->variant_name : 'Tidak ada Varian' }}
                    </div>
                    <div
                        class="text-truncate order-items-product-price-qty text-grey text-end text-md-start fs-12">
                        {{ $order->orderitem[0]->quantity }} x
                        Rp{{ price_format_rupiah($order->orderitem[0]->orderproduct->price) }}
                    </div>
                </div> --}}
                </div>
            </td>

            {{-- checkout --}}
            <form class="checkout-bill-form d-none" action="{{ route('checkout.payment') }}"
                                onsubmit="return validateCheckout()" method="POST">
                                @csrf
                                @foreach ($items as $item)
                                    <input type="hidden" name="product-id[]" value="{{ $item->id }}">
                                    {{-- <input type="hidden" name="product-qty[]" value="{{ $item->quantity }}">
                                    <input type="hidden" name="product-subtotal[]" value="{{ $item->subtotal }}"> --}}
                                @endforeach

                                @foreach ($weight as $weightItem)
                                    <input type="hidden" name="product-weight[]" value="{{ $weightItem }}">
                                @endforeach

                                <input type="hidden" name="user-id" value="{{ auth()->user()->id }}">

                                <div class="input-data-shipment">

                                    @foreach ($userAddress as $address)
                                        @if ($address->is_active == 1)
                                            <input class="address-id" type="hidden" name="addressId"
                                                value="{{ $address->id }}">
                                            <input class="city-origin" type="hidden" name="cityOrigin" value="36">
                                            <input class="city-destination" type="hidden" name="cityDestination"
                                                value="{{ $address->city->city_id }}">
                                        @endif
                                    @endforeach

                                    <input type="hidden" class="courier-name-choosen" name="courier-name-choosen"
                                        value="">
                                    <input type="hidden" class="courier-service-choosen" name="courier-service-choosen"
                                        value="">
                                    <input type="hidden" class="courier-etd-choosen" name="courier-etd-choosen"
                                        value="">
                                    <input type="hidden" class="courier-price-choosen" name="courier-price-choosen"
                                        value="">
                                </div>

                                <div class="input-data-item-detail">
                                    <input class="csrf-token" type="hidden" name="csrf_token"
                                        value="{{ csrf_token() }}">
                                    <input class="total-weight" type="hidden" name="total_weight"
                                        value="{{ array_sum($weight) }}">
                                    <input class="total-subtotal" type="hidden" name="total_subtotal"
                                        value="{{ is_null($items[0]->id) ? $items[0]->subtotal : $items->sum('subtotal') }}">
                                    <input class="courier" type="hidden" name="courier" value="all">
                                </div>

                                <h5 class="cart-items-checkout-header cart-items-checkout-header mt-1 mb-4">Ringkasan
                                    Pesanan</h5>
                                <div class="row">
                                    <div class="col-7 checkout-items-total-text cart-items-total-text pe-0">
                                        Total Harga ({{ count($items) }}) Produk
                                    </div>
                                    <div class="col-5 cart-items-total-val text-end">
                                        Rp{{ price_format_rupiah(is_null($items[0]->id) ? $items[0]->subtotal : $items->sum('subtotal')) }}
                                        {{-- Rp{{ price_format_rupiah($items['subtotal']) }} --}}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div
                                        class="col-7 checkout-items-text cart-items-total-text pe-0 total-weight-checkout">
                                        Berat total: <span class="total-weight-checkout"></span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-7 checkout-shipment-total-text cart-items-total-text pe-0">
                                    </div>
                                    <div class="col-5 checkout-shipment-total-val fs-14 m-0 text-end">
                                    </div>
                                </div>
                                {{-- <div class="row mb-2 mt-3">
                                    <div class="col-12">
                                        <a class="w-100 btn btn-light border-radius-05rem fs-14 py-2 px-3"
                                            data-bs-toggle="modal" data-bs-target="#promoModal">
                                            <div class="d-flex">
                                                <div class="">
                                                    <i class="bi bi-percent"></i> Masukkan/Gunakan Kode Promo
                                                </div>
                                                <div class="ms-auto">
                                                    <i class="bi bi-chevron-right"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div> --}}
                                <div class="my-4 border border-1 border-bottom cart-items-checkout-divider">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="checkout-total-all-text cart-items-checkout-total-all-text mt-1 mb-4">
                                            Total harga</p>
                                    </div>
                                    <div class="col-6 checkout-total-all-val cart-items-total-all-val text-end fw-bold">
                                    </div>
                                    <input type="hidden" name="checkout_total_price" value="">
                                </div>
                                <div class="d-grid">
                                    {{-- <button type="button"
                                        class="btn btn-block checkout-button show-payment-modal-button shadow-none">
                                        Pilih Metode Pembayaran
                                    </button> --}}
                                    <button type="button"
                                        class="btn btn-block checkout-button show-payment-modal-button shadow-none"
                                        data-bs-toggle="modal" data-bs-target="#paymentModal">
                                        Pilih Metode Pembayaran
                                    </button>
                                </div>
                            </form>

                            
        // if ($request->checkout_total_prices >= $promo->min_transaction) {
        //     if ($promo->promo_type_id == 1 || $promo->promo_type_id == 2) {
        //     } elseif ($promo->promo_type_id == 3 || $promo->promo_type_id == 4) {
        //         if ($promo->promo_type_id == 3) {
        //             $discount = $request->checkout_total_prices * $promo->discount / 100;
        //         } elseif ($promo->promo_type_id == 4) {
        //             $discount = (int)$request->checkout_total_prices - (int)$promo->discount;
        //         }
        //     }
        // }




        
        $now = Carbon::now();

        $orders = Order::where('user_id', '=', auth()->user()->id)->withTrashed()->orderByDesc('created_at')->get();
        // print_r($orders);
        // dd($orders[0]->orderitem[0]->orderproduct->orderproductimage[0]->name);
        // dd($orders[0]->orderitem->count());
        foreach ($orders as $userOrder) {
            echo "order: ";
            print_r($userOrder->id);
            echo "<br><br>";
            // $userOrder->uuid = Hash::make($userOrder->id);

            if (is_null($userOrder->deleted_at) && is_null($userOrder->invoice_no)) {
                echo "null deleted at dan invoice no";
                echo "<br><br>";

                $due_date = Carbon::createFromFormat('Y-m-d H:s:i', $userOrder->payment_due_date);
                // dd($due_date);
                if ($now > $due_date) {
                    // dd('expired');
                    $userOrder->order_status = 'expired';
                    $userOrder->save();
                    if ($userOrder->save()) {
                        foreach ($userOrder->orderitem as $item) {
                            $item->order_item_status = 'expired';
                            $item->save();
                        }
                    }
                    $userOrder->delete();
                }
            } elseif (!is_null($userOrder->deleted_at) && is_null($userOrder->invoice_no)) {
                echo "tidak null deleted at dan null invoice no";
                echo "<br><br>";
                $deleted_at = Carbon::createFromFormat('Y-m-d H:s:i', $userOrder->deleted_at);
                $diff_in_hours = $deleted_at->diffInHours($now);
                echo 'deleted at : ' . $deleted_at;
                echo "<br><br>";
                echo 'now : ' . $now;
                echo "<br><br>";
                echo 'diff : ' . $diff_in_hours;
                echo "<br><br>";

                if ($diff_in_hours > 24) {
                    echo $deleted_at;
                    echo "<br><br>";
                    echo $now;
                    echo "<br><br>";
                    echo "arr : ";
                    print_r($diff_in_hours);
                    echo "<br><br>";
                    // $userOrder->forceDelete();

                    foreach ($userOrder->orderItem as $orderItem) {
                        echo "order item : ";
                        print_r($orderItem);
                        echo "<br><br>";
                        echo "order product : ";
                        print_r($orderItem->orderproduct);
                        echo "<br><br>";
                        echo "prod image count : ";
                        print_r(($orderItem->orderproduct));
                        // print_r($orderItem->orderproduct->orderproductimage);

                        if ($orderItem->orderproduct->orderproductimage->count()) {
                            print_r($orderItem->product->productImage);
                            echo "<br><br>";
                            foreach ($orderItem->orderProduct->orderProductImage as $orderProductImage) {
                            }
                            echo "order item id: " . $orderItem->id;
                            echo "<br><br>";
                            echo "order item product id: " . $orderItem->product_id;
                            echo "<br><br>";
                            echo "order item product variant id: " . $orderItem->product_variant_id;
                            echo "<br><br>";

                            $cartItem = CartItem::where([['user_id', '=', auth()->user()->id], ['product_id', '=', $orderItem->product_id], ['product_variant_id', '=', $orderItem->product_variant_id]])->withTrashed()->first();
                            if (!is_null($cartItem)) {
                                echo "mengembalikan item ke keranjang dengan id : ";
                                echo $cartItem->id;
                                echo "<br><br>";
                                $cartItem->deleted_at = NULL;
                                $cartItem->save();
                            }
                            $orderProductImage->delete();
                            $orderItem->orderProduct->delete();
                            print_r($cartItem);
                        } else {
                            print_r('else');
                            echo "<br><br>";

                            $cartItem = CartItem::where([['user_id', '=', auth()->user()->id], ['product_id', '=', $orderItem->product_id], ['product_variant_id', '=', $orderItem->product_variant_id]])->withTrashed()->first();
                            if (!is_null($cartItem)) {
                                $cartItem->deleted_at = NULL;
                                $cartItem->save();
                            }
                            // $orderProductImage->delete();
                            // $orderItem->orderProduct->delete();
                        }
                        // $orderItem->delete();
                    }
                    // $userOrder->forceDelete();   
                    // foreach ($orders->orderItem as $orderItem) {
                    //     foreach ($orderItem->orderProduct->orderProductImage as $orderProductImage) {
                    //         $orderProductImage->delete();
                    //         $orderItem->orderProduct->delete();
                    //     }
                    //     $orderItem->delete();
                    // }
                    // $orders->forceDelete();
                }
            }
        }