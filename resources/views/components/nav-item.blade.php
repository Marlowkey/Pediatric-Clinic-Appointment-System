@props(['route'])

<li class="nav-item">
  <a
    href="{{ route($route) }}"
    {{ $attributes->merge(['class' => 'nav-link fw-normal fs-5 ' . (request()->routeIs($route) ? 'text-white text-decoration-underline' : 'text-white')]) }}>
    {{ $slot }}
  </a>
</li>
