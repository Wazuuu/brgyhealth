<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Find existing user by Google ID or Email
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if (!$user) {
                // Register new user via Google if they don't exist
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt(Str::random(16)), // Random password
                    'email_verified_at' => now(),
                ]);
            } else {
                // Link Google ID if not already linked
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
            }

            // TRIGGER OTP FLOW
            TwoFactorController::generateAndSendOTP($user);

            return redirect()->route('otp.verify');

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Google Login Failed.']);
        }
    }
}