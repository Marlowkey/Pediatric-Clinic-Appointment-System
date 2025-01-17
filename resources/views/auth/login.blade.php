<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <section class="vh-100">
        <div class="vh-100 bg-gray-100 d-flex  h-auto rounded">
            <div class="col-lg-6 d-none d-md-block rounded">
                <img src="{{ asset('logo/splash.png') }}" alt="Login Image"
                     class="img-fluid rounded w-100 h-100" style="object-fit: cover;" />
            </div>

            <div class="col-lg-5 d-flex mx-6 mb-8 justify-content-center align-items-center rounded">
                <div class="card-body px-6 py-2 text-black justify-content-center align-items-center"> <!-- Added shadow and rounded to the form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="flex flex-col items-start mb-4 py-4">
                            <h1 class="text-2xl font-bold mb-1">Login</h1>
                            <h5 class="fw-normal mb-0 pb-2" style="letter-spacing: 1px;">
                                Sign in to your account
                            </h5>
                        </div>

                        <!-- Email Input -->
                        <div class="mb-4">
                            <label for="email" class="text-sm font-medium text-gray-700">
                                Email address
                            </label>
                            <input id="email" type="email" name="email"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                       focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                required autocomplete="email" />
                        </div>

                        <!-- Password Input -->
                        <div class="mb-4">
                            <label for="password" class="text-sm font-medium text-gray-700">
                                Password
                            </label>
                            <div class="relative">
                                <input id="password" type="password" name="password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                           focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pr-10"
                                    required autocomplete="current-password" />
                                <i id="togglePassword"
                                    class="fa fa-eye absolute inset-y-0 right-0 pr-3
                                       flex items-center text-gray-400 cursor-pointer"></i>
                            </div>
                        </div>
                        <!-- Login Button -->
                        <div class="flex items-center justify-center mt-6">
                            <x-primary-button class="w-full justify-center">
                                {{ __('Login') }}
                            </x-primary-button>
                        </div>

                        <!-- Don't have an account? Register link -->
                        <div class="mt-6 text-center">
                            <p class="text-base">
                                {{ __("Don't have an account?") }}
                                <a href="{{ route('register') }}"
                                    class="font-semibold text-green-600 hover:text-blue-400">
                                    {{ __('Register') }}
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>



    <!-- JavaScript for Password Visibility Toggle -->
    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            togglePassword.classList.toggle('fa-eye-slash');
        });
    </script>
</x-guest-layout>
