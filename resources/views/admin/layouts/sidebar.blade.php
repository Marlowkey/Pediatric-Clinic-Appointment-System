<div class="sidebar pe-4 pb-3">
    <nav class="navbar navbar-light">

        <div class="d-flex flex-column align-items-center text-center mx-4 mb-3">
            <div class="position-relative me-2">
                <img src="{{ asset('logo/logo_solid.png') }}" alt="Logo" class="logo-icon"
                    style="width: 56.8px; height: 56.8px;">
            </div>
            <div class="mt-2">
                <h5 class="text-dark mb-0">Clarianes Pediatric</h5> <!-- Black text -->
                <h5 class="text-dark">Clinic</h5> <!-- Black text -->
            </div>
        </div>

        <div class="navbar-nav w-100">
            <a href="{{ route('admin.pages.dashboard') }}" class="nav-item nav-link text-dark"><i
                    class="text-success fa fa-tachometer-alt me-2"></i>Home</a> <!-- Black font color -->
            <!-- Book Patient Link -->
            <a href="{{ route('available-times.index') }}" class="nav-item nav-link text-dark">
                <i class="text-success fa fa-book me-2"></i> <!-- Add an icon for book patient -->
               Availability
            </a>
            <a href="{{ route('reservations.index') }}" class="nav-item nav-link text-dark">
                <i class="text-success fa fa-calendar-check me-2"></i>
              Appointments
            </a>
            <!-- Pending Appointments Link -->
            <a href="{{ route('reservations.pending') }}" class="nav-item nav-link text-dark">
                <i class="text-success fa fa-clock me-2"></i> <!-- Add an icon for pending -->
                Pending
            </a>

            <a href="chart.html" class="nav-item nav-link text-dark"><i class="text-success fa fa-file me-2"></i>Records</a>
            <!-- Black font color -->
            <a href="chart.html" class="nav-item nav-link text-dark"><i class="text-success fa fa-user me-2"></i>Accounts</a>

            <a href="{{ route('logout') }}" class="nav-item nav-link  mt-auto">
                <i class="fa fa-sign-out-alt me-2 text-danger"></i>Logout
            </a>
        </div>
    </nav>
</div>
