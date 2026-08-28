<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DoctorProfileController extends Controller
{
    public function show()
    {
        $user = Auth::guard('web')->user();

        abort_if(! $user, 403, 'You must be logged in as a doctor to view this page.');

        $user->load('doctor');

        abort_if(! $user->doctor, 404, 'No doctor profile found for this account.');

        $doctor = [
            'specialty'      => $user->doctor->specialty ?? 'N/A',
            'license_number' => $user->doctor->license_number ?? 'N/A',
            'institution'    => $user->doctor->institution ?? 'N/A',
        ];

        return view('patients.doctor-profile', compact('doctor'));
    }
}