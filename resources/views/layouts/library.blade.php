<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Klikspl - {{ isset($title) ? $title : '' }}</title>

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
    <script src="/js/moment-with-locales.js" type="text/javascript"></script>
    <script src="/js/script.js" type="text/javascript"></script>

</head>

<body>
    {{-- @include('partials.navbar-mobile') --}}
    <div class="container main-library">
        @yield('container')
    </div>

</body>
{{-- SCRIPT JQUERY --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

{{-- SCRIPT BOOTSTRAP 5 Bundle --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>

{{-- FONTAWESOME --}}
<script src="https://kit.fontawesome.com/c4d8626996.js" crossorigin="anonymous"></script>
<script src="/js/moment-with-locales.js" type="text/javascript"></script>

<script src="/js/moment-with-locales.js" type="text/javascript"></script>
<script src="/js/script.js" type="text/javascript"></script>

{{-- SELECT2 --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</html>
