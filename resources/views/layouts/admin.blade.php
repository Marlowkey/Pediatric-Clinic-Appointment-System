<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">


        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{ asset('admin/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet" >
        <link href="{{ asset('admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />

        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet"/>
        <!-- Template Stylesheet -->
        <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet" />
    </head>

    <body sidebar-mini layout-fixed>

        <div class="content">
            @include('admin.layouts.sidebar')
            @include('admin.layouts.navbar')
            
            <div class="container-fluid pt-4 px-4">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                    
            </div>
            @include('admin.layouts.footer')
        </div>
        

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('admin/lib/chart/chart.min.js') }}"></script>
        <script src="{{ asset('admin/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('admin/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('admin/lib/owlcarousel/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('admin/lib/tempusdominus/js/moment.min.js')}}"></script>
        <script src="{{ asset('admin/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
        {{-- for calendar --}}
        <script src="{{ asset('admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        <!-- Template Javascript -->
        <script src="{{ asset('admin/js/main.js') }}"></script>

    </body>

       
           <script>
               document.addEventListener('DOMContentLoaded', function() {
                   var calendarEl = document.getElementById('calendar');
                   var calendar = new FullCalendar.Calendar(calendarEl, {
                       initialView: 'dayGridMonth',
                       events: [
                           // Example events
                           { title: 'Appointment 1', start: '2024-11-25' },
                           { title: 'Appointment 2', start: '2024-11-26' }
                       ]
                   });
                   calendar.render();
               });
           </script>
</html>