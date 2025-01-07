<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <section>
      <div class="container">
          <div class="row d-flex justify-content-center align-items-center">
              <div class="row flex g-0">
                  <div class="col-md-4 d-none d-md-block">
                      <img src="{{ asset('logo/splash.png') }}" alt="Login background" class="w-32 h-full"  />
                  </div>
                  <div class="col-md-8 d-flex mx-3">
                    <div class="card-body px-6 py-2 text-black">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="flex flex-col items-start mb-4 py-4">
                                <h1 class="text-2xl font-bold mb-1">Login</h1>
                                <h5 class="fw-normal mb-0 pb-2" style="letter-spacing: 1px;">Sign in to your account</h5>
                            </div>
            
                            <!-- Email Input -->
                            <div class="mb-4">
                              <label for="email" class="form-control block text-sm font-medium text-gray-700">Email address</label>
                              <input id="email" type="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required autocomplete="email" />
                            </div>
            
                            <!-- Password Input -->
                            <div class="mb-4">
                              <label for="password" class="form-control block text-sm font-medium text-gray-700">Password</label>
                              <div class="relative">
                                <input id="password" type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pr-10" required autocomplete="current-password" />
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400"></button>
                              </div>
                            </div>
            
                            <!-- Forgot Password and Show Password -->
                            <div class="flex justify-between items-center mt-4">
                                <div class="inline-flex items-center space-x-2">
                                    <input id="showPasswordCheckbox" type="checkbox">
                                    <label for="showPasswordCheckbox" class="text-sm text-gray-600">Show Password</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:underline ml-4">
                                    Forgot password?
                                </a>
                            </div>


                            <div class="flex items-center justify-center mt-6">
                                <x-primary-button class="w-full justify-center">
                                    {{ __('Login') }}
                                </x-primary-button>
                            </div>
            
            
                            <!-- Don't have an account? Register link -->
                            <div class="mt-6 text-center">
                              <p class="text-base">
                                {{ __("Don't have an account?") }}
                                <a href="{{ route('register') }}" class="font-semibold text-green-600 hover:text-blue-400">{{ __('Register') }}</a>
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
  

{{-- Original --}}
{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

        <div class="flex items-center justify-center mt-4">
            <a href="/">
                <x-application-logo class="w-12 h-12 fill-current text-gray-500" />
            </a>
        </div>
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
                {{ __('Forgot password?') }}
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
</x-guest-layout> --}}