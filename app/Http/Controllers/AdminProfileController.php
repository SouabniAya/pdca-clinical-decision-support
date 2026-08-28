<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    public function show()
    {
        $admin = Auth::guard('admin')->user();

        abort_if(! $admin, 403, 'You must be logged in as an admin to view this page.');

        return view('patients.admin-profile', compact('admin'));
    }
}