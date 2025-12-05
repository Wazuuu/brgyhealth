<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    // 1. Show form to enter email
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Process email and send OTP
    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        // Generate OTP using the helper from TwoFactorController (or duplicate logic)
        $otp = rand(100000, 999999);
        
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // Send Email
        Mail::raw("Your Password Reset Code is: $otp. It expires in 10 minutes.", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Password Reset Code');
        });

        // Store email in session to pass to the next step
        session(['reset_email' => $user->email]);

        return redirect()->route('password.reset.form');
    }

    // 3. Show form to enter OTP and new password
    public function showResetForm()
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password', ['email' => session('reset_email')]);
    }

    // 4. Verify OTP and Reset Password
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        // Verify OTP logic
        if ($user->otp_code === $request->otp && now()->lessThan($user->otp_expires_at)) {
            
            // Update Password and Clear OTP
            $user->update([
                'password' => Hash::make($request->password),
                'otp_code' => null,
                'otp_expires_at' => null,
            ]);

            session()->forget('reset_email');

            return redirect()->route('login')->with('success', 'Password reset successfully! Please login.');
        }

        return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
    }
}