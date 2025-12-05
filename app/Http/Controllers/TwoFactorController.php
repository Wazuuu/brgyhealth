<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TwoFactorController extends Controller
{
    // Display the OTP Form
    public function show()
    {
        if (!session()->has('auth_otp_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.otp');
    }

    // Verify the Input Code
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $userId = session()->get('auth_otp_user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Session expired. Please login again.']);
        }

        // Check if OTP matches and is not expired
        if ($user->otp_code === $request->otp && now()->lessThan($user->otp_expires_at)) {
            
            // Clear OTP fields
            $user->update([
                'otp_code' => null, 
                'otp_expires_at' => null,
                'email_verified_at' => now() // Auto-verify email if not already
            ]);

            // Log the user in
            Auth::login($user);
            session()->forget('auth_otp_user_id');
            session()->regenerate();

            return redirect()->route('home');
        }

        return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
    }

    // Helper: Generate and Send OTP (Static for reuse)
    public static function generateAndSendOTP($user)
    {
        $otp = rand(100000, 999999);
        
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // Send Email (You can create a Mailable, using raw for simplicity here)
        Mail::raw("Your Login OTP is: $otp. It expires in 10 minutes.", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your One-Time Password');
        });

        // Store user ID in session to track them during OTP step
        session(['auth_otp_user_id' => $user->id]);
    }
}