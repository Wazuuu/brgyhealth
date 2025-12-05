<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\TwoFactorController;

class AuthController extends Controller
{
    // --- Register Logic ---
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6|confirmed', 
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Generate and send the OTP for new users
        TwoFactorController::generateAndSendOTP($user);

        return redirect()->route('otp.verify');
    }

    // --- Login Logic ---
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 1. Retrieve the user by email
        $user = User::where('email', $request->email)->first();

        // 2. Check if user exists and password is correct
        if ($user && Hash::check($request->password, $user->password)) {
            
            // 3. INSTEAD of Auth::login, trigger OTP flow
            TwoFactorController::generateAndSendOTP($user);

            // 4. Redirect to OTP verification page
            return redirect()->route('otp.verify');
        }

        // 5. If validation fails
        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // --- Logout Logic ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}