<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class VisitorProfileController extends Controller
{
    public function show()
    {
        $user = Auth::guard('web')->user();

        abort_if(! $user, 403, 'You must be logged in to view this page.');

        $user->load('visitor');

        abort_if(! $user->visitor, 404, 'No visitor profile found for this account.');

        return view('patients.visitor-profile');
    }
}