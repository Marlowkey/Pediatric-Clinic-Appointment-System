<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <section>
      <div class="container">
          <div class="row d-flex justify-content-center align-items-center">
              <div class="row flex g-0">
                <div class="col-md-4 d-none d-md-block">
                    <img src="{{ asset('logo/splash.png') }}" alt="Login background" class="w-48 h-full"  />
                </div>
                  <!-- Adjust the column size for responsiveness -->
                  <div class="col-md-8 d-flex mx-3">
                    <div class="card-body px-6 py-4 text-black w-full max-w-lg mx-auto">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="flex flex-col items-start mb-4 py-4">
                                <h1 class="text-2xl font-bold mb-1">Register</h1>
                                <h5 class="fw-normal mb-0 pb-2" style="letter-spacing: 1px;">Sign up to your account</h5>
                            </div>

                            <div class="row flex">
                                <div class="col-sm-6 mb-3 mr-3 form-group">
                                    {{-- Name --}}
                                    <x-input-label for="name" :value="__('Name')" class="text-lg fw-bold" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div class="col-sm-6 mb-3 form-group">
                                    {{-- Email --}}
                                    <x-input-label for="email" :value="__('Email')" class="text-lg fw-bold"/>
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="mb-4 form-group">
                                <x-input-label for="password" :value="__('Password')" class="text-lg fw-bold"/>
                                <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                                <!-- Show Password Checkbox -->
                                <div class="flex items-center mt-2">
                                    <input id="showPasswordCheckbox1" type="checkbox" class="mr-2">
                                    <label for="showPasswordCheckbox1" class="text-sm text-gray-600">Show Password</label>
                                </div>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-md-4 mb-3 form-group">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-lg fw-bold"/>
                                <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10" type="password" name="password_confirmation" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                                <!-- Show Confirm Password Checkbox -->
                                <div class="flex items-center mt-2">
                                    <input id="showPasswordCheckbox2" type="checkbox" class="mr-2">
                                    <label for="showPasswordCheckbox2" class="text-sm text-gray-600">Show Password</label>
                                </div>
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
                                    {{ __("Already have an account?") }}
                                    <a href="{{ route('login') }}" class="font-semibold text-green-600 hover:text-blue-400">
                                        {{ __('Login') }}
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
      const showPasswordCheckbox1 = document.getElementById('showPasswordCheckbox1');
      const showPasswordCheckbox2 = document.getElementById('showPasswordCheckbox2');
  
      // Toggle password visibility for both password and confirmation password
      showPasswordCheckbox1.addEventListener('change', () => {
        passwordInput.type = showPasswordCheckbox1.checked ? 'text' : 'password';
      });
  
      showPasswordCheckbox2.addEventListener('change', () => {
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        passwordConfirmationInput.type = showPasswordCheckbox2.checked ? 'text' : 'password';
      });
    </script>
</x-guest-layout>





{{-- Original --}}
{{-- <x-guest-layout>

    <div class="flex items-center justify-center mt-4">
        <a href="/">
            <x-application-logo class="w-12 h-12 fill-current text-gray-500" />
        </a>
    </div>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-lg font-bold" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-lg font-bold"/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-lg font-bold"/>

            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10"
                    type="password"
                    name="password"
                    required autocomplete="new-password" />
                <!-- Password Toggle Button with Eye Icon -->
                <button type="button" onclick="togglePasswordVisibility('password', 'password-eye-icon')"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm text-gray-500">
                    <i id="password-eye-icon" class="fas fa-eye"></i> <!-- Font Awesome eye icon -->
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-lg font-bold"/>

            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10"
                    type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <!-- Confirm Password Toggle Button with Eye Icon -->
                <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'confirm-password-eye-icon')"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm text-gray-500">
                    <i id="confirm-password-eye-icon" class="fas fa-eye"></i> <!-- Font Awesome eye icon -->
                </button>
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
            <p class="text-sm">
                {{ __("Already have an account?") }}
                <a href="{{ route('login') }}" class="font-semibold text-green-600 hover:text-blue-400">
                    {{ __('Login') }}
                </a>
            </p>
        </div>
    </form>

    <!-- JavaScript for toggling password visibility -->
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const passwordField = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);
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