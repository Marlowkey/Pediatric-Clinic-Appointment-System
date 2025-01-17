<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Clarianes Pediatric Clinic')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900|Rubik:300,400,700" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('user/fonts/fontawesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{ asset('user/fonts/ionicons/css/ionicons.min.css')}}">
        <link rel="stylesheet" href="{{ asset('user/css/magnific-popup.css')}}">

    </head>
    <body>
        <div class="content">
            @include('layouts.navbar_user')
                <div class="content-wrapper">
                    @yield('content')
                </div>

            @include('layouts.footer_user')
        </div>

        <!-- Scripts -->
        <script src="{{ asset('user/js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('user/js/jquery-migrate-3.0.0.js') }}"></script>
        <script src="{{ asset('user/js/popper.min.js') }}"></script>
        <script src="{{ asset('user/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('user/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('user/js/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('user/js/jquery.stellar.min.js') }}"></script>
        <script src="{{ asset('user/js/main.js') }}"></script>


        <script src="{{ asset('user/js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('user/js/magnific-popup-options.js') }}"></script>

        <script src="js/main.js"></script>
    </body>
</html>
