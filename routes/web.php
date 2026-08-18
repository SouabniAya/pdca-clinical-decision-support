<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // TODO: replace with real authentication logic (e.g. Auth::attempt)
    return back()->withErrors(['id' => 'Invalid credentials.']);
})->name('login.store');

Route::get('/password/forgot', function () {
    return 'TODO: forgot password page';
})->name('password.request');

Route::get('/auth/google', function () {
    // TODO: wire up Socialite (or your OAuth provider) here
    return 'TODO: Google OAuth redirect';
})->name('auth.google');
Route::get('/patients', function () {
    return view('patients.index');
})->name('patients.index');
Route::get('/patients/{id}', function ($id) {
    return view('patients.details', ['id' => $id]);
})->name('patients.show');
Route::get('/patients/{id}/clinical-explanation', function ($id) {
    return view('patients.clinical-explanation');
})->name('patients.clinical-explanation');
Route::get('/clinical-rules', function () {
    return view('patients.rules');
})->name('rules.index');
Route::get('/patients/details', function () {
    return view('patients.details');
})->name('patients.details');
Route::get('/help', function () {
    return view('pages.help');
})->name('help');
Route::get('/dashboard', function () {
    return view('patients.dashboard');
})->name('dashboard');
Route::get('/settings', function () {
    return view('patients.settings');
})->name('settings');

Route::get('/users', function () {
    $users = [
        ['id' => 'U00128', 'name' => 'Ahmed Benali', 'email' => 'na_benali@esi.dz', 'status' => 'Active', 'role' => 'Nurse'],
        ['id' => 'U00129', 'name' => 'Sarah Kaci', 'email' => 's_kaci@esi.dz', 'status' => 'Active', 'role' => 'Doctor'],
        ['id' => 'U00130', 'name' => 'Yacine Meziane', 'email' => 'y_meziane@esi.dz', 'status' => 'Active', 'role' => 'Nurse'],
        ['id' => 'U00131', 'name' => 'Lina Belkacem', 'email' => 'l_belkacem@esi.dz', 'status' => 'Inactive', 'role' => 'Administrator'],
        ['id' => 'U00132', 'name' => 'Karim Zerouali', 'email' => 'k_zerouali@esi.dz', 'status' => 'Active', 'role' => 'Doctor'],
        ['id' => 'U00133', 'name' => 'Nadia Bouzid', 'email' => 'n_bouzid@esi.dz', 'status' => 'Active', 'role' => 'Nurse'],
    ];
    return view('users.index', ['users' => $users]);
})->name('users.index');

Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
Route::put('/settings/preferences', [SettingsController::class, 'updatePreferences'])->name('settings.preferences.update');