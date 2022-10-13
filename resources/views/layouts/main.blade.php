<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>KLIKSPL | {{ isset($title) ? $title : '' }}</title>

    {{-- ICON WEB --}}
    <link rel="shortcut icon" href="/assets/klikspl.ico">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    {{-- Bootstrap ICON --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    {{-- Style CSS --}}
    <link rel="stylesheet" href="/css/style.css">

    {{-- SELECT2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" />

    {{-- SCRIPT JQUERY --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/js/script.js" type="text/javascript"></script>

    {{-- XZOOM --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/xzoom/dist/xzoom.css" media="all" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easyzoom@2.5.3/css/easyzoom.css" />
    <script src="https://cdn.jsdelivr.net/npm/easyzoom@2.5.3/src/easyzoom.js"></script>
    
    {{-- cropper.js --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/2.0.0-alpha.2/cropper.min.css"
        integrity="sha512-6QxSiaKfNSQmmqwqpTNyhHErr+Bbm8u8HHSiinMEz0uimy9nu7lc/2NaXJiUJj2y4BApd5vgDjSHyLzC8nP6Ng=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/2.0.0-alpha.2/cropper.min.js"
        integrity="sha512-IlZV3863HqEgMeFLVllRjbNOoh8uVj0kgx0aYxgt4rdBABTZCl/h5MfshHD9BrnVs6Rs9yNN7kUQpzhcLkNmHw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"
        integrity="sha256-6XMVI0zB8cRzfZjqKcD01PBsAy3FlDASrlC8SxCpInY=" crossorigin="anonymous"></script> --}}
</head>

<body>
    @include('partials.top-nav')
    @include('partials.navbar')
    {{-- @include('partials.navbar-mobile') --}}
    <div class="container main">
        @yield('container')
    </div>
    @include('partials.bottom-nav')
    @include('partials.footer')

    {{-- SCRIPT JQUERY --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}

    {{-- SCRIPT BOOTSTRAP 5 Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    {{-- XZOOM JS --}}
    <script type="text/javascript" src="https://unpkg.com/xzoom/dist/xzoom.min.js"></script>
    {{-- FONTAWESOME --}}
    <script src="https://kit.fontawesome.com/c4d8626996.js" crossorigin="anonymous"></script>

    <script src="/js/script.js" type="text/javascript"></script>
    @yield('config.manual-js')
    {{-- SELECT2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>

</html>
