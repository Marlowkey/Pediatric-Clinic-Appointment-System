

<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <section>
      <div class="container">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="row flex g-0">
                <div class="col-md-4 d-none d-md-block">
                    <img src="{{ asset('logo/splash.png') }}" alt="Login background" class="w-48 h-full"  />
                </div>
                <div class="col-md-8 d-flex mx-3">
                    <div class="card-body px-6 py-2 mb-2 text-black">

                        <div class="flex items-center mb-1 py-4">
                            <h1 class="text-2xl font-bold">Forgot Password?</h1>
                        </div>

                        <div class="mb-4 text-sm text-gray-600 justify-evenly">
                            {{ __('Enter your email address and we\'ll send you a link to reset your password.') }}
                        </div>
                    
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                    
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                    
                            <!-- Email Address -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                    
                            <div class="flex items-center justify-center mt-4">
                                <x-primary-button>
                                    {{ __('Email Password Reset Link') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>
      </div>
    </section>
</x-guest-layout>

{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
