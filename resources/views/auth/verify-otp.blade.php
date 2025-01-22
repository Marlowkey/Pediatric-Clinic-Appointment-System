<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<x-guest-layout>
    <div class="container">
        <x-alerts />
        <h1 class="mb-2 fw-bolder text-start fs-6">Verify OTP</h1>
        <form method="POST" action="{{ route('otp.verify.submit') }}">
            @csrf
            <div class="col-md">
                <div class="card">
                    <h5 class="card-header">OTP Verification</h5>
                    <div class="card-body">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="floatingOtp" name="otp"
                                placeholder="Enter OTP" required="{{ $otpExpired ? 'false' : 'true' }}"
                                {{ $otpExpired ? 'disabled' : '' }} aria-describedby="floatingOtpHelp" maxlength="6" />
                            <label for="floatingOtp">OTP</label>
                            <div id="floatingOtpHelp" class="form-text">
                                Enter the OTP sent to your phone.
                            </div>
                        </div>
                        @error('otp')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                        @if (!$otpExpired)
                            <button type="submit" class="btn btn-success mt-3">Verify</button>
                        @endif
                        <!-- Conditionally show the Resend OTP button if OTP has expired -->
                    </div>
                </div>
            </div>
        </form>
        @if ($otpExpired)
        <div class="mt-3 d-flex justify-content-end">
            <form method="POST" action="{{ route('otp.resend') }}">
                @csrf
                <button type="submit" class="btn btn-warning">
                    Resend OTP
                </button>
            </form>
        </div>
    @endif

    </div>
</x-guest-layout>
