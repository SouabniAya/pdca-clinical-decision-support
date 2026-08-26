<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    /**
     * Display admin settings page.
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        return view('admin.settings.index', compact('admin'));
    }

    /**
     * Update admin profile information.
     */
    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $data = $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:admin,email,' . $admin->admin_id . ',admin_id',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'profile_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $admin->first_name = $data['first_name'];
        $admin->last_name = $data['last_name'];
        $admin->email = $data['email'];
        $admin->phone = $data['phone'] ?? null;

        /*
         * Update profile photo if a new one was uploaded.
         */
        if ($request->hasFile('profile_photo')) {

            $path = $request->file('profile_photo')
                ->store('admin-profile-photos', 'public');

            $admin->profile_photo = $path;
        }

        $admin->save();

        return back()->with(
            'success',
            'Profile information updated successfully.'
        );
    }

    /**
     * Update admin password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => [
                'required',
            ],

            'new_password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers(),
            ],
        ]);

        $admin = Auth::guard('admin')->user();

        /*
         * Check current password.
         */
        if (!Hash::check(
            $request->current_password,
            $admin->password
        )) {
            return back()->withErrors([
                'current_password' =>
                    'The current password is incorrect.',
            ]);
        }

        /*
         * Save new password.
         */
        $admin->password = Hash::make(
            $request->new_password
        );

        $admin->save();

        return back()->with(
            'success',
            'Password updated successfully.'
        );
    }

    /**
     * Deactivate admin account.
     */
    public function deactivate()
    {
        $admin = Auth::guard('admin')->user();

        $admin->active = false;

        $admin->save();

        /*
         * Logout the admin after deactivation.
         */
        Auth::guard('admin')->logout();

        return redirect('/login')->with(
            'success',
            'Your admin account has been deactivated.'
        );
    }
}