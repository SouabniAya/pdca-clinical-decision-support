<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NurseProfileController extends Controller
{
    public function show()
    {
        $user = Auth::guard('web')->user();

        abort_if(! $user, 403, 'You must be logged in to view this page.');

        $user->load('nurse');

        abort_if(! $user->nurse, 404, 'No nurse profile found for this account.');

        $nurse = [
            'license_number' => $user->nurse->license_number ?? 'N/A',
            'department'     => $user->nurse->department ?? 'N/A',
        ];

        return view('patients.nurse-profile', compact('nurse'));
    }
}