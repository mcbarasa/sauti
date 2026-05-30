<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    // ── Show login form ──────────────────────────────────────────────
    public function showLogin()
    {
        // Already logged in → go straight to dashboard
        if (Auth::check() && Auth::user()->email === config('admin.email')) {
            return redirect()->route('bookings.admin');
        }

        return view('auth.login');
    }

    // ── Handle login POST ────────────────────────────────────────────
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Rate limiting — max 5 attempts per IP per minute
        $key = 'admin-login:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => "Too many attempts. Try again in {$seconds} seconds."]);
        }

        // Only allow the configured admin email through
        if ($request->email !== config('admin.email')) {
            RateLimiter::hit($key, 60);
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'These credentials do not match our records.']);
        }

        // Attempt authentication
        if (Auth::attempt([
            'email'    => $request->email,
            'password' => $request->password,
        ], $request->boolean('remember'))) {

            // Clear rate limiter on success
            RateLimiter::clear($key);

            // Regenerate session to prevent fixation
            $request->session()->regenerate();

            return redirect()->route('bookings.admin');
        }

        // Failed attempt — increment rate limiter
        RateLimiter::hit($key, 60);

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    // ── Handle logout ────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}