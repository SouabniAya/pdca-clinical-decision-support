<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Redirects the logged-in user to their role-specific profile page.
     */
    public function show()
    {
        $user = Auth::guard('web')->user();

        if ($user) {
            $user->load(['doctor', 'nurse', 'visitor']);

            if ($user->doctor) {
                return redirect()->route('doctor.profile');
            }

            if ($user->nurse) {
                return redirect()->route('nurse.profile');
            }

            if ($user->visitor) {
                return redirect()->route('visitor.profile');
            }
        }

        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.profile');
        }

        abort(404, 'No profile found for this account.');
    }
}