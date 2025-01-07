{{-- <div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="index.html" class="navbar-brand d-flex flex-column align-items-center justify-content-center">
            <!-- Image Above -->
            <img src="{{ asset('logo/3.png') }}" alt="Logo" class="mb-1" style="width: 90px; height: 90px;">
            <!-- Text Below -->
            <h3 class="text-primary px-3">Clarianes Pediatric</h3>
            <h3 class="text-primary px-3">Clinic</h3>
        </a>
        <div class="navbar-nav w-100">
            <a href="{{ route('admin.pages.dashboard')}}" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Appointment Events</a>
                <div class="dropdown-menu bg-transparent border-0 px-2">
                    <a href="{{ route('admin.pages.appointment_calendar') }}" class="dropdown-item">Appointment Calendar</a>
                    <a href="{{ route('admin.pages.pending_appointments')}}" class="dropdown-item">Pending Appointments</a>
                    <a href="{{ route('admin.pages.walk_in_appointments')}}" class="dropdown-item">Walk-in Appointments</a>
                </div>
            </div>
            <a href="widget.html" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Widgets</a>
            <a href="form.html" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Forms</a>
            <a href="table.html" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Tables</a>
            <a href="chart.html" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Charts</a>
        </div>
    </nav>
</div> --}}


<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        {{-- <a href="index.html" class="navbar-brand d-flex flex-column align-items-center mx-4 mb-3 text-center">
            <!-- Logo -->
            <img src="{{ asset('logo/logo_solid.png') }}" alt="Logo" class="logo-icon" style="width: 90px; height: 90px;">
            <!-- Text -->
            <div class="mt-2">
                <h4 class="text-primary mb-0">Clarianes Pediatric</h4>
                <h4 class="text-primary">Clinic</h4>
            </div>
        </a> --}}

        <div class="d-flex flex-column align-items-center text-center mx-4 mb-3">
            <div class="position-relative me-2">
                <img src="{{ asset('logo/logo_solid.png') }}" alt="Logo" class="logo-icon" style="width: 56.8px; height: 56.8px;">
            </div>
            <div class="mt-2">
                <h5 class="text-primary mb-0">Clarianes Pediatric</h5>
                <h5 class="text-primary">Clinic</h5>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ route('admin.pages.dashboard')}}" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle text-center" data-bs-toggle="dropdown">
                    <i class="fa fa-laptop me-2"></i>
                    <span class="d-block">Notification</span>
                </a>
                <div class="dropdown-menu bg-transparent border-0 px-2">
                    <a href="{{ route('admin.pages.appointment_calendar') }}" class="dropdown-item">Messages</a>
                    <a href="{{ route('admin.pages.pending_appointments')}}" class="dropdown-item">Notifications</a>
                </div>
            </div>
            <a href="{{ route('admin.pages.appointment_calendar') }}" class="nav-item nav-link"><i class="fa fa-calendar me-2"></i>Calendar</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle text-center" data-bs-toggle="dropdown">
                    <i class="fa fa-calendar-check me-2"></i>
                    <span class="d-block">Appointments</span>
                </a>
                <div class="dropdown-menu bg-transparent border-0 px-2">
                    <a href="{{ route('admin.pages.pending_appointments')}}" class="dropdown-item">Pending Appointments</a>
                    <a href="{{ route('admin.pages.walk_in_appointments')}}" class="dropdown-item">Walk-in Appointments</a>
                </div>
            </div>
            <a href="chart.html" class="nav-item nav-link"><i class="fa fa-file me-2"></i>Visit Record</a>
            <a href="chart.html" class="nav-item nav-link"><i class="fa fa-user me-2"></i>Account</a>
        </div>
    </nav>
</div>
<!-- Sidebar End -->
