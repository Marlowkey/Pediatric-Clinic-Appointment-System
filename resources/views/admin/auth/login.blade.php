<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <section>
        <div class="container-fluid">
            <div class="row d-flex g-0 justify-content-center align-items-center">
               <div class="row flex">
                <div class="col-md-4">
                    <img src="{{ asset('logo/green_bg.png') }}" alt="Login background" class="w-24
                     h-full"  />
                </div>
                <!-- Right Column for Form -->
                <div class="col-md-8 d-flex justify-content-center align-items-center">
                    <div class="card-body px-8 text-black">
                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf

                            <div class="flex flex-col items-start mb-4 py-4">
                                <h1 class="text-2xl font-bold mb-1">Admin Login</h1>
                                <h5 class="fw-normal mb-0 pb-2" style="letter-spacing: 1px;">Sign in to your admin account</h5>
                            </div>

                            <!-- Email Address -->
                            <div class="mb-4">
                                <x-input-label for="email" :value="__('Email')" class="text-lg fw-bolder" />
                                <x-text-input id="email" class="block mt-1 w-full text-base" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-input-label for="password" :value="__('Password')" class="text-lg fw-bolder" />
                                <x-text-input id="password" class="block mt-1 w-full text-base"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                
                                <div class="flex items-center mt-2">
                                    <input id="showPasswordCheckbox1" type="checkbox" class="mr-2">
                                    <label for="showPasswordCheckbox1" class="text-sm text-gray-600">Show Password</label>
                                </div>
                            </div>

                            <!-- Log in button -->
                            <div class="flex items-center justify-center mt-6">
                                <x-primary-button class="w-full justify-center text-cyan-500">
                                    {{ __('Log in') }}
                                </x-primary-button>
                            </div>

                            <!-- Don't have an account? Register link -->
                            <div class="mt-4 text-center">
                                <p class="text-base">
                                    {{ __("Don't have an account?") }}
                                    <a href="{{ route('admin.register') }}" class="font-semibold text-green-600 hover:text-blue-400">
                                        {{ __('Register') }}
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
               </div>
            </div>
        </div>
    </section>

    <script>
        const passwordInput = document.getElementById('password');
        const showPasswordCheckbox = document.getElementById('showPasswordCheckbox');
        const togglePassword = document.getElementById('togglePassword');

        showPasswordCheckbox.addEventListener('change', () => {
            passwordInput.type = showPasswordCheckbox.checked ? 'text' : 'password';
        });

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
        });
    </script>
</x-guest-layout>



{{-- 
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

        <div class="flex items-center justify-center mt-4">
            <h2 class="text-pink-500">Admin Login</h2>
        </div>
    <form method="POST" action="{{ route('admin.login') }}">
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
            <x-text-input id="password" class="block mt-1 w-full pr-10 text-base"
                type="password"
                name="password"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Log in button -->
        <div class="flex items-center justify-center mt-4">
            <x-primary-button class="ms-3 w-full justify-center text-cyan-500">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- Don't have an account? Register link -->
        <div class="mt-4 text-center">
            <p class="text-base">
                {{ __("Don't have an account?") }}
                <a href="{{ route('admin.register') }}" class="font-semibold text-green-600 hover:text-blue-400">
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
</x-guest-layout> --}}