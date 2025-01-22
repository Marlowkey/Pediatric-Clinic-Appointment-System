<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Services\SmsNotificationService;

class UserRegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'regex:/^\+639[0-9]{9}$/', 'unique:users,phone'], // Validate phone
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        $smsService = new SmsNotificationService();
        $smsService->sendSms($user->phone, "Your OTP is: $otp");

        Auth::login($user);

        event(new Registered($user));

        return redirect(route('otp.verify'));
    }

    public function verifyOtpView()
    {
        $user = Auth::user();

        if (!$user) {
            return back()->withErrors(['email' => 'You must be logged in to verify OTP.']);
        }

        $otpExpired = !$user->otp || Carbon::now()->greaterThan($user->otp_expires_at);
        return view('auth.verify-otp' , compact('otpExpired'));
    }

    public function verifyOtp(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return back()->withErrors(['email' => 'You must be logged in to verify OTP.']);
        }

        if (!$user->otp || Carbon::now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Your OTP has expired. Please request a new one.']);
        }

        if ($request->otp === $user->otp) {
            $user->phone_verified_at = Carbon::now();
            $user->save();

            return redirect()->route('home')->with('success', 'OTP verified successfully. Your phone is now verified.');
        } else {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }
    }

    public function resendOtp(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Please log in first.']);
        }

        $otp = rand(100000, 999999);

        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);

        $user->save();

        $smsService = new SmsNotificationService();
        $smsService->sendSms($user->phone, "Your new OTP is: $otp");

        return back()->with('success', 'A new OTP has been sent to your phone.');
    }

}
