<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Show the registration form, pre-filled with Google data if present.
     */
    public function show(Request $request)
    {
        $google = $request->session()->get('google_registration');

        abort_unless($google, 403, 'No pending registration found.');

        return view('auth.register', ['google' => $google]);
    }

    /**
     * Complete the registration by creating a new User account,
     * along with its role-specific profile (Doctor, Nurse, or Visitor).
     */
    public function store(Request $request)
    {
        $google = $request->session()->get('google_registration');

        abort_unless($google, 403, 'No pending registration found.');

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'phone'      => ['nullable', 'string', 'max:30'],
            'location'   => ['nullable', 'string', 'max:150'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],

            'role' => ['required', 'in:doctor,nurse,visitor'],

            // Doctor-specific
            'specialty'      => ['required_if:role,doctor', 'nullable', 'string', 'max:150'],
            'institution'    => ['required_if:role,doctor', 'nullable', 'string', 'max:150'],
            'license_number' => ['required_if:role,doctor,nurse', 'nullable', 'string', 'max:100'],

            // Nurse-specific
            'department' => ['required_if:role,nurse', 'nullable', 'string', 'max:150'],
        ]);

        $user = DB::transaction(function () use ($validated, $google) {
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name'  => $validated['last_name'],
                'email'      => $google['email'],
                'password'   => Hash::make($validated['password']),
                'phone'      => $validated['phone'] ?? null,
                'location'   => $validated['location'] ?? null,
                'active'     => true,
            ]);

            switch ($validated['role']) {
                case 'doctor':
                    Doctor::create([
                        'user_id'        => $user->user_id,
                        'specialty'      => $validated['specialty'],
                        'institution'    => $validated['institution'],
                        'license_number' => $validated['license_number'],
                    ]);
                    break;

                case 'nurse':
                    Nurse::create([
                        'user_id'        => $user->user_id,
                        'license_number' => $validated['license_number'],
                        'department'     => $validated['department'],
                    ]);
                    break;

                case 'visitor':
                    Visitor::create([
                        'user_id' => $user->user_id,
                    ]);
                    break;
            }

            return $user;
        });

        $request->session()->forget('google_registration');

        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }
}