<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DoctorProfileController extends Controller
{
    public function show()
    {
        // TODO: replace with Auth::user() once the login module is implemented.
        // For now we load Dr. Taieb specifically and log them in for this
        // request only, so the Blade view's auth()->user() calls resolve.
        $user = User::with('doctor')
            ->whereHas('doctor')
            ->where('email', 'dr.taieb@esi.dz')
            ->first();

        if (! $user) {
            $user = User::with('doctor')->whereHas('doctor')->first();
        }

        abort_if(! $user, 404, 'No doctor account found.');

        Auth::login($user); // TEMPORARY — see TODO above

      $doctor = [
    'specialty' => $user->doctor->specialty ?? 'N/A',
    'license_number' => $user->doctor->license_number ?? 'N/A',
    'institution' => $user->doctor->institution ?? 'N/A',
];

        return view('patients.doctor-profile', compact('doctor'));
    }
}