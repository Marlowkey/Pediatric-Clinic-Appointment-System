<div class="sidebar pe-4 pb-3">
    <nav class="navbar navbar-light">
        <!-- Logo and Clinic Name -->
        <div class="d-flex flex-column align-items-center text-center mx-4 mb-3">
            <div class="position-relative me-2">
                <img src="{{ asset('logo/logo_solid.png') }}" alt="Logo" class="logo-icon"
                     style="width: 56.8px; height: 56.8px;">
            </div>
            <div class="mt-2">
                <h5 class="text-dark mb-0">Clarianes Pediatric</h5>
                <h5 class="text-dark">Clinic</h5>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="navbar-nav w-100">
            <!-- Home (Always visible) -->
            <a href="{{ route('admin.pages.dashboard') }}" class="nav-item nav-link text-dark">
                <i class="text-success fa fa-tachometer-alt me-2"></i>Home
            </a>

            {{-- <!-- Availability (Admins only) -->
            @if (auth()->user()->role->name === 'admin')

            @endif --}}

            <!-- Appointments (Admins and Doctors) -->
            @if (auth()->user()->role->name === 'doctor' || auth()->user()->role->name === 'admin')
            <a href="{{ route('available-times.index') }}" class="nav-item nav-link text-dark">
                <i class="text-success fa fa-book me-2"></i>Availability
            </a>
            <a href="{{ route('reservations.index') }}" class="nav-item nav-link text-dark">
                    <i class="text-success fa fa-calendar-check me-2"></i>Appointments
                </a>

            @endif

            <!-- Pending Appointments (Admins only) -->
            @if (auth()->user()->role->name === 'admin')
                <a href="{{ route('reservations.pending') }}" class="nav-item nav-link text-dark">
                    <i class="text-success fa fa-clock me-2"></i>Pending
                </a>
            @endif


            <!-- Records (Admins and Doctors) -->
            @if (auth()->user()->role->name === 'doctor' || auth()->user()->role->name === 'admin')

                <a href="{{ route('reservations.completed') }}" class="nav-item nav-link text-dark">
                    <i class="text-success fa fa-file me-2"></i>Records
                </a>
            @endif

            <!-- Accounts (Admins only) -->
            @if (auth()->user()->role->name === 'admin')
                <a href="{{ route('users.index') }}" class="nav-item nav-link text-dark">
                    <i class="text-success fa fa-user me-2"></i>Accounts
                </a>
            @endif

            <!-- Logout (Always visible) -->
            <a href="{{ route('logout') }}" class="nav-item nav-link text-dark mt-auto">
                <i class="fa fa-sign-out-alt me-2 text-danger"></i>Logout
            </a>
        </div>
    </nav>
</div>
