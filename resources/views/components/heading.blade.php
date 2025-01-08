<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Right side: Heading Text -->
                <h3 class="mb-0">{{ $headingText }}</h3>
                <!-- Left side: Button (only visible if $href is set) -->
                @if($href)
                    <a class="nav-link active bg-success text-white d-flex align-items-center px-4 py-2 rounded-pill" href="{{ $href }}"
                        @isset($dataBsToggle) data-bs-toggle="{{ $dataBsToggle }}" @endisset
                        @isset($dataBsTarget) data-bs-target="{{ $dataBsTarget }}" @endisset>
                        <i class="{{ $icon }}"></i>
                        <span>{{ $slot }}</span>
                    </a>
                @else
                    <button class="btn btn-success d-flex align-items-center px-4 py-2 rounded-pill" type="button"
                        @isset($dataBsToggle) data-bs-toggle="{{ $dataBsToggle }}" @endisset
                        @isset($dataBsTarget) data-bs-target="{{ $dataBsTarget }}" @endisset>
                        <i class="{{ $icon }}"></i>
                        <span>{{ $slot }}</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
