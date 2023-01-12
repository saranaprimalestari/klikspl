<div class="container-fluid footer-main border-top d-none d-sm-block">
    <div class="container footer-content py-5">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-6">
                <h5 class="fs-6 footer-text">LAYANAN PELANGGAN</h5>
                <ul class="list-unstyled">
                    <li>
                        <a class="footer-text" href="">Pusat Bantuan</a>
                    </li>
                    <li>
                        <a class="footer-text" href="{{ route('payment.method') }}">Metode Pembayaran</a>
                    </li>
                    <li>
                        <a class="footer-text" href="">Tracking Pengiriman</a>
                    </li>
                    <li>
                        <a class="footer-text" target="_blank" href="{{ url('https://wa.me/628115102888') }}">Hubungi Kami</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-6 col-6">
                <h5 class="fs-6 footer-text">IKUTI KAMI</h5>
                <ul class="list-unstyled">
                    <li>
                        <a class="footer-text" href="{{ url('https://saranaprimalestari.com') }}"><i class="bi bi-globe"></i> Official Website</a>
                    </li>
                    <li>
                        <a class="footer-text" href="{{ url('https://www.facebook.com/cv.saranaprimalestari') }}"><i class="bi bi-facebook"></i> Facebook</a>
                    </li>
                    <li>
                        <a class="footer-text" href="{{ url('https://www.instagram.com/saranaprimalestari/') }}"><i class="bi bi-instagram"></i> Instagram</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-6 col-6">
                <h5 class="fs-6 footer-text">Pengujung</h5>
                <table>
                    <tr>
                        <td class="footer-text">Hari ini</td>
                        <td class="footer-text px-1">  </td>
                        <td class="footer-text text-end">{{ count($visitorDay) }}</td>
                    </tr>
                    <tr>
                        <td class="footer-text">Bulan ini</td>
                        <td class="footer-text px-1">  </td>
                        <td class="footer-text text-end">{{ count($visitorThisMonth) }}</td>
                    </tr>
                    <tr>
                        <td class="footer-text">Total</td>
                        <td class="footer-text px-1">  </td>
                        <td class="footer-text text-end">{{ count($visitorTotal) }}</td>
                    </tr>
                </table>
                {{-- <ul class="list-unstyled">
                    <li>
                        <div class="footer-text m-0 row">
                            <div class="col-4">Hari ini</div>
                            <div class="col-1">:</div>
                            <div class="col-7">11</div>
                        </div>
                    </li>
                    <li>
                        <span class="footer-text m-0">
                            Hari ini : 11
                        </span>
                    </li>
                    <li>
                        <span class="footer-text m-0">
                            Bulan ini : 11
                        </span>
                    </li>
                    <li>
                        <span class="footer-text m-0">
                            Total : 11
                        </span>
                    </li>
                </ul> --}}
            </div>
            <div class="col-md-5 col-sm-6 col-6">
                <img class="footer-logo w-100" src="{{ asset('/assets/footer-logo.svg') }}" alt="">
            </div>
            </div>
        </div>
    </div>
</div>