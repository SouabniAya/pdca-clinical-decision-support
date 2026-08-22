<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Authenticate an admin.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'id' => [
                'required',
                'integer',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);

        $remember = $request->boolean('remember');

if (Auth::guard('admin')->attempt([
    'admin_id' => $credentials['id'],
    'password' => $credentials['password'],
    'active' => true,   // <-- was 'is_active'
], $remember)) {

            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()
            ->withErrors([
                'id' => 'Invalid credentials.',
            ])
            ->onlyInput('id');
    }

    /**
     * Logout admin.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}