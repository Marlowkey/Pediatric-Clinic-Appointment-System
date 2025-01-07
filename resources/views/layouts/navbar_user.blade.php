<header role="header">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <div class="d-flex align-items-center">
        <img src="{{ asset('logo/3.png') }}" alt="Logo" class="mb-2" style="width: 70px; height: 70px;">
        <a class="navbar-brand ml-3" href="{{ route('home') }}"><span style="font-size: 1.2rem;">Clarianes Pediatric Clinic</span></a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample05">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
          <li class="nav-item cta">
            <a class="nav-link" href="{{ route('reservations.book') }}"><span>Book Now</span></a>
          </li>
          {{-- <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="nav-link btn btn-link logout-btn">Logout</button>
            </form>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"><span>Logout</span></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
