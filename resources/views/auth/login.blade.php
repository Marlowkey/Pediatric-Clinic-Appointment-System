<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-lg font-bold" />
            <x-text-input id="email" class="block mt-1 w-full text-base" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-lg font-bold" />

            <!-- Relative container for input and icon -->
            <div class="relative">
                <!-- Password input with extra padding-right to make space for the icon -->
                <x-text-input id="password" class="block mt-1 w-full pr-10 text-base"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />

                <!-- Icon button inside the input field, aligned to the right -->
                <button type="button" onclick="togglePasswordVisibility()"
                    class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                    <i id="eye-icon" class="fas fa-eye"></i> <!-- Font Awesome eye icon -->
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>




        <!-- Remember Me and Forgot Password next to each other -->
        <div class="flex items-center justify-between mt-4">
            <!-- Remember Me -->
            <label for="remember_me" class="inline-flex items-center text-sm">
                <input id="remember_me" type="checkbox" class="rounded border-gray-100 text-indigo-300 shadow-sm focus:ring-indigo-200" name="remember">
                <span class="ms-2 text-base font-semibold text-gray-600">{{ __('Remember me') }}</span>
            </label>

            <!-- Forgot Password Link -->
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}"
                class="text-base no-underline text-gray-600 hover:text-red-500 hover:font-bold transition-all duration-200">
                {{ __('Forgot your password?') }}
            </a>
            @endif
        </div>

        <!-- Log in button -->
        <div class="flex items-center justify-center mt-4">
            <x-primary-button class="ms-3 w-full justify-center">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- Don't have an account? Register link -->
        <div class="mt-4 text-center">
            <p class="text-base">
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="font-semibold text-green-600 hover:text-blue-400">
                    {{ __('Register') }}
                </a>
            </p>
        </div>
    </form>

    <!-- JavaScript for toggling password visibility -->
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash'); // Change to eye-slash icon
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye'); // Change back to eye icon
            }
        }
    </script>
</x-guest-layout>