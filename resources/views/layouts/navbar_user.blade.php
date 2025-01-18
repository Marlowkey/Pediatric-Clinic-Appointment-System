<header role="header">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <div class="d-flex align-items-center">
        <img src="{{ asset('logo/3.png') }}" alt="Logo" class="mb-2" style="width: 70px; height: 70px;">
        <a class="navbar-brand ml-3 fw-bold " href="{{ route('home') }}"><span style="font-size: 1.2rem;">Clarianes Pediatric Clinic</span></a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample05">
        <ul class="navbar-nav ml-auto">
            <x-nav-item route="home">Home</x-nav-item>
            <x-nav-item route="about">About</x-nav-item>
            <x-nav-item route="contact">Contact</x-nav-item>
          <li class="nav-item cta">
            <a class="nav-link text-white fw-normal fs-5" href="{{ route('reservations.book') }}"><span>Book Now</span></a>
          </li>

        <x-nav-item route="logout">
          <span>Logout</span>
        </x-nav-item>
        </ul>
      </div>
    </div>
  </nav>
</header>
