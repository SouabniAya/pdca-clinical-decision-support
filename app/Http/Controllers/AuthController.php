<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'id' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::guard('admin')->attempt([
            'email' => $credentials['id'],
            'password' => $credentials['password'],
            'active' => true,
        ], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        if (Auth::guard('web')->attempt([
            'email' => $credentials['id'],
            'password' => $credentials['password'],
            'active' => true,
        ], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()
            ->withErrors(['id' => 'Invalid credentials.'])
            ->onlyInput('id');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Redirect to Google's OAuth consent screen.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google's callback: log in if the email exists (admin or user),
     * otherwise send them to complete registration.
     */
    public function handleGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $admin = Admin::where('email', $googleUser->getEmail())->where('active', true)->first();
        if ($admin) {
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        $user = User::where('email', $googleUser->getEmail())->where('active', true)->first();
        if ($user) {
            Auth::guard('web')->login($user);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // No matching account: store Google info in session and send to registration
        $nameParts = explode(' ', $googleUser->getName() ?? '', 2);

        session([
            'google_registration' => [
                'email' => $googleUser->getEmail(),
                'first_name' => $nameParts[0] ?? '',
                'last_name' => $nameParts[1] ?? '',
            ],
        ]);

        return redirect()->route('register.complete');
    }
}