<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
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

Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
Route::put('/settings/preferences', [SettingsController::class, 'updatePreferences'])->name('settings.preferences.update');