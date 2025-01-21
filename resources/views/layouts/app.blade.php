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
    <link rel="stylesheet" href="{{ asset('user/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/fonts/ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/magnific-popup.css') }}">
    <!-- Fonts -->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
  href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
  rel="stylesheet" />

<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/remixicon/remixicon.css') }}" />

<!-- Menu waves for no-customizer fix -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@5.10.0/main.min.css" rel="stylesheet" />



<!-- Helpers -->
<script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ asset('assets/js/config.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Override hover effect for this specific button */
        a.btn.btn-primary.btn-sm.text-black.fw-semibold:hover {
            background-color: #28a745 !important;
            /* Darker green */
            border-color: #28a745 !important;
            /* Darker green border */
            color: #fff !important;
            /* Ensure text color stays white */
        }

        /* Override hover effect for the 'Book Now' button inside the form */
        div.row .col-md-6 .form-group button.btn.btn-primary:hover {
            background-color: #28a745 !important;
            /* Darker green */
            border-color: #28a745 !important;
            /* Darker green border */
            color: #fff !important;
            /* Ensure text color stays white */
        }

        /* Hover effect for form controls */
        .form-control:hover {
            color: #333 !important;
            /* Text color */
        }

        /* Focus effect for form controls */
        .form-control:focus {
            border-color: #155724 !important;
            /* Darker Green Border */
            color: #333 !important;
            /* Text color */
            box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25) !important;
            /* Green Glow */
        }
    </style>
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
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin/lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('admin/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('admin/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('admin/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('admin/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('admin/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    {{-- for calendar --}}
    <script src="{{ asset('admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Template Javascript -->
    <script src="{{ asset('admin/js/main.js') }}"></script>
    <script src="js/main.js"></script>

</body>

</html>
