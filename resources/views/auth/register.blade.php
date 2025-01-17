<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <section>
        <section class="vh-100">
            <div class="vh-100 bg-gray-100 d-flex h-auto rounded">
                <div class="col-lg-6 d-none d-md-block rounded">
                    <img src="{{ asset('logo/splash.png') }}" alt="Login Image" class="img-fluid rounded w-100 h-100"
                        style="object-fit: cover;" />
                </div>
                <div class="col-md-5 d-flex mx-3">
                    <div class="card-body px-6 py-4 text-black w-full max-w-lg mx-auto">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="flex flex-col items-start mb-4 py-4">
                                <h1 class="text-2xl font-bold mb-1">Register</h1>
                                <h5 class="fw-normal mb-0 pb-2" style="letter-spacing: 1px;">Sign up to your account
                                </h5>
                            </div>

                            <div class="row flex">
                                <div class="mb-3 mr-3 form-group">
                                    <x-input-label for="name" :value="__('Name')" class="text-lg fw-bold" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                        :value="old('name')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div class=" mb-3 form-group">
                                    <x-input-label for="email" :value="__('Email')" class="text-lg fw-bold" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                        :value="old('email')" required autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>

                            <div class="mb-4 form-group">
                                <x-input-label for="password" :value="__('Password')" class="text-lg fw-bold" />
                                <div class="relative">
                                    <x-text-input id="password" class="block mt-1 w-full pr-10" type="password"
                                        name="password" required autocomplete="new-password" />
                                    <!-- Eye icon for toggling password visibility -->
                                    <i id="togglePassword1" class="fas fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer"></i>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="mb-3 form-group">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-lg fw-bold" />
                                <div class="relative">
                                    <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10" type="password"
                                        name="password_confirmation" required autocomplete="new-password" />
                                    <!-- Eye icon for toggling confirm password visibility -->
                                    <i id="togglePassword2" class="fas fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer"></i>
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <!-- Register Button -->
                            <div class="flex items-center justify-center mt-6">
                                <x-primary-button class="w-full justify-center">
                                    {{ __('Register') }}
                                </x-primary-button>
                            </div>

                            <!-- Already have an account? Login link -->
                            <div class="mt-4 text-center">
                                <p class="text-base">
                                    {{ __('Already have an account?') }}
                                    <a href="{{ route('login') }}"
                                        class="font-semibold text-green-600 hover:text-blue-400">
                                        {{ __('Login') }}
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const togglePassword1 = document.getElementById('togglePassword1');
        const togglePassword2 = document.getElementById('togglePassword2');

        // Toggle password visibility
        togglePassword1.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            togglePassword1.classList.toggle('fa-eye-slash');
        });

        togglePassword2.addEventListener('click', () => {
            const type = passwordConfirmationInput.type === 'password' ? 'text' : 'password';
            passwordConfirmationInput.type = type;
            togglePassword2.classList.toggle('fa-eye-slash');
        });
    </script>
</x-guest-layout>
