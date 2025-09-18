<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('template/assets/images/logos/favicon.png') }}"/>
  <link rel="stylesheet" href="{{ asset('template/assets/css/styles.min.css')}}"/>
</head>

<body>

    @include('layout.main')

  <script src="{{ asset('template/assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('template/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('template/assets/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('template/assets/js/app.min.js') }}"></script>
  <script src="{{ asset('template/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('template/assets/libs/simplebar/dist/simplebar.js') }}"></script>
  <script src="{{ asset('template/assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('template/assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('template/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
